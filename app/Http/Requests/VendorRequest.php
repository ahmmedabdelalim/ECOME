<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VendorRequest extends FormRequest
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
            'logo' => 'required_without:id| mimes:jpg,jpeg,png ', // with out id  validation if we create first time 
            'name'=>'required|string|max:100',
            'mobile'=>'required|unique:vendors,mobile|string|max:100',
            'email'=>'required|email|unique:vendors,email',
            'category_id'=>'required|exists:main_categories,id',
            'address'=>'required|string|max:100',
            'password'=>'required|string|max:200',

        ];
    }

    public function messages()
    {
        return [
            'logo.required_without'=>'هذا  الحقل مطلوب',
            'required'=>'هذا الحقل مطلوب',
            'max'=> 'هذا الحقل طويل',
            'category_id.exists'=>'هذا الحقل غير موجود',
            'email.email'=>'لابد من كاتبه الاميل',
            'address.string'=>'هذا الحقل لابد ان يكون حروف وارقام',
            'name.string'=>'هذا الحقل لابد ان يكون حروف وارقام',
            'mobile.unique'=>'هذا الرقم مستخدم من قبل',
            'email.unique'=>'هذا الايميل مستخدم من قبل',
        ];
    }
}
