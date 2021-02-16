<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Session;
use Illuminate\Foundation\Auth\AuthenticatesUsers;




class LoginController extends Controller
{
    use AuthenticatesUsers;
    public function  getLogin(){

        return view('admin.Auth.login');
    } 

    public function  checklogin(LoginRequest $request){
        try{
        $remember_me = $request->has('remember_me') ? true : false;

        if (auth::guard('admin')->attempt(['email' => $request->input("email"), 'password' => $request->input("password")], $remember_me)) {
           // notify()->success('تم الدخول بنجاح  ');
            return redirect() -> route('admin.dashboard');
        }
       // notify()->error('خطا في البيانات  برجاء المجاولة مجدا ');
        return redirect()->back()->with(['error' => 'هناك خطا بالبيانات']);
    } catch(\Exception $ex)
    {
        return redirect()->route('get.admin.login');
    }
    }


    public function logout(Request $request)
{
    Auth::logout();

    $request->session()->invalidate();

    $request->session()->regenerateToken();

    return redirect('/login');
}
    
}
