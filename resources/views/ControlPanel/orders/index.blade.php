@extends('ControlPanel.layouts.app_pages')

@section('content')
<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6"><h3 class="mb-0">Shopping Carts List</h3></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Shopping Carts</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="card mb-4">
                        <div class="card-header">
                            <h3 class="card-title">Shopping Carts Table</h3>
                        </div>
                        <div class="card-body">
                            <!-- الجدول -->
                            <table class="table table-bordered" id="shoppingCartsTable">
                                <thead>
                                    <tr>
                                        <th style="width: 10%;">ID</th>
                                        <th>User Name</th>
                                        <th>Status</th>
                                        <th>Total</th>
                                        <th style="width: 20%;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="shoppingCartsTableBody">
                                    @foreach($orders as $order)
                                        <tr class="align-middle">
                                            <td>{{ $order->id }}</td>
                                            <td>{{ $order->user->name }}</td>
                                            <td>{{ $order->status }}</td>
                                            <td>{{ $order->total }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('control_panel_dashboard.orders.show', $order->id) }}" class="btn btn-primary btn-sm">View Items</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <!-- عرض الترقيم -->
                            <div class="pagination-wrapper" style="display: flex; justify-content: center;">
                                {{ $orders->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
