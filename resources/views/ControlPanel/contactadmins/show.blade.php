@extends('ControlPanel.layouts.app_pages')

@section('content')
<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6"><h3 class="mb-0">Contact Admin Details</h3></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('control_panel_dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('control_panel_dashboard.contactadmins.index') }}">Contact Admins</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Details</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <a href="{{ route('control_panel_dashboard.contactadmins.index') }}" class="btn btn-secondary mb-3">Back to Contact Admins List</a>

                    <div class="card mb-4">
                        <div class="card-header">
                            <h3 class="card-title">Contact Admin Details</h3>
                        </div>
                        <div class="card-body">
                            <!-- Displaying contact admin details -->
                            <div class="form-group">
                                <label for="address">Address</label>
                                <input type="text" id="address" class="form-control" value="{{ $contactadmin->address }}" readonly>
                            </div>

                            <div class="form-group mt-3">
                                <label for="email">Email</label>
                                <input type="email" id="email" class="form-control" value="{{ $contactadmin->email }}" readonly>
                            </div>

                            <div class="form-group mt-3">
                                <label for="telephone">Telephone</label>
                                <input type="text" id="telephone" class="form-control" value="{{ $contactadmin->telephone }}" readonly>
                            </div>

                            <!-- Buttons to edit or delete the contact admin -->
                            <div class="form-group mt-3">
                                <a href="{{ route('control_panel_dashboard.contactadmins.edit', $contactadmin->id) }}" class="btn btn-warning">Edit Contact Admin</a>
                                
                                <form action="{{ route('control_panel_dashboard.contactadmins.destroy', $contactadmin->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete Contact Admin</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
