<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Models\Admin;
use Validator,Redirect,Response,Session;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{   

    // show login form
    public function getLogin (){

        return view('admin.Auth.login');
    }

    public function save(){

        $admin = new App\Models\Admin();
        $admin -> name ="Ibrahim sadour";
        $admin -> email ="ibo@ibo.com";
        $admin -> password = bcrypt("ims12345");
        $admin -> save();

    }

    public function login(LoginRequest $request){

        // herenner me (waaneer de gebruiker op de checkbox klickt)
        $remember_me = $request->has('remember_me') ? true : false;

        // check in de table admin als de gebruiker juiste email en wachtwoord ingevuld.
        if (auth()->guard('admin')->attempt(['email' => $request->input("email"), 'password' => $request->input("password")], $remember_me)) {

            // dit geeft soort van notificatie aan de zij kant dat de gebuiker ingelogd is!!
           // notify()->success('تم الدخول بنجاح  ');
            return redirect() -> route('admin.dashboard');
        }
       // notify()->error('خطا في البيانات  برجاء المجاولة مجدا ');
        return redirect()->back()->with(['error' => 'هناك خطا بالبيانات']);
    }

    protected function getGaurd()
    {
        return Auth::guard('admin');
    }

    public function logout() {

        $gaurd = $this->getGaurd();
        $gaurd->logout();

        return redirect()->route('admin.login');
    }
}
