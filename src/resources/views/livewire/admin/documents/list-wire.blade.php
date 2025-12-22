<div>
    @php($modelClass = config('document-tree.customDocumentModel') ?? \GIS\DocumentTree\Models\Document::class)
    @can('viewAny', $modelClass)
        <div class="card">
            <div class="card-header border-b-0">
                <div class="space-y-indent-half">
                    <div class="flex justify-between items-center">
                        <h2 class="font-medium text-2xl">Документы</h2>
                        @can("create", $modelClass)
                            <button type="button" class="btn btn-primary px-btn-x-ico lg:px-btn-x" wire:click="showCreate">
                                <x-tt::ico.circle-plus />
                                <span class="hidden lg:inline-block pl-btn-ico-text">Добавить</span>
                            </button>
                        @endcan
                    </div>

                    <x-tt::notifications.error prefix="document-" />
                    <x-tt::notifications.success prefix="document-" />
                </div>
            </div>

            @include("dt::admin.documents.includes.table")
            @include("dt::admin.documents.includes.table-modals")
        </div>
    @endcan
</div>
