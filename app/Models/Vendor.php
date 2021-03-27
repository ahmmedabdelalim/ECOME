<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Expr\FuncCall;
use Illuminate\Notifications\Notifiable;

class Vendor extends Model
{
    use HasFactory;
    use Notifiable;

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
        'logo',
        'password',
    ];

    
    protected $timestamp = ['created_at','updated_at'];
    protected $hiddden = ['category_id','password',];


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

        return $query->select('id', 'category_id','address','email', 'active', 'name', 'logo', 'mobile','password');
    }

    public function category()
    {
        return $this->belongsTo(Main_Categorie::class,'category_id','id');
    }

    // encrypt the password 

    public function setPasswordAttribute($password)
    {
        if(!empty($password))
        {
            $this->attributes['password']= bcrypt($password);
        }

    }
}
