<?php

namespace GIS\DocumentTree;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

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
    }

    protected function bindInterfaces(): void
    {
    }

    protected function expandConfiguration(): void
    {
        $dt = app()->config['document-tree'];

        $um = app()->config["user-management"];
        $permissions = $um["permissions"];
        // TODO: add document policy
        app()->config["user-management.permissions"] = $permissions;
    }

    protected function observeModels(): void
    {
    }

    protected function setPolicies(): void
    {
    }

    protected function addLivewireComponents(): void
    {
    }
}
