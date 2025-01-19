<?php

namespace App\Http\Controllers\ControlPanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    // عرض جميع الصلاحيات
    public function index()
    {
       // $permissions = Permission::all();
        $permissions = Permission::paginate(10); 

       // dd($permissions);
        return view('controlpanel.permissions.index', compact('permissions'));
    }

    // عرض نموذج إنشاء صلاحية جديدة
    public function create()
    {
        return view('controlpanel.permissions.create');
    }

    // تخزين صلاحية جديدة
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:permissions|max:255',
        ]);

        // حفظ الصلاحية
        Permission::create(['name' => $request->name]);

        return redirect()->route('control_panel_dashboard.permissions.index')->with('success', 'Permission added successfully');
    }

    // عرض صفحة تعديل صلاحية
    public function edit(Permission $permission)
    {
        return view('controlpanel.permissions.edit', compact('permission'));
    }

    // تحديث صلاحية
    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => 'required|max:255|unique:permissions,name,' . $permission->id,
        ]);

        $permission->update(['name' => $request->name]);

        return redirect()->route('control_panel_dashboard.permissions.index')->with('success', 'Permission updated successfully');
    }

    // حذف صلاحية
    public function destroy(Permission $permission)
    {
       // dd($permission);
        $permission->delete();
        return redirect()->route('control_panel_dashboard.permissions.index')->with('success', 'The permission has been successfully deleted.');
    }
     public function show(Permission $permission)
{
    //dd($permission->name);
    // عرض تفاصيل الصلاحية في الـ View
    return view('controlpanel.permissions.show', compact('permission'));
}

 

}
