<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ControlPanel\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ControlPanel\PermissionController;
use App\Http\Controllers\ControlPanel\RoleController;
use App\Http\Controllers\ControlPanel\UserController;
use App\Http\Controllers\ControlPanel\CategoryController;
use App\Http\Controllers\ControlPanel\ContactadminController;
use App\Http\Controllers\ControlPanel\ProductController;
use App\Http\Controllers\ControlPanel\ContactController;
use App\Http\Controllers\Website\FrontendController;
use App\Http\Controllers\Website\CartController;
use App\Http\Controllers\Website\CheckoutController;
use App\Http\Controllers\ControlPanel\ShoppingCartController;
use App\Http\Controllers\ControlPanel\OrderController;
use App\Http\Controllers\ControlPanel\SliderController;




//payment_test
use Illuminate\Http\Request;
 
Route::get('/checkout', function (Request $request) {
    $stripePriceId = 'price_1Qg5DWFFTzW5Q9tji2GF1EXM';
 
    $quantity = 1;
  //dd($request->user());
    return $request->user()->checkout([$stripePriceId => $quantity], [
        'success_url' => route('checkout-success'),
        'cancel_url' => route('checkout-cancel'),
    ]);
})->name('checkout');
 
Route::view('/checkout/success', 'checkout.success')->name('checkout-success');
Route::view('/checkout/cancel', 'checkout.cancel')->name('checkout-cancel');







// Route::prefix('control_panel_dashboard')->name('control_panel_dashboard.')->middleware('auth')->group(function () {
//     Route::get('user/create', [UserController::class, 'create'])->name('user.create');
// });

// Route::get('/website', [FrontendController::class, 'index'])->name('website');
Route::get('/', [FrontendController::class, 'index'])->name('website');

Route::get('/shop', [FrontendController::class, 'shop'])->name('shop');
//contact
Route::get('/contact', [FrontendController::class, 'contact'])->name('contact');
Route::post('/contactstore', [FrontendController::class, 'contactstore'])->name('contactstore');

// مسار لعرض المنتجات بناءً على التصنيف
Route::get('/showproducts/{id}', [FrontendController::class, 'showproducts'])->name('showproducts');
Route::get('/cart/add/{product}', [CartController::class, 'addToCart'])->name('cart.add');
Route::get('/cart', [CartController::class, 'showCart'])->name('cart.index');
Route::post('/cart/update', [CartController::class, 'updateCart'])->name('cart.update');
 Route::post('/cart/update/session', [CartController::class, 'updateSession'])->name('cart.update.session');
 Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
 Route::post('/cart/remove/session', [CartController::class, 'removeSession'])->name('cart.remove.session');
 Route::get('/productdetails/{id}', [FrontendController::class, 'showdetail'])->name('product.details');


