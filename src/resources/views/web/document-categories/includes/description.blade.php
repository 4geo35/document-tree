@props(["model"])
@if ($model->description)
    <div class="prose max-w-none py-indent-half">
        {!! $model->markdown !!}
    </div>
@endif
