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
                            <div class="input-group quantity mt-4" style="width: 100px;">
                                <div class="input-group-btn">
                                    <button class="btn btn-sm btn-minus rounded-circle bg-light border" data-product-id="{{ $item->product->id }}" id="btn-minus-{{ $item->product->id }}">
                                        <i class="fa fa-minus"></i>
                                    </button>
                                </div>
                                <input type="text" class="form-control form-control-sm text-center border-0" value="{{ $item->quantity }}" id="quantity-{{ $item->product->id }}">
                                <div class="input-group-btn">
                                    <button class="btn btn-sm btn-plus rounded-circle bg-light border" data-product-id="{{ $item->product->id }}" id="btn-plus-{{ $item->product->id }}">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </td>
                        <td>
                            {{--<p class="mb-0 mt-4">{{ $item->product->price * $item->quantity }} $</p>--}}
                            <p class="mb-0 mt-4" id="total-{{ $item->product->id }}">{{ $item->total_price }} $</p>

                        </td>
                        <td>
                         
                            <button class="btn btn-md rounded-circle bg-light border mt-4 btn-remove" data-product-id="{{ $item->product->id }}" id="btn-remove-{{ $item->product->id }}">
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
                                    <button class="btn btn-sm btn-minus rounded-circle bg-light border" data-product-id="{{ $item['id']}}" id="btn-minus-{{ $item['id'] }}">
                                        <i class="fa fa-minus"></i>
                                    </button>
                                </div>
                                <input type="text" class="form-control form-control-sm text-center border-0" value="{{ $item['quantity'] }}" id="quantity-{{ $item['id'] }}">
                                <div class="input-group-btn">
                                    <button class="btn btn-sm btn-plus rounded-circle bg-light border" data-product-id="{{ $item['id'] }}" id="btn-plus-{{ $item['id'] }}">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </td>
                        <td>
                            {{--<p class="mb-0 mt-4"> {{ $item['price'] * $item['quantity'] }}  $</p>--}}
                            <p class="mb-0 mt-4" id="totalsession-{{ $item['id'] }}">{{ $item['price'] * $item['quantity'] }} $</p>

                        </td>
                        <td>
                        <button class="btn btn-md rounded-circle bg-light border mt-4 btn-remove" data-product-id="{{ $item['id'] }}" id="btn-remove-{{ $item['id'] }}">
    <i class="fa fa-times text-danger"></i>
</button>


                        </td>
                    </tr>
                @endif
                @endforeach

                </tbody>
            </table>
        </div>
        {{--<div class="mt-5">
            <input type="text" class="border-0 border-bottom rounded me-5 py-3 mb-4" placeholder="Coupon Code">
            <button class="btn border-secondary rounded-pill px-4 py-3 text-primary" type="button">Apply Coupon</button>
        </div>--}}
        <div class="row g-4 justify-content-end">
            <div class="col-8"></div>
            <div class="col-sm-8 col-md-7 col-lg-6 col-xl-4">
                <div class="bg-light rounded">
                    <div class="p-4">
                        <h1 class="display-6 mb-4">Cart <span class="fw-normal">Total</span></h1>
                        <div class="d-flex justify-content-between mb-4">
                            <h5 class="mb-0 me-4">Subtotal:</h5>
                            <p class="mb-0" id="Subtotal">{{$totalPrice}}$</p>
                        </div>
                        {{--<div class="d-flex justify-content-between">
                            <h5 class="mb-0 me-4">Shipping</h5>
                            <div class="">
                                <p class="mb-0">Flat rate: $3.00</p>
                            </div>
                        </div>
                        <p class="mb-0 text-end">Shipping to Ukraine.</p>--}}
                    </div>
                    <div class="py-4 mb-4 border-top border-bottom d-flex justify-content-between">
                        <h5 class="mb-0 ps-4 me-4">Total</h5>
                        <p class="mb-0 pe-4" id="Total">{{$totalPrice  }}$</p>
                    </div>
                    {{--<button class="btn border-secondary rounded-pill px-4 py-3 text-primary text-uppercase mb-4 ms-4" type="button" >Proceed Checkout</button>--}}
                    <a href="{{ route('control_panel_dashboard.checkout') }}" class="btn border-secondary rounded-pill px-4 py-3 text-primary text-uppercase mb-4 ms-4">
    Proceed Checkout
