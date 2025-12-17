<?php

namespace GIS\DocumentTree\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;
use Illuminate\Support\Facades\Gate;

class DocumentTreeController extends Controller
{
    public function index(): View
    {
        return view("dt::admin.document-tree.index");
    }
}
