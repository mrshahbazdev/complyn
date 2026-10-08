<?php

namespace App\Models;

use App\Support\HasTags;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Document extends Model
{
    use HasTags;

    protected $fillable = ['company_id', 'category_id', 'uploaded_by', 'title', 'description', 'status'];

    public function company(): BelongsTo { return $this->belongsTo(Company::class); }
    public function category(): BelongsTo { return $this->belongsTo(Category::class); }
    public function versions(): HasMany { return $this->hasMany(DocumentVersion::class); }
    public function latestVersion() { return $this->hasOne(DocumentVersion::class)->latestOfMany('version'); }
}
