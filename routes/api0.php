<?php

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\ApiTMDBController;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
// Route::post('login', [AuthController::class,"login"]);


// Route::name("movie")->prefix("movie")->group(function ($router) {
//     Route::post('/popular', [ApiTMDBController::class,"movie_popular"]);
// });

// Route::post('reset_password', [AuthController::class,"resetPassword"]);

// Route::post('insert_countries', [AuthController::class,"insert_countries"]);
// Route::post('insert_cities', [AuthController::class,"insert_cities"]);

// Route::post('get_cities_from_countries', [AuthController::class,"get_cities_from_countries"]);

// Route::post('register', [AuthController::class,"register"]);
 
// Route::post('get_cities', [ApiController::class,"getCities"]);
// Route::post('get_cities_by_id', [ApiController::class,"getCitiesById"]);
// Route::post('get_services', [ApiController::class,"getServices"]);
// Route::post('get_countries', [ApiController::class,"getCountries"]);
// Route::post('test', [AuthController::class,"test"]);
// Route::post('send_otp', [AuthController::class,"sendOtp"]);
// Route::post('verfiy_user', [AuthController::class,"verfiyUser"]);
// Route::post('forget_password', [AuthController::class,"sendOtp"]);



// Route::group(['middleware' => 'auth:api'], function () {
//     Route::post('get_profile', [ApiController::class,"getProfile"]);
//     Route::post('get_profile_agent', [ApiController::class,"getProfileAgent"]);
//     Route::post('get_agents', [ApiController::class,"getAgents"]);
//     Route::post('get_agents_favorite', [ApiController::class,"getAgentsFavorite"]);
//     Route::post('get_agent_service', [ApiController::class,"getAgentService"]);
//     Route::post('get_user_countries', [ApiController::class,"getUserCountries"]);
//     Route::post('get_user_cities', [ApiController::class,"getUsercities"]);
//     Route::post('get_favorite_user', [ApiController::class,"getFavoriteUser"]);
//     Route::post('add_or_remove_favorite_user', [ApiController::class,"addOrRemoveFavoriteUser"]);
//     Route::post('check_status_invitation', [ApiController::class,"checkStatusInvitation"]);
//     Route::post('add_invitation', [ApiController::class,"addInvitation"]);
//     Route::post('get_notifications', [ApiController::class,"getNotifications"]);
//     Route::post('accept_or_reject_invitation', [ApiController::class,"acceptOrRejectInvitation"]);
//     Route::post('update_profile', [ApiController::class,"updateProfile"]);
//     Route::post('change_language', [ApiController::class,"changeLanguage"]);
//     Route::post('get_messages', [ApiController::class,"getMessages"]);
//     Route::post('get_messages_reader', [ApiController::class,"getMessagesReader"]);
//     Route::post('get_notification_reader', [ApiController::class,"getNotificationReader"]);

//     Route::post('send_message', [ApiController::class,"sendMessages"]);
//     Route::post('get_list_chats', [ApiController::class,"getListChats"]);
//     Route::post('privacy', [ApiController::class,"privacy"]);
//     Route::post('about', [ApiController::class,"about"]);
//     Route::post('support', [ApiController::class,"support"]);
//     Route::post('update_services', [ApiController::class,"updateServicesProfile"]);

//     Route::post('update_main_profile', [ApiController::class,"updateMainProfile"]);
//     Route::post('update_images_profile', [ApiController::class,"updateImagesProfile"]);
//     Route::post('update_profile_logo', [ApiController::class,"updateProfileLogo"]);
//     Route::post('update_countries_and_cities', [ApiController::class,"updateCountriesAndCities"]);
//     Route::post('refresh_token', [ApiController::class,"refreshToken"]);
//     Route::post('reset_password', [AuthController::class,"resetPassword"]);
//     Route::post('reset_password_without_current_password', [AuthController::class,"resetPasswordWithoutCurrentPassword"]);
 
// });

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
   
//     return $request->user();
// });
