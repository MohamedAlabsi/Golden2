<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Repositories\TMDBRepository;
use Illuminate\Http\Request;
class ApiTMDBController extends Controller
{
    private $request;
    protected TMDBRepository $tmdbRepository;

    public function __construct()
     {
        $this->tmdbRepository = new TMDBRepository();
     }

    public function popular(Request $request)
    {
      return $this->tmdbRepository->movie_popular($request);
    }

    // public function getAgents(Request $request)

    // {
    //     $this->request = $request;
    //     $users = User::where('agent_status', 1)->whereHas('agentServices', function ($query) {
    //         if ($this->request->service_id == null) {
    //             return  $query;
    //         } else
    //             $query->whereIn('service_id', $this->request->service_id);
    //     })->whereHas('userServiceshasMany', function ($query) {
    //         if ($this->request->country_id == null) {
    //             return  $query;
    //         } else
    //             $query->whereIn('user_country_id', $this->request->country_id);
    //     })->with('services')->paginate(10);

    //     return resourceJson($users, "البيانات", true);
    // }

    // public function getAgentsFavorite(Request $request)
    // {
    //     $this->request = $request;
    //     $users = Favorite::where('user_id', $request->user()->id)
    //         ->with('user')->paginate(10);
    //     $favorite =  $users->pluck('favorite_user_id');
    //     $users = User::whereIn('id', $favorite)->whereHas('agentServices')->whereHas('userServiceshasMany')->with('services')->get();

    //     return resourceJson($users, "البيانات", true);
    // }
    // public function getServices(Request $request)
    // {
    //     $service = Service::where('active', 1)->get();
    //     return resourceJson($service, "البيانات", true);
    // }
    // public function getCountries(Request $request)
    // {
    //     // $user = User::find(1);

    //     // $messages["hi"] = "Hey, Happy Birthday {dd}";
    //     // $messages["wish"] = "On behalf of the entire company I wish you a very happy birthday and send you my best wishes for much happiness in your life.";

    //     // $user->notify(new Alert($messages));
    //     // return "";
    //     $country = Country::where('active', 1)->get();
    //     return resourceJson($country, "البيانات", true);
    // }
    // public function getCities(Request $request)
    // {
    //     $cities = City::where('country_id', $request->country_id)->where('active', 1)->get();
    //     return resourceJson($cities, "البيانات", true);
    // }

    // public function getCitiesById(Request $request)
    // {
    //     Log::debug("ddddddddddddddddddd");
    //     Log::debug($request->countries_id);
    //     $cities = Country::whereIn('id', $request->countries_id)->with('cities')->where('active', 1)->get();
    //     return resourceJson($cities, "البيانات", true);
    // }



    // public function getAgentService(Request $request)
    // {
    //     $userService = UserService::where('user_id', $request->user_id)->with('service');
    //     // $usercity = UserCity::  with('country')->with('city')->paginate(2);
    //     return $userService->get();

    //     $userCities = DB::table('user_cities')
    //         ->select('user_country_id', 'user_city_id')
    //         ->distinct('user_country_id')
    //         ->get();
    //     // // $userService= UserService::where('user_id',$request->user_id)->with('service')->paginate(2);
    //     // // $userService= UserService::where('user_id',$request->user_id)->with('service')->with('country')->with('city')->paginate(2);
    //     // $country = UserCountry::where('user_id', $request->user_id)->get()->map(function ($country) {
    //     //     $country->getCityListAttribute = $country->city;
    //     //     return  $country;
    //     // });
    //     //the account has been successfully created
    //     return resourceJson($userCities, "البيانات", true); //the account has been successfully created
    // }

    // public function getUserCountries(Request $request)
    // {
    //     $this->request = $request;
    //     $userServicesTest = UserService::where('user_id', $this->request->user_id)->with("country")->get();
    //     foreach ($userServicesTest  as $key => $value) {
    //         Log::debug("test city value");
    //         Log::debug($value);
    //         $value->cities = City::whereIn('id', (is_array($value->cities_id)  ?  $value->cities_id : [0]))->get();
    //         $value->cityAllByCountries = City::where('country_id', $value->user_country_id)->get();

