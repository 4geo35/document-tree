@if (config("document-tree.useBreadcrumbs"))
    @php($homeUrl = Route::has("web.home") ? route("web.home") : "/")
    @php($indexUrl = route("web.document-categories.index"))
    <x-tt::breadcrumbs>
        <x-tt::breadcrumbs.item :url="$homeUrl">Главная</x-tt::breadcrumbs.item>
        <x-tt::breadcrumbs.item :url="$indexUrl">{{ config("document-tree.categoryPageTitle") }}</x-tt::breadcrumbs.item>
        @foreach($parents as $parent)
            @php($parentUrl = route("web.document-categories.show", ["category" => $parent->slug]))
            <x-tt::breadcrumbs.item :url="$parentUrl">{{ $parent->title }}</x-tt::breadcrumbs.item>
        @endforeach
        <x-tt::breadcrumbs.item>{{ $category->title }}</x-tt::breadcrumbs.item>
    </x-tt::breadcrumbs>
@endif
