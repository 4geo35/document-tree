@props(["model"])
@if ($model->description)
    <div class="prose max-w-none mb-indent-lg">
        {!! $model->markdown !!}
    </div>
@endif

