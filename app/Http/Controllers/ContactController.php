<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'nullable|string',
            'message' => 'required|string|max:1000',
        ]);

        // Prepare email data
        $data = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'user_message' => $request->input('message'),
        ];

        // Send email
        Mail::send('emails.contact_email', $data, function ($message) use ($request) {
            $message->to(config('mail.admin_address'))
                    ->subject('New Contact Form Submission');
        });

        toastr()->timeOut(5000)->closeButton()->success('Your message has been sent successfully!');

        // Redirect back with success message
        return redirect()->back();
    }
}
