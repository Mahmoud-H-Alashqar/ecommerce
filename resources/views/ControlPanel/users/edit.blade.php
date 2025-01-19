@extends('ControlPanel.layouts.app_pages')

@section('content')
<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6"><h3 class="mb-0">Edit User</h3></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('control_panel_dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('control_panel_dashboard.users.index') }}">Users</a></li>
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
                    <a href="{{ route('control_panel_dashboard.users.index') }}" class="btn btn-secondary mb-3">Back to Users List</a>

                    <div class="card mb-4">
                        <div class="card-header">
                            <h3 class="card-title">Edit User</h3>
                        </div>
                        <div class="card-body">
                            <!-- نموذج تعديل مستخدم -->
                            <form method="POST" action="{{ route('control_panel_dashboard.users.update', $user->id) }}">
                                @csrf
                                @method('PUT')

                                <!-- Field for User Name -->
                                <div class="form-group">
                                    <label for="name">User Name</label>
                                    <input type="text" id="name" name="name" class="form-control" placeholder="Enter User Name" value="{{ old('name', $user->name) }}" required>

                                    <!-- عرض الأخطاء الخاصة بالاسم إذا كانت موجودة -->
                                    @error('name')
                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Field for Email -->
                                <div class="form-group mt-3">
                                    <label for="email">Email</label>
                                    <input type="email" id="email" name="email" class="form-control" placeholder="Enter Email" value="{{ old('email', $user->email) }}" required>

                                    @error('email')
                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Field for Password -->
                                <div class="form-group mt-3">
                                    <label for="password">Password</label>
                                    <input type="password" id="password" name="password" class="form-control" placeholder="Enter Password (Leave empty to keep current password)">

                                    @error('password')
                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Field for Password Confirmation -->
                                <div class="form-group mt-3">
                                    <label for="password_confirmation">Confirm Password</label>
                                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Confirm Password">

                                    @error('password_confirmation')
                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Field for Role Selection -->
                                <div class="form-group mt-3">
    <label for="role">Assign Role</label>
    <select name="role" id="role" class="form-control">
        <option value="" disabled {{ old('role') ? '' : 'selected' }}>Select a role</option> <!-- خيار افتراضي -->

        @foreach($roles as $role)
            <option value="{{ $role->name }}" 
                {{ old('role', $user->roles->first()->name ?? '') == $role->name ? 'selected' : '' }}>
                {{ $role->name }}
            </option>
        @endforeach
    </select>

    <!-- عرض خطأ إذا لم يتم اختيار دور -->
    @error('role')
        <div class="alert alert-danger mt-2">{{ $message }}</div>
    @enderror
</div>


                                <div class="form-group mt-3">
                                    <button type="submit" class="btn btn-success">Update User</button>
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
