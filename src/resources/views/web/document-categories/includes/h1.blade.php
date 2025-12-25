@if (config("document-tree.useH1"))
    <div class="container">
        <x-tt::h1 class="mb-indent">{{ config("document-tree.categoryPageTitle") }}</x-tt::h1>
    </div>
@endif
