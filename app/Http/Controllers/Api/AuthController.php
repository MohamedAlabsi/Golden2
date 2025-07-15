<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiAllResource;
use App\Http\Resources\UserCollection;
use App\Models\AgentService;
use App\Models\Category;
use App\Models\Chat;
use App\Models\City;
use App\Models\Collection;
use App\Models\Country;
use App\Models\country_and_city;
use App\Models\CountryAll;
use App\Models\Genres;
use App\Models\Mohammed;
use App\Models\Notification;
use App\Models\OriginalLanguage;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Table;
use App\Models\User;
use App\Models\UserService;
use App\Rules\Phone;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        $user = User::where('name', $request->name)
            ->first();
        if (!$user) {
            throw ValidationException::withMessages([
                'message' => trans( 'عذرا هذا الحساب غير موجود'), //not account found
            ]);
        }
        $user->device_id =  $request->header('x-device-token');
        $user->device_name =  $request->header('x-device-name');
        $user->save();
        $token = $user->createToken($request->name)->plainTextToken;
        $isLogin = true;
        $originalLanguages =OriginalLanguage::where('active',true)->orderBy('order')->get();

        $collections =Collection::get();
        $categories =Category::get();
        $genres =Genres::where('active',true)->orderBy('order')->get();
        $settings =  Setting::pluck('key')->collapse();
        return  new  ApiAllResource(['collections'=>$collections ,'categories'=>$categories,'settings'=>$settings,'genres'=>$genres,'original_languages'=>$originalLanguages,'is_login'=>$isLogin,'user'=>$user,'token'=>$token]);

    }
    public function register(Request $request)
    {
        return DB::transaction(function () use ($request) {
            $user = User::where('name', $request->name)->first();

            if ($user) {
                throw ValidationException::withMessages([
                    'message' =>  trans(  'هذا الاسم مسجل من قبل'), //مسجل بالفعل
                ]);
            }


            $user = User::create([
                'name' => $request->name,
                'device_id' => $request->header('x-device-token'),
                'device_name' =>  null,
            ]);


            $isLogin = true;
            $originalLanguages =OriginalLanguage::where('active',true)->orderBy('order')->get();
            $collections =Collection::get();
            $categories =Category::get();
            $genres =Genres::where('active',true)->orderBy('order')->get();
            $settings =  Setting::pluck('key')->collapse();
            $token = $user->createToken($request->name)->plainTextToken;
            return  new  ApiAllResource(['collections'=>$collections ,'categories'=>$categories,'settings'=>$settings,'genres'=>$genres,'original_languages'=>$originalLanguages,'is_login'=>$isLogin,'user'=>$user,'token'=>$token]);

            //
        });
    }




    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }




    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        Auth::guard('web')->logout();
        $request->session()->flush();
        $request->session()->regenerate();
        return redirect('/');
    }

    protected function authenticated()
    {
        Auth::logoutOtherDevices(request('password'));
    }
}
