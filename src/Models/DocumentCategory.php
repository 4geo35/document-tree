<?php

namespace GIS\DocumentTree\Models;

use GIS\Metable\Traits\ShouldMeta;
use GIS\PriceList\Interfaces\DocumentCategoryInterface;
use GIS\TraitsHelpers\Traits\ShouldHumanDate;
use GIS\TraitsHelpers\Traits\ShouldHumanPublishDate;
use GIS\TraitsHelpers\Traits\ShouldMarkdown;
use GIS\TraitsHelpers\Traits\ShouldSlug;
use GIS\TraitsHelpers\Traits\ShouldTree;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class DocumentCategory extends Model implements DocumentCategoryInterface
{
    use ShouldSlug, ShouldMeta, ShouldMarkdown, ShouldTree, ShouldHumanDate, ShouldHumanPublishDate;

    protected $fillable = [
        "title",
        "slug",
        "short",
        "description",
        "info",
        "show_nested",
        "published_at",
    ];

    public function getInfoMarkdownAttribute(): ?string
    {
        $value = $this->info;
        if (! $value) return $value;
        return Str::markdown($value);
    }
}
