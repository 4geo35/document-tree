@props(["item", "key"])
<div class="space-y-2 py-indent-half">
    <div class="text-lg">{{ $item->title }}</div>
    @if ($item->description)
        <div class="prose max-w-0">{!! $item->markdown !!}</div>
    @endif
</div>
