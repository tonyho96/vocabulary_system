<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewUserRegister;

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
    protected $redirectTo = '/';

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
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $confirmation_code = str_random(30);
        $user = User::create([
            'name' => $data['name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'role' => $data['role'],
            'password' => bcrypt($data['password']),
            'status' => 'not_verified',
            'confirmation_code' => $confirmation_code,
        ]);

        Mail::to('admin@admin.com')->send(new NewUserRegister($user));

        $mail_data = ['confirmation_code' => $confirmation_code, 'email' => $data['email'], 'name' => $data['name']];
        Mail::send('emails.verify', $mail_data, function($message) use ($mail_data) {
            $message->to($mail_data['email'],$mail_data['name'])
                ->subject('Verify your email address');
        });

        return $user;
    }

    public function confirm($confirmation_code)
    {
        if(!$confirmation_code)
        {
            return redirect('/login')->with('error', 'Confirmation code is invalid!');
        }

        $user = User::where('confirmation_code', $confirmation_code)->first();

        if (!$user)
        {
            return redirect('/login')->with('error', 'User not found!');
        }

        $user->status = 'verified';
        $user->confirmation_code = null;
        $user->save();

        return redirect('/login')->with('message', 'You have successfully verified your account.');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        // $this->guard()->login($user);

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }
}
