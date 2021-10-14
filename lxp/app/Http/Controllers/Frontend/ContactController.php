<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Support\Facades\Mail;
use App\Mail\Frontend\Contact\SendContact;
use App\Mail\Frontend\Contact\SendToExpertise;
use App\Http\Requests\Frontend\Contact\SendContactRequest;
use Illuminate\Support\Facades\Session;
use Arcanedev\NoCaptcha\Rules\CaptchaRule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Gamify\Points\PageVisit;



/**
 * Class ContactController.
 */
class ContactController extends Controller
{

    private $path;

    public function __construct()
    {
        $path = 'frontend';
        $this->path = $path;
    }


    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        givePoint(new PageVisit("ContactPage"));
        return view($this->path . '.contact');
    }

    /**
     * @param SendContactRequest $request
     *
     * @return mixed
     */
    public function send(SendContactRequest $request)
    {
        $contact = new Contact();
        $contact->name = $request->name;
        $contact->number = $request->phone;
        $contact->email = $request->email;
        $contact->message = $request->message;
        $contact->subject = __('strings.emails.contact.subject', ['app_name' => app_name()]);
        $contact->recipient = config('mail_to_address');
        $contact->save();

        Mail::send(new SendContact($request));

        return ['success' => true, 'message' => 'Response received successfully!'];

        //response(['success' => true, 'message' => 'Response received successfully!']);

        // $validator = Validator::make(Input::all(), [
        //     'email' => 'required|email|max:255',
        //     'name' => 'required|regex:/^[a-zA-Z]+$/u',
        //     'email' => 'required|email',
        //     'message' => 'required',
        // ]);

        // echo "test";
        // die();

        // if ($validator->passes()) {
        //     $contact = new Contact();
        //     $contact->name = $request->name;
        //     $contact->number = $request->phone;
        //     $contact->email = $request->email;
        //     $contact->message = $request->message;
        //     $contact->save();

        //     Mail::send(new SendContact($request));
        //     Session::flash('alert', 'Response received successfully!');
        //     return redirect()->back();
        // }

        //return response(['success' => false, 'errors' => $validator->errors()]);

        // return redirect()->back();
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function sendToExpertise(Request $request)
    {
        $validator = Validator::make(Input::all(), [
            'message' => 'required',
            'subject' => 'required',
            'g-recaptcha-response' => ['required', new CaptchaRule],
        ], [
            'g-recaptcha-response.required' => 'Captcha Required',
        ]);


        if ($validator->passes()) {
            $contact = new Contact();
            $contact->name = $request->sender_name;
            $contact->email = $request->sender_email;
            $contact->message = $request->message;
            $contact->subject = $request->subject;
            $contact->recipient = $request->recipient_email;
            $contact->save();
            Mail::send(new SendToExpertise($request));

            return ['success' => true, 'message' => 'Response received successfully!'];
        }

        return response(['success' => false, 'errors' => $validator->errors()]);
    }
}
