<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Models\Artist;
use App\Mail\ArtistRegistrationMail;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Tag;
use App\Models\ArtistTag;

class ArtistRegistrationController extends Controller
{
    public function submit(Request $request)
    {
        Log::info('Artist registration started.', ['email' => $request->input('email')]);

        try {
            // バリデーション
            $request->validate([
                'email' => 'required|email|unique:artists,email',
                'name' => 'required|string|max:255',  // 追加
            ]);
            Log::info('Validation passed.', ['email' => $request->input('email'), 'name' => $request->input('name')]);
        } catch (\Exception $e) {
            Log::error('Validation failed.', ['email' => $request->input('email'), 'error' => $e->getMessage()]);
            return back()->withErrors(['email' => 'Invalid or already registered email address.']);
        }

        try {
            $email = $request->input('email');
            $name = $request->input('name');  // 追加
            Log::info('Email and Name extracted.', ['email' => $email, 'name' => $name]);

            $token = Str::random(60);
            Log::info('Token generated.', ['email' => $email, 'token' => $token]);

            // 仮登録としてartistsテーブルにメールアドレスと名前、トークンを保存
            Artist::create([
                'name' => $name,  // 追加
                'email' => $email,
                'email_verified_at' => null,
                'token' => $token,
            ]);
            Log::info('Artist record created in the database.', ['email' => $email, 'name' => $name]);

            // SMTP接続前のログを追加
            Log::info('Attempting to send email.', ['email' => $email]);

            $registrationUrl = route('artist.verify', ['token' => $token]);
            Mail::to($email)->send(new ArtistRegistrationMail($registrationUrl));
            Log::info('Registration email sent.', ['email' => $email, 'url' => $registrationUrl]);

            return redirect()->route('mypage.registration-sent');

        } catch (\Exception $e) {
            // 例外キャッチ部分に詳細なエラーメッセージをログ出力
            Log::error('Unexpected error during artist registration.', [
                'email' => $email,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),  // スタックトレースを含む詳細なエラーメッセージ
            ]);
            return back()->withErrors(['email' => 'An unexpected error occurred. Please try again later.']);
        }
    }

    public function verifyEmail($token)
    {
        $artist = Artist::where('token', $token)->first();

        if (!$artist) {
            return redirect()->route('error.page')->with('error', 'Invalid token.');
        }

        $artist->email_verified_at = Carbon::now();
        $artist->save();

        return redirect()->route('artist.details.form', [
            'email' => $artist->email,
            'name' => $artist->name,
        ]);
    }

    public function showDetailsForm(Request $request)
    {
        $email = $request->query('email');  // クエリパラメータからメールアドレスを取得
        $name = $request->query('name');  // クエリパラメータから名前を取得
        $tags = Tag::all();

        return view('mypage.details', compact('email','name','tags'));
    }

    public function submitDetails(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:artists,email',
            'password' => 'required|string|min:8',
            'photo_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tags' => 'required|array',
            'tags.*' => 'exists:tags,id', // 選択されたタグが存在するか確認
        ]);

        $artist = Artist::where('email', $request->input('email'))->firstOrFail();

        //$artist->name = $request->input('name');
        $artist->password = Hash::make($request->input('password'));
        $artist->bio = $request->input('bio');
        $artist->pr_statement = $request->input('pr_statement');

        // プロフィール写真の保存
        if ($request->hasFile('photo_url')) {
            // 一意のファイル名を生成する
            $filename = Str::uuid() . '.' . $request->file('photo_url')->getClientOriginalExtension();
            // artist_photo フォルダにファイルを保存する
            $filePath = $request->file('photo_url')->storeAs('artist_photo', $filename, 'public');
            $artist->photo_url = $filePath;
        }

        $artist->save();

        // タグを保存
        $artist->tags()->sync($request->input('tags'));

        Auth::guard('artist')->login($artist);

        return redirect()->route('artist.login');
    }
}
