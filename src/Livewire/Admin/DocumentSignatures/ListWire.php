<?php

namespace GIS\DocumentTree\Livewire\Admin\DocumentSignatures;

use GIS\DocumentTree\Interfaces\DocumentInterface;
use GIS\DocumentTree\Interfaces\DocumentSignatureInterface;
use GIS\DocumentTree\Interfaces\ShouldDocumentsInterface;
use GIS\DocumentTree\Models\Document;
use GIS\DocumentTree\Models\DocumentSignature;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;

class ListWire extends Component
{
    use WithFileUploads;

    public ShouldDocumentsInterface $model;
    public DocumentInterface|null $document = null;
    public bool $documentError = false;

    public bool $displayData = false;
    public bool $displayDelete = false;

    public int|null $signatureId = null;
    public TemporaryUploadedFile|null $file = null;
    public string|null $fileUrl = null;
    public string $title = "";
    public string $person = "";
    public string $position = "";
    public string $organization = "";
    public string $date = "";
    public string $certificate = "";
    public string $issued = "";
    public string $period = "";

    public function mount(): void
    {
        $this->setFirstDocument();
    }

    public function rules(): array
    {
        return [
            "file" => [$this->signatureId ? "nullable" : "required", "file"],
            "title" => ["required", "string", "max:255"],
            "person" => ["nullable", "string", "max:255"],
            "position" => ["nullable", "string", "max:255"],
            "organization" => ["nullable", "string", "max:255"],
            "date" => ["nullable", "date"],
            "certificate" => ["nullable", "string", "max:255"],
            "period" => ["nullable", "string", "max:255"],
        ];
    }

    public function validationAttributes(): array
    {
        return [
            "file" => "Файл подписи",
            "title" => "Заголовок",
            "person" => "Подписант",
            "position" => "Должность",
            "organization" => "Организация",
            "date" => "Дата подписания",
            "certificate" => "Сертификат",
            "period" => "Период действия сертификата"
        ];
    }

    public function render(): View
    {
        if ($this->document) {
            $signatures = $this->document->signatures()->orderBy("created_at")->get();
        } else { $signatures = null; }
        return view("dt::livewire.admin.document-signatures.list-wire", compact("signatures"));
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

        $signature = $this->document->signatures()->create([
            "title" => $this->title,
            "person" => $this->person,
            "position" => $this->position,
            "organization" => $this->organization,
            "date" => empty($this->date) ? null : $this->date,
            "certificate" => $this->certificate,
            "issued" => $this->issued,
            "period" => $this->period,
        ]);
        /**
         * @var DocumentSignatureInterface $signature
         */
        $signature->livewireFile($this->file);
        $this->closeData();
        session()->flash("signature-success", "Подпись успешно добавлена");
    }

    public function showEdit(int $signatureId): void
    {
        $this->resetFields();
        $this->signatureId = $signatureId;
        $signature = $this->findModel();
        if (! $signature) { return; }
        if (! $this->checkAuth("update", $signature)) { return; }

        $this->title = $signature->title;
        $this->person = $signature->person;
        $this->position = $signature->position;
        $this->organization = $signature->organization;
        $this->date = $signature->date ?? "";
        $this->certificate = $signature->certificate;
        $this->issued = $signature->issued;
        $this->period = $signature->period;
        if ($signature->file_id) {
            $signature->load("file");
            $this->fileUrl = route("download-file", ["filename" => $signature->file->filename]);
        } else { $this->fileUrl = null; }
        $this->displayData = true;
    }

    public function update(): void
    {
        $signature = $this->findModel();
        if (! $signature) { return; }
        if (! $this->checkAuth("update", $signature)) { return; }
        $this->validate();

        $signature->update([
            "title" => $this->title,
            "person" => $this->person,
            "position" => $this->position,
            "organization" => $this->organization,
            "date" => empty($this->date) ? null : $this->date,
            "certificate" => $this->certificate,
            "issued" => $this->issued,
            "period" => $this->period,
        ]);
        $signature->livewireFile($this->file);
        $this->closeData();
        session()->flash("signature-success", "Подпись успешно обновлена");
    }

    public function closeDelete(): void
    {
        $this->resetFields();
        $this->displayDelete = false;
    }

    public function showDelete(int $signatureId): void
    {
        $this->resetFields();
        $this->signatureId = $signatureId;
        $signature = $this->findModel();
        if (! $signature) { return; }
        if (! $this->checkAuth("delete", $signature)) { return; }
        $this->displayDelete = true;
    }

    public function confirmDelete(): void
    {
        $signature = $this->findModel();
        if (! $signature) { return; }
        if (! $this->checkAuth("delete", $signature)) { return; }
        $signature->delete();
        session()->flash("signature-success", "Подпись успешно удалена");
        $this->closeDelete();
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

    protected function resetFields(): void
    {
        $this->reset("signatureId", "file", "fileUrl", "title", "person", "position", "organization", "date", "certificate", "issued", "period");
    }

    protected function findModel(): ?DocumentSignatureInterface
    {
        $modelClass = config("document-tree.customDocumentSignatureModel") ?? DocumentSignature::class;
        $signature = $modelClass::find($this->signatureId);
        if (! $signature) {
            session()->flash("signature-error", "Подпись не найдена");
            $this->closeData();
            $this->closeDelete();
            return null;
        }
        return $signature;
    }

    public function checkAuth(string $action, DocumentSignatureInterface $signature = null): bool
    {
        try {
            $modelClass = config("document-tree.customDocumentSignatureModel") ?? DocumentSignature::class;
            $this->authorize($action, $signature ?? $modelClass);
            return true;
        } catch (AuthorizationException $e) {
            session()->flash("signature-error", "Неавторизованное действие");
            $this->closeData();
            $this->closeDelete();
            return false;
        }
    }
}
