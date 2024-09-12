<?php

namespace App\Http\Controllers\Admin;

use App\Mail\InquiryReceived;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Inquiry;
use App\Mail\InquiryReplyMail; // メール通知を行う場合
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
class InquiryController extends Controller
{
    public function index()
    {
        // 一般ユーザの問い合わせを取得 (user_type = 2)
        $generalInquiries = Inquiry::where('user_type', 2)
            ->whereNull('parent_id')
            ->with(['user', 'admin', 'artist'])  // 多態リレーションで一般ユーザを取得
            ->get();
        // 作家の問い合わせを取得 (user_type = 1)
        $artistInquiries = Inquiry::where('user_type', 1)
            ->whereNull('parent_id')
            ->with(['user', 'admin', 'artist'])  // 多態リレーションで作家を取得
            ->get();

                // ビューにデータを渡す
        return view('admin.inquiry', compact('generalInquiries', 'artistInquiries'));
    }

    public function getMessages($inquiryId)
    {
        try {
            // 該当の問い合わせを取得
            $inquiry = Inquiry::with('user', 'artist', 'admin')->findOrFail($inquiryId);

            // メッセージを整形して返す
            $messages = Inquiry::where('id', $inquiryId)
                ->orWhere('parent_id', $inquiryId)
                ->orderBy('created_at', 'asc')
                ->get();
            $formattedMessages = $messages->map(function($message) {
                $sender = $message->user ?? $message->artist ?? $message->admin ?? '不明な送信者';
                return [
                    'sender_name' => $sender->name ?? '不明な送信者',
                    'body' => $message->message,
                    'created_at' => $message->created_at->format('Y-m-d H:i:s')
                ];
            });

            return response()->json(['messages' => $formattedMessages]);

        } catch (\Exception $e) {
            Log::error('Error fetching messages for inquiry ID ' . $inquiryId . ': ' . $e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }
    public function reply(Request $request)
    {
        // バリデーション
        $validatedData = $request->validate([
            'inquiry_id' => 'required|exists:inquiries,id',
            'message' => 'required|string|max:1000',
        ]);

        // 親問い合わせを取得
        $parentInquiry = Inquiry::findOrFail($request->inquiry_id);
        // 最初の問い合わせを特定
        $rootInquiry = $parentInquiry;
        while ($rootInquiry->parent_id) {
            $rootInquiry = Inquiry::find($rootInquiry->parent_id);
        }


        // 返信をinquiriesテーブルに保存
        $replyInquiry = Inquiry::create([
            'user_id' => auth('admin')->user()->id,  // ログイン中の管理者のIDを保存
            'created_by_admin_id' => auth('admin')->user()->id,  // ログイン中の管理者のIDを保存
            'user_type' => 0,
            'inq_type' => $parentInquiry->inq_type,
            'subject' => $parentInquiry->subject,
            'message' => $request->message,
            'status' => 1, // 対応中に設定
            'parent_id' => $rootInquiry->id,  // 返信元の問い合わせを親として設定
        ]);

        // 返信元の問い合わせとその返信のstatusを1に更新
        Inquiry::where('parent_id', $rootInquiry->id)
            ->orWhere('id', $rootInquiry->id)  // 最初の問い合わせ自体も含む
            ->update(['status' => 1]);

/* 一旦オフに。 未検証
        // 一般ユーザーの場合、返信用フォームのURLをメールで送信
        if ($parentInquiry->user_type == 2) {
            $user = $parentInquiry->user;
            Mail::to($user->email)->send(new InquiryReplyMail($replyInquiry)); // メール送信
        }
*/
        // 成功時のリダイレクト
        return redirect()->back()->with('success', '返信を送信しました。');
    }



}
