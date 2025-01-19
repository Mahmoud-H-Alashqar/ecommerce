@extends('ControlPanel.layouts.app_pages')

@section('content')
<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6"><h3 class="mb-0">Roles List</h3></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Roles</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <a href="{{ route('control_panel_dashboard.roles.create') }}" class="btn btn-success mb-3">Add New Role</a>
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="card mb-4">
                        <div class="card-header">
                            <h3 class="card-title">Roles Table</h3>
                        </div>
                        <div class="card-body">
                            <!-- خانة البحث -->
                            <input type="text" id="searchInput" class="form-control mb-3" placeholder="Search for role...">

                            <!-- الجدول -->
                            <table class="table table-bordered" id="rolesTable">
                                <thead>
                                    <tr>
                                        <th style="width: 10%;">ID</th>
                                        <th>Role Name</th>
                                        <th>Permissions</th> <!-- إضافة عمود للصلاحيات -->
                                        <th style="width: 20%;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="rolesTableBody">
                                    @foreach($roles as $role)
                                        <tr class="align-middle">
                                            <td>{{ $role->id }}</td>
                                            <td>{{ $role->name }}</td>

                                            <!-- عرض الصلاحيات المرتبطة بالدور -->
                                            <td>
                                                @foreach($role->permissions as $permission)
                                                    <span class="badge bg-info">{{ $permission->name }}</span>
                                                @endforeach
                                            </td>

                                            <td class="text-center">
                                                <a href="{{ route('control_panel_dashboard.roles.show', $role->id) }}" class="btn btn-primary btn-sm">View</a>
                                                <a href="{{ route('control_panel_dashboard.roles.edit', $role->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                                <form action="{{ route('control_panel_dashboard.roles.destroy', $role->id) }}" method="POST" style="display:inline;">
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
                                {{ $roles->links() }}
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        $("#searchInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#rolesTableBody tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>
@endsection
