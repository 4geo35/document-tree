<x-admin-layout>
    <x-slot name="title">Документа категории</x-slot>
    <x-slot name="pageTitle">Документа категории</x-slot>

    <div class="space-y-indent">
        <livewire:dt-admin-document-category-show :$category />
        <livewire:ma-metas :model="$category" />
    </div>
</x-admin-layout>
