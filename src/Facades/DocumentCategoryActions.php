<?php

namespace GIS\DocumentTree\Facades;

use GIS\DocumentTree\Helpers\DocumentCategoryActionsManager;
use GIS\PriceList\Interfaces\DocumentCategoryInterface;
use Illuminate\Support\Facades\Facade;

/**
 * @method static array getCategoryTree(array $newOrder = null)
 * @method static bool rebuildTree(array $newOrder)
 *
 * @method static void cascadeShutdown(DocumentCategoryInterface $category)
 *
 * @see DocumentCategoryActionsManager
 */
class DocumentCategoryActions extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return "document-category-actions";
    }
}
