<?php


namespace App\Http\Routes\Account\Mail;


use App\Http\Routes\User\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailChangeMail extends Mailable {
    use Queueable, SerializesModels;

    protected $user;
    protected $newEmail;

    public function __construct(User $user, $newEmail) {
        $this->user = $user;
        $this->newEmail = $newEmail;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        return $this->subject('Notificare schimbare e-mail')
            ->markdown('emails.users.email-change')
            ->with([
                'name' => $this->user->firstName,
                'email' => $this->newEmail
            ]);
    }
}