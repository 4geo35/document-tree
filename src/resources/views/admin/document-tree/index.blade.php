<x-admin-layout>
    <x-slot name="title">{{ config("document-tree.categoryPageTitle") }}</x-slot>
    <x-slot name="pageTitle">{{ config("document-tree.categoryPageTitle") }}</x-slot>

    <livewire:dt-admin-document-category-list />

    @include("tt::admin.draggable-tree-script")
</x-admin-layout>
