<?php

namespace GIS\DocumentTree\Livewire\Admin\DocumentCategories;

use GIS\DocumentTree\Facades\DocumentCategoryActions;
use GIS\DocumentTree\Models\DocumentCategory;
use GIS\DocumentTree\Traits\DocumentCategoryEditActions;
use Illuminate\View\View;
use Livewire\Component;

class IndexWire extends Component
{
    use DocumentCategoryEditActions;

    public array|null $tmpTree = null;

    public function render(): View
    {
        $tree = DocumentCategoryActions::getCategoryTree($this->tmpTree);
        $this->dispatch("re-init-script");
        return view("dt::livewire.admin.document-categories.index-wire", compact("tree"));
    }

    public function showCreate(int $parentId = null): void
    {
        $this->resetFields();
        if (! $this->checkAuth("create")) { return; }

        $this->parentId = $parentId;
        $this->displayData = true;
    }

    public function store(): void
    {
        if (! $this->checkAuth("create")) { return; }
        if ($this->parentId) {
            $parent = $this->findModel($this->parentId);
            if (! $parent) { return; }
        }
        $this->validate();
        $data = [
            "title" => $this->title,
            "slug" => $this->slug,
            "short" => $this->short,
            "description" => $this->description,
            "info" => $this->info,
            "show_nested" => $this->showNested ? now() : null,
        ];
        if ($this->parentId) {
            $category = $parent->children()->create($data);
        } else {
            $modelClass = config("document-tree.customDocumentCategoryModel") ?? DocumentCategory::class;
            $category = $modelClass::create($data);
        }
        session()->flash("success", "Категория успешно добавлена");
        $this->closeData();
    }

    public function tmpOrder(array $tree): void
    {
        $this->tmpTree = $tree;
        $this->dispatch("change-tree");
    }

    public function updateOrder(): void
    {
        if (! $this->checkAuth("order")) { return; }
        $result = DocumentCategoryActions::rebuildTree($this->tmpTree);
        $this->tmpTree = null;
        if ($result) { session()->flash("success", "Дерево категорий успешно изменено"); }
        else { session()->flash("error", "Ошибка при обновлении дерева"); }
    }
}
