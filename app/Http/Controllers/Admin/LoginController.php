<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class LoginController extends Controller
{
    public function login(){
      return view('admin.login');
    }



    public function authenticate(Request $request){
        // return $request->username . ' ' . $request->password;
        $this->validate($request, [
          'username'   => 'required',
          'password' => 'required'
        ]);
        if (FacadesAuth::guard('admin')->attempt(['username' => $request->username,'password' => $request->password]))
        {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->back()->with('alert','Username and Password Not Matched');
      }

    public function logout() {
      FacadesAuth::guard('admin')->logout();
      return redirect()->route('admin.login');
    }
}
