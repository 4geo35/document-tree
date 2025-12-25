<?php

namespace GIS\DocumentTree\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use GIS\DocumentTree\Facades\DocumentCategoryActions;
use GIS\DocumentTree\Interfaces\DocumentCategoryInterface;
use GIS\DocumentTree\Models\DocumentCategory;
use GIS\Metable\Facades\MetaActions;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DocumentTreeController extends Controller
{
    public function index(): RedirectResponse|View
    {
        if (config('document-tree.singlePage')) {
            $metas = MetaActions::renderByPage(config('document-tree.prefix'));
            $tree = DocumentCategoryActions::buildNestedTree();
            return view("dt::web.document-categories.index", compact('metas', 'tree'));
        } else {
            $modelClass = config("document-tree.customDocumentCategoryModel") ?? DocumentCategory::class;
            $category = $modelClass::query()
                ->whereNull("parent_id")
                ->whereNotNull("published_at")
                ->orderBy("priority")
                ->firstOrFail();

            if (! $category->show_nested) {
                $nestedChild = DocumentCategoryActions::findNestedChild($category);
                if ($nestedChild->id !== $category->id) { $category = $nestedChild; }
            }

            return redirect()->route("web.document-categories.show", compact('category'));
        }
    }

    public function show(DocumentCategoryInterface $category): RedirectResponse|View
    {
        if (! $category->published_at) { abort(404); }
        if (config("document-tree.singlePage")) {
            return redirect()->route("web.document-categories.index", [], 301);
        }
        $rootNested = DocumentCategoryActions::findRootNested($category);
        if ($rootNested) {
            return redirect()->route("web.document-categories.show", ["category" => $rootNested]);
        }

        $metas = MetaActions::renderByModel($category);
        $parents = DocumentCategoryActions::getParents($category);

        $renderDocumentTree = $category->show_nested || !$category->children()->select("id")->count();

        if ($renderDocumentTree) { $tree = DocumentCategoryActions::buildNestedTree($category); }
        else { $tree = $category->children()->select("id", "title", "slug")->orderBy("priority")->get(); }

        return view("dt::web.document-categories.show", compact('category', 'metas', 'parents', 'renderDocumentTree', 'tree'));
    }
}
