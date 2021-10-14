<?php

namespace App\Mail\Frontend\Contact;

use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Class SendContact.
 */
class SendToExpertise extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var Request
     */
    public $request;

    /**
     * SendContact constructor.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = app_name() . ": " . $this->request->subject; 
        return $this->to($this->request->recipient_email, $this->request->recipient_name)
            ->view('frontend.mail.contactExpertise')
            ->text('frontend.mail.contactExpertise-text')
            ->subject($subject)
            ->from($this->request->sender_email, $this->request->sender_name)
            ->replyTo($this->request->sender_email, $this->request->sender_name);
    }
}
