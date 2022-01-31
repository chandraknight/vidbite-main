<?php

use App\Http\Controllers\AdvertiseManagement;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\TwoFactorController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContinueWatchController;
use App\Http\Controllers\Front\ChannelController;
use App\Http\Controllers\Front\CommentController;
use App\Http\Controllers\Front\MainController;
use App\Http\Controllers\Front\UserController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SuperAdmin\CampaignController;
use App\Http\Controllers\SuperAdmin\DashboardController;
use App\Http\Controllers\SuperAdmin\VideoController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\VideoContentController;
use App\Http\Controllers\WatchListController;
use App\Models\User;
use App\Models\VerifyUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

//Route::get('/', function () {
//    return view('auth.login');
//});

Route::get('/', [MainController::class, 'home']);
// Public Routes
Route::get('test', function () {

    // $users = User::whereHas('subscribers', function($query){
    //     $query->whereRaw('count(subscribers.id) > 100000');
    // })->get();

    $users = User::withCount(['subscribers','verifyUser'])->having('subscribers_count', '>=', 2)->having('verify_user_count', '=', 0)->get();

    foreach ($users as $key => $user) {
        if($user->profile != null){
            if($user->profile->cover_image != null &&
                $user->profile->profile_image != null &&
                $user->profile->about != null &&
                $user->videos->count() > 5)
            {

                $verify = new VerifyUser();
                $verify->user_id = $user->id;
                $verify->token = uniqid();
                $verify->save();


            }
        }

    }

    return $users;

});
Route::get('/user/verify/{token}', [RegisterController::class, 'verifyUser']);
Route::get('verify/resend', [TwoFactorController::class, 'resend'])->name('verify.resend');
Route::resource('verify', TwoFactorController::class)->only(['index', 'store']);
//Auth::routes();
Auth::routes(['verify' => true]);

