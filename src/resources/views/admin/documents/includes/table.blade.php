<x-tt::table>
    <x-slot name="head">
        <tr>
            <x-tt::table.heading class="text-left">Заголовок</x-tt::table.heading>
            <x-tt::table.heading class="text-left">Описание</x-tt::table.heading>
            <x-tt::table.heading class="text-left">Файл</x-tt::table.heading>
            <x-tt::table.heading>Действия</x-tt::table.heading>
        </tr>
    </x-slot>
    <x-slot name="body">
        @foreach($documents as $item)
            <tr>
                <td>{{ $item->title }}</td>
                <td>
                    <div class="prose max-w-none">{!! $item->markdown !!}</div>
                </td>
                <td>
                    @php($file = $item->file)
                    @if($file)
                        <ul>
                            <li>
                                <a href="{{ route('download-file', ['filename' => $file->file_name]) }}"
                                   target="_blank" class="text-primary hover:text-primary-hover">
                                    Просмотр\Скачать
                                </a>
                            </li>
                            <li class="flex flex-nowrap space-x-indent-half">
                                <span class="font-semibold">Размер:</span>
                                <span>{{ $file->human_size }}</span>
                            </li>
                            <li class="flex flex-nowrap space-x-indent-half">
                                <span class="font-semibold">Формат:</span>
                                <span>{{ $file->mime }}</span>
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
                        @can("update", $item)
                            <button type="button" class="btn btn-outline-warning px-btn-x-ico ml-2"
                                    wire:loading.attr="disabled"
                                    wire:click="showSignatures({{ $item->id }})">
                                <x-dt::ico.draw />
                            </button>
                        @endcan
                    </div>
                </td>
            </tr>
        @endforeach
    </x-slot>
</x-tt::table>
