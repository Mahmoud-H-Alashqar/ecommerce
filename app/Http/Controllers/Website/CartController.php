<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\ShoppingCart;
use App\Models\CartItem;

use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function addToCart(Product $product)
    {
     if (Auth::check()) {
      // إذا كان المستخدم مسجل دخول، نقوم بإضافة العنصر إلى قاعدة البيانات
       // الحصول على المستخدم المسجل
      $user = Auth::user();
        // dd($user);
       // التحقق إذا كان للمستخدم سلة مفتوحة موجودة
      $shoppingCart = ShoppingCart::where('user_id', $user->id)
                                  ->where('status', ShoppingCart::STATUS_OPEN)
                                  ->first();
            ///dd($user->id);
          //  dd($shoppingCart);
       // إذا لم توجد سلة مفتوحة، نقوم بإنشاء واحدة جديدة
      if (!$shoppingCart) {
      
          $shoppingCart = ShoppingCart::create([
              'user_id' => $user->id,
              'status' => ShoppingCart::STATUS_OPEN,
          ]);
      }
       // إضافة المنتج إلى جدول cart_items
      $cartItem = CartItem::create([
          'shopping_cart_id' => $shoppingCart->id,
          'product_id' => $product->id,
          'quantity' => 1, // يمكنك تعديل الكمية حسب الحاجة
          'unit_price' => $product->price,
          'total_price' => $product->price * 1, // الكمية × السعر
      ]);
      //dd($shoppingCart->id);
      // التحقق إذا كان هناك منتجات في الجلسة
      $cartSession = session()->get('cart', []);
 //   dd($cartSession);
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
           // مسح السلة من الجلسة بعد نقلها إلى قاعدة البيانات
          session()->forget('cart');
      }
       return redirect()->route('cart.index')->with('success', 'تم إضافة المنتج إلى السلة!');
  } else {
      // إذا لم يكن المستخدم مسجل دخول، نقوم بتخزين المنتج في الجلسة
      $cart = session()->get('cart', []);
       // إضافة العنصر إلى السلة
      $cart[$product->id] = [
         'id' => $product->id,
          'name' => $product->name,
          'price' => $product->price,
          'image' => $product->image,
          'quantity' => 1, // يمكنك تعديل الكمية حسب الحاجة
      ];
       // تخزين السلة في الجلسة
      session()->put('cart', $cart);
   //   dd($cart);
       return redirect()->route('cart.index')->with('success', 'تم إضافة المنتج إلى السلة!');
  }
 
     }
//      public function showCart()
//      {
//          if (Auth::check()) {
//              // إذا كان المستخدم مسجل دخول، نعرض السلة من قاعدة البيانات
//              $user = Auth::user();
//               // dd($user);
//              $shoppingCart = ShoppingCart::where('user_id', $user->id)
//                                          ->where('status', ShoppingCart::STATUS_OPEN)
//                                          ->first();
//               // dd($shoppingCart);
//               // dd(session()->get('cart', []));
//               // dd(count($shoppingCart->cartItems));
//               // if (empty(session()->get('cart', [])))  
//               // if (empty(session()->get('cart', [])) && count($shoppingCart->cartItems) == 0) 
//                if (empty(session()->get('cart', [])) && $shoppingCart == null )  
 
//                  {
//                 //  dd("12");
//                 return redirect()->route('shop');
//                 }
               
