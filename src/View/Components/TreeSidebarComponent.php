<?php

namespace GIS\DocumentTree\View\Components;

use GIS\DocumentTree\Facades\DocumentCategoryActions;
use GIS\DocumentTree\Interfaces\DocumentCategoryInterface;
use Illuminate\View\Component;
use Illuminate\View\View;
class TreeSidebarComponent extends Component
{
    public array $parentIds = [];
    public bool $useAnchors = false;

    public function __construct(
        public array $parents = [],
        public DocumentCategoryInterface|null $category = null
    ){
        $array = [];
        if ($this->category) { $array[] = $this->category->id; }
        foreach ($this->parents as $parent) {
            $array[] = $parent->id;
        }
        $this->parentIds = array_unique($array);
        $this->useAnchors = config("document-tree.singlePage");
    }

    public function render(): View
    {
        $tree = $this->makeTree();
        return view("dt::web.document-categories.components.tree-sidebar.index", compact("tree"));
    }

    protected function makeTree(): array
    {
        $rawTree = DocumentCategoryActions::getCategoryTree();
        return $this->checkTree($rawTree);
    }

    protected function checkTree(array &$tree): array
    {
        foreach ($tree as $key => &$item) {
            if (!$item["published_at"]) {
                unset($tree[$key]);
            }
            if ($item["show_nested"] && ! config("document-tree.singlePage")) {
                $item["children"] = [];
            } else {
                $item["children"] = $this->checkTree($item["children"]);
            }
            $item["hasChildren"] = count($item["children"]) > 0;
            $item["expanded"] = in_array($item["id"], $this->parentIds);
            $item["isActive"] = $item["id"] == $this->category->id;
        }
        return $tree;
    }
}