    //     }
    //     return $userServicesTest;

    // }



    // public function getUsercities(Request $request)
    // {
    //     $country = Country::where('active', 1)->get();
    //     return resourceJson($country, "البيانات", true);
    // }
    // public function getFavoriteUser(Request $request)
    // {

    //     // استعلام لجلب بيانات المستخدم المفضل للمستخدم 
    //     $favorite_user_id = Favorite::where('favorite_user_id', $request->favorite_user_id)->where('user_id', $request->user()->id)->first();

    //     if ($favorite_user_id) {
    //         // إرجاع بيانات المستخدم المفضل

    //         return resourceJson($favorite_user_id, "البيانات", true);
    //     } else {
    //         // رسالة خطأ إذا لم يتم العثور على المستخدم المفضل
    //         return resourceJson(null, "البيانات", false);
    //     }
    // }
    // public function addOrRemoveFavoriteUser(Request $request)
    // {

    //     try {
    //         // استعلام لجلب بيانات المستخدم المفضل للمستخدم 
    //         $favorite_user = Favorite::where('favorite_user_id', $request->favorite_user_id)->where('user_id', $request->user()->id)->first();

    //         if ($favorite_user) {

    //             // إرجاع بيانات المستخدم المفضل
    //             $favorite_user->delete();
    //             return resourceJson(NULL, "البيانات", true);
    //         } else {

    //             $new_favorite_user = Favorite::create([
    //                 'user_id' => $request->user()->id,
    //                 'favorite_user_id' => $request->favorite_user_id,
    //             ]);

    //             return resourceJson($new_favorite_user, "البيانات", true);
    //         }
    //     } catch (Exception) {
    //         Log::debug("eerror");
    //     }
    // }
    // public function checkStatusInvitation(Request $request)
    // {
    //     $invitation_user = Invitation::where('invitation_user_id', $request->invitation_user_id)->where('user_id', $request->user()->id)->first();

    //     if ($invitation_user) {
    //         return resourceJson($invitation_user, "البيانات", true);
    //     } else {
    //         return resourceJson(null, "البيانات", false);
    //     }
    // }

    // public function getProfile(Request $request)
    // {
    //     $user = User::find($request->user()->id);
    //     return resourceJson($user, "البيانات", true);
    // }

    // public function getProfileAgent(Request $request)
    // {
    //     $this->request = $request;
    //     // Log::debug($this->request->user()->id);
    //     // $userServices = UserService::select('users_services.*', 'countries.name', 'countries.id as cities')
    //     //     ->join('countries', 'users_services.user_country_id', '=', 'countries.id')
    //     //     ->whereIn('users_services.id', function ($query) {
    //     //         $query->select(\DB::raw('MAX(id)'))
    //     //             ->from('users_services')
    //     //             ->where('user_id', $this->request->user()->id)
    //     //             ->groupBy('user_country_id');
    //     //     })->orderBy('users_services.id')
    //     //     ->get();
    //     $userServices = UserService::where('user_id', $this->request->user()->id)->with("country")->get();
    //     foreach ($userServices  as $key => $value) {
    //         $value->cities = City::whereIn('id', (is_array($value->cities_id)  ?  $value->cities_id : [0]))->get();
    //     }



    //     // foreach ($userServices as $forUserService) {


    //     //     $cityPluck = UserService::where('user_country_id', $forUserService->user_country_id)->where("user_id", $this->request->user()->id);
    //     //     $city = City::whereIn('id', $cityPluck->pluck('user_city_id'))->get();
    //     //     $forUserService->cities = $city;

    //     // }
    //     $userAgentId = AgentService::where('user_id', $this->request->user()->id)->get()->pluck('service_id');

    //     $dataUserServices = Service::whereIn('id', $userAgentId)->get();



