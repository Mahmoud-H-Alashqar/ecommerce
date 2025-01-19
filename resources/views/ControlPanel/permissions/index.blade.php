@extends('ControlPanel.layouts.app_pages')

@section('content')
<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6"><h3 class="mb-0">Permissions List</h3></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Permissions</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                     <a href="{{ route('control_panel_dashboard.permissions.create') }}" class="btn btn-success mb-3">Add New Permission</a>
                     @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="card mb-4">
                        <div class="card-header">
                            <h3 class="card-title">Permissions Table</h3>
                        </div>
                        <div class="card-body">
                            <!-- خانة البحث -->
                            <input type="text" id="searchInput" class="form-control mb-3" placeholder="Search for permission...">

                            <!-- الجدول -->
                            <table class="table table-bordered" id="permissionsTable">
                                <thead>
                                    <tr>
                                        <th style="width: 10%;">ID</th>
                                        <th>Permission Name</th>
                                        <th style="width: 20%;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="permissionsTableBody">
                                 
                                     @foreach($permissions as $permission)
                                        <tr class="align-middle">
                                            <td>{{ $permission->id }}</td>
                                            <td>{{ $permission->name }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('control_panel_dashboard.permissions.show', $permission->id) }}" class="btn btn-primary btn-sm">View</a>
                                                <a href="{{ route('control_panel_dashboard.permissions.edit', $permission->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                                <form action="{{ route('control_panel_dashboard.permissions.destroy', $permission->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach


                                
                                </tbody>
                            </table>
                            <!-- عرض الترقيم -->
                            <div class="pagination-wrapper" style="display: flex; justify-content: center;">
                            {{ $permissions->links() }}
                            </div>



                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // $(document).ready(function() {
    //     // عند كتابة شيء في خانة البحث
    //     $('#searchInput').on('keyup', function() {
    //         var searchValue = $(this).val().toLowerCase(); // الحصول على النص المدخل وتحويله إلى أحرف صغيرة

    //         // البحث في كل الصفوف داخل الجدول
    //         $('#permissionsTableBody tr').each(function() {
    //             var permissionName = $(this).find('td:eq(1)').text().toLowerCase(); // البحث في عمود "Permission Name"
                
    //             // إذا كان النص المدخل موجودًا في العمود، إظهار الصف
    //             if (permissionName.indexOf(searchValue) !== -1) {
    //                 $(this).show();  // إظهار الصف
    //             } else {
    //                 $(this).hide();  // إخفاء الصف
    //             }
    //         });
    //     });
    // });
</script>





<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
  $("#searchInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#permissionsTableBody tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>
 


 