<?php

namespace GIS\DocumentTree\Helpers;

use GIS\DocumentTree\Models\Document;
use GIS\DocumentTree\Models\DocumentCategory;
use GIS\DocumentTree\Interfaces\DocumentCategoryInterface;
use GIS\TraitsHelpers\Interfaces\ShouldTreeInterface;
use GIS\TraitsHelpers\Traits\ManagerTreeTrait;
use GIS\TraitsHelpers\Traits\ManagerTreeWithNestedTrait;
use Illuminate\Database\Eloquent\Builder;

class DocumentCategoryActionsManager
{
    use ManagerTreeTrait, ManagerTreeWithNestedTrait;

    public function __construct()
    {
        $this->modelClass = config("document-tree.customDocumentCategoryModel") ?? DocumentCategory::class;
        $this->hasImage = false;
        $this->elementModelClass = config("document-tree.customDocumentModel") ?? Document::class;
        $this->elementRelationCol = "documentable";
        $this->isMorphed = true;
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

    protected function expandRawDataQueryWith(Builder $query, ShouldTreeInterface $item = null): void
    {
        $query->with(["documents" => function ($query) {
            $query->with("signatures");
            $query->orderBy("priority");
        }]);
    }

    protected function expandNestedData(array &$data, ShouldTreeInterface $item): void
    {
        $data["documents"] = $item->documents;
    }
}
