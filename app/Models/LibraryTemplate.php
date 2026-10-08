<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LibraryTemplate extends Model
{
    protected $table = "library_templates";
    protected $fillable = ["company_id","name","content","type"];
}
