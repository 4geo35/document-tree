<?php

namespace GIS\DocumentTree\Traits;

use GIS\DocumentTree\Interfaces\ShouldDocumentsInterface;
use GIS\DocumentTree\Models\Document;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait ShouldDocuments
{
    protected static function bootShouldDocuments(): void
    {
        static::deleting(function (ShouldDocumentsInterface $model) {
            $model->clearDocuments();
        });
    }

    public function getDocumentClassAttribute(): string
    {
        return config('document-tree.customDocumentModel') ?? Document::class;
    }

    public function documents(): MorphMany
    {
        return $this->morphMany($this->document_class, "documentable");
    }

    public function clearDocuments(): void
    {
        foreach ($this->documents as $document) {
            $document->delete();
        }
    }
}
