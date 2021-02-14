<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MainCategoriesrequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
             
            'photo'=> 'reuired|string|mimes:jpg,jpeg,png',
            
            'categorie' => 'required|array|min:1',
            'categorie.*.name' => 'required',
            'categorie.*.abbr' => 'required',
        ];
    }
    public function messsage()
    {
        return['required' => 'هذا الحقل مطلوب',];
    }

     
    
}