</a>

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
        $('.btn-minus').click(function(){
            var productId = $(this).data('product-id');
          //alert(productId);
            var quantity = parseInt($('#quantity-' + productId).val());
            if(quantity > 1) {
                var newQuantity = quantity - 1;
                $('#quantity-' + productId).val(newQuantity);
                updateCartQuantity(productId, newQuantity); // تحديث الكمية إلى السيرفر أو الجلسة
            }
        });

        // زيادة الكمية
        $('.btn-plus').click(function(){
            var productId = $(this).data('product-id');
          //  alert(productId);
            var quantity = parseInt($('#quantity-' + productId).val());
            var newQuantity = quantity + 1;
            $('#quantity-' + productId).val(newQuantity);
            updateCartQuantity(productId, newQuantity); // تحديث الكمية إلى السيرفر أو الجلسة
        });

        // تحديث الكمية في السلة بناءً على حالة المستخدم
        function updateCartQuantity(productId, quantity) {
            @if(Auth::check())  // إذا كان المستخدم مسجلاً دخولًا
                // إرسال الكمية إلى السيرفر لتحديث قاعدة البيانات
                $.ajax({
                    url: "{{ route('cart.update') }}",  // تعديل الرابط إلى المسار الذي يتعامل مع التحديث
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        product_id: productId,
                        quantity: quantity
                    },
                    success: function(response) {
                        console.log(response.totalPrice);
                        // يمكنك إضافة ما تود فعله بعد نجاح العملية، مثل عرض رسالة نجاح
                     $('#total-' + productId).text(response.totalPrice + ' $');  // تحديث Total المنتج في الصفحة
                     $('#Subtotal').text(response.all_total + ' $');
                        // $('#Total').text(response.all_total + 3 + ' $');
                         $('#Total').text(response.all_total + ' $');
                         $('#catitemscount').text(response.totalItems );
                         
                    }
                });
            @else
                            $.ajax({
                    url: "{{ route('cart.update.session') }}",  // مسار جديد لمعالجة السلة في الجلسة
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        product_id: productId,
                        quantity: quantity
                    },
                    success: function(response) {
                         // يمكن إضافة أي إجراء بعد نجاح التحديث في الجلسة
                         console.log(response.cart[productId].price);
                         console.log(response.cart[productId].quantity);
                         var totalprice = response.cart[productId].price * response.cart[productId].quantity;
                         console.log(totalprice);
                         $('#totalsession-' + productId).text(totalprice + ' $');  // تحديث Total المنتج في الصفحة
                         $('#Subtotal').text(response.total_price + ' $');
                       //  $('#Total').text(response.total_price + 3 + ' $');
                         $('#Total').text(response.total_price  + ' $');
                         $('#catitemscount').text(response.totalQuantity);


                     }
                });

             @endif
        }


        //delete product
            // عندما يتم الضغط على زر الحذف
    $('.btn-remove').click(function(){
        var productId = $(this).data('product-id');

        // التحقق إذا كان المستخدم مسجلاً دخولًا
        @if(Auth::check())
            // إرسال الطلب لحذف المنتج من قاعدة البيانات
            $.ajax({
                url: "{{ route('cart.remove') }}",  // المسار الذي يحذف المنتج من قاعدة البيانات
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    product_id: productId
                },
                success: function(response) {
                    // بعد النجاح، تحديث واجهة المستخدم أو القيام بأي إجراء
                    alert('Product removed from cart.');
                    location.reload();  // تحديث الصفحة لإعادة تحميل السلة
                }
            });
        @else
       // alert(productId);
            // إذا لم يكن المستخدم مسجلاً دخولًا، نقوم بحذف المنتج من الجلسة
            $.ajax({
                    url: "{{ route('cart.remove.session') }}",  // مسار جديد لمعالجة السلة في الجلسة
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        product_id: productId,
                     },
                    success: function(response) {
                        // يمكن إضافة أي إجراء بعد نجاح التحديث في الجلسة
                        alert('Product removed from cart.');
                        location.reload();  
                    }
                });
        @endif
    });




    // تحديث ملخص السلة (SubTotal و Total)
    function updateCartSummary() {
        var subtotal = 0;
        $(".total-price").each(function() {
            subtotal += parseFloat($(this).text().replace('$', ''));
        });
        $('#subtotal').text(subtotal.toFixed(2) + ' $');  // تحديث الـ Subtotal

        var shipping = 3.00;  // قيمة الشحن الثابتة
        var total = subtotal + shipping;
        $('#total').text(total.toFixed(2) + ' $');  // تحديث الـ Total
    }





    });
</script>

@endsection
