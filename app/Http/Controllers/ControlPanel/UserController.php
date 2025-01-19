<?php
namespace App\Http\Controllers\ControlPanel;
use App\Http\Controllers\Controller;

  use App\Models\User;
 use Illuminate\Http\Request;
 use Spatie\Permission\Models\Role;
 use Spatie\Permission\Models\Permission;
 
 class UserController extends Controller
 {
     // عرض قائمة المستخدمين
     public function index()
     {
       //  $users = User::all(); // جلب جميع المستخدمين
         $users = User::paginate(10); 

         return view('controlpanel.users.index', compact('users'));
     }
 
     // عرض نموذج إضافة مستخدم
     public function create()
     {
      //  dd("111");
         $roles = Role::all(); // جلب جميع الأدوار
         return view('controlpanel.users.create', compact('roles'));
     }
 
     public function store(Request $request)
{
    //dd($request->all());
    // تحقق من المدخلات
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:8|confirmed',  // التأكد من تطابق كلمة المرور
      //  'role' => 'required|exists:roles,id',  // التأكد من وجود الدور في قاعدة البيانات
    ]);

    try {
        // حفظ المستخدم الجديد في قاعدة البيانات
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),  // تشفير كلمة المرور
         ]);
         $user->syncRoles($request->role);

        // إعادة التوجيه مع رسالة نجاح
        return redirect()->route('control_panel_dashboard.users.index')->with('success', 'User created successfully.');
    } catch (\Exception $e) {
        // في حال حدوث خطأ، اعرض رسالة الخطأ
        return back()->withError('An error occurred while saving the user.');
    }
}

 
     // عرض نموذج تعديل المستخدم
     public function edit(User $user)
     {
         $roles = Role::all(); // جلب جميع الأدوار
         return view('controlpanel.users.edit', compact('user', 'roles'));
     }
 
     // تحديث بيانات المستخدم
    //  public function update(Request $request, User $user)
    //  {
    //     dd($user);
    //      $request->validate([
    //          'name' => 'required|string|max:255',
    //          'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
    //          'roles' => 'required|array', // تحديد أنه يجب أن يكون هناك أدوار
    //      ]);
 
    //      $user->update([
    //          'name' => $request->name,
    //          'email' => $request->email,
    //      ]);
 
    //      // إضافة الأدوار للمستخدم
    //      $user->syncRoles($request->roles);
 
    //      return redirect()->route('control_panel_dashboard.users.index')->with('success', 'User updated successfully.');
    //  }
    public function update(Request $request, User $user)
{
    // تحقق من المدخلات
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id, // التأكد من عدم تكرار البريد الإلكتروني باستثناء المستخدم الحالي
        'password' => 'nullable|string|min:8|confirmed',  // كلمة المرور اختيارية أثناء التحديث
    ]);

    try {
        // تحديث بيانات المستخدم
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            // إذا تم إدخال كلمة مرور جديدة، قم بتحديثها
            'password' => $request->password ? bcrypt($validated['password']) : $user->password,
        ]);

        // تحديث الأدوار للمستخدم
        $user->syncRoles($request->role);

        // إعادة التوجيه مع رسالة نجاح
        return redirect()->route('control_panel_dashboard.users.index')->with('success', 'User updated successfully.');
    } catch (\Exception $e) {
        // في حال حدوث خطأ، اعرض رسالة الخطأ
        return back()->withError('An error occurred while updating the user.');
    }
}

 
     // عرض تفاصيل المستخدم
     public function show(User $user)
     {
         return view('controlpanel.users.show', compact('user'));
     }
 
     // حذف المستخدم
     public function destroy(User $user)
     {
         $user->delete();
 
         return redirect()->route('control_panel_dashboard.users.index')->with('success', 'User deleted successfully.');
     }
 }
 