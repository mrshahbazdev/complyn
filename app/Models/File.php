<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class File extends Model
{
    protected $fillable = ['company_id', 'uploaded_by', 'context', 'path', 'original_name', 'size', 'mime'];

    public function company(): BelongsTo { return $this->belongsTo(Company::class); }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}