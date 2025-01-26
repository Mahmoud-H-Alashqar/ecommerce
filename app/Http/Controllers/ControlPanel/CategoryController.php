<?php

namespace App\Http\Controllers\ControlPanel;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function index()
    {
       // $categories = Category::all();
        $categories = Category::paginate(10); 
      //  dd($categories);
        return view('ControlPanel.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('ControlPanel.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Category::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('control_panel_dashboard.categories.index')->with('success', 'تم إضافة التصنيف بنجاح');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('ControlPanel.categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $category = Category::findOrFail($id);
        $category->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('control_panel_dashboard.categories.index')->with('success', 'تم تحديث التصنيف بنجاح');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('control_panel_dashboard.categories.index')->with('success', 'تم حذف التصنيف بنجاح');
    }

    public function show($id)
    {
        $category = Category::findOrFail($id);
        return view('ControlPanel.categories.show', compact('category'));
    }
}