//               // إذا كانت السلة موجودة
//              if ($shoppingCart) {
//                 //  $cartItems = $shoppingCart->cartItems()->with('product')->get();
//                  //حتى يدمج مع الي بسلة
//             //  $shoppingCart = ShoppingCart::where('user_id', $user->id)
//             // ->where('status', ShoppingCart::STATUS_OPEN)
//             // ->first();
//              $cartSession = session()->get('cart', []);
//            // dd($cartSession);
//                  // إذا كانت هناك منتجات في الجلسة، نقوم بإضافتها إلى قاعدة البيانات
//                  if (!empty($cartSession)) {
//                    // dd("12");
//                     // $shoppingCart = ShoppingCart::create([
//                     //     'user_id' => $user->id,
//                     //     'status' => ShoppingCart::STATUS_OPEN,
//                     // ]);
//                      foreach ($cartSession as $item) {
//                          CartItem::create([
//                              'shopping_cart_id' => $shoppingCart->id,
//                              'product_id' => $item['id'],
//                              'quantity' => $item['quantity'],
//                              'unit_price' => $item['price'],
//                              'total_price' => $item['price'] * $item['quantity'],
//                          ]);
//                      }
//                       // مسح السلة من الجلسة بعد نقلها إلى قاعدة البيانات
//                      session()->forget('cart');
//                  }
//                  $cartItems = $shoppingCart->cartItems()->with('product')->get();
//                //  dd($cartItems);
//              } else {
//                  $cartItems = [];
//                 // dd($cartItems);
//                 // $cartItems = array_merge($cartItems->toArray(), session()->get('cart', []));
//                  //حتى يدمج مع الي بسلة
//                  if (!empty(session()->get('cart', []))) {
//                  // $cartItems = array_merge($cartItems, session()->get('cart', []));
//                   //dd($cartItems);
//                   $cartSession = session()->get('cart', []);
//                   if (!empty($cartSession)) {
//                     // dd("12");
//                      $shoppingCart = ShoppingCart::create([
//                          'user_id' => $user->id,
//                          'status' => ShoppingCart::STATUS_OPEN,
//                      ]);
//                       foreach ($cartSession as $item) {
//                           CartItem::create([
//                               'shopping_cart_id' => $shoppingCart->id,
//                               'product_id' => $item['id'],
//                               'quantity' => $item['quantity'],
//                               'unit_price' => $item['price'],
//                               'total_price' => $item['price'] * $item['quantity'],
//                           ]);
//                       }
//                        // مسح السلة من الجلسة بعد نقلها إلى قاعدة البيانات
//                       session()->forget('cart');
//                   }
//                   $cartItems = $shoppingCart->cartItems()->with('product')->get();
//                  }
//              }

// //حل البيق
// if($shoppingCart){


//              $cartItems =   $cartitem = CartItem::where('shopping_cart_id',$shoppingCart->id)->get();
//              $totalPrice = 0;
// foreach ($cartItems as $cartItem) {
// $totalPrice += $cartItem->quantity * $cartItem->unit_price;
// }
// }else{
//     return redirect()->route('shop');
// }
// //حل البيق

//          } else {
//              // إذا لم يكن المستخدم مسجل دخول، نعرض السلة من الجلسة
//              $cartItems = session()->get('cart', []);
//              $totalPrice = 0;

// // التكرار عبر السلة لحساب المجموع لكل منتج
// foreach ($cartItems as $product) {
//     // حساب المجموع لهذا المنتج (السعر × الكمية)
//     $totalPrice += $product['price'] * $product['quantity'];
// }


//          }
//               // إذا كانت السلة من الجلسة غير فارغة، ندمجها مع السلة من قاعدة البيانات
//     // if (!empty($cartItems) && session()->has('cart')) {
//     //     // دمج السلة من الجلسة مع السلة من قاعدة البيانات
//     //     $cartItems = array_merge($cartItems->toArray(), session()->get('cart', []));
//     // }
//      // dd($cartItems);
// 	  // dd(count($cartItems));
//       $countcartItems = count($cartItems) ; 

