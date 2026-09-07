@props(["depth" => 0, "tree"])
<div>
    @foreach($tree as $treeItem)
        @php($model = $treeItem["model"])
        <div class="my-indent-half">
            @if ($depth > 0 || config("document-tree.singlePage"))
                @php($addToHeaderSize = config("document-tree.addToHeaderSize"))
                @php($headerSize = $depth <= 3 ? $depth + $addToHeaderSize : 3 + $addToHeaderSize)
                @php($headerComponent = "tt::h" . $headerSize)
                @php($headerClass = $depth <= 2 ? "mb-indent" : "mb-indent-half")
                <x-dynamic-component :component="$headerComponent"
                                     id="list-{{ $model->slug }}"
                                     class="{{ $headerClass }}">
                    {{ $model->title }}
                </x-dynamic-component>
            @endif

            @include("dt::web.document-categories.includes.short", ["model" => $model])

            @foreach($treeItem["documents"] as $key => $document)
                <x-dt::document :$document :$key />
            @endforeach

            @include("dt::web.document-categories.includes.description", ["model" => $model])
            @include("dt::web.document-categories.includes.info", ["model" => $model])

            @if (count($treeItem["children"]))
                <x-dt::document-tree :depth="$depth + 1" :tree="$treeItem['children']" />
            @endif
        </div>
    @endforeach
</div>
