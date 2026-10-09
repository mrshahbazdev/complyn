<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CreatorDraft extends Model
{
    protected $table = "creator_drafts";
    protected $fillable = ["company_id","user_id","title","content","type","status","document_id"];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}