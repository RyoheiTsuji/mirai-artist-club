<?php

namespace App\Http\Controllers;

use App\Mail\InquiryReceived;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Inquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class FrontController
{
    public function index(){
        return view('home');
    }
}
