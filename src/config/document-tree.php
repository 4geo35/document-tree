<?php

return [
    "prefix" => "documents",
    "pageTitle" => "Документы",
    "categoryPageTitle" => "Категории документов",
    "singlePage" => false,

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

    // Policy
    "documentCategoryTitle" => "Управление категориями документов",
    "documentCategory" => \GIS\DocumentTree\Policies\DocumentCategoryPolicy::class,
    "documentCategoryKey" => "document_categories",

    "documentTitle" => "Управление документами",
    "document" => \GIS\DocumentTree\Policies\DocumentPolicy::class,
    "documentKey" => "documents",
];
