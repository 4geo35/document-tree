<?php

namespace GIS\DocumentTree;

use GIS\DocumentTree\Helpers\DocumentCategoryActionsManager;
use GIS\DocumentTree\Models\Document;
use GIS\DocumentTree\Models\DocumentCategory;
use GIS\DocumentTree\Observers\DocumentCategoryObserver;
use GIS\DocumentTree\Interfaces\DocumentCategoryInterface;
use GIS\DocumentTree\Observers\DocumentObserver;
use GIS\DocumentTree\View\Components\TreeSidebarComponent;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use GIS\DocumentTree\Livewire\Admin\DocumentCategories\IndexWire as AdminDocumentCategoriesIndexWire;
use GIS\DocumentTree\Livewire\Admin\DocumentCategories\ShowWire as AdminDocumentCategoriesShowWire;
use GIS\DocumentTree\Livewire\Admin\Documents\ListWire as AdminDocumentsListWire;
use GIS\DocumentTree\Livewire\Admin\DocumentSignatures\ListWire as AdminDocumentSignaturesListWire;

class DocumentTreeServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');

        $this->mergeConfigFrom(__DIR__ . '/config/document-tree.php', 'document-tree');

        $this->initFacades();
        $this->bindInterfaces();
    }

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'dt');

        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        $this->loadRoutesFrom(__DIR__ . '/routes/admin.php');

        $this->expandConfiguration();
        $this->observeModels();
        $this->setPolicies();

        $this->addLivewireComponents();
        $this->addBladeComponents();
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
        $permissions[] = [
            "title" => $dt["documentTitle"],
            "key" => $dt["documentKey"],
            "policy" => $dt["document"],
        ];
        app()->config["user-management.permissions"] = $permissions;
    }

    protected function observeModels(): void
    {
        $modelClass = config("document-tree.customDocumentCategoryModel") ?? DocumentCategory::class;
        $observerClass = config("document-tree.customDocumentCategoryModelObserver") ?? DocumentCategoryObserver::class;
        $modelClass::observe($observerClass);

        $modelClass = config("document-tree.customDocumentModel") ?? Document::class;
        $observerClass = config("document-tree.customDocumentModelObserver") ?? DocumentObserver::class;
        $modelClass::observe($observerClass);
    }

    protected function setPolicies(): void
    {
        Gate::policy(config("document-tree.customDocumentCategoryModel") ?? DocumentCategory::class, config("document-tree.documentCategory"));

        Gate::policy(config("document-tree.customDocumentModel") ?? Document::class, config("document-tree.document"));
    }

    protected function addLivewireComponents(): void
    {
        $component = config("document-tree.customAdminDocumentCategoryIndexComponent");
        Livewire::component(
            "dt-admin-document-category-index",
            $component ?? AdminDocumentCategoriesIndexWire::class
        );

        $component = config("document-tree.customAdminDocumentCategoryShowComponent");
        Livewire::component(
            "dt-admin-document-category-show",
            $component ?? AdminDocumentCategoriesShowWire::class
        );

        $component = config("document-tree.customAdminDocumentListComponent");
        Livewire::component(
            "dt-admin-document-list",
            $component ?? AdminDocumentsListWire::class
        );

        $component = config("document-tree.customAdminDocumentSignatureIndexComponent");
        Livewire::component(
            "dt-admin-document-signature-list",
            $component ?? AdminDocumentSignaturesListWire::class
        );
    }

    protected function addBladeComponents(): void
    {
        $component = config("document-tree.customWebTreeSidebarComponent") ?? TreeSidebarComponent::class;
        Blade::component("dt-tree-sidebar", $component);
    }
}