//          // عرض السلة في الفيو
//          return view('website.frontend.cart', compact('cartItems','totalPrice','countcartItems'));
//      }
//مع حساب لكميات 
public function showCart()
{
    if (Auth::check()) {
        // إذا كان المستخدم مسجل دخول، نعرض السلة من قاعدة البيانات
        $user = Auth::user();
        $shoppingCart = ShoppingCart::where('user_id', $user->id)
                                    ->where('status', ShoppingCart::STATUS_OPEN)
                                    ->first();

        // إذا كانت السلة فارغة أو لا توجد سلة للمستخدم، نقوم بإعادة التوجيه إلى صفحة المتجر
        if (empty(session()->get('cart', [])) && $shoppingCart == null ) {
            return redirect()->route('shop');
        }

        // إذا كانت السلة موجودة في قاعدة البيانات
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
                // مسح السلة من الجلسة بعد نقلها إلى قاعدة البيانات
                session()->forget('cart');
            }

            // استرجاع العناصر من السلة في قاعدة البيانات
            $cartItems = $shoppingCart->cartItems()->with('product')->get();
        } else {
            $cartItems = [];
            // إذا كانت السلة فارغة في قاعدة البيانات، ندمج السلة من الجلسة مع قاعدة البيانات
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
                // استرجاع العناصر من السلة في قاعدة البيانات
                $cartItems = $shoppingCart->cartItems()->with('product')->get();
            }
        }

        // حساب المجموع الكلي للأسعار وحساب العدد الإجمالي مع الكميات
        $totalPrice = 0;
        $countcartItems = 0; // العدد الكلي للمنتجات مع الكميات

        foreach ($cartItems as $cartItem) {
            $totalPrice += $cartItem->quantity * $cartItem->unit_price;
            $countcartItems += $cartItem->quantity;  // إضافة الكمية لكل منتج
        }

    } else {
        // إذا لم يكن المستخدم مسجل دخول، نعرض السلة من الجلسة
        $cartItems = session()->get('cart', []);
        $totalPrice = 0;
        $countcartItems = 0;

        // التكرار عبر السلة لحساب المجموع لكل منتج
        foreach ($cartItems as $product) {
            $totalPrice += $product['price'] * $product['quantity'];
            $countcartItems += $product['quantity'];  // إضافة الكمية لكل منتج
        }
    }

    // عرض السلة في الفيو
    return view('website.frontend.cart', compact('cartItems', 'totalPrice', 'countcartItems'));
}

      public function updateCart(Request $request)
     {
         // التحقق من البيانات
         $validated = $request->validate([
             'product_id' => 'required|integer',
             'quantity' => 'required|integer|min:1',
         ]);
 
         // الحصول على الـ product_id و quantity
         $productId = $validated['product_id'];
         $quantity = $validated['quantity'];
 
         // إذا كان المستخدم مسجلاً دخولًا
         if (Auth::check()) {
             $userId = Auth::id();
             $shoppingCart = ShoppingCart::where('user_id', $userId)
                                         ->where('status', ShoppingCart::STATUS_OPEN)
                                         ->first();
 
             if ($shoppingCart) {
                 // تحديث الكمية في سلة التسوق
                 $shoppingCart->updateCartItemQuantity($productId, $quantity);
                 $cartitem = CartItem::where('shopping_cart_id',$shoppingCart->id)
                 ->where('product_id',$productId)
                 ->first();
                 $total_price = $cartitem->total_price;
 
                 $cartItems =   $cartitem = CartItem::where('shopping_cart_id',$shoppingCart->id)->get();
                 $allTotal = 0;
                 $totalItems = 0; // لحساب عدد العناصر الإجمالي في السلة
foreach ($cartItems as $cartItem) {
        // حساب عدد العناصر بناءً على الكمية
        $totalItems += $cartItem->quantity; 

    $allTotal += $cartItem->quantity * $cartItem->unit_price;
}


                //  return response()->json(['success' => true, 'message' => 'Quantity updated successfully']);
                 return response()->json([
                    'success' => true,
                    'message' => 'Quantity updated successfully',
                    'totalPrice' => $total_price,  // قيمة الـ TotalPrice الخاصة بالمنتج
                    'all_total' => $allTotal, 
                    'totalItems' => $totalItems, 
                    // 'subtotal' => $subtotal,                // الـ Subtotal لجميع العناصر
                    // 'total' => $total                       // الـ Total النهائي مع الشحن
                ]);
            
             } else {
                 return response()->json(['success' => false, 'message' => 'Shopping cart not found']);
             }
         } else {
             return response()->json(['success' => false, 'message' => 'User not authenticated']);
         }
     }


    // دالة لتحديث الكمية في السلة إذا كان المستخدم غير مسجل دخول
    public function updateSession(Request $request)
    {
        // الحصول على السلة الحالية من الجلسة، وإذا كانت غير موجودة يتم إنشاء مصفوفة فارغة
        $cart = session()->get('cart', []);
      //  dd($cart);

        // تحقق إذا كان المنتج موجودًا في السلة
        if (isset($cart[$request->product_id])) {
          //  dd($request->product_id);
            // تحديث الكمية
            $cart[$request->product_id]['quantity'] = $request->quantity;
        } else {
            // إذا لم يكن المنتج موجودًا، نقوم بإضافته
            $cart[$request->product_id] = [
                'id' => $request->product_id,
                'name' => $request->product_name,
                'price' => $request->product_price,
                'image' => $request->product_image,
                'quantity' => $request->quantity
            ];
        }
// متغير لتخزين الإجمالي
$totalPrice = 0;
$totalQuantity = 0;  // لتخزين عدد العناصر

// التكرار عبر السلة لحساب المجموع لكل منتج
foreach ($cart as $product) {
    // حساب المجموع لهذا المنتج (السعر × الكمية)
    $totalPrice += $product['price'] * $product['quantity'];
        // حساب إجمالي عدد العناصر
        $totalQuantity += $product['quantity'];

}

        // تخزين السلة المحدثة في الجلسة
        session()->put('cart', $cart);

        //return response()->json(['message' => 'Cart updated successfully.']);
        return response()->json([
            'total_price' => $totalPrice,
            'totalQuantity' => $totalQuantity,
            'cart' => $cart,
            'message' => 'Cart updated successfully.'
        ]);
    
    }

 //delete product from cart
