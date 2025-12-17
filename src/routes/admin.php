<?php

use Illuminate\Support\Facades\Route;
use GIS\DocumentTree\Http\Controllers\Admin\DocumentTreeController;

Route::middleware(["web", "auth", "app-management"])
    ->prefix("admin")
    ->as("admin.")
    ->group(function () {
        Route::prefix(config("document-tree.prefix"))
            ->as("document-tree.")
            ->group(function () {
                $controllerClass = config("document-tree.customAdminDocumentTreeController") ?? DocumentTreeController::class;
                Route::get("/", [$controllerClass, "index"])->name("index");
                Route::get("/{category}", [$controllerClass, "show"])->name("show");
            });
    });
