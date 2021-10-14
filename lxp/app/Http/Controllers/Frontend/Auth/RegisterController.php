<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Helpers\Frontend\Auth\Socialite;
use App\Events\Frontend\Auth\UserRegistered;
use App\Models\Auth\User;
use Arcanedev\NoCaptcha\Rules\CaptchaRule;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Repositories\Frontend\Auth\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\Gamify\Points\UserRegister;
use Illuminate\Validation\ClosureValidationRule;

/**
 * Class RegisterController.
 */
class RegisterController extends Controller
{
    use RegistersUsers;

    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * RegisterController constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

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
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        abort_unless(config('access.registration'), 404);

        return view('frontend.auth.register')
            ->withSocialiteLinks((new Socialite)->getSocialLinks());
    }

    /**
     * @param RegisterRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Throwable
     */
    public function register(Request $request)
    {

        $validator = Validator::make(Input::all(), [
            'first_name'    => 'required|max:255',
            'last_name'     => 'required|max:255',
            'dob'           => ['required', function ($attribute, $value, $fail) {
                $date1 = date_create($value);
                $date2 = date_create(date("Y-m-d"));
                $diff = date_diff($date1, $date2);
                if ($diff->y  < 18) {
                    $fail('User must be 18yrs old and above.');
                }
            },],
            'gender'        => 'required',
            'phone'         => 'required|max:12',
            'state'         => 'required',
            'province'      => 'required',
            'city'          => 'required',
            // 'barangay'      => 'required',
            'address'       => 'required',
            'privacy'       => 'required',
            'user_type'     => 'required',
            'position'      => 'required',
            'password'      => [
                'confirmed',
                'required',
                'string',
                'min:8',             // must be at least 10 characters in length
                'regex:/[a-z]/',      // must contain at least one lowercase letter
                'regex:/[A-Z]/',      // must contain at least one uppercase letter
                'regex:/[0-9]/',      // must contain at least one digit
                'regex:/[@$!%*#?_&]/', // must contain a special character
            ],
            'g-recaptcha-response' => (config('access.captcha.registration') ? ['required', new CaptchaRule] : ''),
            'username'      => 'required|min:5|max:255|alpha_dash|unique:users',
            'email'         => 'required|email|max:255|unique:users',
        ], [
            'g-recaptcha-response.required' => __('validation.attributes.frontend.captcha'),
            'privacy.required'              => 'Please Check Data Privacy Act Agreement.',
            'user_type.required'            => 'The Type of User field is required.',
            'state.required'                => 'The Region field is required.',
            'city.required'                 => 'The Municipality field is required.',
            'dob.required'                  => 'The Date of Birth field is required.',
            'username.unique'               => '',
            'email.unique'                  => '',
        ]);

        if ($validator->passes()) {
            // Store your user in database
            event(new Registered($user = $this->create($request->all())));
            return response(['success' => true]);
        }

        $err = $validator->errors();
        $errors = $err->toArray();
        $reg_failed = false;
        foreach ($errors as $key => $value) {
            if ($key == "username" || $key == "email") {
                if ($value[0] == "" || $value[0] == "") {
                    $reg_failed = true;
                }
            } else {
                $reg_failed = false;
                break;
            }
        }
        if ($reg_failed) {
            return response(['success' => false, 'message' => 'User Registration Failed.']);
        }
        return response(['errors' => $err]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $confirmation_code = str_random(20);
        $user = User::create([
            'first_name' => $data['first_name'],
            'middle_name' => $data['middle_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'username' => $data['username'],
            'active' => 0,
            'confirmation_code' => $confirmation_code
        ]);

        $user->active   = 0;
        $user->dob      = isset($data['dob']) ? $data['dob'] : NULL;
        $user->phone    = isset($data['phone']) ? $data['phone'] : NULL;
        $user->gender   = isset($data['gender']) ? $data['gender'] : NULL;
        $user->address  = isset($data['address']) ? $data['address'] : NULL;
        $user->pincode  = isset($data['pincode']) ? $data['pincode'] : NULL;
        $user->country  = isset($data['country']) ? $data['country'] : NULL;
        $user->state    = isset($data['state']) ? $data['state'] : NULL;
        $user->province = isset($data['province']) ? $data['province'] : NULL;
        $user->city     = isset($data['city']) ? $data['city'] : NULL;
        //$user->barangay = isset($data['barangay']) ? $data['barangay'] : NULL;
        $user->user_type = isset($data['user_type']) ? $data['user_type'] : NULL;
        $user->position = isset($data['position']) ? $data['position'] : NULL;
        $user->privacy  = isset($data['privacy']) ? $data['privacy'] : false;
        $user->save();

        $userForRole = User::find($user->id);
        $userForRole->confirmed = 0;
        $userForRole->save();
        $userForRole->assignRole('student');
        givePoint(new UserRegister($userForRole));
        return $user;
    }

    public function addPointsToRegister()
    {
        $user =   User::where('reputation', 0)->get();
        if (!empty($user)) {
            foreach ($user as $uk => $uv) {
                givePoint(new UserRegister($uv));
            }
        }
    }
}
