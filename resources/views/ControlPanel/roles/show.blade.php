@extends('ControlPanel.layouts.app_pages')

@section('content')
<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6"><h3 class="mb-0">Role Details</h3></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('control_panel_dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('control_panel_dashboard.roles.index') }}">Roles</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Show</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <a href="{{ route('control_panel_dashboard.roles.index') }}" class="btn btn-secondary mb-3">Back to Roles List</a>

                    <div class="card mb-4">
                        <div class="card-header">
                            <h3 class="card-title">Role Details</h3>
                        </div>
                        <div class="card-body">
                            <!-- عرض تفاصيل الدور -->
                            <div class="form-group">
                                <label for="role_name"><strong>Role Name:</strong></label>
                                <input type="text" id="role_name" class="form-control bg-light" value="{{ $role->name }}" readonly>
                            </div>

                            <hr> <!-- فاصل بين المعلومات -->

                            <!-- عرض الصلاحيات المرتبطة بالدور -->
                            <div class="form-group mt-3">
                                <label for="permissions"><strong>Assigned Permissions:</strong></label>
                                <ul class="list-group">
                                    @foreach($role->permissions as $permission)
                                        <li class="list-group-item list-group-item-info">
                                            <i class="fas fa-check-circle"></i> {{ $permission->name }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                            <hr> <!-- فاصل بين المعلومات -->

                            <!-- عرض تاريخ الإنشاء والتحديث -->
                        

                        
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
