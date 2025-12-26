@props(["signature", "column", "title"])
@isset($signature->{$column})
    <div class="row">
        <div class="col w-full sm:w-1/3 font-semibold sm:mb-2">{{ $title }}:</div>
        <div class="col w-full sm:w-2/3 mb-2">{{ $signature->{$column} }}</div>
    </div>
@endisset
