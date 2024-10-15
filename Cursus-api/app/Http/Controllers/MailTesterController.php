<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SampleEmail;

class MailTesterController extends Controller
{
    public function sendMail(Request $request)
    {
        Mail::to('recipient@example.com')->send(new SampleEmail());
    }
}