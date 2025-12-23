<?php

namespace GIS\DocumentTree\Models;

use GIS\DocumentTree\Interfaces\DocumentSignatureInterface;
use GIS\Fileable\Traits\ShouldFile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DocumentSignature extends Model implements DocumentSignatureInterface
{
    use ShouldFile;

    protected $fillable = [
        "title",
        "person",
        "position",
        "organization",
        "date",
        "certificate",
        "issued",
        "period",
    ];

    public function document(): BelongsTo
    {
        $modelClass = config("document-tree.customDocumentModel") ?? Document::class;
        return $this->belongsTo($modelClass, "document_id");
    }
}
