<?php

namespace App\Http\Controllers\Website;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Contact;
use App\Models\Slider;
use App\Models\Contactadmin;



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
        return view('website.frontend.index',compact('sliders','categories','products'));  // عرض القالب من داخل مجلد website
    }
    public function shop()
    {
      $products =  Product::paginate(9);

     //dd("shop");
    // $categories = Category::all();
    // $categories = Category::with('products')->get(); // "with('products')" يقوم بتحميل المنتجات المرتبطة بكل فئة
      $categories = Category::with('products')->paginate(5);
    // dd($categories);
        return view('website.frontend.shop',compact('categories','products'));  // عرض القالب من داخل مجلد website
    }
    public function showproducts($id)
{
 // dd($id);
       // $products =  Product::where('category_id',$id)->get();
        $products =  Product::where('category_id',$id)->paginate(9);

     //   dd($products);
     $categories = Category::with('products')->paginate(5);

     return view('website.frontend.shop',compact('categories','products'));  
  }

  public function showdetail($id)
  {
   
    $product = Product::findOrFail($id);
    $categories = Category::with('products')->paginate(5);
    //dd($product);
    // عرض صفحة تفاصيل المنتج مع البيانات
    return view('website.frontend.shop-detail', compact('product','categories'));

  }

  //contact
  public function contact()
  {
    //dd("contact");
    $contactadmin = Contactadmin::first();
     return view('website.frontend.contact', compact('contactadmin'));
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
