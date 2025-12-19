<div>
    <div class="card">
        <div class="card-header">
            <div class="space-y-indent-half">
                @include("dt::admin.document-tree.includes.show-title")
                <x-tt::notifications.error/>
                <x-tt::notifications.success/>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col w-full md:w-1/2 mb-indent-half md:mb-0 flex flex-col gap-indent-half">
                    <div class="row">
                        <div class="col w-full xs:w-2/5 mb-indent-half xs:mb-0">
                            <h3 class="font-semibold">Адресная строка</h3>
                        </div>
                        <div class="col w-full xs:w-3/5">{{ $category->slug }}</div>
                    </div>

                    <div class="row">
                        <div class="col w-full xs:w-2/5 mb-indent-half xs:mb-0">
                            <h3 class="font-semibold">Краткое описание</h3>
                        </div>
                        <div class="col w-full xs:w-3/5">{{ $category->short }}</div>
                    </div>

                    <div class="row">
                        <div class="col w-full xs:w-2/5 mb-indent-half xs:mb-0">
                            <h3 class="font-semibold">Раскрывать вложенные</h3>
                        </div>
                        <div class="col w-full xs:w-3/5">{{ $category->show_nested ? "Да" : "Нет" }}</div>
                    </div>

                    @if ($category->children->count())
                        <div class="row">
                            <div class="col w-full xs:w-2/5 mb-indent-half xs:mb-0">
                                <h3 class="font-semibold">Дочерние</h3>
                            </div>
                            <div class="col w-full xs:w-3/5">
                                <ul>
                                    @foreach($category->children()->orderBy("priority")->get() as $child)
                                        <li class="py-1">
                                            <a href="{{ route("admin.document-tree.show", ['category' => $child]) }}"
                                               class="text-primary hover:text-primary-hover">
                                                {{ $child->title }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    @if ($category->parent)
                        <div class="row">
                            <div class="col w-full xs:w-2/5 mb-indent-half xs:mb-0">
                                <h3 class="font-semibold">Родитель</h3>
                            </div>
                            <div class="col w-full xs:w-3/5">
                                <a href="{{ route("admin.document-tree.show", ['category' => $category->parent]) }}"
                                   class="text-primary hover:text-primary-hover">
                                    {{ $category->parent->title }}
                                </a>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="col w-full md:w-1/2 mb-indent-half md:mb-0 flex flex-col gap-indent-half">
                    <div>
                        <h3 class="font-semibold mb-indent-half">Описание</h3>
                        <div class="prose max-w-none">
                            {!! $category->markdown !!}
                        </div>
                    </div>

                    <div>
                        <h3 class="font-semibold mb-indent-half">Информация</h3>
                        <div class="prose max-w-none">
                            {!! $category->info_markdown !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include("dt::admin.document-tree.includes.modals")
</div>
