<?php

namespace App\Repositories;
use App\Models\User;
use App\Models\OriginalLanguage;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;

use App\Http\Resources\ApiAllResource;
use App\Http\Resources\ApiResource;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Entertainment;
use App\Models\Genre;
use App\Models\Genres;
use App\Models\MovieCart;
use App\Models\MovieCartItem;
use App\Models\Setting;
use App\Models\Slider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
class ApiRepository
{

    public $channel;


    public function __construct()
  {

  }

    public function categories(Request $request)
    {
     $categories =Category::with('genres')->get();
     return  new  ApiAllResource($categories);
    }
    public function init(Request $request)
    {
        $isLogin = false;
        $user =null;
        $authHeader = $request->bearerToken();

        if ($authHeader) {
            $accessToken = PersonalAccessToken::findToken($authHeader);

            if ($accessToken && $accessToken->tokenable instanceof User) {
                $user = $accessToken->tokenable;
                Auth::login($user); // تسجيل الدخول يدويًا في الجلسة
                $isLogin = true;
            } else {
                $isLogin = false;
            }
        } else {
            $isLogin = false;
        }
//        if (Auth::check()) {
//            $user = $request->user();
//            $isLogin = true;
//        }


        $originalLanguages =OriginalLanguage::where('active',true)->orderBy('order')->get();
        $collections =Collection::get();
        $categories =Category::get();
        $genres =Genres::where('active',true)->orderBy('order')->get();
        $settings =  Setting::pluck('key')->collapse();
;        return  new  ApiAllResource(['collections'=>$collections ,'categories'=>$categories,'settings'=>$settings,'genres'=>$genres,'original_languages'=>$originalLanguages,'is_login'=>$isLogin,'user'=>$user]);
//;        return  new  ApiAllResource([ 'is_login'=>$isLogin,'user'=>$user]);
    }

    public function collection(Request $request)
    {
//        $collections =Collection::with('collectionEntertainments')->limit(10)->get();
//        $collections = Collection::with('entertainments')->get();
        $collections = Collection::whereIn('id', [1, 2])->get();

        foreach ($collections as $collection) {
            if ($collection->id == 1) {
                // أفضل الأفلام
                $collection->setRelation('entertainments', Entertainment::where('is_top_movie', true)->get());
            } elseif ($collection->id == 2) {
                // أفضل المسلسلات
                $collection->setRelation('entertainments', Entertainment::where('is_top_series', true)->get());
            }
        }
        return  new  ApiAllResource( $collections );
    }


    public function sliders(Request $request)
    {


        $entertainments = Entertainment::where('is_slider',1)->get();

//        $slider = Slider::where('active', 1)
//            ->first();
//        $slider->entertainments = $slider->entertainment()->get();

        return  new  ApiAllResource($entertainments);
    }

    public function moviesAll(Request $request)
    {
        Log::debug("lsdkjfoweiurowier search ");
        $entertainments = Entertainment::paginate(10);
        return  new  ApiResource($entertainments);
    }


    public function genres(Request $request)
    {
     $genres =Genres::all();
     return  new  ApiResource($genres);
    }

    public function save($interest = null)
   {

   }

    public function confirm($send_id = null, $loan_id = null, $interest = null, $responsLoan = null)
   {

   }

    public function reject()
     {

     }

    public function cancel($id = null)
    {

    }

        public function addToCart(Request $request)
    {
        $data = $request->validate([
            'movie_id'       => 'required|integer',
            'name'           => 'required|string|max:255',
            'image'          => 'nullable|string',
            'note'           => 'nullable|string',
        ]);

        $cart = MovieCart::where('user_id',$request->user()->id)
            ->where('status', 'pending')
            ->first();

        if (!$cart) {
            $cart = MovieCart::create([
                'user_id' => $request->user()->id,
                'status' => 'pending',
            ]);
        }

         $cartItem = new MovieCartItem([
            'movie_cart_id'  =>  $cart->id,
             'user_id'  => $request->user()->id,
            'movie_id' => $data['movie_id'],
            'name'     => $data['name'],
            'image'    => $data['image'] ?? null,
            'note'     => $data['note'] ?? null,
        ]);

        $cart->items()->save($cartItem);
        return  new  ApiAllResource($cart);
    }

    public function updateCart(Request $request)
    {

        $cart = MovieCart::where('id', $request->id)->where('user_id', $request->user()->id)
            ->where('status', 'pending')
            ->first();
        $cart->status='confirmed';
        $cart->note= $request->note;
        $cart->save();
        $cart->refresh();
        return  new  ApiAllResource($cart);
    }


    public function deleteFromCart(Request $request)
    {

        $cart = MovieCart::where('user_id', $request->user()->id)
            ->where('status', 'pending')
            ->first();

            $moveItems=MovieCartItem::where('movie_cart_id',$cart->id)->where('movie_id',$request->movie_id)->delete();


        return  new  ApiAllResource($moveItems);
    }


    public function getCart(Request $request)
    {
        $cart = MovieCart::where('user_id', $request->user()->id)
            ->with('items')->orderByDesc('id')->paginate(10);
         return  new  ApiAllResource($cart);
    }


}
