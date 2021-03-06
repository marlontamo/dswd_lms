<?php

namespace App\Http\Controllers\Backend\Auth\User;

use App\Http\Controllers\Controller;
use App\Repositories\Frontend\Auth\UserRepository;
use App\Http\Requests\Frontend\User\UpdateProfileRequest;

/**
 * Class ProfileController.
 */
class ProfileController extends Controller
{
    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * ProfileController constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param UpdateProfileRequest $request
     *
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     */
    public function update(UpdateProfileRequest $request)
    {
        $fieldsList = [];
        if(config('registration_fields') != NULL){
            $fields = json_decode(config('registration_fields'));

            foreach ($fields  as $field){
                $fieldsList[] =  ''.$field->name;
            }
        }
        $output = $this->userRepository->update(
            $request->user()->id,
            $request->only(
                'first_name', 
                'middle_name', 
                'last_name',
                'dob', 
                'phone', 
                'gender', 
                'user_type', 
                'position', 
                'state', 
                'province', 
                'city',
                'address', 
                'city', 
                'pincode', 
                'state', 
                'country', 
                'avatar_type', 
                'avatar_location'),
            $request->has('avatar_location') ? $request->file('avatar_location') : false
        );
        
        // E-mail address was updated, user has to reconfirm
        if (is_array($output) && $output['email_changed']) {
            auth()->logout();

            return redirect()->route('frontend.auth.login')->withFlashInfo(__('strings.frontend.user.email_changed_notice'));
        }

        return redirect()->route('admin.account')->withFlashSuccess(__('strings.frontend.user.profile_updated'));
    }
}
