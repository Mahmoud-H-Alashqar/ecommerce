<?php

namespace App\Http\Controllers\ControlPanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ShoppingCart;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
       
        $orders = Order::with('orderItems')->paginate(10); 
     //   dd($orders);
        return view('controlpanel.orders.index', compact('orders'));
    }
    public function show($ordertId)
    {
     //  dd($ordertId);
        // الحصول على السلة المحددة مع تفاصيل المنتجات داخل السلة
        $order = Order::with('orderItems')->findOrFail($ordertId);
      //  dd($orderItems);
        return view('controlpanel.orders.show', compact('order'));
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
        return view('website.frontend.success');

     }
   }
