<?php


namespace App\Http\Routes\Auth\Models;


use App\Http\Routes\User\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserCreatedMail extends Mailable {
    use Queueable, SerializesModels;

    protected $user;

    public function __construct(User $user) {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        return $this->subject('Bine ai venit pe APROZi!')
            ->markdown('emails.users.created')
            ->with([
                'name' => $this->user->firstName,
                'email' => $this->user->email,
            ]);
    }
}