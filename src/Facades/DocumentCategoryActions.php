<?php

namespace GIS\DocumentTree\Facades;

use GIS\DocumentTree\Helpers\DocumentCategoryActionsManager;
use GIS\DocumentTree\Interfaces\DocumentCategoryInterface;
use GIS\TraitsHelpers\Interfaces\ShouldTreeInterface;
use Illuminate\Support\Facades\Facade;

/**
 * @method static void cascadeShutdown(DocumentCategoryInterface $category)
 *
 * @method static array getCategoryTree(array $newOrder = null)
 * @method static bool rebuildTree(array $newOrder)
 *
 * @method static array buildNestedTree(ShouldTreeInterface $item = null)
 *
 * @method static ShouldTreeInterface findNestedChild(ShouldTreeInterface $item)
 * @method static ShouldTreeInterface|null findRootNested(ShouldTreeInterface $item)
 *
 * @method static array getElementIds(ShouldTreeInterface $list, bool $includeSubs = false)
 * @method static array getChildrenIds(ShouldTreeInterface $list, bool $includeSelf = false)
 * @method static array getParents(ShouldTreeInterface $list)
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
