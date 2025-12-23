@props(["modelClass"])
<div class="flex justify-between items-center overflow-x-auto beautify-scrollbar">
    <h3 class="font-medium text-xl text-nowrap mr-indent-half">Документы</h3>

    <div class="flex items-center space-x-2">
        @can("create", $modelClass)
            <button type="button" class="btn btn-primary px-btn-x-ico lg:px-btn-x" wire:click="showCreate">
                <x-tt::ico.circle-plus />
                <span class="hidden lg:inline-block pl-btn-ico-text">Добавить</span>
            </button>
        @endcan
        @can("order", $modelClass)
            <button type="button" class="btn btn-primary px-btn-x-ico lg:px-btn-x ml-indent-half" wire:click="showOrder">
                <x-tt::ico.bars />
                <span class="hidden lg:inline-block pl-btn-ico-text">Порядок</span>
            </button>
        @endcan
    </div>
</div>
