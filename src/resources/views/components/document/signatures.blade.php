@props(["document"])
@if ($document->signatures->count())
    <div class="flex items-center space-x-2">
        @foreach($document->signatures as $signature)
            <button type="button" x-data @click="$dispatch('show-signature-modal-{{ $signature->id }}')"
                    class="px-2 rounded-base bg-danger hover:bg-danger-hover text-white text-sm font-semibold cursor-pointer">
                ЭП
            </button>
            @push("modals")
                <x-tt::modal.dialog :id="'signatureModal' . $signature->id" :event="'show-signature-modal-' . $signature->id">
                    <x-slot name="title">Подписано квалифицированной электронной подписью</x-slot>
                    <x-slot name="content">
                        <div class="space-y-2 text-base">
                            <x-dt::document.signature-value :$signature column="person" title="Подписант" />
                            <x-dt::document.signature-value :$signature column="position" title="Должность" />
                            <x-dt::document.signature-value :$signature column="organization" title="Организация" />
                            <x-dt::document.signature-value :$signature column="date" title="Дата подписания" />
                            <x-dt::document.signature-value :$signature column="certificate" title="Сертификат" />
                            <x-dt::document.signature-value :$signature column="issued" title="Кем выдан" />
                            <x-dt::document.signature-value :$signature column="period" title="Период действия сертификата" />
                            <div class="mt-2" x-data="{expanded: false}">
                                <button type="button" class="font-semibold text-primary hover:text-primary-hover cursor-pointer" @click="expanded = !expanded">
                                    <span x-show="!expanded">Показать</span><span x-show="expanded">Скрыть</span> электронную подпись
                                </button>
                                <div x-collapse.duration.1000ms x-show="expanded" style="display: none" class="pt-indent-half">
                                    <div class="p-indent-half rounded-base border border-stroke break-words text-xs">
                                        {{ Storage::get($signature->file->path) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </x-slot>
                </x-tt::modal.dialog>
            @endpush
        @endforeach
    </div>
@endif
