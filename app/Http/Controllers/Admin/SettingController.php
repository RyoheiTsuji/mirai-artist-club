<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Log;
use App\Models\Admin;
use App\Models\Tag;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SettingController extends Controller
{
    public function index()
    {
        // 管理人の数を取得
        $adminCount = Admin::count();

        // 登録済みのタグの数を取得
        $tagCount = Tag::count();

        // 管理人の名前とIDを取得
        $admins = Admin::select('id', 'name')->get();

        // Viewにデータを渡して表示
        return view('admin.setting', compact('adminCount', 'tagCount', 'admins'));
    }

    public function adminRegistration(Request $request)
    {
        try {
            // バリデーション
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:admins',
                'password' => 'required|string|min:8|confirmed',
            ]);
            Log::info('Validation passed.', ['data' => $validated]);

            // 管理者の作成
            $admin = Admin::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
            ]);
            Log::info('Admin created.', ['admin' => $admin]);

            // 成功メッセージと共にリダイレクト
            return redirect()->route('admin.setting')->with('success', '管理者が正常に登録されました。');
        } catch (\Exception $e) {
            Log::error('Admin registration failed.', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return back()->withErrors(['error' => '管理者の登録に失敗しました。']);
        }
    }

    public function deleteAdmin(Request $request)
    {
        // バリデーション
        $request->validate([
            'admin_id' => 'required|array',
            'admin_id.*' => 'exists:admins,id',
        ]);

        // 選択された管理者を削除
        Admin::whereIn('id', $request->input('admin_id'))->delete();

        // 成功メッセージと共にリダイレクト
        return redirect()->route('admin.setting')->with('success', '選択された管理者が正常に削除されました。');
    }

}
