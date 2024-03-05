<?php

use App\Http\Controllers\Api\AnalyticsDataController;
use App\Http\Controllers\Api\AuthController;
<<<<<<< HEAD
use App\Http\Controllers\Api\LemonWebhookController;
use App\Http\Controllers\Api\LinkController;
use App\Http\Controllers\Api\LinkImageController;
=======
use App\Http\Controllers\Api\GuestDataSubmitionController;
use App\Http\Controllers\Api\GuestPageController;
use App\Http\Controllers\Api\LemonWebhookController;
use App\Http\Controllers\Api\LinkController;
use App\Http\Controllers\Api\LinkDataController;
use App\Http\Controllers\Api\LinkImageController;
use App\Http\Controllers\Api\MailchimpAuthController;
>>>>>>> c7b34354aa909a8d74f6e9ec7ce888db0cf51b02
use App\Http\Controllers\Api\MainLinkAnalyticsController;
use App\Http\Controllers\Api\MainLinkGetterController;
use App\Http\Controllers\Api\PageanalyticsController;
use App\Http\Controllers\Api\PageController;
use App\Http\Controllers\Api\PageGuestController;
<<<<<<< HEAD
=======
use App\Http\Controllers\API\SocialAuthController;
use App\Http\Controllers\Api\SocialmediaController;
use App\Http\Controllers\Api\StoreitemsController;
>>>>>>> c7b34354aa909a8d74f6e9ec7ce888db0cf51b02
use App\Http\Controllers\Api\ThemeController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\UserImageController;
use App\Http\Controllers\Api\WebsiteAnalyticsController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Resources\UserResource;
use App\Models\Pageanalytics;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use LemonSqueezy\Laravel\Http\Controllers\WebhookController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::middleware(['guest'])->group(function () {
    Route::post('/register', [AuthController::class, 'store']);
                //->middleware('guest')
                //->name('register');

<<<<<<< HEAD
Route::post('/register', [AuthController::class, 'store']);
                //->middleware('guest')
                //->name('register');


Route::post('/login', [AuthController::class, 'login']);
                //->middleware('guest')
                //->name('login');
                

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', function (Request $request) {
        return new UserResource($request->user());
    });
    //Route::get('users', [UserController::class, 'index']);
    Route::patch('users/{user}', [UserController::class, 'update']);
    
    Route::get('page', [PageController::class, 'index']);
    Route::post('user-image', [UserImageController::class, 'store']);

    Route::get('links', [LinkController::class, 'index']);
    Route::get('sociallinks', [LinkController::class, 'fetchSocialLinks']);
    Route::post('links', [LinkController::class, 'store']);
    Route::patch('links/{link}', [LinkController::class, 'update']);
    Route::delete('links/{link}', [LinkController::class, 'destroy']);

    Route::post('link-image', [LinkImageController::class, 'store']);

    Route::get('themes', [ThemeController::class, 'index']);
    Route::patch('themes', [ThemeController::class, 'update']);

    Route::post('chartdata', [AnalyticsDataController::class, 'fetchdata']);
    Route::post('toplinks', [AnalyticsDataController::class, 'fetchlinksdata']);

    //payments stuff
    
});


Route::post('/usernamevalid', [UserController::class, 'userNameValid']);
Route::get('/guestview/{linkname}', [PageGuestController::class, 'showForGuest']);

Route::post('linkactivity', [PageanalyticsController::class, 'activitytriggger']);
=======

    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/verify-email-token', [AuthController::class, 'verifyemail']);
                
});

