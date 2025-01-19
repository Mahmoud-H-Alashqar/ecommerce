<?php

namespace App\Http\Controllers\Website;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Models\ShoppingCart;
use App\Models\CartItem;
use Stripe\PaymentIntent;
use Stripe\Stripe;


class CheckoutController extends Controller
{
    public function index()
    {
    // dd("index");

     if (Auth::check()) {
         $user = Auth::user();
        // dd($user->id);
        $shoppingCart = ShoppingCart::where('user_id', $user->id)
                                    ->where('status', ShoppingCart::STATUS_OPEN)
                                    ->first();
       // dd($shoppingCart);
      //  dd(count($shoppingCart->cartItems));
        //if(count($shoppingCart->cartItems) == 0)
        if($shoppingCart == null)
        {
            return redirect()->route('shop');
        }
        else{ 
        $cartItems = $shoppingCart->cartItems;
        $totalPrice = 0;
        foreach ($cartItems as $item) {
            $totalPrice += $item->product->price * $item->quantity;
        }

        Stripe::setApiKey(env('STRIPE_SECRET'));
        $paymentIntent = PaymentIntent::create([
                'amount' => $totalPrice * 100, // المبلغ بالقرش (1 جنيه = 100 قرش)
             //   'amount' => 500 * 100,
                  'currency' => 'egp', // العملة (EGP)
            ],
        );



      //  return view('website.frontend.chackout',compact('cartItems', 'totalPrice'));   
        return view('website.frontend.chackout', [
            'cartItems' => $cartItems, // تمرير السلة إذا كان المستخدم مسجلاً
  
              'clientSecret' => $paymentIntent->client_secret,
              'totalPrice' => $totalPrice // تمرير المجموع الكلي إلى الـ Blade
          ]);
        }
     }
       
    }
   
 
}
