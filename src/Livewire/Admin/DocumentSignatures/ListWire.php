<?php

namespace GIS\DocumentTree\Livewire\Admin\DocumentSignatures;

use GIS\DocumentTree\Interfaces\DocumentInterface;
use GIS\DocumentTree\Models\Document;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\Attributes\On;

class ListWire extends Component
{
    public DocumentInterface|null $document = null;
    public bool $documentError = false;

    public function render(): View
    {
        return view("dt::livewire.admin.document-signatures.list-wire");
    }

    #[On("show-signatures")]
    public function setDocument(int $documentId): void
    {
        $modelClass = config("document-tree.customDocumentModel") ?? Document::class;
        $document = $modelClass::find($documentId);
        if (!$document) {
            $this->documentError = true;
            session()->flash("signature-document-error", "Документ не найден");
            return;
        }
        $this->document = $document;
    }

    #[On("document-deleted")]
    public function resetDocument(int $documentId): void
    {
        if (! $this->document) { return; }
        if ($this->document->id !== $documentId) { return; }
        $this->document = null;
    }

    #[On("document-updated")]
    public function freshDocument(int $documentId): void
    {
        if (! $this->document) { return; }
        if ($this->document->id !== $documentId) { return; }
        $this->document->fresh();
    }
}
