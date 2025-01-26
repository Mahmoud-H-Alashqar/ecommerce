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

//عدد السلة 
if (Auth::check()) {
  // إذا كان المستخدم مسجل دخول، نعرض السلة من قاعدة البيانات
  $user = Auth::user();
  $shoppingCart = ShoppingCart::where('user_id', $user->id)
                              ->where('status', ShoppingCart::STATUS_OPEN)
                              ->first();

  if (empty(session()->get('cart', [])) && $shoppingCart == null ) {
      return redirect()->route('shop');
  }

  if ($shoppingCart) {
      $cartSession = session()->get('cart', []);
      // إذا كانت هناك منتجات في الجلسة، نقوم بإضافتها إلى قاعدة البيانات
      if (!empty($cartSession)) {
          foreach ($cartSession as $item) {
              CartItem::create([
                  'shopping_cart_id' => $shoppingCart->id,
                  'product_id' => $item['id'],
                  'quantity' => $item['quantity'],
                  'unit_price' => $item['price'],
                  'total_price' => $item['price'] * $item['quantity'],
              ]);
          }
          session()->forget('cart');  // مسح السلة من الجلسة بعد نقلها إلى قاعدة البيانات
      }
      $cartItems = $shoppingCart->cartItems()->with('product')->get();
  } else {
      $cartItems = [];
      if (!empty(session()->get('cart', []))) {
          $cartSession = session()->get('cart', []);
          if (!empty($cartSession)) {
              $shoppingCart = ShoppingCart::create([
                  'user_id' => $user->id,
                  'status' => ShoppingCart::STATUS_OPEN,
              ]);
              foreach ($cartSession as $item) {
                  CartItem::create([
                      'shopping_cart_id' => $shoppingCart->id,
                      'product_id' => $item['id'],
                      'quantity' => $item['quantity'],
                      'unit_price' => $item['price'],
                      'total_price' => $item['price'] * $item['quantity'],
                  ]);
              }
              session()->forget('cart');
          }
          $cartItems = $shoppingCart->cartItems()->with('product')->get();
      }
  }

  // حساب العدد الإجمالي مع الكميات
  $countcartItems = 0;
  foreach ($cartItems as $cartItem) {
      $countcartItems += $cartItem->quantity;  // إضافة الكمية لكل منتج
  }
} else {
  // إذا لم يكن المستخدم مسجل دخول، نعرض السلة من الجلسة
  $cartItems = session()->get('cart', []);
  $totalPrice = 0;

  // التكرار عبر السلة لحساب المجموع لكل منتج
  foreach ($cartItems as $product) {
      $totalPrice += $product['price'] * $product['quantity'];
  }

  // حساب العدد الكلي مع الكميات
  $countcartItems = 0;
  foreach ($cartItems as $product) {
      $countcartItems += $product['quantity'];  // إضافة الكمية لكل منتج
  }
}

// في النهاية، $countcartItems يحتوي على العدد الإجمالي لجميع المنتجات في السلة مع الكميات
//dd($countcartItems);

 //عدد السلة


      //  return view('website.frontend.chackout',compact('cartItems', 'totalPrice'));   
        return view('website.frontend.chackout', [
            'cartItems' => $cartItems, // تمرير السلة إذا كان المستخدم مسجلاً
  
              'clientSecret' => $paymentIntent->client_secret,
              'totalPrice' => $totalPrice, // تمرير المجموع الكلي إلى الـ Blade
              'countcartItems' => $countcartItems,
              
          ]);
        }
     }
       
    }
   
 
}