    //     return resourceJson(["user_services" => $userServices, "services" => $dataUserServices], "البيانات", true);
    // }

    // public function updateServicesProfile(Request $request)
    // {
    //     AgentService::where('user_id',  $request->user()->id)->delete();
    //     foreach ($request->data  as $key => $value) {
    //         AgentService::create([
    //             'user_id'=>$request->user()->id,
    //             'service_id'=> $value
    //         ]); 
    //         // $service = Service::where('active', 1)->get();
    //     }
    //     Log::debug($request->all());
    //     $service = AgentService::where('user_id', $request->user()->id )->get()->map(function ($agentService) {
    //          $agentService->name =Service::where('id',$agentService->service_id)->first()->toArray()['name'];

    //             return  $agentService;
    //         });
    //     return resourceJson($service, "البيانات", true);
    // }

    // public function addInvitation(Request $request)
    // {
    //     try {

    //         $invitation_user = Invitation::where('invitation_user_id', $request->invitation_user_id)->where('user_id', $request->user()->id)->first();
    //         $toUser = User::find($request->invitation_user_id);
    //         if ($invitation_user) {
    //             return resourceJson($invitation_user, "البيانات", false);
    //         } else {

    //             $new_invitation_user = Invitation::create([
    //                 'user_id' => $request->user()->id,
    //                 'invitation_user_id' => $request->invitation_user_id,
    //                 'accepted' => 1,
    //             ]);

    //             $notification = Notification::create([
    //                 'from_user_id' => $request->user()->id,
    //                 'to_user_id' => $toUser->id,
    //                 'action' => true,
    //                 'active' => 1,
    //                 'title' => trans('filament.user_invitation', [], $toUser->language_code ?? 'en')    , //user invitation
    //                 //the user invited you
    //                 //accept the invitation to reveal your wechat id
    //                 'body' => trans('filament.the_user_invited_you', [], $toUser->language_code ?? 'en')    . " " . $request->user()->name . " " . trans('filament.accept_the_invitation_to_reveal_your_wechat_id', [], $toUser->language_code ?? 'en')  
    //             ]);
    //         //    ApiController::sendSms($toUser, $notification, "notification");
    //             sendNotification($toUser, $notification->body,   "notification",[]);
    //             return resourceJson($new_invitation_user, "البيانات", true);
    //         }
    //     } catch (Exception $e) {
    //         Log::debug($e->getMessage());
    //     }
    // }

    // public function updateProfile(Request $request)
    // {
    //     return DB::transaction(function () use ($request) {
    //         $user = $request->user();
    //         $user->name = $request->name;
    //         $user->email = $request->email ?? null;
    //         $user->address = $request->address;
    //         $user->wechat = $request->wechat;
    //         $user->company_info = $request->company_info;
    //         $user->company_name = $request->company_name;
    //         $user->tin = $request->tin;

    //         $logo = $request->file('profileLogo');   

    //             Log::debug($request->isDeleteProfileLogo);
    //             if($logo && $logo != null){
    //                 Log::debug("hiiiiiiiiiiiiiii");

    //                 $user->clearMediaCollection('profile_logo');

    //                 $media = $user->addMedia($logo)->usingName($logo->getClientOriginalName())->toMediaCollection('profile_logo');

    //             }
    //             else {

    //                 Log::debug("hiiiiiiiiiiiiiiifalse");
    //                 if(!$request->isDeleteProfileLogo){
    //                     Log::debug("hiiiiiiiiiiiiiiiprofile_logo false");
    //                     $user->clearMediaCollection('profile_logo');
    //                 }

    //             }




    //         $user->save();


    //         return resourceJson($user, __("filament.the_profile_has_been_successfully_modified"), true);

    //         //
    //     });
    // }

