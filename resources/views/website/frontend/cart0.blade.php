@extends('website.layouts.app')

@section('content')


<!-- Modal Search Start -->
<div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content rounded-0">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Search by keyword</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body d-flex align-items-center">
                        <div class="input-group w-75 mx-auto d-flex">
                            <input type="search" class="form-control p-3" placeholder="keywords" aria-describedby="search-icon-1">
                            <span id="search-icon-1" class="input-group-text p-3"><i class="fa fa-search"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Search End -->


        <!-- Single Page Header start -->
        <div class="container-fluid page-header py-5">
            <h1 class="text-center text-white display-6">Cart</h1>
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Pages</a></li>
                <li class="breadcrumb-item active text-white">Cart</li>
            </ol>
        </div>
        <!-- Single Page Header End -->


        <!-- Cart Page Start -->
        <div class="container-fluid py-5">
            <div class="container py-5">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">Products</th>
                            <th scope="col">Name</th>
                            <th scope="col">Price</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Total</th>
                            <th scope="col">Handle</th>
                          </tr>
                        </thead>
                        <tbody>
                        @foreach($cartItems as $item)
                        
                        @if(is_object($item))
                            <tr>
                                <th scope="row">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('storage/' . $item->product->image) }}" class="img-fluid me-5 rounded-circle" style="width: 80px; height: 80px;" alt="">
                                    </div>
                                </th>
                                <td>
                                    <p class="mb-0 mt-4">{{ $item->product->name }}</p>
                                </td>
                                <td>
                                    <p class="mb-0 mt-4">{{ $item->product->price }} $</p>
                                </td>
                                <td>
                                    {{--<div class="input-group quantity mt-4" style="width: 100px;">
                                        <div class="input-group-btn">
                                            <button class="btn btn-sm btn-minus rounded-circle bg-light border" >
                                            <i class="fa fa-minus"></i>
                                            </button>
                                        </div>
                                        <input type="text" class="form-control form-control-sm text-center border-0" value="1">
                                        <div class="input-group-btn">
                                            <button class="btn btn-sm btn-plus rounded-circle bg-light border">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>--}}
                                    <div class="input-group quantity mt-4" style="width: 100px;">
                                <div class="input-group-btn">
                                    <button class="btn btn-sm btn-minus rounded-circle bg-light border" id="btn-minus">
                                        <i class="fa fa-minus"></i>
                                    </button>
                                </div>
                                <input type="text" class="form-control form-control-sm text-center border-0" id="quantity" value="1">
                                <div class="input-group-btn">
                                    <button class="btn btn-sm btn-plus rounded-circle bg-light border" id="btn-plus">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>

                                </td>
                                <td>
                                    <p class="mb-0 mt-4">2.99 $</p>
                                </td>
                                <td>
                                    <button class="btn btn-md rounded-circle bg-light border mt-4" >
                                        <i class="fa fa-times text-danger"></i>
                                    </button>
                                </td>
                            
                            </tr>
                            @else
                            <tr>
                                <th scope="row">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('storage/' . $item['image']) }}" class="img-fluid me-5 rounded-circle" style="width: 80px; height: 80px;" alt="">
                                    </div>
                                </th>
                                <td>
                                    <p class="mb-0 mt-4">{{ $item['name'] }}</p>
                                </td>
                                <td>
                                    <p class="mb-0 mt-4">{{ $item['price'] }} $</p>
                                </td>
                                <td>
                                    <div class="input-group quantity mt-4" style="width: 100px;">
                                        <div class="input-group-btn">
                                            <button class="btn btn-sm btn-minus rounded-circle bg-light border" >
                                            <i class="fa fa-minus"></i>
                                            </button>
                                        </div>
                                        <input type="text" class="form-control form-control-sm text-center border-0" value="1">
                                        <div class="input-group-btn">
                                            <button class="btn btn-sm btn-plus rounded-circle bg-light border">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <p class="mb-0 mt-4">2.99 $</p>
                                </td>
                                <td>
                                    <button class="btn btn-md rounded-circle bg-light border mt-4" >
                                        <i class="fa fa-times text-danger"></i>
                                    </button>
                                </td>
                            
                            </tr>

                            @endif
                            @endforeach

                        </tbody>
                    </table>
                </div>
                <div class="mt-5">
                    <input type="text" class="border-0 border-bottom rounded me-5 py-3 mb-4" placeholder="Coupon Code">
                    <button class="btn border-secondary rounded-pill px-4 py-3 text-primary" type="button">Apply Coupon</button>
                </div>
                <div class="row g-4 justify-content-end">
                    <div class="col-8"></div>
                    <div class="col-sm-8 col-md-7 col-lg-6 col-xl-4">
                        <div class="bg-light rounded">
                            <div class="p-4">
                                <h1 class="display-6 mb-4">Cart <span class="fw-normal">Total</span></h1>
                                <div class="d-flex justify-content-between mb-4">
                                    <h5 class="mb-0 me-4">Subtotal:</h5>
                                    <p class="mb-0">$96.00</p>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <h5 class="mb-0 me-4">Shipping</h5>
                                    <div class="">
                                        <p class="mb-0">Flat rate: $3.00</p>
                                    </div>
                                </div>
                                <p class="mb-0 text-end">Shipping to Ukraine.</p>
                            </div>
                            <div class="py-4 mb-4 border-top border-bottom d-flex justify-content-between">
                                <h5 class="mb-0 ps-4 me-4">Total</h5>
                                <p class="mb-0 pe-4">$99.00</p>
                            </div>
                            <button class="btn border-secondary rounded-pill px-4 py-3 text-primary text-uppercase mb-4 ms-4" type="button">Proceed Checkout</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Cart Page End -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function(){
        // الحد من نقص الكمية إذا كانت أقل من 1
        $('#btn-minus').click(function(){
            alert("min");
            var quantity = parseInt($('#quantity').val());
            if(quantity > 1) {
                $('#quantity').val(quantity - 1);
                updateCartQuantity();
            }
        });

        // زيادة الكمية
        $('#btn-plus').click(function(){
            alert("plus");
            var quantity = parseInt($('#quantity').val());
            $('#quantity').val(quantity + 1);
            updateCartQuantity();
        });

        // تحديث الكمية في السلة بناءً على حالة المستخدم
        // function updateCartQuantity() {
        //     var quantity = parseInt($('#quantity').val());
        //     var productId = /* هنا ضع معرف المنتج */;

        //     @if(Auth::check())  // إذا كان المستخدم مسجلاً دخولًا
        //         // إرسال الكمية إلى السيرفر لتحديث قاعدة البيانات
        //         $.ajax({
        //             url: "{{ route('cart.update') }}",  // تعديل الرابط إلى المسار الذي يتعامل مع التحديث
        //             method: "POST",
        //             data: {
        //                 _token: "{{ csrf_token() }}",
        //                 product_id: productId,
        //                 quantity: quantity
        //             },
        //             success: function(response) {
        //                 // يمكنك إضافة ما تود فعله بعد نجاح العملية، مثل عرض رسالة نجاح
        //             }
        //         });
        //     @else
        //         // إذا لم يكن المستخدم مسجلاً دخولًا، نقوم بتحديث السلة في الجلسة
        //         var cart = JSON.parse(localStorage.getItem('cart')) || [];
        //         var found = false;

        //         // تحقق إذا كان المنتج موجودًا بالفعل في السلة
        //         cart.forEach(function(item) {
        //             if(item.id === productId) {
        //                 item.quantity = quantity;  // تحديث الكمية
        //                 found = true;
        //             }
        //         });

        //         // إذا لم يكن المنتج موجودًا في السلة
        //         if (!found) {
        //             cart.push({id: productId, quantity: quantity});
        //         }

        //         // حفظ السلة المحدثة في الجلسة
        //         localStorage.setItem('cart', JSON.stringify(cart));
        //     @endif
        // }
    });
</script>












@endsection
