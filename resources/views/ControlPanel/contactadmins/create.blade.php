@extends('ControlPanel.layouts.app_pages')

@section('content')
<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6"><h3 class="mb-0">Create New Contact Admin</h3></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('control_panel_dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('control_panel_dashboard.contactadmins.index') }}">Contact Admins</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create</li>
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
                            <h3 class="card-title">Create New Contact Admin</h3>
                        </div>
                        <div class="card-body">
                            <!-- نموذج إنشاء Contact Admin -->
                            <form method="POST" action="{{ route('control_panel_dashboard.contactadmins.store') }}">
                                @csrf

                                <!-- حقل العنوان -->
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <input type="text" id="address" name="address" class="form-control" placeholder="Enter Address" value="{{ old('address') }}" required>

                                    <!-- عرض الأخطاء الخاصة بالعنوّان إذا كانت موجودة -->
                                    @error('address')
                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- حقل البريد الإلكتروني -->
                                <div class="form-group mt-3">
                                    <label for="email">Email</label>
                                    <input type="email" id="email" name="email" class="form-control" placeholder="Enter Email" value="{{ old('email') }}" required>

                                    <!-- عرض الأخطاء الخاصة بالبريد الإلكتروني إذا كانت موجودة -->
                                    @error('email')
                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- حقل رقم الهاتف -->
                                <div class="form-group mt-3">
                                    <label for="telephone">Telephone</label>
                                    <input type="text" id="telephone" name="telephone" class="form-control" placeholder="Enter Telephone" value="{{ old('telephone') }}" required>

                                    <!-- عرض الأخطاء الخاصة برقم الهاتف إذا كانت موجودة -->
                                    @error('telephone')
                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mt-3">
                                    <button type="submit" class="btn btn-success">Create Contact Admin</button>
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
