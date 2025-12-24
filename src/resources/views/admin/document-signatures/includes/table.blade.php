<x-tt::table>
    <x-slot name="head">
        <tr>
            <x-tt::table.heading class="text-left">Заголовок</x-tt::table.heading>
            <x-tt::table.heading class="text-left">Данные</x-tt::table.heading>
            <x-tt::table.heading class="text-left">Файл</x-tt::table.heading>
            <x-tt::table.heading>Действия</x-tt::table.heading>
        </tr>
    </x-slot>
    <x-slot name="body">
        @foreach($signatures as $item)
            <tr>
                <td>{{ $item->title }}</td>
                <td>
                    <ul class="space-y-2">
                        <li class="flex flex-nowrap space-x-indent-half">
                            <span class="font-semibold">Подписант:</span>
                            <span class="text-nowrap">{{ $item->person }}</span>
                        </li>
                        <li class="flex flex-nowrap space-x-indent-half">
                            <span class="font-semibold">Должность:</span>
                            <span class="text-nowrap">{{ $item->position }}</span>
                        </li>
                        <li class="flex flex-nowrap space-x-indent-half">
                            <span class="font-semibold">Организация:</span>
                            <span class="text-nowrap">{{ $item->organization }}</span>
                        </li>
                        <li class="flex flex-nowrap space-x-indent-half">
                            <span class="font-semibold">Дата:</span>
                            <span class="text-nowrap">{{ $item->date }}</span>
                        </li>
                        <li class="flex flex-nowrap space-x-indent-half">
                            <span class="font-semibold">Сертификат:</span>
                            <span class="text-nowrap">{{ $item->certificate }}</span>
                        </li>
                        <li class="flex flex-nowrap space-x-indent-half">
                            <span class="font-semibold">Кем выдан:</span>
                            <span class="text-nowrap">{{ $item->issued }}</span>
                        </li>
                        <li class="flex flex-nowrap space-x-indent-half">
                            <span class="font-semibold">Период действия:</span>
                            <span class="text-nowrap">{{ $item->period }}</span>
                        </li>
                    </ul>
                </td>
                <td>
                    @php($file = $item->file)
                    @if($file)
                        <ul>
                            <li>
                                <a href="{{ route('download-file', ['filename' => $file->file_name]) }}"
                                   target="_blank" class="text-primary hover:text-primary-hover">
                                    Скачать
                                </a>
                            </li>
                            <li class="flex flex-nowrap space-x-indent-half">
                                <span class="font-semibold">Размер:</span>
                                <span class="text-nowrap">{{ $file->human_size }}</span>
                            </li>
                            <li class="flex flex-nowrap space-x-indent-half">
                                <span class="font-semibold">Формат:</span>
                                <span class="text-nowrap">{{ $file->mime }}</span>
                            </li>
                        </ul>
                    @endif
                </td>
                <td>
                    <div class="flex items-center justify-center">
                        <button type="button" class="btn btn-dark px-btn-x-ico rounded-e-none"
                                @cannot("update", $item) disabled
                                @else wire:loading.attr="disabled"
                                @endcannot
                                wire:click="showEdit({{ $item->id }})">
                            <x-tt::ico.edit />
                        </button>
                        <button type="button" class="btn btn-danger px-btn-x-ico rounded-s-none"
                                @cannot("delete", $item) disabled
                                @else wire:loading.attr="disabled"
                                @endcannot
                                wire:click="showDelete({{ $item->id }})">
                            <x-tt::ico.trash />
                        </button>
                    </div>
                </td>
            </tr>
        @endforeach
    </x-slot>
</x-tt::table>
