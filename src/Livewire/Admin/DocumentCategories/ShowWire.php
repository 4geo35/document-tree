<?php

namespace GIS\DocumentTree\Livewire\Admin\DocumentCategories;

use GIS\DocumentTree\Interfaces\DocumentCategoryInterface;
use GIS\DocumentTree\Traits\DocumentCategoryEditActions;
use Illuminate\View\View;
use Livewire\Component;

class ShowWire extends Component
{
    use DocumentCategoryEditActions;

    public DocumentCategoryInterface $category;

    public function render(): View
    {
        return view("dt::livewire.admin.document-categories.show-wire");
    }
}
