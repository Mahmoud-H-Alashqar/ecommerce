<?php

namespace App\Http\Controllers\ControlPanel;

use App\Models\Slider;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SliderController extends Controller
{
    // عرض جميع السلايدر
    public function index()
    {
        $sliders = Slider::with('category')->paginate(10); 
        return view('ControlPanel.sliders.index', compact('sliders'));
    }

    // عرض نموذج إضافة سلايدر جديد
    public function create()
    {
        $categories = Category::all();
        return view('ControlPanel.sliders.create', compact('categories'));
    }

    // تخزين سلايدر جديد
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $slider = new Slider();
        $slider->title = $request->title;
        $slider->category_id = $request->category_id;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('sliders', 'public');
            $slider->image = $imagePath;
        }

        $slider->save();

        return redirect()->route('control_panel_dashboard.sliders.index')
                         ->with('success', 'Slider added successfully!');
    }

    // عرض تفاصيل سلايدر معين
    public function show(Slider $slider)
    {
        return view('ControlPanel.sliders.show', compact('slider'));
    }

    // عرض نموذج تعديل سلايدر
    public function edit(Slider $slider)
    {
        $categories = Category::all();
        return view('ControlPanel.sliders.edit', compact('slider', 'categories'));
    }

    // تحديث سلايدر
    public function update(Request $request, Slider $slider)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $slider->title = $request->title;
        $slider->category_id = $request->category_id;
        
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('sliders', 'public');
            $slider->image = $imagePath;
        }

        $slider->save();

        return redirect()->route('control_panel_dashboard.sliders.index')
                         ->with('success', 'Slider updated successfully!');
    }

    // حذف سلايدر
    public function destroy(Slider $slider)
    {
        $slider->delete();
        return redirect()->route('control_panel_dashboard.sliders.index')
                         ->with('success', 'Slider deleted successfully!');
    }
}
