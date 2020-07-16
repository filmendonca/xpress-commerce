<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Password;
use Validator;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    public function sendResetLinkEmail(Request $request){

        //dd($request->all());

        $validator = Validator::make($request->all(),[ 
            'email' => 'required|email|exists:users,email'
        ]);

        if ($validator->fails()) { 
            return redirect("password/reset")->withErrors($validator)->withInput(); 
        }	


        $user = $this->broker()->getUser($request->only('email'));	

        $response = $this->broker()->sendResetLink(

            $request->only('email')

        );

        return redirect('/');

    } 
}
