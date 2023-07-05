<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use App\Mail\AutoMail;
use Illuminate\Http\Request;

class MailController extends Controller
{
    public function index(Request $request)
    {
        $mailData = $request;
        Mail::to($request->email)->send(new AutoMail($mailData));
        dd('Email send successfully');
    }
}
