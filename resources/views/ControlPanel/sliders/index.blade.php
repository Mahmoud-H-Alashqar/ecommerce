@extends('ControlPanel.layouts.app_pages')

@section('content')
<style>
    .carousel-img {
    width: 600px;  /* تحديد العرض */
    height: 400px; /* تحديد الارتفاع */
    object-fit: cover; /* لضمان أن الصورة تغطي المساحة المحددة مع الحفاظ على التناسب */
}

    </style>
<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6"><h3 class="mb-0">Sliders List</h3></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Sliders</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                     <a href="{{ route('control_panel_dashboard.sliders.create') }}" class="btn btn-success mb-3">Add New Slider</a>
                     @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="card mb-4">
                        <div class="card-header">
                            <h3 class="card-title">Sliders Table</h3>
                        </div>
                        <div class="card-body">
                            <!-- خانة البحث -->
                            <input type="text" id="searchInput" class="form-control mb-3" placeholder="Search for slider...">

                            <!-- الجدول -->
                            <table class="table table-bordered" id="slidersTable">
                                <thead>
                                    <tr>
                                        <th style="width: 10%;">ID</th>
                                        <th>Slider Title</th>
                                        <th>Category</th>
                                        <th>Image</th>
                                        <th style="width: 20%;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="slidersTableBody">
                                    @foreach($sliders as $slider)
                                        <tr class="align-middle">
                                            <td>{{ $slider->id }}</td>
                                            <td>{{ $slider->title }}</td>
                                            <td>{{ $slider->category->name }}</td>
                                            <td><img src="{{ asset('storage/' . $slider->image) }}" width="100" alt="Slider Image"></td>
                                            <td class="text-center">
                                                <a href="{{ route('control_panel_dashboard.sliders.show', $slider->id) }}" class="btn btn-primary btn-sm">View</a>
                                                <a href="{{ route('control_panel_dashboard.sliders.edit', $slider->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                                <form action="{{ route('control_panel_dashboard.sliders.destroy', $slider->id) }}" method="POST" style="display:inline;">
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
                                {{ $sliders->links() }}
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
    $("#slidersTableBody tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>
@endsection
