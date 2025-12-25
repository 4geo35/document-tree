<?php

namespace GIS\DocumentTree\Facades;

use GIS\DocumentTree\Helpers\DocumentCategoryActionsManager;
use GIS\DocumentTree\Interfaces\DocumentCategoryInterface;
use Illuminate\Support\Facades\Facade;

/**
 * @method static array buildDocumentTree(DocumentCategoryInterface $category = null)
 *
 * @method static DocumentCategoryInterface findNestedChild(DocumentCategoryInterface $category)
 * @method static DocumentCategoryInterface|null findRootNested(DocumentCategoryInterface $category)
 *
 * @method static array getCategoryTree(array $newOrder = null)
 * @method static bool rebuildTree(array $newOrder)
 *
 * @method static void cascadeShutdown(DocumentCategoryInterface $category)
 *
 * @method static array getDocumentIds(DocumentCategoryInterface $category, bool $includeSubs = false)
 * @method static array getChildrenIds(DocumentCategoryInterface $category, bool $includeSelf = false)
 *
 * @method static array getParents(DocumentCategoryInterface $list)
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
