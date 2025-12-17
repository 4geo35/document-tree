<?php

namespace GIS\DocumentTree\Helpers;

use GIS\DocumentTree\Models\DocumentCategory;
use GIS\PriceList\Interfaces\DocumentCategoryInterface;
use GIS\TraitsHelpers\Traits\ManagerTreeTrait;

class DocumentCategoryActionsManager
{
    use ManagerTreeTrait;

    public function __construct()
    {
        $this->modelClass = config("document-tree.customDocumentCategoryModel") ?? DocumentCategory::class;
        $this->hasImage = false;
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
}
