<div class="flex justify-between items-center overflow-x-auto beautify-scrollbar">
    <h3 class="font-medium text-2xl text-nowrap mr-indent-half">Подписи документа "{{ $document->title }}"</h3>

    <div class="flex items-center space-x-2">
        @can("update", $document)
            <button type="button" class="btn btn-primary px-btn-x-ico lg:px-btn-x"
                    wire:loading.attr="disabled"
                    wire:click="showCreate">
                <x-tt::ico.circle-plus />
                <span class="hidden lg:inline-block pl-btn-ico-text">Добавить</span>
            </button>
        @endcan
    </div>
</div>