    // public function updateMainProfile(Request $request)
    // {
    //     return DB::transaction(function () use ($request) {
    //         $user = $request->user();
    //         $user->name = $request->name;
    //         $user->email = $request->email ?? null;
    //         $user->address = $request->address;
    //         $user->wechat = $request->wechat;
    //         $user->company_name = $request->company_name;
    //         $user->company_info = $request->company_info; 
    //         $user->tin = $request->tin;
    //         $user->save(); 
    //         return resourceJson($user, __("filament.the_profile_has_been_successfully_modified"), true);

    //         //
    //     });
    // }

    // public function updateImagesProfile(Request $request)
    // {
    //     return DB::transaction(function () use ($request) {
    //         $user = $request->user();


    //         if ($user->role_id == 2) {

    //             $company_logo = $request->file('company_logo');

    //             $commercial_register = $request->file('commercial_register');
    //             $tax_card_image = $request->file('tax_card_image'); 



    //             if ($company_logo && $company_logo != null) { 
    //                 $user->clearMediaCollection('company_logo');
    //                 $media = $user->addMedia($company_logo)->usingName($company_logo->getClientOriginalName())->toMediaCollection('company_logo');

    //             }

    //             if(!$request->isDeleteCompanyLogo){
    //                 $user->clearMediaCollection('company_logo');
    //             } 

    //             if ($commercial_register && $commercial_register != null) {
    //                 $user->clearMediaCollection('commercial_register');
    //                 // $media = $user->addMedia($commercial_register)->toMediaCollection('commercial_register');
    //                 $media = $user->addMedia($commercial_register)->usingName($commercial_register->getClientOriginalName())->toMediaCollection('commercial_register');


    //             }

    //             if(!$request->isDeleteCommercialRegisterLogo){
    //                 $user->clearMediaCollection('commercial_register');

    //             }

    //             if ($tax_card_image && $tax_card_image != null) { 
    //                 $user->clearMediaCollection('tax_card_image');
    //                 // $media = $user->addMedia($tax_card_image)->toMediaCollection('tax_card_image');
    //                 $media = $user->addMedia($tax_card_image)->usingName($tax_card_image->getClientOriginalName())->toMediaCollection('tax_card_image');
    //                 // $user->tax_card_image = $media->getAttribute('file_name');
    //                 // $taxCard_image= $media->getUrl();
    //             }

    //             if(!$request->isDeleteTaxCardImage){ 
    //                 $user->clearMediaCollection('tax_card_image');

    //             }
    //         }
    //         $profile_logo = $request->file('profileLogo');
    //         Log::debug("hiiiiiiiiiiiiiiiprofile_logo");
    //         if ($profile_logo && $profile_logo != null) { 
    //             Log::debug("hiiiiiiiiiiiiiiiprofile_logo true");
    //             $user->clearMediaCollection('profile_logo');
    //             $media = $user->addMedia($profile_logo)->usingName($profile_logo->getClientOriginalName())->toMediaCollection('profile_logo');

    //         }

    //         if(!$request->isDeleteProfileLogo){
    //             Log::debug("hiiiiiiiiiiiiiiiprofile_logo false");
    //             $user->clearMediaCollection('profile_logo');
    //         }

    //         $user->save();


    //         return resourceJson($user, __("filament.the_profile_has_been_successfully_modified"), true);

    //         //
    //     });
    // }

    // public function updateProfileLogo(Request $request)
    // {
    //     return DB::transaction(function () use ($request) {
    //         $user = $request->user();

    //         // $user->addMedia(Storage::path('logdo.jpg'))->toMediaCollection('000000000000000'); 
    //             $logo = $request->file('logo');
    //             Log::debug($request->delete_profile);
    //             if($logo && $logo != null){
    //                 Log::debug("hiiiiiiiiiiiiiii");

    //                 $user->clearMediaCollection('logo');

    //                 $media = $user->addMedia($logo)->usingName($logo->getClientOriginalName())->toMediaCollection('logo');

    //             }
    //             else {

    //                 Log::debug("hiiiiiiiiiiiiiiifalse");
    //                 $user->clearMediaCollection('logo');

    //             }



    //         $user->save();


    //         return resourceJson($user, __("filament.the_profile_has_been_successfully_modified"), true);

