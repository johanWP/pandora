<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\DB;

class PasswordController extends Controller
{
    protected $redirectTo = '/escritorio';
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;
    protected $subject = "Resetea tu contraseña de Panatel: Inventario";

    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Send a reset link to the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postEmail(Request $request)
    {

//        $this->validate($request, ['email' => 'required|email', 'username' =>'required']);
        /*
                $response = Password::sendResetLink($request->only('email'), function (Message $message) {
                    $message->subject($this->getEmailSubject());
                });
        */
        $this->validate($request, ['email' => 'required|email', 'username' =>'required']);
        $correo = DB::table('users')->where('username', '=', $request->username)->first();

        if (is_null($correo))
        {
            $response = Password::INVALID_USER;
        } else
        {
            if($correo->email == $request->email)
            {
//            dd($request->email);
                $response = Password::sendResetLink($request->only('email'), function (Message $message) {
                    $message->subject($this->getEmailSubject());
                });
            } else
            {

                $response = Password::INVALID_USER;
            }
        }


        switch ($response) {
            case Password::RESET_LINK_SENT:
                session()->flash('flash_message', 'Se ha enviado un correo a la dirección de correo asociada.');
                return view('auth.password');

            case Password::INVALID_USER:
                //session()->flash('flash_message_danger', 'No existe un usuario con ese nombre.');
                return redirect()->back()->withErrors(['email' => trans($response)]);
        }
    }
}
