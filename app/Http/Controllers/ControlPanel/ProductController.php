<?php

namespace App\Http\Controllers\ControlPanel;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    // عرض جميع المنتجات
    public function index()
    {
        $products = Product::with('category')->paginate(10); 
        return view('controlpanel.products.index', compact('products'));
    }

    // عرض نموذج إضافة منتج جديد
    public function create()
    {
        $categories = Category::all();
        return view('controlpanel.products.create', compact('categories'));
    }

    // تخزين منتج جديد
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $product = new Product();
        $product->name = $request->name;
        $product->price = $request->price;
        $product->category_id = $request->category_id;
        $product->description = $request->description;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $product->image = $imagePath;
        }

        $product->save();

        return redirect()->route('control_panel_dashboard.products.index')
                         ->with('success', 'Product added successfully!');
    }

    // عرض تفاصيل منتج معين
    public function show(Product $product)
    {
        return view('controlpanel.products.show', compact('product'));
    }

    // عرض نموذج تعديل منتج
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('controlpanel.products.edit', compact('product', 'categories'));
    }

    // تحديث منتج
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $product->name = $request->name;
        $product->price = $request->price;
        $product->category_id = $request->category_id;
        $product->description = $request->description;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $product->image = $imagePath;
        }

        $product->save();

        return redirect()->route('control_panel_dashboard.products.index')
                         ->with('success', 'Product updated successfully!');
    }

    // حذف منتج
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('control_panel_dashboard.products.index')
                         ->with('success', 'Product deleted successfully!');
    }
}
