<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LibraryArticle extends Model
{
    protected $table = "library_articles";
    protected $fillable = ["company_id","category_id","title","body","status"];
}
