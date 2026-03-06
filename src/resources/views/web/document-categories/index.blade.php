<x-app-layout>
    @include("dt::web.document-categories.includes.metas")
    @include("dt::web.document-categories.includes.breadcrumbs")
    @include("dt::web.document-categories.includes.h1")

    <div class="container">
        <div class="row">
            <div class="col w-full lg:w-1/3 order-last lg:order-first mb-indent">
                <div class="sticky top-sticky lg:max-h-dvh overflow-y-auto beautify-scrollbar">
                    <x-dt-tree-sidebar />
                </div>
            </div>
            <div class="col w-full lg:w-2/3 mb-indent">
                <x-dt::document-tree :$tree />
            </div>
        </div>
    </div>
</x-app-layout>
