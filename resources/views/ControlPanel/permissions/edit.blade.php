@extends('ControlPanel.layouts.app_pages')

@section('content')
<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6"><h3 class="mb-0">Edit Permission</h3></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('control_panel_dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('control_panel_dashboard.permissions.index') }}">Permissions</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <a href="{{ route('control_panel_dashboard.permissions.index') }}" class="btn btn-secondary mb-3">Back to Permissions List</a>

                    <div class="card mb-4">
                        <div class="card-header">
                            <h3 class="card-title">Edit Permission</h3>
                        </div>
                        <div class="card-body">
                            <!-- نموذج تعديل صلاحية -->
                            <form method="POST" action="{{ route('control_panel_dashboard.permissions.update', $permission->id) }}">
                                @csrf
                                @method('PUT') <!-- استخدام PUT لتعديل البيانات -->

                                <!-- Field for Permission Name -->
                                <div class="form-group">
                                    <label for="permission_name">Permission Name</label>
                                    <input type="text" id="permission_name" name="name" class="form-control" placeholder="Enter Permission Name" value="{{ old('name', $permission->name) }}" required>

                                    <!-- عرض الأخطاء الخاصة بالاسم إذا كانت موجودة -->
                                    @error('name')
                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mt-3">
                                    <button type="submit" class="btn btn-success">Update Permission</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
