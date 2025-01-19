@extends('ControlPanel.layouts.app_pages')

@section('content')
<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6"><h3 class="mb-0">Permission Details</h3></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('control_panel_dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('control_panel_dashboard.permissions.index') }}">Permissions</a></li>
                        <li class="breadcrumb-item active" aria-current="page">View</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <!-- زر العودة إلى قائمة الصلاحيات -->
                    <a href="{{ route('control_panel_dashboard.permissions.index') }}" class="btn btn-secondary mb-3"><i class="fas fa-arrow-left"></i> Back to Permissions List</a>

                    <div class="card mb-4">
                        <div class="card-header">
                            <h3 class="card-title">Permission Details</h3>
                        </div>
                        <div class="card-body">
                            <!-- عرض تفاصيل الصلاحية -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="permission_name"><strong>Permission Name:</strong></label>
                                        <p class="form-control-plaintext">{{ $permission->name }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- أزرار إضافية -->
                            <div class="form-group mt-4">
                                <a href="{{ route('control_panel_dashboard.permissions.index') }}" class="btn btn-secondary">Back to List</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
