<?php

return [
    "prefix" => "documents",
    "pageTitle" => "Документы",
    "categoryPageTitle" => "Категории документов",

    // Admin
    "customDocumentCategoryModel" => null,
    "customDocumentCategoryModelObserver" => null,

    "customAdminDocumentTreeController" => null,

    // Facades
    "customDocumentTreeActionsManager" => null,

    // Policy
    "documentCategoryTitle" => "Управление категориями документов",
    "documentCategory" => \GIS\DocumentTree\Policies\DocumentCategoryPolicy::class,
    "documentCategoryKey" => "document_categories",
];