Route::group(['middleware' => ['api']], function () {
    Route::get('google-login', [SocialAuthController::class, 'redirectToProvider']);
    Route::post('google-login-token', [SocialAuthController::class, 'handlecallback']);

});



                

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', function (Request $request) {
        return new UserResource($request->user());
    });
    //Route::get('users', [UserController::class, 'index']);
    Route::post('username', [AuthController::class, 'updateUsername']);
    Route::patch('users/{user}', [UserController::class, 'update']);
    Route::post('/logout', [AuthController::class, 'logout']);
    
    Route::get('page', [PageController::class, 'index']);
    Route::post('page/update', [PageController::class, 'update']);
    Route::post('links/order', [PageController::class, 'linkorder']);
    Route::post('user-image', [UserImageController::class, 'store']);

    Route::get('links', [LinkController::class, 'index']);
    Route::post('links', [LinkController::class, 'store']);
    Route::patch('links/{link}', [LinkController::class, 'update']);
    Route::delete('links/{link}', [LinkController::class, 'destroy']);

    Route::get('socialicon', [SocialmediaController::class, 'index']);
    Route::post('socialicon', [SocialmediaController::class, 'store']);
    Route::patch('socialicon/{icon}', [SocialmediaController::class, 'update']);
    Route::post('socialicon/{icon}', [SocialmediaController::class, 'destroy']);

    Route::post('links/data/layout', [LinkDataController::class, 'layout']);
    Route::post('links/data/startup', [LinkDataController::class, 'startupdata']);
    Route::post('links/data/quote', [LinkDataController::class, 'quotedata']);
    Route::post('links/data/form', [LinkDataController::class, 'formdata']);
    Route::post('links/data/portfolio', [LinkDataController::class, 'portfoliodata']);

    Route::post('links/data/store/items', [StoreitemsController::class, 'store']);

    Route::post('link-image', [LinkImageController::class, 'store']);
    Route::post('link-thumbimage', [LinkImageController::class, 'storethumbnail']);
    Route::post('/link-portfoliothumbimage', [LinkImageController::class, 'storethumbnail']);

    Route::get('/googleAuth/authuri', [GuestDataSubmitionController::class, 'getAuthUrl']);
    Route::post('/googleAuth/setCode', [GuestDataSubmitionController::class, 'setCode']);
    Route::get('/googleAuth/getsheet', [GuestDataSubmitionController::class, 'getSheet']);

    Route::get('/mailchimpAuth/authuri', [MailchimpAuthController::class, 'getAuthUrl']);
    Route::post('/mailchimpAuth/getToken', [MailchimpAuthController::class, 'getMailchimpAccessToken']);


    Route::post('/guest/mailist', [GuestDataSubmitionController::class, 'mailinglist']);


    Route::get('themes', [ThemeController::class, 'index']);
    Route::patch('themes', [ThemeController::class, 'update']);
    Route::patch('page/appearance', [ThemeController::class, 'pageappearance']);

    Route::post('chartdata', [AnalyticsDataController::class, 'fetchdata']);
    Route::get('countrydata', [AnalyticsDataController::class, 'fetchcountriesdata']);
    Route::post('toplinks', [AnalyticsDataController::class, 'fetchlinksdata']);
    Route::post('topforms', [AnalyticsDataController::class, 'formsOverviewdata']);
    Route::post('formsummary', [AnalyticsDataController::class, 'fetchformsdata']);

    //payments stuff
    
});


Route::post('/usernamevalid', [UserController::class, 'userNameValid']);
Route::get('/guestview/{linkname}', [GuestPageController::class, 'showForGuest']);
Route::post('/form/answer', [GuestDataSubmitionController::class, 'storeAnswers']);


//Route::get('/googleAuth/authuri', [GuestDataSubmitionController::class, 'getAuthUrl']);
//Route::get('/googleAuth/getsheet', [GuestDataSubmitionController::class, 'getSheet']);

Route::post('linkactivity', [PageanalyticsController::class, 'linkclicked']);
Route::post('formviewed', [PageanalyticsController::class, 'formviewed']);
>>>>>>> c7b34354aa909a8d74f6e9ec7ce888db0cf51b02
Route::post('analytics', [PageanalyticsController::class, 'trigger']);
Route::post('mainlink', [MainLinkGetterController::class, 'linkdata']);
Route::post('pagelinks', [MainLinkGetterController::class, 'pagelinks']);
Route::post('/lemon-squeezy/webhook', [LemonWebhookController::class, 'webhook']);


//admin side
Route::middleware(['auth:sanctum', 'isAdmin'])->group(function () {
    Route::get('/admin/dashboard/users', [WebsiteAnalyticsController::class, 'users']);
    Route::get('/admin/dashboard/orders', [WebsiteAnalyticsController::class, 'orders']);
    Route::get('/admin/dashboard/analytics', [WebsiteAnalyticsController::class, 'analytics']);
});