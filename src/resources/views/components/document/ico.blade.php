@props(["document", "isPdf", "isImage"])
<div class="mr-indent-half">
    @if ($document->description)
        <div class="inline-flex relative"
             x-data="{ hovered: false, show: false }" @mouseleave="hovered = false" @click.outside="show = false">
            <button type="button" @mouseover="hovered = true" @click="show = true"
                    class="inline-flex items-center justify-center cursor-help text-primary hover:text-primary-hover">
                @if ($isPdf)
                    <x-dt::ico.library-pdf width="48" height="48" />
                @elseif ($isImage)
                    <x-dt::ico.library-photo width="48" height="48" />
                @else
                    <x-dt::ico.library-books width="48" height="48" />
                @endif
            </button>
            <div class="bg-[#F4F4F4] z-10 absolute left-0 top-10 min-w-[270px] px-indent py-indent-half rounded-base shadow-md border border-stroke"
                 x-show="hovered || show" style="display: none">
                <div class="prose">{!! $document->markdown !!}</div>
            </div>
        </div>
    @else
        @if ($isPdf)
            <x-dt::ico.library-pdf width="48" height="48" />
        @elseif ($isImage)
            <x-dt::ico.library-photo width="48" height="48" />
        @else
            <x-dt::ico.library-books width="48" height="48" />
        @endif
    @endif
</div>
