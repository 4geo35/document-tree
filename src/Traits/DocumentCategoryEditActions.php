<?php

namespace GIS\DocumentTree\Traits;

use GIS\DocumentTree\Interfaces\DocumentCategoryInterface;
use GIS\DocumentTree\Models\DocumentCategory;
use Illuminate\Auth\Access\AuthorizationException;

trait DocumentCategoryEditActions
{
    public bool $displayDelete = false;
    public bool $displayData = false;

    public int|null $categoryId = null;
    public int|null $parentId = null;

    public string $title = "";
    public string $slug = "";
    public string $short = "";
    public string $description = "";
    public string $info = "";
    public bool $showNested = false;

    public function rules(): array
    {
        $uniqueCondition = "unique:document_categories,slug";
        if ($this->categoryId) { $uniqueCondition .= ",{$this->categoryId}"; }
        return [
            "title" => ["required", "string", "max:250"],
            "slug" => ["nullable", "string", "max:250", $uniqueCondition],
            "short" => ["nullable", "string", "max:250"],
        ];
    }

    public function validationAttributes(): array
    {
        return [
            "title" => "Заголовок",
            "slug" => "Адресная строка",
            "short" => "Краткое описание",
        ];
    }

    public function closeData(): void
    {
        $this->displayData = false;
        $this->resetFields();
    }

    public function showEdit(int $id): void
    {
        $this->categoryId = $id;
        $category = $this->findModel();
        if (! $category) { return; }
        if (! $this->checkAuth("update", $category)) { return; }

        $this->displayData = true;
        $this->title = $category->title;
        $this->slug = $category->slug;
        $this->short = $category->short;
        $this->description = $category->description;
        $this->info = $category->info;
        $this->showNested = (bool) $category->show_nested;
    }

    public function update(): void
    {
        $category = $this->findModel();
        if (! $category) { return; }
        if (! $this->checkAuth("update", $category)) { return; }
        $this->validate();

        $slugHasChanged = $this->slug !== $category->slug;

        $category->update([
            "title" => $this->title,
            "slug" => $this->slug,
            "short" => $this->short,
            "description" => $this->description,
            "info" => $this->info,
            "show_nested" => $this->showNested ? now() : null,
        ]);
        session()->flash("success", "Категория успешно обновлена");
        $this->closeData();
        if (isset($this->category)) {
            $this->category = $category;
            if ($slugHasChanged) {
                $this->redirectRoute("admin.document-tree.show", ["category" => $this->category]);
            }
        }
    }

    public function closeDelete(): void
    {
        $this->displayDelete = false;
        $this->resetFields();
    }

    public function showDelete(int $id): void
    {
        $this->categoryId = $id;
        $category = $this->findModel();
        if (! $category) { return; }
        if (! $this->checkAuth("delete", $category)) { return; }
        $this->displayDelete = true;
    }

    public function confirmDelete(): void
    {
        $category = $this->findModel();
        if (! $category) { return; }
        if (! $this->checkAuth("delete", $category)) { return; }

        if ($category->children->count()) {
            session()->flash("error", "Невозможно удалить категорию, у которой есть дочерние категории");
            $this->closeDelete();
            return;
        }

        // TODO: check items

        try {
            $category->delete();
            session()->flash("success", "Категория успешно удалена");
        } catch (\Exception $exception) {
            session()->flash("error", "Ошибка при удалении категории");
        }
        $this->closeDelete();
        if (isset($this->category)) {
            $this->redirectRoute("admin.document-tree.index");
        }
    }

    public function switchPublish(int $id): void
    {
        $this->categoryId = $id;
        $category = $this->findModel();
        if (! $category) { return; }
        if (! $this->checkAuth("update", $category)) { return; }

        $category->update([
            "published_at" => $category->published_at ? null : now(),
        ]);
        if (isset($this->category)) {
            $this->category = $category;
            $this->dispatch("switch-category-published");
        }
    }

    protected function resetFields(): void
    {
        $this->reset("title", "slug", "short", "description", "info", "showNested", "categoryId", "parentId");
    }

    protected function checkAuth(string $action, ?DocumentCategoryInterface $category = null): bool
    {
        try {
            $modelClass = config("document-tree.customDocumentCategoryModel") ?? DocumentCategory::class;
            $this->authorize($action, $category ?? $modelClass);
            return true;
        } catch (AuthorizationException $e) {
            session()->flash("error", "Неавторизованное действие");
            $this->closeData();
            $this->closeDelete();
            return false;
        }
    }

    protected function findModel(?int $id = null): ?DocumentCategoryInterface
    {
        $modelClass = config("document-tree.customDocumentCategoryModel") ?? DocumentCategory::class;
        if ($id) { $category = $modelClass::find($id); }
        else { $category = $modelClass::find($this->categoryId);}
        if (!$category) {
            session()->flash("error", "Категория не найдена");
            $this->closeData();
            $this->closeDelete();
            return null;
        }
        return $category;
    }
}
