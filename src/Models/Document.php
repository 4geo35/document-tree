<?php

namespace GIS\DocumentTree\Models;

use GIS\DocumentTree\Interfaces\DocumentInterface;
use GIS\Fileable\Traits\ShouldFile;
use GIS\TraitsHelpers\Traits\ShouldHumanDate;
use GIS\TraitsHelpers\Traits\ShouldMarkdown;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Document extends Model implements DocumentInterface
{
    use ShouldFile, ShouldHumanDate, ShouldMarkdown;

    protected $fillable = [
        "title",
        "description",
        "priority",
    ];

    public function documentable(): MorphTo
    {
        return $this->morphTo();
    }

    public function signatires(): HasMany
    {
        $modelClass = config("document-tree.customDocumentSignatureModel") ?? DocumentSignature::class;
        return $this->hasMany($modelClass, "document_id");
    }
}
