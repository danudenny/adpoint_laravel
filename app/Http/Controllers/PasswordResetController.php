<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Mail\ResetUser;
use Illuminate\Support\Facades\Hash;
use Mail;

class PasswordResetController extends Controller
{
    public function sendEmailReset(Request $request)
    {
        
        $user = User::where('email', $request->email)->where('verified', 1)->first();
        $request->validate([
            'email' => 'required'
        ]);
        if ($user) {
            $token = base64_encode(random_bytes(32));
            $user_token = [
                'name'          => $user->name,
                'email'         => $user->email,
                'token'         => $token,
                'created_at'    => time() 
            ];
            Mail::to($request->email)->send(new ResetUser($user_token));
            \Session::flash('success', 'Silahkan cek email untuk reset password');
            return back();
        }else{
            \Session::flash('error', 'Email tidak terdaftar!');
            return back();
        }
    }

    public function formResetPassword(Request $request)
    {
        $user = $request;
        return view('frontend.user_change_password', compact('user'));
    }

    public function setPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:6|confirmed'
        ]);
        $reset_user = User::where('email', $request->email)->where('verified', 1)->first();
        if ($reset_user) {
            $reset_user->password = Hash::make($request->password);
            $reset_user->save();
            \Session::flash('success', 'Password sudah di rubah. Silahkan login');
            return redirect('users/login');
        }else{
            \Session::flash('error', 'Email tidak terdaftar!');
            return back();
        }
    }
}
