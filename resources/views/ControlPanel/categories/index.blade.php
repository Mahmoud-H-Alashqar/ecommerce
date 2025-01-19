@extends('ControlPanel.layouts.app_pages')

@section('content')
<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6"><h3 class="mb-0">Categories List</h3></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Categories</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                     <a href="{{ route('control_panel_dashboard.categories.create') }}" class="btn btn-success mb-3">Add New Category</a>
                     @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="card mb-4">
                        <div class="card-header">
                            <h3 class="card-title">Categories Table</h3>
                        </div>
                        <div class="card-body">
                            <!-- خانة البحث -->
                            <input type="text" id="searchInput" class="form-control mb-3" placeholder="Search for category...">

                            <!-- الجدول -->
                            <table class="table table-bordered" id="categoriesTable">
                                <thead>
                                    <tr>
                                        <th style="width: 10%;">ID</th>
                                        <th>Category Name</th>
                                        <th>Category Description</th>
                                        <th style="width: 20%;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="categoriesTableBody">
                                    @foreach($categories as $category)
                                        <tr class="align-middle">
                                            <td>{{ $category->id }}</td>
                                            <td>{{ $category->name }}</td>
                                            <td>{{ $category->description }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('control_panel_dashboard.categories.show', $category->id) }}" class="btn btn-primary btn-sm">View</a>
                                                <a href="{{ route('control_panel_dashboard.categories.edit', $category->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                                <form action="{{ route('control_panel_dashboard.categories.destroy', $category->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <!-- عرض الترقيم -->
                            <div class="pagination-wrapper" style="display: flex; justify-content: center;">
                                {{ $categories->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@section('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
  $("#searchInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#categoriesTableBody tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>
@endsection
