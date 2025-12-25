<x-app-layout>
    @include("dt::web.document-categories.includes.show-metas")
    @include("dt::web.document-categories.includes.show-breadcrumbs")

    <div class="container">
        <div class="row">
            <div class="col w-full lg:w-1/3 order-last lg:order-first mb-indent">
                <x-dt-tree-sidebar :$category :$parents />
            </div>
            <div class="col w-full lg:w-2/3 mb-indent">
                <x-tt::h1 class="mb-indent">{{ $category->title }}</x-tt::h1>

                @if ($renderDocumentTree)
                    <x-dt::document-tree :$tree />
                @else
                    @include("dt::web.document-categories.includes.children-list", ["children" => $tree])
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
