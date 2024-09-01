<?php

namespace App\Http\Controllers\Admin;

use App\Mail\InquiryReceived;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Inquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class InquiryController extends Controller
{
    public function index()
    {
        return view('admin.inquiry');
    }

}
