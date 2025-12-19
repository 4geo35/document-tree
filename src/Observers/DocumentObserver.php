<?php

namespace GIS\DocumentTree\Observers;

use GIS\DocumentTree\Interfaces\DocumentInterface;
use GIS\DocumentTree\Models\Document;

class DocumentObserver
{
    public function creating(DocumentInterface $document): void
    {
        $modelClass = config("document-tree.customDocumentModel") ?? Document::class;
        $priority = $modelClass::query()
            ->where("documentable_type", $document->documentable_type)
            ->where("documentable_id", $document->documentable_id)
            ->max("priority");
        if (! $priority) { $priority = 1; }
        $document->priority = $priority + 1;
    }
}
