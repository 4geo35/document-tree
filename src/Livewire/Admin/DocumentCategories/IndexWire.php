<?php

namespace GIS\DocumentTree\Livewire\Admin\DocumentCategories;

use GIS\DocumentTree\Facades\DocumentCategoryActions;
use Illuminate\View\View;
use Livewire\Component;

class IndexWire extends Component
{
    public array|null $tmpTree = null;

    public function render(): View
    {
        $tree = DocumentCategoryActions::getCategoryTree($this->tmpTree);
        $this->dispatch("re-init-script");
        return view("dt::livewire.admin.document-categories.index-wire", compact("tree"));
    }
}