public function remove(Request $request)
{
    if (Auth::check()) {
      //  dd(Auth::user()->id);
       $shoppingcart = ShoppingCart::where('user_id',Auth::user()->id)
       ->where('status', ShoppingCart::STATUS_OPEN)
       ->first();
     //  dd($shoppingcart->id);
        // إذا كان المستخدم مسجلاً دخولًا، نحذف المنتج من قاعدة البيانات
        $cartItem = CartItem::where('shopping_cart_id', $shoppingcart->id) // افترض أنك تحتفظ بمعرف السلة في الجلسة
                           ->where('product_id', $request->product_id)
                           ->first();
        
        if ($cartItem) {
            $cartItem->delete();
        }

        return response()->json(['message' => 'Product removed from cart successfully.']);
    } 
    // else {
    //     // إذا لم يكن المستخدم مسجلاً دخولًا، نقوم بحذف المنتج من الجلسة
    //     $cart = session()->get('cart', []);

    //     // تحقق إذا كان المنتج موجودًا في السلة
    //     if (isset($cart[$request->product_id])) {
    //         // حذف المنتج من السلة
    //         unset($cart[$request->product_id]);

    //         // تخزين السلة المحدثة في الجلسة
    //         session()->put('cart', $cart);
    //     }

    //     return response()->json(['message' => 'Product removed from cart successfully.']);
    // }
}
public function removeSession(Request $request)
{
    $cart = session()->get('cart', []);

    // تحقق إذا كان المنتج موجودًا في السلة
    if (isset($cart[$request->product_id])) {
        // حذف المنتج من السلة
        unset($cart[$request->product_id]);

        // تخزين السلة المحدثة في الجلسة
        session()->put('cart', $cart);
    }

    return response()->json(['message' => 'Product removed from cart successfully.']);

}
 
}
