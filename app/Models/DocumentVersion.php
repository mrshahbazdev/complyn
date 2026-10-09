<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DocumentVersion extends Model
{
    protected $fillable = ['document_id', 'version', 'path', 'original_name', 'size', 'mime'];

    public function document(): BelongsTo { return $this->belongsTo(Document::class); }

    public function document()
    {
        return $this->belongsTo(\App\Models\Document::class);
    }
}