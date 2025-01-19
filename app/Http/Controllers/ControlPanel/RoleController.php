<?php

namespace App\Http\Controllers\ControlPanel;
use App\Http\Controllers\Controller;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;  
use Illuminate\Http\Request;

class RoleController extends Controller
{
    // عرض جميع الأدوار
    public function index()
    {
       // $roles = Role::all();
        $roles = Role::paginate(10); 

      //  dd($roles);
        return view('controlpanel.roles.index', compact('roles'));
    }

    // عرض نموذج إنشاء دور جديد
    public function create()
    {
        $permissions = Permission::all();
        return view('controlpanel.roles.create',compact('permissions'));
    }

    // تخزين دور جديد في قاعدة البيانات
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles|max:255',
            'permissions' => 'array',
        ]);

        $role = Role::create([
            'name' => $request->name,
        ]);

        // إضافة الصلاحيات إلى الدور (إذا كان هناك صلاحيات مختارة)
        if ($request->has('permissions')) {
            $role->givePermissionTo($request->permissions);
        }

        return redirect()->route('control_panel_dashboard.roles.index')
                         ->with('success', 'Role created successfully.');
    }

    // عرض نموذج تعديل دور معين
    public function edit(Role $role)
    {
        $permissions = Permission::all();

        return view('controlpanel.roles.edit', compact('role', 'permissions'));
    }

    // تحديث الدور في قاعدة البيانات
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|max:255|unique:roles,name,' . $role->id,
            'permissions' => 'array',
        ]);

        $role->update([
            'name' => $request->name,
        ]);

        // إضافة الصلاحيات الجديدة إلى الدور (إذا كان هناك صلاحيات مختارة)
        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions);
        }

        return redirect()->route('control_panel_dashboard.roles.index')
                         ->with('success', 'Role updated successfully.');
    }

    // عرض تفاصيل الدور
    public function show(Role $role)
    {
        $role->load('permissions'); 
        return view('controlpanel.roles.show', compact('role'));
    }

    // حذف الدور
    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('control_panel_dashboard.roles.index')
                         ->with('success', 'Role deleted successfully.');
    }
}
 