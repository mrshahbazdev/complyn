<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LibraryArticle extends Model
{
    protected $table = "library_articles";
    protected $fillable = ["company_id","category_id","title","body","status"];

    public function category()
    {
        return $this->belongsTo(\App\Models\Category::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}