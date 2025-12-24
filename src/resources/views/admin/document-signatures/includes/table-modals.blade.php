<x-tt::modal.confirm wire:model="displayDelete">
    <x-slot name="title">Удалить подпись</x-slot>
    <x-slot name="text">Будет невозможно восстановить подпись!</x-slot>
</x-tt::modal.confirm>

<x-tt::modal.aside wire:model="displayData">
    <x-slot name="title">
        {{ $signatureId ? "Редактировать подпись" : "Добавить подпись" }}
    </x-slot>
    <x-slot name="content">
        <form wire:submit.prevent="{{ $signatureId ? 'update' : 'store' }}"
              class="space-y-indent-half"
              id="signaturesDataForm">
            <div>
                <label for="signatureFile" class="inline-block mb-2">
                    Файл подписи @if (!$fileUrl) <span class="text-danger">*</span> @endif
                </label>
                <input type="file" id="signatureFile"
                       class="form-control {{ $errors->has('file') ? 'border-danger' : '' }}"
                       wire:loading.attr="disabled"
                       wire:model.lazy="file">
                <x-tt::form.error name="file"/>
                @if ($fileUrl)
                    <div class="mt-2">
                        <a href="{{ $fileUrl }}" target="_blank" class="text-primary hover:text-primary-hover">
                            Скачать
                        </a>
                    </div>
                @endif
            </div>

            <div>
                <label for="signatureTitle" class="inline-block mb-2">
                    Заголовок<span class="text-danger">*</span>
                </label>
                <input type="text" id="signatureTitle"
                       class="form-control {{ $errors->has("title") ? "border-danger" : "" }}"
                       required
                       wire:loading.attr="disabled"
                       wire:model="title">
                <x-tt::form.error name="title"/>
            </div>

            <div>
                <label for="signaturePerson" class="inline-block mb-2">
                    Подписант
                </label>
                <input type="text" id="signaturePerson"
                       class="form-control {{ $errors->has("person") ? "border-danger" : "" }}"
                       wire:loading.attr="disabled"
                       wire:model="person">
                <x-tt::form.error name="person"/>
            </div>

            <div>
                <label for="signaturePosition" class="inline-block mb-2">
                    Должность
                </label>
                <input type="text" id="signaturePosition"
                       class="form-control {{ $errors->has("position") ? "border-danger" : "" }}"
                       wire:loading.attr="disabled"
                       wire:model="position">
                <x-tt::form.error name="position"/>
            </div>

            <div>
                <label for="signatureOrganization" class="inline-block mb-2">
                    Организация
                </label>
                <input type="text" id="signatureOrganization"
                       class="form-control {{ $errors->has("organization") ? "border-danger" : "" }}"
                       wire:loading.attr="disabled"
                       wire:model="organization">
                <x-tt::form.error name="organization"/>
            </div>

            <div>
                <label for="signatureDate" class="inline-block mb-2">
                    Дата подписания
                </label>
                <input type="date" id="signatureDate"
                       class="form-control {{ $errors->has("date") ? "border-danger" : "" }}"
                       wire:loading.attr="disabled"
                       wire:model="date">
                <x-tt::form.error name="date"/>
            </div>

            <div>
                <label for="signatureCertificate" class="inline-block mb-2">
                    Сертификат
                </label>
                <input type="text" id="signatureCertificate"
                       class="form-control {{ $errors->has("certificate") ? "border-danger" : "" }}"
                       wire:loading.attr="disabled"
                       wire:model="certificate">
                <x-tt::form.error name="certificate"/>
            </div>

            <div>
                <label for="signatureIssued" class="flex justify-start items-center mb-2">
                    Кем выдан
                </label>
                <textarea id="signatureIssued"
                          class="form-control !min-h-52 {{ $errors->has('issued') ? 'border-danger' : '' }}"
                          rows="10"
                          wire:model="issued">
                        {{ $issued }}
                </textarea>
                <x-tt::form.error name="issued"/>
            </div>

            <div>
                <label for="signaturePeriod" class="inline-block mb-2">
                    Период действия сертификата
                </label>
                <input type="text" id="signaturePeriod"
                       class="form-control {{ $errors->has("period") ? "border-danger" : "" }}"
                       wire:loading.attr="disabled"
                       wire:model="period">
                <x-tt::form.error name="period"/>
            </div>

            <div class="flex items-center space-x-indent-half">
                <button type="button" class="btn btn-outline-dark" wire:click="closeData">
                    Отмена
                </button>
                <button type="submit" form="signaturesDataForm" class="btn btn-primary" wire:loading.attr="disabled">
                    {{ $signatureId ? "Обновить" : "Добавить" }}
                </button>
            </div>
        </form>
    </x-slot>
</x-tt::modal.aside>
