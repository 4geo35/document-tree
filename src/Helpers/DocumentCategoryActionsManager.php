<?php

namespace GIS\DocumentTree\Helpers;

use GIS\DocumentTree\Models\Document;
use GIS\DocumentTree\Models\DocumentCategory;
use GIS\DocumentTree\Interfaces\DocumentCategoryInterface;
use GIS\TraitsHelpers\Interfaces\ShouldTreeInterface;
use GIS\TraitsHelpers\Traits\ManagerTreeTrait;

class DocumentCategoryActionsManager
{
    use ManagerTreeTrait;

    public function __construct()
    {
        $this->modelClass = config("document-tree.customDocumentCategoryModel") ?? DocumentCategory::class;
        $this->hasImage = false;
    }

    public function buildDocumentTree(DocumentCategoryInterface $category = null): array
    {
        list($items, $roots) = $this->makeRawDocumentCategoryDataWithDocuments($category);

        $grouped = $this->splitByParents($items);
        $tree = [];
        foreach ($roots as $id) {
            $item = $items[$id];
            $this->addChildren($item, $grouped);
            $tree[$id] = $item;
        }
        return $this->sortByPriority($tree);
    }

    public function findNestedChild(DocumentCategoryInterface $category): DocumentCategoryInterface
    {
        $firstChild = $category->children()->whereNotNull("published_at")->orderBy("priority")->first();
        if (! $firstChild) { return $category; }
        if ($firstChild->show_nested) { return $firstChild; }
        return $this->findNestedChild($firstChild);
    }

    public function findRootNested(DocumentCategoryInterface $category): ?DocumentCategoryInterface
    {
        $parent = $category->parent;
        if (! $parent) { return null; }
        $check = $this->findRootNested($parent);
        if (! $parent->show_nested && ! $check) { return null; }
        if (! $check) { return $parent; }
        return $check;
    }

    public function cascadeShutdown(DocumentCategoryInterface $category): void
    {
        foreach ($category->children as $child) {
            if (! $child->published_at) { continue; }
            $child->update([
                "published_at" => null,
            ]);
        }
    }

    public function getDocumentIds(DocumentCategoryInterface $category, bool $includeSubs = false): array
    {
        $modelClass = config("document-tree.customDocumentModel") ?? Document::class;
        $query = $modelClass::query()
            ->select("id");
        $query->where("documentable_type", $category::class);
        if ($includeSubs) {
            $query->whereIn("documentable_id", $this->getChildrenIds($category, true));
        } else {
            $query->where("documentable_id", $category->id);
        }
        $documents = $query->get();
        $dIds = [];
        foreach ($documents as $document) {
            $dIds[] = $document->id;
        }
        return $dIds;
    }

    public function getChildrenIds(DocumentCategoryInterface $category, bool $includeSelf = false): array
    {
        $ids = [];
        if ($includeSelf) { $ids[] = $category->id; }
        $children = $category->children()->select("id")->whereNotNull("published_at")->get();
        foreach ($children as $child) {
            $ids[] = $child->id;
            $ids = array_merge($ids, $this->getDocumentIds($child));
        }
        return array_unique($ids);
    }

    public function getParents(DocumentCategoryInterface $category): array
    {
        $result = [];
        if ($category->parent) {
            $result[] = (object)[
                "id" => $category->parent->id,
                "slug" => $category->parent->slug,
                "title" => $category->parent->title,
            ];
            $result = array_merge($this->getParents($category->parent), $result);
        }
        return $result;
    }

    protected function expandItemData(&$data, ShouldTreeInterface $category): void
    {
        $data["published_at"] = $category->published_at ?? null;
        $showNested = (bool)$category->show_nested;
        $data["show_nested"] = $showNested;
        $data["webTitle"] = $data["title"];
        if ($showNested) {
            $data["title"] .= " (Раскрыто)";
        }
    }

    protected function makeRawDocumentCategoryDataWithDocuments(DocumentCategoryInterface $category = null): array
    {
        $query = $this->modelClass::query();
        $query->with(["documents" => function ($query) {
            $query->with("signatures");
            $query->orderBy("priority");
        }]);
        if ($category) {
            $ids = $this->getChildrenIds($category, true);
            $query->whereIn("id", $ids);
        }
        $categories = $query->orderBy("parent_id")->get();

        $items = [];
        $roots = [];
        if ($category && $category->parent_id) { $roots[] = $category->id; }
        foreach ($categories as $item) {
            $data = [
                "model" => $item,
                "parent" => $item->parent_id,
                "priority" => $item->priority,
                "id" => $item->id,
                "children" => [],
                "documents" => $item->documents,
            ];
            $items[$item->id] = $data;
            if (empty($item->parent_id)) { $roots[] = $item->id; }
        }
        return [$items, $roots];
    }
}
