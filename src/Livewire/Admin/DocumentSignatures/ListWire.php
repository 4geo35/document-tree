<?php

namespace GIS\DocumentTree\Livewire\Admin\DocumentSignatures;

use GIS\DocumentTree\Interfaces\DocumentInterface;
use Illuminate\View\View;
use Livewire\Component;

class ListWire extends Component
{
    public DocumentInterface|null $document = null;

    public function render(): View
    {
        return view("dt::livewire.admin.document-signatures.list-wire");
    }
}
