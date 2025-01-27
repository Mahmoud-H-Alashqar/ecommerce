<?php

namespace App\Http\Controllers\ControlPanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Models\ShoppingCart;

class DashboardController extends Controller
{
    public function index()
    {
        $category = Category::all();
        $category = count($category);
        $product = Product::all();
        $product = count($product);

        $shoppingcart = ShoppingCart::all();
        $shoppingcart = count($shoppingcart);

        $order = Order::all();
        $order = count($order);

      //  dd($category); 
        return view('ControlPanel.dashboard',compact('category','product','shoppingcart','order'));

    }

  
}
