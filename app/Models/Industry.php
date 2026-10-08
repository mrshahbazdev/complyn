<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Industry extends Model
{
    use HasFactory;

    protected $fillable = ['key', 'name_de', 'name_en'];

    public function label(?string $locale = null): string
    {
        return ($locale ?? app()->getLocale()) === 'de' ? $this->name_de : $this->name_en;
    }
}
