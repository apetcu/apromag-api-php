<?php

namespace App\Http\Routes\Contact;

use App\Http\Controllers\Controller;
use App\Http\Routes\Contact\Requests\ContactRequest;

class ContactController extends Controller {
    private $contactService;

    public function __construct(ContactService $pageService) {
        $this->contactService = $pageService;
    }

    public function sendMessage(ContactRequest $request) {
        return response()->json($this->contactService->sendMessage($request));
    }
}
