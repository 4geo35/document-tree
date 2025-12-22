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
                                <a href="#" target="_blank" class="text-primary hover:text-primary-hover">
                                    Просмотр (Сделать ссылку)
                                </a>
                            </li>
                            <li class="flex flex-nowrap space-x-indent-half">
                                <span class="font-semibold">Размер:</span>
                                <span>{{ $file->human_size }}</span>
                            </li>
                            <li class="flex flex-nowrap space-x-indent-half">
                                <span class="font-semibold">Mime:</span>
                                <span>{{ $file->mime }}</span>
                            </li>
                        </ul>
                    @endif
                </td>
                <td></td>
            </tr>
        @endforeach
    </x-slot>
</x-tt::table>
