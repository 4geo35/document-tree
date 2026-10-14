<?php

return [
    // Settings
    "prefix" => "documents",
    "categoryPageTitle" => "Категории документов",
    "useBreadcrumbs" => true,
    "useH1" => true,
    "singlePage" => false, // Если включить, то лучше поставить addToHeaderSize в значение 1
    "addToHeaderSize" => 2,

    // Models
    "customDocumentCategoryModel" => null,
    "customDocumentCategoryModelObserver" => null,

    "customDocumentModel" => null,
    "customDocumentModelObserver" => null,

    "customDocumentSignatureModel" => null,

    // Controllers
    "customWebDocumentTreeController" => null,

    "customAdminDocumentTreeController" => null,

    // Facades
    "customDocumentTreeActionsManager" => null,

    // Wire Components
    "customAdminDocumentCategoryIndexComponent" => null,
    "customAdminDocumentCategoryShowComponent" => null,

    "customAdminDocumentListComponent" => null,

    "customAdminDocumentSignatureIndexComponent" => null,

    // Blade components
    "customWebTreeSidebarComponent" => null,

    // Policy
    "documentCategoryTitle" => "Управление категориями документов",
    "documentCategory" => \GIS\DocumentTree\Policies\DocumentCategoryPolicy::class,
    "documentCategoryKey" => "document_categories",

    "documentTitle" => "Управление документами",
    "document" => \GIS\DocumentTree\Policies\DocumentPolicy::class,
    "documentKey" => "documents",
];
