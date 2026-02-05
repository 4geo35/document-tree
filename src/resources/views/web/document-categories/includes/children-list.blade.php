@props(["children"])

@include("dt::web.document-categories.includes.short", ["model" => $category])

<div class="row">
    @foreach($children as $child)
        <div class="col px-2 w-full md:w-1/2 lg:w-full xl:w-1/2 mb-indent-sm">
            <a href="{{ route('web.document-categories.show', ['category' => $child]) }}"
               class="h-full flex items-center justify-center text-center p-indent-xs border border-primary rounded-base font-medium text-sm text-primary hover:bg-primary hover:text-white transition-colors">
                {{ $child->title }}
            </a>
        </div>
    @endforeach
</div>

@include("dt::web.document-categories.includes.description", ["model" => $category])
@include("dt::web.document-categories.includes.info", ["model" => $category])
