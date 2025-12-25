@props(["children"])

@include("dt::web.document-categories.includes.short", ["model" => $priceList])

<div class="row">
    @foreach($children as $child)
        <div class="col w-full md:w-1/2 lg:w-full xl:w-1/2 mb-indent">
            <a href="{{ route('web.document-categories.show', ['category' => $child]) }}"
               class="h-full flex items-center justify-center text-center p-indent-half border border-primary rounded-base bg-primary/20 hover:bg-primary/30 font-semibold text-lg">
                {{ $child->title }}
            </a>
        </div>
    @endforeach
</div>

@include("dt::web.document-categories.includes.description", ["model" => $priceList])
@include("dt::web.document-categories.includes.info", ["model" => $priceList])
