<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    //
    use AuthenticatesUsers;

    public function  getlogin(){

        return view('user.Auth.login');
    }

    public function index()
    {
        return view('user.dashboard');
    }


    public function  checklogin(LoginRequest $request){
        try{
        $remember_me = $request->has('remember_me') ? true : false;

        if (auth::guard('user')->attempt(['email' => $request->input("email"), 'password' => $request->input("password")], $remember_me)) {
           // notify()->success('تم الدخول بنجاح  ');
            return redirect() -> route('user.dashboard');
        }
       // notify()->error('خطا في البيانات  برجاء المجاولة مجدا ');
        return redirect()->back()->with(['error' => 'هناك خطا بالبيانات']);
    } catch(\Exception $ex)
    {
        return redirect()->route('get.admin.login');
    }
    }
}
