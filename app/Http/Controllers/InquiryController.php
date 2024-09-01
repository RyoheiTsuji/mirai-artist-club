<?php

namespace App\Http\Controllers;

use App\Mail\InquiryReceived;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Inquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class InquiryController
{
    public function index()
    {
        return view('user_inquiry');
    }

    public function submitForm(Request $request)
    {
        // バリデーション
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'affiliation' => 'nullable|string|max:255',
            'inq_type' => 'required|integer',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // メールアドレスが既に存在する場合、そのユーザーを取得し、存在しない場合は新規作成
        $user = User::firstOrCreate(
            ['email' => $validatedData['email']],
            [
                'name' => $validatedData['name'],
                'affiliation' => $validatedData['affiliation'],
            ]
        );

        // 問い合わせ情報の登録
        $inquiry = Inquiry::create([
            'user_id' => $user->id,
            'user_type' => 2, // user_typeを2に設定
            'inq_type' => $validatedData['inq_type'],
            'subject' => $validatedData['subject'],
            'message' => $validatedData['message'],
        ]);

        // 問い合わせ受け付けメールを送信
        Mail::to($user->email)->send(new InquiryReceived($inquiry,$user->name));

        return redirect()->back()->with('success', '問い合わせを送信しました。');
    }
}
