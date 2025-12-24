<?php

namespace GIS\DocumentTree\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use GIS\DocumentTree\Interfaces\DocumentCategoryInterface;
use GIS\DocumentTree\Models\DocumentCategory;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class DocumentTreeController extends Controller
{
    public function index(): View
    {
        $modelClass = config("document-tree.customDocumentCategoryModel") ?? DocumentCategory::class;
        Gate::authorize("viewAny", $modelClass);
        return view("dt::admin.document-categories.index");
    }

    public function show(DocumentCategoryInterface $category): View
    {
        $modelClass = config("document-tree.customDocumentCategoryModel") ?? DocumentCategory::class;
        Gate::authorize("viewAny", $modelClass);
        return view("dt::admin.document-categories.show", compact("category"));
    }
}
