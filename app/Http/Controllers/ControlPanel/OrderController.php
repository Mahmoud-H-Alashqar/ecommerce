<?php

namespace App\Http\Controllers\ControlPanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ShoppingCart;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
       
        $orders = Order::with('orderItems')->paginate(10); 
     //   dd($orders);
        return view('ControlPanel.orders.index', compact('orders'));
    }
    public function show($ordertId)
    {
     //  dd($ordertId);
        // الحصول على السلة المحددة مع تفاصيل المنتجات داخل السلة
        $order = Order::with('orderItems')->findOrFail($ordertId);
      //  dd($orderItems);
        return view('ControlPanel.orders.show', compact('order'));
    }
    
 

    public function store(Request $request)
    {
     //  dd($request->all());
        // return response()->json(['message' => 'تم إنشاء الطلب بنجاح']);

        // exit();
        DB::transaction(function () use ($request) {

        $order = Order::create([
 
            'user_id' => $request->userId,
            'status' => $request->status,
            'total' => $request->totalAmount ,
            'payment_method' => $request->paymentMethod ,
            'shipping_address' => $request->shippingAddress  ,
            'phone' => $request->phone ,
            // 'payment_intent_id' => $request->paymentIntentId  , // التأكد من إضافة payment_intent_id
        ]);
//dd($request->cartItems);
$cartItem = $request->cartItems[0];   
$shoppingCartId = $cartItem['shopping_cart_id'];
//dd($shoppingCartId);

 
        foreach ($request->cartItems as $cartItem) {
            $product = Product::find($cartItem['product_id']);
            // حفظ كل عنصر في جدول order_items
            OrderItem::create([
                'order_id' => $order->id,  // معرف الطلب
                'product_id' => $cartItem['product_id'],  // معرف المنتج
                'quantity' => $cartItem['quantity'],  // الكمية
              //  'user_id' => 2,//$cartItem['user_id'],
                 'product_name' =>  $product->name  ,
                'price' =>  $product->price ,

             ]);
        }
      //  dd($cartItem['shopping_cart_id']);
      //  $cart = ShoppingCart::find($cartItem['shopping_cart_id']);
        $cart = ShoppingCart::find($shoppingCartId);

        
       // $cart = ShoppingCart::where('id', $cartItem['shopping_cart_id'])->first();

        //$cart = ShoppingCart::where('user_id', $request->userId)->first();  // العثور على سلة المستخدم
        if ($cart) {
            $cart->update(['status' => '2']);  // تحديث حالة السلة إلى "مدفوعة"
        }



        }, 5); 
        return response()->json(['message' => 'تم إنشاء الطلب بنجاح']);


     }

     public function success()
     {
       // dd("hi");  
               //عدد السلة 
if (Auth::check()) {
  // إذا كان المستخدم مسجل دخول، نعرض السلة من قاعدة البيانات
  $user = Auth::user();
  $shoppingCart = ShoppingCart::where('user_id', $user->id)
                              ->where('status', ShoppingCart::STATUS_OPEN)
                              ->first();

  // if (empty(session()->get('cart', [])) && $shoppingCart == null ) {
  //     return redirect()->route('shop');
  // }

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

        return view('website.frontend.success',compact('countcartItems'));

     }
   }
