<?php


namespace App\Http\Routes\Auth\Models;


use App\Http\Routes\User\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordResetConfirmationMail extends Mailable {
    use Queueable, SerializesModels;

    protected $user;
    protected $uuid;

    public function __construct(User $user) {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        return $this->subject('Parola a fost resetata cu succes')
            ->markdown('emails.users.password-reset-confirmation')
            ->with([
                'name' => $this->user->firstName
            ]);
    }
}