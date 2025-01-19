@extends('ControlPanel.layouts.app_pages')

@section('content')
<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6"><h3 class="mb-0">Create New Product</h3></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('control_panel_dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('control_panel_dashboard.products.index') }}">Products</a></li>
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
                    <a href="{{ route('control_panel_dashboard.products.index') }}" class="btn btn-secondary mb-3">Back to Products List</a>

                    <div class="card mb-4">
                        <div class="card-header">
                            <h3 class="card-title">Create New Product</h3>
                        </div>
                        <div class="card-body">
                            <!-- نموذج إنشاء منتج -->
                            <form method="POST" action="{{ route('control_panel_dashboard.products.store') }}" enctype="multipart/form-data">
                                @csrf

                                <!-- حقل اسم المنتج -->
                                <div class="form-group">
                                    <label for="product_name">Product Name</label>
                                    <input type="text" id="product_name" name="name" class="form-control" placeholder="Enter Product Name" value="{{ old('name') }}" required>

                                    <!-- عرض الأخطاء الخاصة بالاسم إذا كانت موجودة -->
                                    @error('name')
                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- حقل الوصف -->
                                <div class="form-group mt-3">
                                    <label for="product_description">Product Description</label>
                                    <textarea id="product_description" name="description" class="form-control" placeholder="Enter Product Description" rows="4">{{ old('description') }}</textarea>

                                    <!-- عرض الأخطاء الخاصة بالوصف إذا كانت موجودة -->
                                    @error('description')
                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- حقل السعر -->
                                <div class="form-group mt-3">
                                    <label for="product_price">Product Price</label>
                                    <input type="number" id="product_price" name="price" class="form-control" placeholder="Enter Product Price" value="{{ old('price') }}" required>

                                    <!-- عرض الأخطاء الخاصة بالسعر إذا كانت موجودة -->
                                    @error('price')
                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- حقل الفئة -->
                                <div class="form-group mt-3">
                                    <label for="category_id">Category</label>
                                    <select id="category_id" name="category_id" class="form-control" required>
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                        @endforeach
                                    </select>

                                    <!-- عرض الأخطاء الخاصة بالفئة إذا كانت موجودة -->
                                    @error('category_id')
                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- حقل صورة المنتج -->
                                <div class="form-group mt-3">
                                    <label for="product_image">Product Image</label>
                                    <input type="file" id="product_image" name="image" class="form-control" accept="image/*">

                                    <!-- عرض الأخطاء الخاصة بالصورة إذا كانت موجودة -->
                                    @error('image')
                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mt-3">
                                    <button type="submit" class="btn btn-success">Create Product</button>
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
