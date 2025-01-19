@extends('ControlPanel.layouts.app_pages')

@section('content')
<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6"><h3 class="mb-0">Edit Role</h3></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('control_panel_dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('control_panel_dashboard.roles.index') }}">Roles</a></li>
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
                    <a href="{{ route('control_panel_dashboard.roles.index') }}" class="btn btn-secondary mb-3">Back to Roles List</a>

                    <div class="card mb-4">
                        <div class="card-header">
                            <h3 class="card-title">Edit Role</h3>
                        </div>
                        <div class="card-body">
                            <!-- نموذج تعديل الدور -->
                            <form method="POST" action="{{ route('control_panel_dashboard.roles.update', $role->id) }}">
                                @csrf
                                @method('PUT')

                                <!-- Field for Role Name -->
                                <div class="form-group">
                                    <label for="role_name">Role Name</label>
                                    <input type="text" id="role_name" name="name" class="form-control" placeholder="Enter Role Name" value="{{ old('name', $role->name) }}" required>

                                    <!-- عرض الأخطاء الخاصة بالاسم إذا كانت موجودة -->
                                    @error('name')
                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Field for Permissions (Multiple Select) -->
                                <div class="form-group mt-3">
                                    <label for="permissions">Assign Permissions</label>
                                    <select name="permissions[]" id="permissions" class="form-control" multiple>
                                        @foreach($permissions as $permission)
                                            <option value="{{ $permission->name }}" 
                                                {{ in_array($permission->name, old('permissions', $role->permissions->pluck('name')->toArray())) ? 'selected' : '' }}>
                                                {{ $permission->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('permissions')
                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mt-3">
                                    <button type="submit" class="btn btn-success">Update Role</button>
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
