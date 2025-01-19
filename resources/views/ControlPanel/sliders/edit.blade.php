@extends('ControlPanel.layouts.app_pages')

@section('content')
<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6"><h3 class="mb-0">Edit Slider</h3></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('control_panel_dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('control_panel_dashboard.sliders.index') }}">Sliders</a></li>
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
                    <a href="{{ route('control_panel_dashboard.sliders.index') }}" class="btn btn-secondary mb-3">Back to Sliders List</a>

                    <div class="card mb-4">
                        <div class="card-header">
                            <h3 class="card-title">Edit Slider</h3>
                        </div>
                        <div class="card-body">
                            <!-- نموذج تعديل سلايدر -->
                            <form method="POST" action="{{ route('control_panel_dashboard.sliders.update', $slider->id) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')  <!-- لتحديد أن هذا طلب تعديل -->

                                <!-- حقل عنوان السلايدر -->
                                <div class="form-group">
                                    <label for="slider_title">Slider Title</label>
                                    <input type="text" id="slider_title" name="title" class="form-control" placeholder="Enter Slider Title" value="{{ old('title', $slider->title) }}" required>

                                    <!-- عرض الأخطاء الخاصة بالعناوين إذا كانت موجودة -->
                                    @error('title')
                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- حقل الفئة -->
                                <div class="form-group mt-3">
                                    <label for="category_id">Category</label>
                                    <select id="category_id" name="category_id" class="form-control" required>
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id', $slider->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                        @endforeach
                                    </select>

                                    <!-- عرض الأخطاء الخاصة بالفئة إذا كانت موجودة -->
                                    @error('category_id')
                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- حقل صورة السلايدر -->
                                <div class="form-group mt-3">
                                    <label for="slider_image">Slider Image</label>
                                    <input type="file" id="slider_image" name="image" class="form-control" accept="image/*">

                                    <!-- عرض الصورة الحالية -->
                                    @if($slider->image)
                                        <div class="mt-2">
                                            <img src="{{ asset('storage/' . $slider->image) }}" alt="Slider Image" width="100" height="100">
                                        </div>
                                    @endif

                                    <!-- عرض الأخطاء الخاصة بالصورة إذا كانت موجودة -->
                                    @error('image')
                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mt-3">
                                    <button type="submit" class="btn btn-success">Update Slider</button>
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
