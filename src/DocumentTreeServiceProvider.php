<?php

namespace GIS\DocumentTree;

use GIS\DocumentTree\Helpers\DocumentCategoryActionsManager;
use GIS\DocumentTree\Models\DocumentCategory;
use GIS\DocumentTree\Observers\DocumentCategoryObserver;
use GIS\DocumentTree\Interfaces\DocumentCategoryInterface;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use GIS\DocumentTree\Livewire\Admin\DocumentCategories\IndexWire as AdminDocumentCategoriesIndexWire;

class DocumentTreeServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');

        $this->mergeConfigFrom(__DIR__ . '/config/document-tree.php', 'document-tree');

        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        $this->loadRoutesFrom(__DIR__ . '/routes/admin.php');

        $this->initFacades();
        $this->bindInterfaces();
    }

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'dt');

        $this->expandConfiguration();
        $this->observeModels();
        $this->setPolicies();

        $this->addLivewireComponents();
    }

    protected function initFacades(): void
    {
        $this->app->singleton("document-category-actions", function () {
            $managerClass = config("document-tree.customDocumentTreeActionsManager") ?? DocumentCategoryActionsManager::class;
            return new $managerClass();
        });
    }

    protected function bindInterfaces(): void
    {
        $modelClass = config("document-tree.customDocumentCategoryModel") ?? DocumentCategory::class;
        $this->app->bind(DocumentCategoryInterface::class, $modelClass);
    }

    protected function expandConfiguration(): void
    {
        $dt = app()->config['document-tree'];

        $um = app()->config["user-management"];
        $permissions = $um["permissions"];
        $permissions[] = [
            "title" => $dt["documentCategoryTitle"],
            "key" => $dt["documentCategoryKey"],
            "policy" => $dt["documentCategory"],
        ];
        app()->config["user-management.permissions"] = $permissions;
    }

    protected function observeModels(): void
    {
        $modelClass = config("document-tree.customDocumentCategoryModel") ?? DocumentCategory::class;
        $observerClass = config("document-tree.customDocumentCategoryModelObserver") ?? DocumentCategoryObserver::class;
        $modelClass::observe($observerClass);
    }

    protected function setPolicies(): void
    {
        Gate::policy(config("document-tree.customDocumentCategoryModel") ?? DocumentCategory::class, config("document-tree.documentCategory"));
    }

    protected function addLivewireComponents(): void
    {
        $component = config("document-tree.customAdminDocumentCategoryListComponent");
        Livewire::component(
            "dt-admin-document-category-list",
            $component ?? AdminDocumentCategoriesIndexWire::class
        );
    }
}
