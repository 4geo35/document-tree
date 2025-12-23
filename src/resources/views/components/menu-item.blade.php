@can("viewAny", config("document-tree.customDocumentCategoryModel") ?? \GIS\DocumentTree\Models\DocumentCategory::class)
    <x-tt::admin-menu.item
        href="{{ route('admin.document-tree.index') }}"
        :active="in_array(\Illuminate\Support\Facades\Route::currentRouteName(), ['admin.document-tree.index', 'admin.document-tree.show'])">
        <x-slot name="ico"><x-dt::ico.library-books /></x-slot>
        {{ config("document-tree.categoryPageTitle") }}
    </x-tt::admin-menu.item>
@endcan
