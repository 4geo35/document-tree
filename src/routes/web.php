<?php

use Illuminate\Support\Facades\Route;
use GIS\DocumentTree\Http\Controllers\Web\DocumentTreeController;

Route::middleware(["web"])
    ->as("web.")
    ->group(function () {
        Route::prefix(config("document-tree.prefix"))
            ->as("document-categories.")
            ->group(function () {
                $controllerClass = config("document-tree.customWebDocumentTreeController") ?? DocumentTreeController::class;
                Route::get("/", [$controllerClass, "index"])->name("index");
                Route::get("/{category}", [$controllerClass, "show"])->name("show");
            });
    });
