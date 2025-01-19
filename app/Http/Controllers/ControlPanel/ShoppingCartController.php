<?php

namespace App\Http\Controllers\ControlPanel;

use App\Models\ShoppingCart;
use App\Models\CartItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShoppingCartController extends Controller
{
     public function index()
    {
        //dd("112");
        $shoppingcarts = ShoppingCart::with('cartItems')->paginate(10); 
        return view('controlpanel.shoppingcarts.index', compact('shoppingcarts'));
    }
    public function show($cartId)
    {
       // dd($cartId);
        // الحصول على السلة المحددة مع تفاصيل المنتجات داخل السلة
        $cart = ShoppingCart::with('cartItems.product')->findOrFail($cartId);
        return view('controlpanel.shoppingcarts.show', compact('cart'));
    }
    public function updateQuantity(Request $request)
    {
        // تحديث الكمية في CartItem
        $cartItem = CartItem::findOrFail($request->item_id);
//dd($cartItem);
        // تحديث الكمية فقط إذا كانت أكبر من أو تساوي 1
        $cartItem->quantity = max(1, $request->quantity); 
        $cartItem->total_price = $cartItem->quantity * $cartItem->unit_price;
        $cartItem->save();

        // إعادة التوجيه مع رسالة نجاح
        return redirect()->back()->with('success', 'Quantity updated successfully!');
    }

    public function removeItem($itemId)
    {
        // العثور على المنتج في سلة التسوق وحذفه
        $cartItem = CartItem::findOrFail($itemId);
        $cartItem->delete();

        // إعادة التوجيه مع رسالة نجاح
        return redirect()->back()->with('success', 'Product removed from cart.');
    }

    public function destroy($itemId)
    {
        // البحث عن العنصر باستخدام المعرف
        $item = CartItem::find($itemId);

        // إذا تم العثور على العنصر، نحذفه
        if ($item) {
            $item->delete();
            return response()->json(['status' => 'success', 'message' => 'Item deleted successfully']);
        }

        // إذا لم يتم العثور على العنصر
        return response()->json(['status' => 'error', 'message' => 'Item not found'], 404);
    }

  }
