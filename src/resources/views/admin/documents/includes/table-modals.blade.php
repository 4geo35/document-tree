<x-tt::modal.confirm wire:model="displayDelete">
    <x-slot name="title">Удалить документ</x-slot>
    <x-slot name="text">Будет невозможно восстановить документ!</x-slot>
</x-tt::modal.confirm>

<x-tt::modal.dialog wire:model="displayData">
    <x-slot name="title">
        {{ $documentId ? "Редактировать документ" : "Добавить документ" }}
    </x-slot>
    <x-slot name="content">
        <form wire:submit.prevent="{{ $documentId ? 'update' : 'store' }}"
              class="space-y-indent-half"
              id="documentsDataForm">
            <div>
                <label for="documentTitle" class="inline-block mb-2">
                    Заголовок<span class="text-danger">*</span>
                </label>
                <input type="text" id="documentTitle"
                       class="form-control {{ $errors->has("title") ? "border-danger" : "" }}"
                       required
                       wire:loading.attr="disabled"
                       wire:model="title">
                <x-tt::form.error name="title"/>
            </div>

            <div>
                <label for="documentFile" class="inline-block mb-2">
                    Файл @if (!$fileUrl) <span class="text-danger">*</span> @endif
                </label>
                <input type="file" id="documentFile"
                       class="form-control {{ $errors->has('file') ? 'border-danger' : '' }}"
                       wire:loading.attr="disabled"
                       wire:model.lazy="file">
                @if ($fileUrl)
                    <div class="mt-2">
                        <a href="{{ $fileUrl }}" target="_blank" class="text-primary hover:text-primary-hover">
                            Просмотр\Скачать
                        </a>
                    </div>
                @endif
                <x-tt::form.error name="file"/>
            </div>

            <div>
                <label for="documentDescription" class="flex justify-start items-center mb-2">
                    Описание
                    @include("tt::admin.description-button", ["id" => "documentDescriptionHidden"])
                </label>
                @include("tt::admin.description-info", ["id" => "documentDescriptionHidden"])
                <textarea id="documentDescription"
                          class="form-control !min-h-52 {{ $errors->has('description') ? 'border-danger' : '' }}"
                          rows="10"
                          wire:model.live="description">
                        {{ $description }}
                    </textarea>
                <x-tt::form.error name="description"/>

                <div class="prose prose-sm mt-indent-half">
                    {!! \Illuminate\Support\Str::markdown($description) !!}
                </div>
            </div>

            <div class="flex items-center space-x-indent-half">
                <button type="button" class="btn btn-outline-dark" wire:click="closeData">
                    Отмена
                </button>
                <button type="submit" form="documentsDataForm" class="btn btn-primary" wire:loading.attr="disabled">
                    {{ $documentId ? "Обновить" : "Добавить" }}
                </button>
            </div>
        </form>
    </x-slot>
</x-tt::modal.dialog>
