<?php

namespace GIS\DocumentTree\Observers;

use GIS\DocumentTree\Facades\DocumentCategoryActions;
use GIS\DocumentTree\Models\DocumentCategory;
use GIS\DocumentTree\Interfaces\DocumentCategoryInterface;

class DocumentCategoryObserver
{
    public function creating(DocumentCategoryInterface $category): void
    {
        $parentId = $category->parent_id;
        $categoryModelClass = config("document-tree.customDocumentCategoryModel") ?? DocumentCategory::class;
        $priority = $categoryModelClass::query()
            ->select("id", "priority")
            ->where("parent_id", $parentId)
            ->max("priority");
        if (empty($priority)) { $priority = 0; }
        $category->priority = $priority + 1;
    }

    public function updated(DocumentCategoryInterface $category): void
    {
        if ($category->wasChanged("published_at")) {
            if (! $category->publushed_at) { DocumentCategoryActions::cascadeShutdown($category); }
        }

        if ($category->wasChanged("parent_id")) {
            $parent = $category->parent;
            if ($parent && ! $parent->published_at) {
                $category->published_at = null;
                $category->saveQuietly();
                DocumentCategoryActions::cascadeShutdown($category);
            }
        }
    }
}
