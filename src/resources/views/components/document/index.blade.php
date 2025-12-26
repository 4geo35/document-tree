@props(["document", "key"])
@php($ext = $document->file->mime)
@php($isPdf = $ext === "pdf")
@php($isImage = in_array($ext, ["jpg", "jpeg", "png", "webp"]))
@php($downloadUrl = route('download-file', ['filename' => $document->file->filename]))
<div class="py-indent-half flex items-start justify-start">
    <x-dt::document.ico :$document :$isPdf :$isImage />
    <div>
        <div class="text-lg font-semibold">{{ $document->title }}</div>
        <div class="flex items-center justify-start flex-wrap space-x-2">
            <div class="flex items-center justify-start flex-wrap space-x-2">
                @if (! $isPdf)
                    <a href="{{ $downloadUrl }}"
                       class="text-primary hover:text-primary-hover font-semibold inline-flex items-center" target="_blank">
                        <x-fa::ico.file-download /> <span class="pl-0.5">Скачать</span>
                    </a>
                @endif
                <span class="text-nowrap">(Размер {{ $document->file->human_size }})</span>
            </div>

            <div class="flex items-center justify-start space-x-2">
                @if ($isImage)
                    <a data-fslightbox="lightbox-{{ $document->id }}" href="{{ $downloadUrl }}"
                       class="text-primary hover:text-primary-hover font-semibold inline-flex items-center">
                        <x-tt::ico.eye /> <span class="pl-0.5">Просмотр</span>
                    </a>
                @elseif ($isPdf)
                    <a href="{{ $downloadUrl }}" target="_blank"
                       class="text-primary hover:text-primary-hover font-semibold inline-flex items-center">
                        <x-tt::ico.eye /> <span class="pl-0.5">Просмотр</span>
                    </a>
                @else
                    <a href="https://docs.google.com/gview?url={{ $downloadUrl }}&embedded=true" target="_blank"
                       class="text-primary hover:text-primary-hover font-semibold inline-flex items-center">
                        <x-tt::ico.eye /> <span class="pl-0.5">Просмотр</span>
                    </a>
                @endif

                <x-dt::document.signatures :$document />
            </div>
        </div>
    </div>
</div>
