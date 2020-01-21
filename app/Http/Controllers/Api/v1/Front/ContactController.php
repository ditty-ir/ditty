<?php

namespace App\Http\Controllers\Api\v1\Front;

use App\Classes\Response;
use App\Mail\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\ContactRequest;

class ContactController extends Controller
{
    public function submit(ContactRequest $request)
    {
        $to = [
            [
                'email' => config('app.contact_email'),
                'name' => $request->name
            ]
        ];

        Mail::to($to)->send(new Contact($request));

        $message = "پیام شما رو با موفقیت دریافت کردیم!";

        if ($request->name) {
            $message = "{$request->name} عزیز، " . $message;
        }

        return Response::success($message);
    }
}
