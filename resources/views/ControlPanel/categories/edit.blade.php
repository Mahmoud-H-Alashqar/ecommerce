@extends('ControlPanel.layouts.app_pages')

@section('content')
<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6"><h3 class="mb-0">Edit Category</h3></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('control_panel_dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('control_panel_dashboard.categories.index') }}">Categories</a></li>
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
                    <a href="{{ route('control_panel_dashboard.categories.index') }}" class="btn btn-secondary mb-3">Back to Categories List</a>

                    <div class="card mb-4">
                        <div class="card-header">
                            <h3 class="card-title">Edit Category</h3>
                        </div>
                        <div class="card-body">
                            <!-- نموذج تعديل التصنيف -->
                            <form method="POST" action="{{ route('control_panel_dashboard.categories.update', $category->id) }}">
                                @csrf
                                @method('PUT')

                                <!-- حقل اسم التصنيف -->
                                <div class="form-group">
                                    <label for="category_name">Category Name</label>
                                    <input type="text" id="category_name" name="name" class="form-control" placeholder="Enter Category Name" value="{{ old('name', $category->name) }}" required>

                                    <!-- عرض الأخطاء الخاصة بالاسم إذا كانت موجودة -->
                                    @error('name')
                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- حقل وصف التصنيف -->
                                <div class="form-group mt-3">
                                    <label for="category_description">Category Description</label>
                                    <textarea id="category_description" name="description" class="form-control" placeholder="Enter Category Description" rows="4">{{ old('description', $category->description) }}</textarea>

                                    <!-- عرض الأخطاء الخاصة بالوصف إذا كانت موجودة -->
                                    @error('description')
                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mt-3">
                                    <button type="submit" class="btn btn-success">Update Category</button>
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