    //         //
    //     });
    // }


    // public function updateCountriesAndCities(Request $request)
    // {
    //     return DB::transaction(function () use ($request) {
    //         $user = $request->user();
    //         UserService::where('user_id', $user->id)->delete();
    //         foreach ($request->countries as $country) {  
    //             $arr = [];
    //             foreach ($country['city'] as $city) {  
    //                    array_push($arr, $city['id']); 

    //             }
    //             UserService::create([
    //                 'service_id'=>null,
    //                 'user_id'=>$user->id,
    //                 'user_country_id'=>$country['id'],
    //                 'user_city_id'=>1,
    //                 'cities_id'=>$arr,
    //             ]);


    //           } 

    //     $userServices= UserService::where('user_id', $user->id)->with("country")->get() ;
    //     foreach ($userServices  as $key => $value) {
    //         $value->cities = City::whereIn('id', (is_array($value->cities_id)  ?  $value->cities_id : [0]))->get();
    //     }
    //     return $userServices;


    //         return resourceJson($userServices, __("filament.the_profile_has_been_successfully_modified"), true);

    //         //
    //     });
    // }







    // public function acceptOrRejectInvitation(Request $request)
    // {

    //     $notification = Notification::find($request->id);
    //     $user = User::where('id', $notification->from_user_id)->first();
    //     $invitation_user = Invitation::where('invitation_user_id', $notification->to_user_id)->where('invitation_user_id', $request->user()->id)->first();
    //     $invitation_user->accepted = $request->invitationType;
    //     $notificationCreat = Notification::create([
    //         'from_user_id' => $request->user()->id,
    //         'to_user_id' => $user->id,
    //         //the invitation has been declned : the invitation has been accepted
    //         'title' => $request->invitationType == 2 ?           trans('filament.the_invitation_has_been_accepted', [], $user->language_code ?? 'en')     :  trans('filament.the_invitation_has_been_rejected', [], $user->language_code ?? 'en') ,
    //         //by the shipping agent
    //         'body' => ($request->invitationType == 2 ?   trans('filament.the_invitation_has_been_accepted', [], $user->language_code ?? 'en')  :  trans('filament.the_invitation_has_been_rejected', [], $user->language_code ?? 'en')            ) . ' ' .     trans('filament.by_the_shipping_agent', [], $user->language_code ?? 'en')        . ' ' . $request->user()->name
    //     ]);


    //     $notification->action = 0;
    //     $notification->save();
    //     $invitation_user->save();
    //     sendNotification($user, $notificationCreat->body, "notification",[]);
    //     // ApiController::sendSms($user, $notificationCreat, "notification");
    //     return resourceJson($notification, "البيانات", true);
    // }

    // public function getNotifications(Request $request)
    // {
    //     $data  = Notification::where('to_user_id', $request->user()->id)->where('is_chat', 0)->paginate(10);
    //     return resourceJson($data, "البيانات", true);
    // }
    // public function changeLanguage(Request $request)
    // {

    //     $user  = $request->user();
    //     $user->language_code = $request->language;
    //     $user->save();
    //     return resourceJson($user, "البيانات", true);
    // }

    // public function privacy(Request $request)
    // {

    //     $data  = Privacy::first();
    //     return resourceJson($data, "البيانات", true);
    // }
    // public function about(Request $request)
    // {

    //     $data  = About::first();
    //     return resourceJson($data, "البيانات", true);
    // }
    // public function support(Request $request)
    // {

    //     $data  = Support::first();
    //     return resourceJson($data, "البيانات", true);
    // }

