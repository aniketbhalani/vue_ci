<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CmsPageController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\MissionSkillController;
use App\Http\Controllers\MissionThemeController;
use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\PolicyPageController;
use App\Http\Controllers\UserLoginController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\MissionApplicationController;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\CountryCityController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::resource('products', ProductController::class);
Route::resource('cmspage', CmsPageController::class);
Route::resource('banner',BannerController::class);
Route::resource('missionskill',MissionSkillController::class);
Route::resource('missiontheme', MissionThemeController::class);
Route::post('/admin/login', [AdminLoginController::class, 'login']);
Route::post('/user/login', [UserLoginController::class, 'login']);
Route::post('/user/register', [UserLoginController::class, 'register']);
Route::post('/user/check-email', [UserLoginController::class, 'resetPassword']);
Route::post('/user/reset-password', [UserLoginController::class, 'passwordResetting']);
Route::post('/admin/check-email', [AdminLoginController::class, 'resetPassword']);
Route::post('/admin/reset-password', [AdminLoginController::class, 'passwordResetting']);
Route::get('policies',[PolicyPageController::class,'index']);

Route::get('/admin/mission-applications', [MissionApplicationController::class, 'getMissionApplications']);
Route::get('/admin/approve-application', [MissionApplicationController::class, 'approveApplication']);
Route::get('/admin/reject-application', [MissionApplicationController::class, 'rejectApplication']);


Route::get('/admin/users', [AdminUserController::class, 'index']);
Route::delete('/admin/users/{user}', [AdminUserController::class, 'destroy']);
Route::get('/fetch-countries', [CountryCityController::class, 'fetchCountries']);
Route::post('/fetch-city', [CountryCityController::class, 'fetchCities']);
Route::post('/admin/user', [AdminUserController::class, 'store']);
Route::get('admin/user/{user}',[AdminUserController::class,'show']);
Route::put('admin/user/{user}',[AdminUserController::class,'update']);

Route::get('/admin/stories', [StoryController::class, 'index'])->name('stories.index');
Route::get('/admin/stories/{id}', [StoryController::class, 'show'])->name('stories.show');
Route::post('/admin/stories/{id}/publish', [StoryController::class, 'publish'])->name('stories.publish');
Route::post('/admin/stories/{id}/decline', [StoryController::class, 'decline'])->name('stories.decline');
Route::delete('/admin/stories/{id}', [StoryController::class, 'destroy'])->name('stories.destroy');

