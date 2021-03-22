<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Expr\FuncCall;

class Vendor extends Model
{
    use HasFactory;

    protected $table = 'vendors';

    protected $fillable = [
        'id',
        'name',
        'mobile',
        'address',
        'email',
        'created_at',
        'updated_at',
        'category_id',
        'active',
        'logo'
    ];

    
    protected $timestamp = ['created_at','updated_at'];
    protected $hiddden = ['category_id'];


    public function scopeActive($query)
    {
        return $query->where('active',1);
    }

    public function getActive()
    {
        return $this->active ==  1 ? 'مفعل':'غير مفعل';

    }

    public function getPhotoAttribute($val) // to add the url of local host to photo url
    {
        return ($val !== null) ? asset('' . $val) : "";

    }

    public function scopeSelection($query)
    {

        return $query->select('id', 'category_id', 'active', 'name', 'logo', 'mobile');
    }

    public function category()
    {
        return $this->belongsTo(Main_Categorie::class,'category_id','id');
    }
}
