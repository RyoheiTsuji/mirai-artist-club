<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Notification;
use App\Models\Artist;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Log;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        view()->composer('components.header_admin', function ($view) {
            $notifications = Notification::where('is_read', false)->get();

            // 通知データにアーティスト名を追加
            $notifications->transform(function ($notification) {
                $data = json_decode($notification->data, true);

                if (isset($data['artist_id'])) {
                    $artist = Artist::find($data['artist_id']);
                    $data['artist_name'] = $artist ? $artist->name : '不明なアーティスト';
                }

                $notification->data = json_encode($data);
                return $notification;
            });

            Log::info('DBから取得した通知:', $notifications->toArray());

            $view->with('notifications', $notifications);

            // デバッグ: ビューに渡されるデータを確認
            Log::info('ビューに渡す通知:', $notifications->toArray());
        });

        Relation::morphMap([
            0 => 'App\Models\Admin', // user_typeが0のときにAdminモデルを使う
            1 => 'App\Models\Artist', // user_typeが1のときにArtistモデルを使う
            2 => 'App\Models\User',    // user_typeが2のときにUserモデルを使う
        ]);
    }


}
