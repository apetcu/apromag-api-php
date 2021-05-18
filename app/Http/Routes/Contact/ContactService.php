<?php

namespace App\Http\Routes\Contact;

use App\Http\Routes\Contact\Models\ContactMail;
use Illuminate\Support\Facades\Mail;

class ContactService {
    public function sendMessage($contactForm) {
        Mail::to('office@aprozi.ro')
            ->send(new ContactMail($contactForm));
        return true;
    }

}