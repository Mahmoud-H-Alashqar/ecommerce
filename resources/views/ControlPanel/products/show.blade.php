@extends('ControlPanel.layouts.app_pages')

@section('content')
<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6"><h3 class="mb-0">Product Details</h3></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('control_panel_dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('control_panel_dashboard.products.index') }}">Products</a></li>
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
                    <a href="{{ route('control_panel_dashboard.products.index') }}" class="btn btn-secondary mb-3">Back to Products List</a>

                    <div class="card mb-4">
                        <div class="card-header">
                            <h3 class="card-title">Product Details</h3>
                        </div>
                        <div class="card-body">
                            <!-- عرض تفاصيل المنتج -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="product_name">Product Name</label>
                                        <input type="text" id="product_name" class="form-control" value="{{ $product->name }}" disabled>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="product_price">Product Price</label>
                                        <input type="text" id="product_price" class="form-control" value="{{ $product->price }}" disabled>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="category_name">Category</label>
                                        <input type="text" id="category_name" class="form-control" value="{{ $product->category->name }}" disabled>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="product_image">Product Image</label>
                                        <div>
                                            @if($product->image)
                                                <img src="{{ asset('storage/' . $product->image) }}" alt="Product Image" width="150" height="150">
                                            @else
                                                <p>No image available</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="product_description">Product Description</label>
                                <textarea id="product_description" class="form-control" rows="4" disabled>{{ $product->description }}</textarea>
                            </div>

                            <div class="form-group mt-3">
                                <a href="{{ route('control_panel_dashboard.products.edit', $product->id) }}" class="btn btn-warning">Edit Product</a>
                                <form action="{{ route('control_panel_dashboard.products.destroy', $product->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete Product</button>
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
