<?php

namespace GIS\DocumentTree\Livewire\Admin\DocumentSignatures;

use GIS\DocumentTree\Interfaces\DocumentInterface;
use GIS\DocumentTree\Interfaces\ShouldDocumentsInterface;
use GIS\DocumentTree\Models\Document;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\Attributes\On;

class ListWire extends Component
{
    public ShouldDocumentsInterface $model;
    public DocumentInterface|null $document = null;
    public bool $documentError = false;

    public function mount(): void
    {
        $this->setFirstDocument();
    }

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
        $this->setFirstDocument($documentId);
    }

    #[On("document-updated")]
    public function freshDocument(int $documentId): void
    {
        if (! $this->document) { return; }
        if ($this->document->id !== $documentId) { return; }
        $this->document->fresh();
    }

    protected function setFirstDocument(int $id = null): void
    {
        $query = $this->model->documents();
        if ($id) { $query->where('id', '!=', $id); }
        $firstDocument = $query->orderBy("priority")->first();
        if ($firstDocument) { $this->document = $firstDocument; }
        else { $this->document = null; }
    }
}
