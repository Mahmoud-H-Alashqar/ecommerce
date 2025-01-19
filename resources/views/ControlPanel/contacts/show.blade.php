@extends('ControlPanel.layouts.app_pages')

@section('content')
<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6"><h3 class="mb-0">Contact Details</h3></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('control_panel_dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('control_panel_dashboard.contactadmin.index') }}">Contacts</a></li>
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
                    <a href="{{ route('control_panel_dashboard.contactadmin.index') }}" class="btn btn-secondary mb-3">Back to Contacts List</a>

                    <div class="card mb-4">
                        <div class="card-header">
                            <h3 class="card-title">Contact Details</h3>
                        </div>
                        <div class="card-body">
                            <!-- عرض تفاصيل الاتصال -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="contact_name">Name</label>
                                        <input type="text" id="contact_name" class="form-control" value="{{ $contact->name }}" disabled>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="contact_email">Email</label>
                                        <input type="email" id="contact_email" class="form-control" value="{{ $contact->email }}" disabled>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="contact_message">Message</label>
                                        <textarea id="contact_message" class="form-control" rows="4" disabled>{{ $contact->message }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mt-3">
                                {{--<a href="{{ route('control_panel_dashboard.contacts.edit', $contact->id) }}" class="btn btn-warning">Edit Contact</a>--}}
                                <form action="{{ route('control_panel_dashboard.contacts.destroy', $contact->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete Contact</button>
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
