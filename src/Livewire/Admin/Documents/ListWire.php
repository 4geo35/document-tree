<?php

namespace GIS\DocumentTree\Livewire\Admin\Documents;

use GIS\DocumentTree\Interfaces\DocumentInterface;
use GIS\DocumentTree\Interfaces\ShouldDocumentsInterface;
use GIS\DocumentTree\Models\Document;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;

class ListWire extends Component
{
    use WithFileUploads;

    public ShouldDocumentsInterface $model;

    public bool $displayDelete = false;
    public bool $displayData = false;
    public bool $displayOrder = false;

    public int|null $documentId = null;
    public string $title = "";
    public string $description = "";
    public TemporaryUploadedFile|null $file = null;
    public string|null $fileUrl = null;

    public Collection|null $list = null;
    public bool $hasSearch = false;

    public function rules(): array
    {
        return [
            "title" => ["required", "string", "max:255"],
            "file" => [$this->documentId ? "nullable" : "required", "file"],
        ];
    }

    public function validationAttributes(): array
    {
        return [
            "title" => "Заголовок",
            "file" => "Файл",
        ];
    }

    public function render(): View
    {
        $documents = $this->model->documents()->orderBy("priority")->get();
        return view("dt::livewire.admin.documents.list-wire", compact("documents"));
    }

    public function closeData(): void
    {
        $this->resetFields();
        $this->displayData = false;
    }

    public function showCreate(): void
    {
        $this->resetFields();
        if (! $this->checkAuth("create")) { return; }
        $this->displayData = true;
    }

    public function store(): void
    {
        if (! $this->checkAuth("create")) { return; }
        $this->validate();

        $document = $this->model->documents()->create([
            "title" => $this->title,
            "description" => $this->description,
        ]);
        /**
         * @var DocumentInterface $document
         */
        $document->livewireFile($this->file);
        $this->closeData();
        session()->flash("document-success", "Документ успешно добавлен");
    }

    public function showEdit(int $documentId): void
    {
        $this->resetFields();
        $this->documentId = $documentId;
        $document = $this->findModel();
        if (! $document) { return; }
        if (! $this->checkAuth("update")) { return; }

        $this->title = $document->title;
        $this->description = $document->description;
        if ($document->file_id) {
            $document->load("file");
            $this->fileUrl = route("download-file", ["filename" => $document->file->filename]);
        } else { $this->fileUrl = null; }
        $this->displayData = true;
    }

    public function update(): void
    {
        $document = $this->findModel();
        if (! $document) { return; }
        if (! $this->checkAuth("update")) { return; }
        $this->validate();

        $document->update([
            "title" => $this->title,
            "description" => $this->description,
        ]);
        $document->livewireFile($this->file);
        session()->flash("document-success", "Документ успешно обновлен");
        $this->dispatch("document-updated", documentId: $this->documentId);
        $this->closeData();
    }

    public function closeDelete(): void
    {
        $this->resetFields();
        $this->displayDelete = false;
    }

    public function showDelete(int $documentId): void
    {
        $this->resetFields();
        $this->documentId = $documentId;
        $document = $this->findModel();
        if (! $document) { return; }
        if (! $this->checkAuth("delete")) { return; }
        $this->displayDelete = true;
        $this->dispatch("document-deleted", documentId: $this->documentId);
    }

    public function confirmDelete(): void
    {
        $document = $this->findModel();
        if (! $document) { return; }
        if (! $this->checkAuth("delete")) { return; }
        $document->delete();
        session()->flash("document-success", "Документ успешно удален");
        $this->closeDelete();
    }

    public function showOrder(): void
    {
        if (! $this->checkAuth("order")) { return; }
        $this->displayOrder = true;
        $this->setDocumentList();
        $this->dispatch("update-list");
    }

    public function reorderItems(array $newOrder): void
    {
        if (! $this->checkAuth("order")) { return; }

        foreach ($newOrder as $priority => $id) {
            $this->documentId = $id;
            $document = $this->findModel();
            if (! $document) { continue; }
            $document->priority = $priority;
            $document->save();
        }

        $this->resetFields();
        $this->setDocumentList();
    }

    public function showSignatures(int $documentId): void
    {
        $this->resetFields();
        $this->documentId = $documentId;
        $document = $this->findModel();
        if (! $document) { return; }
        if (! $this->checkAuth("update")) { return; }
        $this->dispatch("show-signatures", documentId: $documentId);
    }
    protected function setDocumentList(): void
    {
        $this->list = $this->model->documents()
            ->select("id", "title", "priority")
            ->orderBy("priority")
            ->get();
    }

    protected function resetFields(): void
    {
        $this->reset("documentId", "title", "description", "file", "fileUrl");
    }

    protected function findModel(): ?DocumentInterface
    {
        $modelClass = config("document-tree.customDocumentModel") ?? Document::class;
        $document = $modelClass::find($this->documentId);
        if (! $document) {
            session()->flash("document-error", "Документ не найден");
            $this->closeData();
            $this->closeDelete();
            return null;
        }
        return $document;
    }

    protected function checkAuth(string $action, DocumentInterface $document = null): bool
    {
        try {
            $modelClass = config("document-tree.customDocumentModel") ?? Document::class;
            $this->authorize($action, $document ?? $modelClass);
            return true;
        } catch (AuthorizationException $e) {
            session()->flash("document-error", "Неавторизованное действие");
            $this->closeData();
            $this->closeDelete();
            return false;
        }
    }
}
