@extends('ControlPanel.layouts.app_pages')

@section('content')
<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6"><h3 class="mb-0">User Details</h3></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('control_panel_dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('control_panel_dashboard.users.index') }}">Users</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $user->name }}</li>
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
                            <h3 class="card-title">User Details: {{ $user->name }}</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">User Name</label>
                                <p>{{ $user->name }}</p>
                            </div>

                            <div class="form-group mt-3">
                                <label for="email">Email</label>
                                <p>{{ $user->email }}</p>
                            </div>

                            <div class="form-group mt-3">
                                <label for="roles">Roles</label>
                                <p>
                                    @foreach($user->roles as $role)
                                        <span class="badge bg-primary">{{ $role->name }}</span>
                                    @endforeach
                                </p>
                            </div>

                            {{--<div class="form-group mt-3">
                                <label for="created_at">Created At</label>
                                <p>{{ $user->created_at->format('Y-m-d H:i:s') }}</p>
                            </div>

                            <div class="form-group mt-3">
                                <label for="updated_at">Updated At</label>
                                <p>{{ $user->updated_at->format('Y-m-d H:i:s') }}</p>
                            </div>--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
