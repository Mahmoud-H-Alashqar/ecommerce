@extends('ControlPanel.layouts.app_pages')

@section('content')
<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6"><h3 class="mb-0">Slider Details</h3></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('control_panel_dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('control_panel_dashboard.sliders.index') }}">Sliders</a></li>
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
                    <a href="{{ route('control_panel_dashboard.sliders.index') }}" class="btn btn-secondary mb-3">Back to Sliders List</a>

                    <div class="card mb-4">
                        <div class="card-header">
                            <h3 class="card-title">Slider Details</h3>
                        </div>
                        <div class="card-body">
                            <!-- عرض تفاصيل السلايدر -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="slider_title">Slider Title</label>
                                        <input type="text" id="slider_title" class="form-control" value="{{ $slider->title }}" disabled>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="slider_category">Category</label>
                                        <input type="text" id="slider_category" class="form-control" value="{{ $slider->category->name }}" disabled>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="slider_image">Slider Image</label>
                                        <div>
                                            @if($slider->image)
                                                <img src="{{ asset('storage/' . $slider->image) }}" alt="Slider Image" width="150" height="150">
                                            @else
                                                <p>No image available</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mt-3">
                                <a href="{{ route('control_panel_dashboard.sliders.edit', $slider->id) }}" class="btn btn-warning">Edit Slider</a>
                                <form action="{{ route('control_panel_dashboard.sliders.destroy', $slider->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete Slider</button>
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
