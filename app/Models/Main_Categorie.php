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
    
    public function getActive()
    {
        return $this->active ==  1 ? 'مفعل':'غير مفعل';

    }
    
    public function scopeSelection($query)
    {

        return $query->select('id', 'translation_lang', 'name', 'slug', 'photo', 'active', 'translation_of');
    }
    public function getPhotoAttribute($val) // to add the url of local host to photo url
    {
        return ($val !== null) ? asset('' . $val) : "";

    }

    public function categories()
    {
        return $this->hasMany(self::class,'translation_of');
    }

     
}
