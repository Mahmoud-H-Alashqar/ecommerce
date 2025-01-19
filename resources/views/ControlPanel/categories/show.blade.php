@extends('ControlPanel.layouts.app_pages')

@section('content')
<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6"><h3 class="mb-0">Category Details</h3></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('control_panel_dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('control_panel_dashboard.categories.index') }}">Categories</a></li>
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
                    <a href="{{ route('control_panel_dashboard.categories.index') }}" class="btn btn-secondary mb-3">Back to Categories List</a>

                    <div class="card mb-4">
                        <div class="card-header">
                            <h3 class="card-title">Category Details</h3>
                        </div>
                        <div class="card-body">
                            <!-- عرض تفاصيل التصنيف -->
                            <div class="form-group">
                                <label for="category_name">Category Name</label>
                                <input type="text" id="category_name" class="form-control" value="{{ $category->name }}" readonly>
                            </div>

                            <div class="form-group mt-3">
                                <label for="category_description">Category Description</label>
                                <textarea id="category_description" class="form-control" rows="4" readonly>{{ $category->description }}</textarea>
                            </div>

                            <!-- أزرار لتعديل أو حذف التصنيف -->
                            <div class="form-group mt-3">
                                <a href="{{ route('control_panel_dashboard.categories.edit', $category->id) }}" class="btn btn-warning">Edit Category</a>
                                
                                <form action="{{ route('control_panel_dashboard.categories.destroy', $category->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete Category</button>
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
