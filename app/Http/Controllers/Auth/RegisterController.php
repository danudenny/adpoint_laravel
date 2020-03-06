<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Customer;
use App\BusinessSetting;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Mail;
use Session;
use App\Mail\User\RegistUser;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/users/registration';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'ktp' => 'required',
            'npwp' => 'required',
            'captcha' => 'captcha'
        ]);
    }
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name'      => $data['name'],
            'email'     => $data['email'],
            'password'  => Hash::make($data['password']),
            'ktp'       => $data['ktp']->store('uploads/users'),
            'npwp'      => $data['npwp']->store('uploads/users')
        ]);

        $user->email_verified_at = date('Y-m-d H:m:s');
        $user->ktp = $data['ktp']->store('uploads/users');
        $user->npwp = $data['npwp']->store('uploads/users');
        $user->verified = 2;
        if ($user->save()) {
            Mail::to($user->email)->send(new RegistUser($user));
            \Session::flash('message', 'Please wait for the account to be verified');
            flash(__('Registration successfull. Please check your email.'))->success();
            $customer = new Customer;
            $customer->user_id = $user->id;
            $customer->save();
            return $user;
        }


    }
}
