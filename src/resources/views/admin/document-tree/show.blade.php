<x-admin-layout>
    <x-slot name="title">Документы категории</x-slot>
    <x-slot name="pageTitle">Документы категории</x-slot>

    <div class="space-y-indent">
        <livewire:dt-admin-document-category-show :$category />
        <livewire:dt-admin-document-list :model="$category" />
        <livewire:dt-admin-document-signature-list />
        <livewire:ma-metas :model="$category" />
    </div>
</x-admin-layout>