Route::prefix('control_panel_dashboard')->name('control_panel_dashboard.')->middleware('auth')->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders');
    Route::get('/success', [OrderController::class, 'success'])->name('success');

    
    Route::get('users/create', [UserController::class, 'create'])->name('users.create');

    Route::get('permissions', [PermissionController::class, 'index'])->name('permissions.index');
    Route::get('permissions/create', [PermissionController::class, 'create'])->name('permissions.create');
   // Route::get('permissions/show', [PermissionController::class, 'show'])->name('permissions.show');

    Route::post('permissions', [PermissionController::class, 'store'])->name('permissions.store');
    Route::get('permissions/{permission}/edit', [PermissionController::class, 'edit'])->name('permissions.edit');
    Route::get('permissions/{permission}/show', [PermissionController::class, 'show'])->name('permissions.show');

    Route::put('permissions/{permission}', [PermissionController::class, 'update'])->name('permissions.update');
    Route::delete('permissions/{permission}', [PermissionController::class, 'destroy'])->name('permissions.destroy');
    // مسارات الأدوار
    Route::get('roles', [RoleController::class, 'index'])->name('roles.index');
    Route::get('roles/create', [RoleController::class, 'create'])->name('roles.create');
    Route::post('roles', [RoleController::class, 'store'])->name('roles.store');
    Route::get('roles/{role}/edit', [RoleController::class, 'edit'])->name('roles.edit');
    Route::get('roles/{role}/show', [RoleController::class, 'show'])->name('roles.show');
    Route::put('roles/{role}', [RoleController::class, 'update'])->name('roles.update');
    Route::delete('roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');
             // مسار عرض تفاصيل المستخدم
    Route::get('user/{user}', [UserController::class, 'show'])->name('user.show');
        // مسار عرض قائمة المستخدمين
    Route::get('users', [UserController::class, 'index'])->name('users.index');
        // مسار إضافة مستخدم جديد
    // Route::get('user/create', [UserController::class, 'create'])->name('user.create');
    Route::post('users', [UserController::class, 'store'])->name('users.store');

    // مسار تعديل مستخدم
    Route::get('users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('users/{user}', [UserController::class, 'update'])->name('users.update');

    // مسار حذف مستخدم
    Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::get('users/{user}/show', [UserController::class, 'show'])->name('users.show');
        // مسارات التصنيفات
        Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
        Route::get('categories/create', [CategoryController::class, 'create'])->name('categories.create');
        Route::post('categories', [CategoryController::class, 'store'])->name('categories.store');
        Route::get('categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
        Route::put('categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
        Route::get('categories/{category}/show', [CategoryController::class, 'show'])->name('categories.show');
    //contactadmin
    Route::get('contactadmins', [ContactadminController::class, 'index'])->name('contactadmins.index');
    Route::get('contactadmins/create', [ContactadminController::class, 'create'])->name('contactadmins.create');
    Route::post('contactadmins', [ContactadminController::class, 'store'])->name('contactadmins.store');
    Route::get('contactadmins/{category}/edit', [ContactadminController::class, 'edit'])->name('contactadmins.edit');
    Route::put('contactadmins/{category}', [ContactadminController::class, 'update'])->name('contactadmins.update');
    Route::delete('contactadmins/{category}', [ContactadminController::class, 'destroy'])->name('contactadmins.destroy');
    Route::get('contactadmins/{category}/show', [ContactadminController::class, 'show'])->name('contactadmins.show');


                // مسار عرض جميع المنتجات
         Route::get('contactadmin', [ContactController::class, 'index'])->name('contactadmin.index');
         Route::get('contacts/{contact}', [ContactController::class, 'show'])->name('contacts.show');
         Route::delete('contacts/{contact}', [ContactController::class, 'destroy'])->name('contacts.destroy');

        // مسار عرض جميع المنتجات
        Route::get('products', [ProductController::class, 'index'])->name('products.index');

        // مسار عرض صفحة إضافة منتج جديد
        Route::get('products/create', [ProductController::class, 'create'])->name('products.create');

        // مسار تخزين منتج جديد
        Route::post('products', [ProductController::class, 'store'])->name('products.store');

        // مسار عرض تفاصيل منتج معين
        Route::get('products/{product}', [ProductController::class, 'show'])->name('products.show');

        // مسار عرض صفحة تعديل منتج
        Route::get('products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');

        // مسار تحديث منتج
        Route::put('products/{product}', [ProductController::class, 'update'])->name('products.update');

        // مسار حذف منتج
        Route::delete('products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
        //slider
        Route::get('sliders', [SliderController::class, 'index'])->name('sliders.index');
        Route::get('sliders/create', [SliderController::class, 'create'])->name('sliders.create');
        Route::post('sliders', [SliderController::class, 'store'])->name('sliders.store');
        Route::get('sliders/{slider}', [SliderController::class, 'show'])->name('sliders.show');
        Route::get('sliders/{slider}/edit', [SliderController::class, 'edit'])->name('sliders.edit');
        Route::put('sliders/{slider}', [SliderController::class, 'update'])->name('sliders.update');
        Route::delete('sliders/{slider}', [SliderController::class, 'destroy'])->name('sliders.destroy');
        
//السلة
Route::get('shoppingcarts', [ShoppingCartController::class, 'index'])->name('shoppingcarts.index');
Route::get('shoppingcarts/{shoppingcart}', [ShoppingCartController::class, 'show'])->name('shoppingcarts.show');
Route::post('/cartitems/{itemId}/update-quantity', [ShoppingCartController::class, 'updateQuantity'])->name('shoppingcarts.updateQuantity');
//الطلبات بالادمن
Route::get('ordersadmin', [OrderController::class, 'index'])->name('ordersadmin.index');
Route::get('ordersadmin/{ordersadmin}', [OrderController::class, 'show'])->name('orders.show');

// حذف المنتج من السلة
Route::delete('/cartitems/{itemId}/remove', [ShoppingCartController::class, 'removeItem'])->name('shoppingcarts.removeItem');
//تحديث سلة بالادمن
Route::post('/update-quantity', [ShoppingCartController::class, 'updateQuantity'])->name('update-quantity');
Route::delete('/delete-item/{id}', [ShoppingCartController::class, 'destroy'])->name('delete-item');

 
});


// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/control_panel_dashboard', [DashboardController::class, 'index'])->name('control_panel_dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
