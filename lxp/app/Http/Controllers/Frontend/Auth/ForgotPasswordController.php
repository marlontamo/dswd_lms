<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Arcanedev\NoCaptcha\Rules\CaptchaRule;

/**
 * Class ForgotPasswordController.
 */
class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    /**
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLinkRequestForm()
    {
        return view('frontend.auth.passwords.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $this->validate($request, ['email' => 'required|email']);
        
        $validator = Validator::make(Input::all(), [
            'email' => 'required|email|max:255',
            'g-recaptcha-response' => ['required',new CaptchaRule],
        ],[
            'g-recaptcha-response.required' => "Captcha Required",
        ]);

        if($validator->passes()){
            // We will send the password reset link to this user. Once we have attempted
            // to send the link, we will examine the response then see the message we
            // need to show to the user. Finally, we'll send out a proper response.
            $response = $this->broker()->sendResetLink(
                $request->only('email'), $this->resetNotifier() 
            );
    
            switch ($response) {
                case Password::RESET_LINK_SENT:
                    return response()->json([
                        'success' => true
                    ]);
    
                case Password::INVALID_USER:
                default:
                    return response()->json([
                        'success' => false,
                        'message' => 'Invalid user'
                    ]);
            }
        }
        return response()->json([
            'success' => false,
            'errors' => $validator->errors()
        ]);

        
    }

    protected function resetNotifier()
    {
        return function($token)
        {
            return new ResetPasswordNotification($token);
        };
    }
}
