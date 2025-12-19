<?php

namespace GIS\DocumentTree\Interfaces;

use Illuminate\Database\Eloquent\Relations\MorphMany;

interface ShouldDocumentsInterface
{
    public function documents(): MorphMany;
    public function clearDocuments(): void;
}