    // // static public function sendSms($toUser, $notification, $type = "notification")
    // // {
    // //     Log::debug("to user notifaction");
    // //     Log::debug($toUser->token);
    // //     Http::acceptJson()->withToken("AAAAYAM7wzc:APA91bGxxgeicSP_nPn3q84G40NrHxEY3KOVWrH6ieZi2pElfuoU8Yed939XUlEyoExRUmW2xpc9VzKR7IbdmSqkzzFH3Mph6-pWOVFqNO7NOf2vTsUaZK2frm0FO1hyCgteMBc8BQM9")->post(
    // //         'https://fcm.googleapis.com/fcm/send',
    // //         [
    // //             'to' => $toUser->token,
    // //             'notification' => [
    // //                 'title' => $notification->title,
    // //                 'body' => $notification->body . ' ' . $type . '....',
    // //             ],
    // //         ]
    // //     );
    // // } 

    // // static public function sendNotification($token, $title, $body, $type = "notification")
    // // {

    // //     Http::acceptJson()->withToken("AAAAYAM7wzc:APA91bGxxgeicSP_nPn3q84G40NrHxEY3KOVWrH6ieZi2pElfuoU8Yed939XUlEyoExRUmW2xpc9VzKR7IbdmSqkzzFH3Mph6-pWOVFqNO7NOf2vTsUaZK2frm0FO1hyCgteMBc8BQM9")->post(
    // //         'https://fcm.googleapis.com/fcm/send',
    // //         [
    // //             'to' => $token,
    // //             'notification' => [
    // //                 'title' =>  $title,
    // //                 'body' => $body,
    // //                 'titleLocKey' => $type . ' ' . $type . '....'
    // //             ],
    // //         ]
    // //     );
    // // }


    // public function sendMessages(Request $request)
    // {
    //     try {

    //     $toUser = User::where('id', $request->receiverId)->first();
    //     $chatCount = 0;
    //     if ($request->user()->role_id == 2 && $toUser->role_id !=3 ) {
    //         $chat = Chat::where('user_id', $request->receiverId)->where('agent_id', $request->user()->id)->first();
    //     } else {
    //        $chat = Chat::where('user_id', $request->user()->id)->where('agent_id', $request->receiverId)->first();

    //     }
    //     // تحويل المحادثة إلى تنسيق JSON
    //     $conversation = $chat ?  $chat->messages : [];

    //     $oneMessage=[
    //         'sender' => $request->user()->id,
    //         'receiver' => $request->receiverId,
    //         'content' => $request->content,
    //         'timestamp' => now()->toDateTimeString()
    //     ];


    //     $conversation[] = $oneMessage;
    //     $conversationJson =  $conversation;
    //     Log::debug("ssssssssssssssss");


    //     if (!$chat) {

    //         Chat::create([
    //             'user_id' => $toUser->isAdmin() ? $request->user()->id :   ($request->user()->role_id == 2 ? $request->receiverId : $request->user()->id),
    //             'agent_id' => $toUser->isAdmin()  ?  $request->receiverId :   ($request->user()->role_id == 2 ? $request->user()->id : $request->receiverId),
    //             'admin_type' => $request->receiverId == 1 ? true : false,
    //             'reader_user' => $toUser->role_id == 1  ? 1 : 0,
    //             'reader_agent' => $toUser->role_id == 2  ? 1 : 0,
    //             'reader_admin' => $toUser->role_id == 3  ? 1 : 0,
    //             'with_admin' => $toUser->role_id == 3 ? 1 : 0,
    //             //the invitation has been declned : the invitation has been accepted
    //             'messages' => $conversationJson,
    //         ]);
    //     } else {
    //         $countMessage = countMessageReader($toUser, $chat);
    //         $chat->update([
    //             'messages' => $conversationJson,
    //             'reader_user' => $toUser->role_id == 1  ? $chat->reader_user + 1 : 0,
    //             'reader_agent' => $toUser->role_id == 2  ? $chat->reader_agent + 1 : 0, 

    //         ]);
    //     }

    //     Log::debug("language");
    //     Log::debug($toUser->token);
    //     // استخدام اللغة المفضلة للمستخدم لترجمة النص
    //     $body = trans('filament.You_have_a_new_message_from', [], $toUser->language_code ?? 'en') . ' ' . $request->user()->name;
    //     $title = trans('filament.new_message', [], $toUser->language_code ?? 'en');

