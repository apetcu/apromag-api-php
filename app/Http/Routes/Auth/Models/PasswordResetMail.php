<?php


namespace App\Http\Routes\Auth\Models;


use App\Http\Routes\User\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordResetMail extends Mailable {
    use Queueable, SerializesModels;

    protected $user;
    protected $uuid;

    public function __construct(User $user, $uuid) {
        $this->user = $user;
        $this->uuid = $uuid;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        return $this->subject('Resetare parola')
            ->markdown('emails.users.password-reset')
            ->with([
                'name' => $this->user->firstName,
                'email' => $this->user->email,
                'uuid' => $this->uuid,
            ]);
    }
}