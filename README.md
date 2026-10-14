### Установка

Добавить в `tailwind.admin.config.js`, созданный в пакете `tailwindcss-theme`.

    "./vendor/4geo35/document-tree/src/resources/views/components/**/*.blade.php",
    "./vendor/4geo35/document-tree/src/resources/views/admin/**/*.blade.php",
    "./vendor/4geo35/document-tree/src/resources/views/livewire/admin/**/*.blade.php",

Добавить в `tailwind.config.js`, созданный в пакете `tailwindcss-theme`.

    "./vendor/4geo35/document-tree/src/resources/views/components/**/*.blade.php",
    "./vendor/4geo35/document-tree/src/resources/views/web/**/*.blade.php",
    "./vendor/4geo35/document-tree/src/resources/views/livewire/web/**/*.blade.php",

Запустить миграции для создания таблиц `php artisan migrate`

Установить lightbox `npm install fslightbox`, добавить в `app.js`:

    import "fslightbox"

#### Views

Сокращение для представлений: `dt`  
Меню для панели администрирования: `<x-dt::menu-item/>`

#### Config

Название файла: `document-tree`

- `prefix` => `documents`: адрес страницы
- `categoryPageTitle` => `Категории документов`: заголовок индексной страницы
- `useBreadcrumbs` => `true`: выводить хлебные крошки на странице
- `useH1` => `true`: выводить h1
- `singlePage` => `false`: вывод всего дерева на одной странице. Если включить, то лучше поставить addToHeaderSize в значение 1
- `addToHeaderSize` => `2`: какого размера будут заголовки

#### Routes

Файл `admin.php`, `middleware(["web", "auth", "app-management"])`, `prefix(config("document-tree.prefix"))`

- `admin.document-tree.index` => `admin/{prefix}`
- `admin.document-tree.show` => `admin/{prefix}/{category}`

Файл `web.php`, `middleware(["web"])`, `prefix(config("document-tree.prefix"))`

- `web.document-categories.index` => `{prefix}`
- `web.document-categories.show` => `{prefix}/{category}`