    //     // if($request->receiverId==1){
    //     //     Notification::create([
    //     //            'from_user_id' => $request->user()->id,
    //     //            'to_user_id' => 1,
    //     //            //the invitation has been declned : the invitation has been accepted
    //     //            'title' =>  $title,
    //     //            'is_chat' =>  1,
    //     //            'is_admin' =>  true,
    //     //            //by the shipping agent
    //     //            'body' => $body 
    //     //        ]);
    //     //    }

    //     // sendNotification($toUser->token, $title, $body, 'chat');
    //     sendNotification($toUser, $body,   "message",$oneMessage);
    //     return resourceJson(null, "البيانات", true);
    // } catch (Exception $e) {
    //     Log::debug("error when send message");
    //     Log::debug($e->getMessage());
    //     Log::debug($body);
    //     throw ValidationException::withMessages([
    //         'message' => __("filament.this_account_is_currently_closed"),//this account is currently closed
    //     ]);
    // }
    // }



    // public function getMessages(Request $request)
    // {
    //     $user = User::where("id", $request->receiverId )->first();
    //     if ($request->user()->role_id == 2  && $user->role_id !=3) {
    //         $chat = Chat::where('user_id', $request->receiverId)->where('agent_id', $request->user()->id)->get();
    //     } else {
    //         $chat = Chat::where('user_id', $request->user()->id)->where('agent_id', $request->receiverId)->get();
    //     }


    //     $typeChat = typeChat($request->user());
    //     Log::debug($chat);
    //     Log::debug($typeChat);
    //     // $chat->$typeChat = 0;
    //     // $chat->save();
    //     // $chat->update([$typeChat => 0]);


    //     return resourceJson($chat, "البيانات", true);
    // }

    // public function getListChats(Request $request)
    // {
    //     if ($request->user()->role_id == 2) {
    //         $chat = Chat::where('agent_id', $request->user()->id)->with('user')->get();
    //         Log::debug($request->user()->id);
    //         $getChatSupport = Chat::where('user_id', $request->user()->id)->with('agent')->get();
    //         $chat = $chat->merge($getChatSupport);
    //     } else {
    //         $chat = Chat::where('user_id', $request->user()->id)->with('agent')->get();
    //     }
    //     // Log::debug($chat);

    //     //   $chat = Chat::where('user_id', 214)->with('user')->get();
    //     return resourceJson($chat, "البيانات", true);
    // }

    // public function getMessagesReader(Request $request)
    // {

    //     $typeChat = typeChat($request->user());
    //     $chat = Chat::where('id', $request->id)->first();
    //     $chat->update([$typeChat => 0]);
    //     return resourceJson($chat, "البيانات", true);
    // }

    // public function getNotificationReader(Request $request)
    // {

    //     $notification = Notification::where('id', $request->id)->first();
    //     $notification->update(['reader' => 1]);
    //     return resourceJson($notification, "البيانات", true);
    // }
    // public function refreshToken(Request $request)
    // {

    //     $user = $request->user();
    //     $user->token = $request->token;
    //     $user->save();
    //     return resourceJson("", "البيانات", true);
    // }



    // /**
    //  * Store a newly created resource in storage.
    //  */
    // public function store(Request $request)
    // {
    //     //
    // }

    // /**
    //  * Display the specified resource.
    //  */
    // public function show(string $id)
    // {
    //     //
    // }

    // /**
    //  * Update the specified resource in storage.
    //  */
    // public function update(Request $request, string $id)
    // {
    //     //
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  */
    // public function destroy(string $id)
    // {
    //     //
    // }


    // public function logout(Request $request)
    // {
    //     Auth::guard('admin')->logout();
    //     Auth::guard('web')->logout();
    //     $request->session()->flush();
    //     $request->session()->regenerate();
    //     return redirect('/');
    // }

    // protected function authenticated()
    // {
    //     Auth::logoutOtherDevices(request('password'));
    // }
}
