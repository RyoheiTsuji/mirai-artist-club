<?php

use App\Http\Controllers\FrontController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InquiryController as UserInquiryController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Auth\ArtistAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ArtistController;
use App\Http\Controllers\Admin\OfferController;
use App\Http\Controllers\Admin\InquiryController as AdminInquiryController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\CatalogueController;
use App\Http\Controllers\Admin\SalesController;
use App\Http\Controllers\Admin\NoticeController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Mypage\MypageController;
use App\Http\Controllers\Mypage\MypageArtworkController;
use App\Http\Controllers\Mypage\MypageProfileController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\ArtistRegistrationController;
use App\Http\Controllers\FileUploadController;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Request;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/




/*サイトトップページ*/
Route::get('/',  [FrontController::class, 'index'])->name('home');



/*一般ページ問い合わせルート*/
Route::get('/inquiry', function(){
    return view('user_inquiry');
});
Route::get('/inquiry', [UserInquiryController::class, 'index'])->name('inquiry.form');
Route::post('/inquiry', [UserInquiryController::class, 'submitForm'])->name('inquiry.submit');



// エラーページへのルートを
Route::get('/error-page', function () {
    return view('errors.session_timeout');
})->name('error.page');

// 認証ルートの基本設定
/* 管理画面 */
Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login']);
Route::get('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

/* マイページ */
Route::get('/artist/login', [ArtistAuthController::class, 'showLoginForm'])->name('artist.login');
Route::post('/artist/login', [ArtistAuthController::class, 'login']);
Route::post('/artist/logout', [ArtistAuthController::class, 'logout'])->name('artist.logout');

// 作家新規登録のルート STEP1 設定
Route::get('/mypage/register', function () {
    return view('mypage.register');
})->name('mypage.register');
Route::post('/mypage/register', [ArtistRegistrationController::class, 'submit'])->name('artist.register.submit');
Route::get('/mypage/registration-sent', function () {
    return view('mypage.registration-sent');
})->name('mypage.registration-sent');
Route::get('/artist_register', function (Request $request) {
    return view('mypage.mypage');
})->name('artist.register.form');

// 作家新規登録のルート STEP2 設定
Route::get('/artist/verify/{token}', [ArtistRegistrationController::class, 'verifyEmail'])->name('artist.verify');
Route::get('/artist/register/details', [ArtistRegistrationController::class, 'showDetailsForm'])->name('artist.details.form');
Route::post('/artist/register/details', [ArtistRegistrationController::class, 'submitDetails'])->name('artist.details.submit');

// 一般画面内のルート設定
Route::get('/inquiry', function () {
    return view('user_inquiry');
})->name('user.inquiry');


// 管理画面内のルート設定
Route::middleware(['auth:admin'])->group(function () {
    Route::get('/admin', [DashboardController::class, 'index'])->name('admin.dashboard');
    //作家管理画面のルート
    Route::get('/admin/artist', [ArtistController::class, 'index'])->name('admin.artist');
    Route::get('/admin/artist/detail/{id}', [ArtistController::class, 'detail'])->name('admin.artist.detail');
    // オファー管理画面のルート
    Route::get('/admin/offer', [OfferController::class, 'index'])->name('admin.offer'); // 一覧表示
    Route::get('/admin/offer/create', [OfferController::class, 'create'])->name('admin.offer.create'); // 新規作成画面
    Route::post('/admin/offer/store', [OfferController::class, 'store'])->name('admin.offer.store'); // 新規作成処理
    Route::get('/admin/offer/{id}/edit', [OfferController::class, 'edit'])->name('admin.offer.edit'); // 編集画面
    Route::put('/admin/offer/{id}', [OfferController::class, 'update'])->name('admin.offer.update'); // 更新処理
    Route::post('/admin/offer/delete', [OfferController::class, 'delete'])->name('admin.offer.delete'); // 削除処理
    Route::post('/admin/offer/search-artists', [OfferController::class, 'searchArtists'])->name('admin.offer.searchArtists'); // 作家検索処理

    //フロントからのお問い合わせ管理
    Route::get('/admin/inquiry', [AdminInquiryController::class, 'index'])->name('admin.inquiry');
    Route::get('/admin/inquiry/messages/{inquiryId}', [AdminInquiryController::class, 'getMessages']);
    Route::post('/admin/inquiry/reply', [AdminInquiryController::class, 'reply'])->name('inquiry.reply');

    // メッセージ管理画面のルート
    Route::get('/admin/message', [MessageController::class, 'index'])->name('admin.message');
    Route::get('/admin/message/list', [MessageController::class, 'list'])->name('admin.message.list');
    Route::post('/admin/message/store', [MessageController::class, 'store'])->name('admin.message.store');
    Route::get('/admin/message/detail', [MessageController::class, 'detail'])->name('admin.message.detail');
    Route::get('/admin/message/send', [MessageController::class, 'send'])->name('admin.message.send');
    Route::get('/admin/message/search', [MessageController::class, 'search'])->name('admin.message.search');
    // カタログ作成
    Route::get('/admin/catalogue', [CatalogueController::class, 'index'])->name('admin.catalogue');
    Route::get('/admin/notice', [NoticeController::class, 'index'])->name('admin.notice');
    Route::get('/admin/page', [PageController::class, 'index'])->name('admin.page');
    //売買管理
    Route::get('/admin/sales', [SalesController::class, 'index'])->name('admin.sales');
    Route::get('/admin/setting', [SettingController::class, 'index'])->name('admin.setting');
    // タグ管理用のルート
    Route::get('/admin/tags/create', [TagController::class, 'create'])->name('tags.create');
    Route::post('/admin/tags/delete', [TagController::class, 'delete'])->name('tags.delete');
    Route::post('/admin/tags', [TagController::class, 'store'])->name('tags.store');
    Route::post('/tags/update-order', [TagController::class, 'updateOrder'])->name('tags.updateOrder');
    //管理者追加と削除のルート
    Route::post('/admin/setting/admin_register',[SettingController::class, 'adminRegistration'])->name('admin.RegAdmin');
    Route::post('/admin/setting/admin_delete',[SettingController::class, 'deleteAdmin'])->name('admin.deleteAdmin');

    /*画像ファイルアップロード用*/
    Route::get('/admin/file-upload', [FileUploadController::class, 'index'])->name('admin.file.upload');
    Route::post('/admin/file-upload', [FileUploadController::class, 'upload'])->name('admin.file.upload.submit');

    // 他の管理画面内のルートもここに追加します
});

// マイページ内のルート設定
Route::middleware(['auth:artist'])->group(function () {
    Route::get('/mypage', [MypageController::class, 'index'])->name('artist.mypage');
    //プロフィール関連のルート
    Route::get('/mypage/profile', [MypageProfileController::class, 'index'])->name('mypage.profile');
    Route::post('/mypage/photo-upload', [MypageProfileController::class, 'photoUpload'])->name('mypage.photo.upload');
    Route::post('/mypage/profile/update', [MypageProfileController::class, 'updateProfile'])->name('mypage.profile.update');
    Route::post('/mypage/portfolio/register', [\App\Http\Controllers\Mypage\PortfolioController::class, 'upload'])->name('portfolio.upload');
    // 作品管理用のルート
    Route::get('/mypage/my_art', [MypageArtworkController::class, 'index'])->name('mypage.art.index');
    Route::get('/mypage/my_art/edit/{id}', [MypageArtworkController::class, 'edit'])->name('mypage.art.edit');
    Route::get('/mypage/my_art/register', [MypageArtworkController::class, 'create'])->name('mypage.art.create');
    Route::post('/mypage/my_art/register', [MypageArtworkController::class, 'store'])->name('mypage.art.store');
    // 案件管理用ルート
    Route::get('/mypage/offer', [MypageOfferController::class, 'index'])->name('mypage.offer');
    // コメント管理用ルート
    Route::get('/mypage/comment', [MypageCommentController::class, 'index'])->name('mypage.comment');
    // 問い合わせ管理用ルート
    Route::get('/mypage/inquiry', [MypageInquiryController::class, 'index'])->name('mypage.inquiry');
});
