<?php

namespace App\Http\Controllers\Mypage;

class MypageInquiryController
{
    public function index(){
        return view('mypage.inquiry.index');
    }
    public function create(){
        return view('mypage.inquiry.create');
    }

}
