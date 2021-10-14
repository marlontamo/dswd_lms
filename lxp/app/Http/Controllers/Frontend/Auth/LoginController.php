<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Helpers\Auth\Auth;
use Illuminate\Http\Request;
use App\Exceptions\GeneralException;
use App\Http\Controllers\Controller;
use App\Helpers\Frontend\Auth\Socialite;
use App\Events\Frontend\Auth\UserLoggedIn;
use App\Events\Frontend\Auth\UserLoggedOut;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Repositories\Frontend\Auth\UserSessionRepository;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Arcanedev\NoCaptcha\Rules\CaptchaRule;
use App\Models\Auth\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Artisan;

/**
 * Class LoginController.
 */
class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @return string
     */
    public function redirectPath()
    {
        return route(home_route());
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showLoginForm()
    {
        if(request()->ajax()){
            return ['socialLinks' => (new Socialite)->getSocialLinks()];
        }

        return redirect('/')->with('show_login', true);
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return config('access.users.username');
    }



    public function login(Request $request)
    {
        $validator = Validator::make(Input::all(), [
            // 'email' => 'required|email|max:255',
            'username' => 'required|max:255',
            'password' => 'required|min:6',
            'g-recaptcha-response' => (config('access.captcha.registration') ? ['required',new CaptchaRule] : ''),
        ],[
            'g-recaptcha-response.required' => __('validation.attributes.frontend.captcha'),
        ]);

        if($validator->passes()){
            $credentials = $request->only($this->username(), 'password');
            $authSuccess = \Illuminate\Support\Facades\Auth::attempt($credentials, $request->has('remember'));
            if($authSuccess) {
                $request->session()->regenerate();
                if(auth()->user()->active > 0){
                    if(auth()->user()->confirmed > 0){

                        $new_sessid   = \Session::getId();
                        $stored_session = (isset(auth()->user()->last_session))?auth()->user()->last_session:"";


                        if($stored_session != "" && $new_sessid != $stored_session)
                        {
                            app()->make(Auth::class)->flushTempSession();
                            $this->guard()->logout();

                            $form_logout_all = '<form method="POST" action="'.route('logout.others').'">
                                                    <input type="hidden" name="_token" value="'.csrf_token().'" />
                                                    <input type="hidden" name="username" value="'.$request->username.'" />
                                                    <input type="hidden" name="password" value="'.$request->password.'" />
                                                    <button class="btn btn-danger">Log out Other device.</button>
                                                </form>';
                            

                            return response([
                                    'success' => false,
                                    // 'message' => "You are logged in from a different device.<a class='text-primary' href=".route('logout.others').">Log out Other device.</a>",
                                    'message' => "You are logged in from a different device.".$form_logout_all,
                                ], Response::HTTP_FORBIDDEN);
                        }
                        else
                        {
                            if(auth()->user()->isSuperAdmin()){
                                $redirect = 'dashboard';
                            }else{
                                $redirect = 'back';
                            }

                            auth()->user()->last_session = \Session::getId();
                            auth()->user()->save();

                            return response(['success' => true,'redirect' => $redirect], Response::HTTP_OK);
                        }
                        
                        // if(auth()->user()->isSuperAdmin()){
                        //         $redirect = 'dashboard';
                        //     }else{
                        //         $redirect = 'back';
                        //     }

                        //     auth()->user()->last_session = \Session::getId();
                        //     auth()->user()->save();

                        //     return response(['success' => true,'redirect' => $redirect], Response::HTTP_OK);
                        
                    }else{
                        \Illuminate\Support\Facades\Auth::logout();
                        return
                            response([
                                'success' => false,
                                'message' => 'Login Failed. Something went wrong. Please contact your Administrator. Thank You.'
                                //'message' => 'Login failed. Account is not confirmed. Please check your registered email for confirmation. If you have not received any email, Please contact your Administrator. Thank You.'
                            ], Response::HTTP_FORBIDDEN);
                    }
                }else{
                    \Illuminate\Support\Facades\Auth::logout();

                    return
                        response([
                            'success' => false,
                            'message' => 'Login Failed. Something went wrong. Please contact your Administrator. Thank You.'
                            //'message' => 'Login failed. Account is not active'
                        ], Response::HTTP_FORBIDDEN);
                }
            }else{
                return
                    response([
                        'success' => false,
                        'message' => 'Login Failed. Invalid username or password.'
                        //'message' => 'Login failed. Account not found'
                    ], Response::HTTP_FORBIDDEN);
            }

        }


        return response(['success'=>false,'errors' => $validator->errors(),'message' => ""]);

    }





    /**
     * The user has been authenticated.
     *
     * @param Request $request
     * @param         $user
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws GeneralException
     */
    protected function authenticated(Request $request, $user)
    {
        /*
         * Check to see if the users account is confirmed and active
         */
        if (! $user->isConfirmed()) {
            auth()->logout();

            // If the user is pending (account approval is on)
            if ($user->isPending()) {
                throw new GeneralException(__('exceptions.frontend.auth.confirmation.pending'));
            }

            // Otherwise see if they want to resent the confirmation e-mail

            throw new GeneralException(__('exceptions.frontend.auth.confirmation.resend', ['url' => route('frontend.auth.account.confirm.resend', $user->{$user->getUuidName()})]));
        } elseif (! $user->isActive()) {
            auth()->logout();
            throw new GeneralException(__('exceptions.frontend.auth.deactivated'));
        }

        event(new UserLoggedIn($user));

        // If only allowed one session at a time
        if (config('access.users.single_login')) {
            resolve(UserSessionRepository::class)->clearSessionExceptCurrent($user);
        }

        return redirect()->intended($this->redirectPath());
    }

    /**
     * Log the user out of the application.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        // Artisan::call('cache:clear');
        // Artisan::call('route:clear');
        // Artisan::call('config:clear');
        // Artisan::call('view:clear');
        // header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        // header("Cache-Control: post-check=0, pre-check=0", false);
        // header("Pragma: no-cache");
        // header('Content-Type: text/html');
        // header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        // Session::flush();

        // Artisan::call('cache:clear');
        //$request->session()->regenerate();

        // header("cache-Control: no-store, no-cache, must-revalidate");
        // header("cache-Control: post-check=0, pre-check=0", false);
        // header("Pragma: no-cache");
        // header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
        // Session::flush();
        //$request->session()->regenerate();
        $request->headers->set("Cache-Control","no-cache,no-store, must-revalidate");
        $request->headers->set("Pragma", "no-cache"); //HTTP 1.0
        $request->headers->set("Expires"," Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past

        /*
         * Remove the socialite session variable if exists
         */
        if (app('session')->has(config('access.socialite_session_name'))) {
            app('session')->forget(config('access.socialite_session_name'));
        }

        auth()->user()->last_session = "";
        auth()->user()->save();


        /*
         * Remove any session data from backend
         */
        app()->make(Auth::class)->flushTempSession();

        /*
         * Fire event, Log out user, Redirect
         */
        event(new UserLoggedOut($request->user()));

        /*
         * Laravel specific logic
         */
        auth()->user()->last_session = "";
        auth()->user()->save();
        $this->guard()->logout();
        $request->session()->invalidate();

        return redirect()->route('frontend.index');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logoutAs()
    {
        // If for some reason route is getting hit without someone already logged in
        if (! auth()->user()) {
            return redirect()->route('frontend.auth.login');
        }

        // If admin id is set, relogin
        if (session()->has('admin_user_id') && session()->has('temp_user_id')) {
            // Save admin id
            $admin_id = session()->get('admin_user_id');

            app()->make(Auth::class)->flushTempSession();

            // Re-login admin
            auth()->loginUsingId((int) $admin_id);

            // Redirect to backend user page
            return redirect()->route('admin.auth.user.index');
        } else {
            app()->make(Auth::class)->flushTempSession();

            // Otherwise logout and redirect to login
            auth()->logout();

            return redirect()->route('frontend.auth.login');
        }
    }


    public function checkSingleSession()
    {
        /*
         * Remove the socialite session variable if exists
         */
        // return false;
        $response['stop_loop'] = TRUE;

        // if (auth()->user() != NULL) {
        //     $response['stop_loop'] = FALSE;
        //     $response['logout'] = FALSE;
        //     $new_sessid   = \Session::getId();
        //     $stored_session = (isset(auth()->user()->last_session))?auth()->user()->last_session:"";

        //     if($new_sessid != $stored_session)
        //     {
        //         if (app('session')->has(config('access.socialite_session_name'))) {
        //             app('session')->forget(config('access.socialite_session_name'));
        //         }
        //         // auth()->logout();
        //         /*
        //          * Remove any session data from backend
        //          */
        //         app()->make(Auth::class)->flushTempSession();

        //         /*
        //          * Fire event, Log out user, Redirect
        //          */
        //         // event(new UserLoggedOut($request->user()));

        //         /*
        //          * Laravel specific logic
        //          */
        //         $this->guard()->logout();
        //         // $request->session()->invalidate();

        //         $response['logout'] = TRUE;

        //         // return redirect()->route('frontend.index');
        //     }
        // }

        echo json_encode($response);
        
    }


    public function logout_others(Request $request)
    {
        // $authSuccess = \Illuminate\Support\Facades\Auth::attempt($credentials, $request->has('remember'));
        // $request->session()->regenerate();

        // if(auth()->user()->isSuperAdmin()){
        //     $redirect = 'dashboard';
        // }else{
        //     $redirect = 'back';
        // }

        // auth()->user()->last_session = \Session::getId();
        // auth()->user()->save();

        // return response(['success' => true,'redirect' => 'back'], Response::HTTP_OK);



        $credentials = $request->only($this->username(), 'password');
            $authSuccess = \Illuminate\Support\Facades\Auth::attempt($credentials, $request->has('remember'));
            if($authSuccess) {
                $request->session()->regenerate();


                auth()->user()->last_session = \Session::getId();
                auth()->user()->save();

                if(auth()->user()->isSuperAdmin()){
                    return redirect()->route('dashboard');
                }else{
                    return redirect()->back();
                }

            }
    }


    
}
