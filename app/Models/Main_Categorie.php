<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Main_Categorie extends Model
{
    use HasFactory;

    
    protected $table = 'main_categories';

    protected $fillable = [
        'id',
        'name',
        'translation_lang',
        'translation_of',
        'slug',
        'created_at',
        'updated_at',
        'active',
        'photo'
    ];

    
    protected $timestamp = ['created_at','updated_at'];

    public function scopeActive($query)
    {
        return $query->where('active','1');
    }

     
}
