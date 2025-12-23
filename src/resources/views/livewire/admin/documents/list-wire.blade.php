<div>
    @php($modelClass = config('document-tree.customDocumentModel') ?? \GIS\DocumentTree\Models\Document::class)
    @can('viewAny', $modelClass)
        <div class="card">
            <div class="card-header border-b-0">
                <div class="space-y-indent-half">
                    @include("dt::admin.documents.includes.list-title", compact("modelClass"))
                    <x-tt::notifications.error prefix="document-"/>
                    <x-tt::notifications.success prefix="document-"/>
                </div>
            </div>

            @include("dt::admin.documents.includes.table")
            @include("dt::admin.documents.includes.table-modals")
            @include("dt::admin.documents.includes.order-modal")
        </div>
    @endcan
</div>
