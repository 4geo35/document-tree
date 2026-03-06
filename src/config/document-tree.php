<?php

return [
    "prefix" => "documents",
    "pageTitle" => "Документы",
    "categoryPageTitle" => "Категории документов",
    "useBreadcrumbs" => true,
    "useH1" => true,
    "singlePage" => false, // Если включить, то лучше поставить addToHeaderSize в значение 1
    "addToHeaderSize" => 2,

    "customWebDocumentTreeController" => null,

    // Admin
    "customDocumentCategoryModel" => null,
    "customDocumentCategoryModelObserver" => null,

    "customDocumentModel" => null,
    "customDocumentModelObserver" => null,

    "customDocumentSignatureModel" => null,

    "customAdminDocumentTreeController" => null,

    // Facades
    "customDocumentTreeActionsManager" => null,

    // Components
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
