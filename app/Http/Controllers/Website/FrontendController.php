<?php

namespace App\Http\Controllers\Website;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Contact;
use App\Models\Slider;
use App\Models\Contactadmin;
use Illuminate\Support\Facades\Auth;
use App\Models\ShoppingCart;
use App\Models\CartItem;



class FrontendController extends Controller
{
    public function index()
    {
    //   dd("index");
       $sliders =  Slider::all();
     //  $categories =  Category::all();
          $categories = Category::with('products')->get();
    //    $categories = Category::with(['products' => function($query) {
    //     $query->paginate(8);  // عرض 8 منتجات لكل فئة فقط
    // }])->get();

      // $products = Product::all(); 
       $products = Product::paginate(8); 
    // dd($categories);
     //  dd($sliders);
//عدد السلة 
if (Auth::check()) {
  // إذا كان المستخدم مسجل دخول، نعرض السلة من قاعدة البيانات
  $user = Auth::user();
  $shoppingCart = ShoppingCart::where('user_id', $user->id)
                              ->where('status', ShoppingCart::STATUS_OPEN)
                              ->first();

//   if (empty(session()->get('cart', [])) && $shoppingCart == null ) {
//       return redirect()->route('shop');
//   }

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


        return view('website.frontend.index',compact('sliders','categories','products','countcartItems'));  // عرض القالب من داخل مجلد website
    }
    public function shop()
    {
      $products =  Product::paginate(6);

     //dd("shop");
    // $categories = Category::all();
     $categories = Category::with('products')->get(); // "with('products')" يقوم بتحميل المنتجات المرتبطة بكل فئة
    //  $categories = Category::with('products')->paginate(5);
    // dd($categories);

//عدد السلة 
if (Auth::check()) {
  // إذا كان المستخدم مسجل دخول، نعرض السلة من قاعدة البيانات
  $user = Auth::user();
  $shoppingCart = ShoppingCart::where('user_id', $user->id)
                              ->where('status', ShoppingCart::STATUS_OPEN)
                              ->first();

//   if (empty(session()->get('cart', [])) && $shoppingCart == null ) {
//       return redirect()->route('shop');
//   }

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


        return view('website.frontend.shop',compact('categories','products','countcartItems'));  // عرض القالب من داخل مجلد website
    }
    public function showproducts($id)
{
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

 // dd($id);
       // $products =  Product::where('category_id',$id)->get();
        $products =  Product::where('category_id',$id)->paginate(6);

     //   dd($products);
     $categories = Category::with('products')->paginate(5);

     return view('website.frontend.shop',compact('categories','products','countcartItems'));  
  }

  public function showdetail($id)
  {
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

   
    $product = Product::findOrFail($id);
    $categories = Category::with('products')->paginate(5);
    //dd($product);
    // عرض صفحة تفاصيل المنتج مع البيانات
    return view('website.frontend.shop-detail', compact('product','categories','countcartItems'));

  }

  //contact
  public function contact()
  {
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

    
    //dd("contact");
    $contactadmin = Contactadmin::first();
     return view('website.frontend.contact', compact('contactadmin','countcartItems'));
   }

  public function contactstore(Request $request)
  {
   // dd($request->all());
      // التحقق من البيانات المدخلة (اختياري)
      $request->validate([
          'name' => 'required|string|max:255',
          // 'email' => 'required|email|max:255',
          // 'message' => 'required|string',
      ]);

      $contact = new Contact;
      $contact->name = $request->name;   
      $contact->email = $request->email;   
      $contact->message = $request->message;   
      $contact->save();   

       return back()->with('success', 'Your message has been sent successfully!');
  }


}