// Protected Route //twofactor
Route::group(['middleware' => 'auth', 'web','verified'], function () {

    // Route::get('/test', [MainController::class, 'test']);
    // Front Routes
    Route::get('/home', [MainController::class, 'index'])->name('home');
    Route::get('/video/{id}', [MainController::class, 'playVideo'])->name('video.play');
    Route::get('/trending', [MainController::class, 'trending'])->name('trending');
    Route::get('/library', [MainController::class, 'library'])->name('library');
    Route::get('/history', [MainController::class, 'history'])->name('history');
    Route::get('/playlists', [MainController::class, 'playlists'])->name('playlists');

    // Watchlist
    Route::get('/watchlist', [WatchListController::class, 'index'])->name('watchlist');

    // Advt Management
    Route::prefix('advertise')->group(function () {
        Route::get('/dashboard', [AdvertiseManagement::class, 'dashboard'])->name('dashboard');
        Route::get('/account', [AdvertiseManagement::class, 'account'])->name('account');
        Route::get('/advt-mgmt', [AdvertiseManagement::class, 'advertiseManagement'])->name('advt-mgmt');
        Route::get('/create-campaign', [AdvertiseManagement::class, 'createCampaign'])->name('create-campaign');
    });

    // History
    // Route::get('/history', [HistoryController::class, 'index'])->name('history');

    // Search
    Route::get('/search', [SearchController::class, 'index'])->name('search');
    Route::get('/search-vid', [SearchController::class, 'search_result'])->name('search_result');
    Route::get('autocomplete', [SearchController::class, 'autocomplete'])->name('autocomplete');

    // Notifications
    Route::get('/notifications', [MainController::class, 'notifications'])->name('notifications');
    Route::get('/notifies', [MainController::class, 'notifies'])->name('page.notifications');
    // Comments
    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::post('/like-comments', [CommentController::class, 'like'])->name('comments.like');
    Route::post('/dislike-comments', [CommentController::class, 'dislike'])->name('comments.dislike');
    // Channel Routes
    Route::get('/channel/{id}', [ChannelController::class, 'index'])->name('channel.index');
    Route::get('/subscribe/{id}', [ChannelController::class, 'subscribe'])->name('channel.subscribe');
    Route::get('/like/{videoid}', [ChannelController::class, 'videoLike'])->name('channel.videolike');
    Route::get('/dislike/{videoid}', [ChannelController::class, 'videoDislike'])->name('channel.videodislike');
    Route::get('/unsubscribe/{subscriberId}/{accountID}', [ChannelController::class, 'unsubscribe'])->name('channel.unsubscribe');
    Route::get('/change-notification-settings/{subscriberId}/{accountID}', [ChannelController::class, 'changeNotificationSettings'])->name('channel.changeNotificationSettings');
    Route::get('/playlist/{id}', [ChannelController::class, 'playlist'])->name('channel.playlist');
    Route::get('/create-playlist/{id}', [ChannelController::class, 'createPlaylist'])->name('channel.createPlaylist');
    Route::post('/create-playlist/{id}', [ChannelController::class, 'storePlaylist'])->name('channel.storePlaylist');
    Route::get('/assign-video-playlist/{playlist_id}', [ChannelController::class, 'assignVideoToPlaylistView'])->name('channel.assignVideoToPlaylistView');
    Route::post('/assign-video-playlist/{playlist_id}', [ChannelController::class, 'assignVideoToPlaylist'])->name('channel.assignVideoToPlaylist');
    Route::post('/save-video-playlist/{playlist_id}', [ChannelController::class, 'assignVideoToPlaylist'])->name('channel.saveVideoToPlaylist');

    // Admin Routes
    Route::prefix('admin')->middleware(['auth','admin'])->group(function () {
        Route::get('/', [HomeController::class, 'index'])->name('admin.home');
        Route::get('/usermanagement', [UserManagementController::class, 'allUser'])->name("allUsers");
        Route::get('/create', [UserManagementController::class, 'create'])->name("createUser");
        Route::post('/add', [UserManagementController::class, 'store'])->name("addUser");
        Route::get('/edit/{id}', [UserManagementController::class, 'editUser'])->name("editUser");
        Route::post('/update/{id}', [UserManagementController::class, 'updateUser'])->name("updateUser");
        Route::delete('delete/{id}', [UserManagementController::class, 'delete'])->name("deleteUser");
        // to verify user
        Route::post('/verifyUser/{id}', [UserManagementController::class, 'verifyUser'])->name("verifyUser");

        Route::get('/accounts-edits/{id}', [UserController::class, 'editUserDetails'])->name("editUserDetails");
        Route::post('/accounts-update/{id}', [UserController::class, 'updateUser'])->name("updateUserAccount");

        Route::resource('/categories', CategoryController::class);
        /** Topics **/
        Route::get('/topics', [CategoryController::class, 'topics'])->name("topics");
        Route::get('/createTopic', [CategoryController::class, 'createTopic'])->name("createTopic");
        Route::post('/addTopic', [CategoryController::class, 'saveTopic'])->name("saveTopic");
        Route::get('/topicUpdate/{id}', [CategoryController::class, 'topicEdit'])->name("topicEdit");
        Route::post('/updateTopic', [CategoryController::class, 'updateTopic'])->name("updateTopic");
        Route::delete('/topicDelete/{id}', [CategoryController::class, 'topicDelete'])->name("topicDelete");
        /** End  **/
        Route::post('/make-category/{id}', [CategoryController::class, 'makeCategory'])->name("make.category");
        /** Banner **/
        Route::resource('/banners', BannerController::class);
        Route::get('/banners', [BannerController::class, 'index'])->name("banner.index");
        Route::get('/banners/list', [BannerController::class, 'list'])->name("banner.list");
        Route::get('/banners/create', [BannerController::class, 'create'])->name("banner_create");
        Route::delete('/banner/{id}', [BannerController::class, 'destroy'])->name("banner.delete");
        Route::get('/banner/{id}', [BannerController::class, 'show'])->name("banner.show");
        Route::get('/banner/{id}', [BannerController::class, 'show'])->name("banner.show");
        //Route::post('/banner/{id}', [BannerController::class, 'update'])->name("banner.update");
        Route::post('/banner', [BannerController::class, 'store'])->name("banner.add");
        /** End  **/
        Route::get('/videos', [VideoContentController::class, 'index'])->name("video.index");
        Route::get('/videos/list', [VideoContentController::class, 'list'])->name("video.list");
        Route::get('/video/{id}', [VideoContentController::class, 'detail'])->name("video.detailP");
    });

    //User Routes
    Route::prefix('user')->middleware(['auth','user'])->group(function () {
        Route::get('/profile/{id}', [UserController::class, 'index'])->name('user.profile');
        Route::get('/edit-profile/{id}', [UserController::class, 'editProfile'])->name('user.editProfile');
        Route::post('/edit-profile/{id}', [UserController::class, 'updateProfile'])->name('user.updateProfile');
        Route::get('/studio', [UserController::class, 'studio'])->name('user.studio');
        Route::get('/upload', [UserController::class, 'upload'])->name('user.upload');
        Route::post('/upload', [UserController::class, 'storeVideo'])->name('user.storeVideo');
        Route::get('/edit-video/{id}', [UserController::class, 'editVideo'])->name('user.editVideo');
        Route::post('/edit-video/{id}', [UserController::class, 'updateVideo'])->name('user.updateVideo');
        Route::get('/delete-video/{id}', [UserController::class, 'deleteVideo'])->name('user.deleteVideo');
    });

    // Super Admin Routes
    Route::prefix('super-admin')->middleware(['auth','superAdmin'])->group(function () {

        Route::get('/', [DashboardController::class,'index'])->name('super-admin');
        Route::get('/home', [DashboardController::class,'home']);

        Route::resource('campaigns', (CampaignController::class));

        Route::get('video-platform', [VideoController::class,'index'])->name('video-platform');
        Route::get('play-ad', [VideoController::class,'playAd'])->name('play-ad');
    });


    Route::get('/form-upload', [VideoContentController::class, 'create'])->name('uploadform');
    Route::post('/form-upload', [VideoContentController::class, 'store'])->name('uploadform');

    Route::get('/store/{video}', [ContinueWatchController::class, 'store'])->name('store');
    Route::get('/getTime/{video}', [ContinueWatchController::class, 'create'])->name('getTime'); //Route for getting the saved time
});