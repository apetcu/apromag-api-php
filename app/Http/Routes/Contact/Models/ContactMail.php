<?php


namespace App\Http\Routes\Contact\Models;


use App\Http\Routes\Contact\Requests\ContactRequest;
use App\Http\Routes\User\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable {
    use Queueable, SerializesModels;

    protected $request;

    public function __construct($request) {
        $this->request = $request;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        return $this->subject('Mesaj nou: '.$this->request->subject)
            ->markdown('emails.contact.message')
            ->with([
                'name' => $this->request->name,
                'email' => $this->request->email,
                'message' => $this->request->message,
            ]);
    }
}