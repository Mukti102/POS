@extends('layouts.pos')
@section('content')
    <div id="global-loader">
        <div class="whirly-loader"></div>
    </div>
    <div class="main-wrappers">
        @include('partials.headerpos')
        <div class="page-wrapper ms-0">
            <div class="content">
                <div class="row">
                    <div class="col-lg-8 col-sm-12 tabs_wrapper">
                        <div class="page-header">
                            <div class="page-title">
                                <h4>Categories</h4>
                                <h6>Manage your purchases</h6>
                            </div>
                        </div>
                        <ul class="tabs owl-carousel owl-theme owl-product border-0">
                            @foreach ($categories as $key => $category)
                                <li class="{{ $key === 0 ? 'active' : '' }}" id="{{ $category->id }}">
                                    <div class="product-details">
                                        <img src="/assets/img/product/product62.png" alt="img" />
                                        <h6>{{ $category->name }}</h6>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                        <div class="tabs_container">
                            @foreach ($categories as $key => $category)
                                <div class="tab_content {{ $key == 0 ? 'active' : '' }}" data-tab="{{ $category->id }}">
                                    <div class="row">
                                        @foreach ($category->products as $product)
                                            <div class="col-lg-3 col-sm-6 d-flex">
                                                <div class="productset flex-fill" data-id="{{ $product->id }}"
                                                    data-name="{{ $product->name }}"
                                                    data-price="{{ $product->selling_price }}"
                                                    data-category="{{ $product->category->name }}"
                                                    data-stock="{{ $product->stock }}"
                                                    data-image="assets/img/product/product29.jpg">
                                                    <div class="productsetimg">
                                                        <img src="assets/img/product/product29.jpg" alt="img" />
                                                        <h6>Qty: {{ $product->stock }}</h6>
                                                        <div class="check-product">
                                                            <i class="fa fa-check"></i>
                                                        </div>
                                                    </div>
                                                    <div class="productsetcontent">
                                                        <h5>{{ $product->category->name }}</h5>
                                                        <h4>{{ $product->name }}</h4>
                                                        <h6>${{ number_format($product->selling_price, 2) }}</h6>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <form action="{{ route('pos.checkout') }}" class="col-lg-4 col-sm-12" method="POST" id="checkoutForm">
                        @csrf
                        <input type="hidden" name="cart_data" id="cartData">
                        <input type="hidden" name="customer_id" id="selectedCustomerId">
                        <input type="hidden" name="subtotal" id="subtotalInput">
                        <input type="hidden" name="tax" id="taxInput">
                        <input type="hidden" name="total" id="totalInput">

                        <div class="order-list">
                            <div class="orderid">
                                <h4>Order List</h4>
                                <h5>Transaction id : #<span
                                        id="transactionId">{{ str_pad(rand(10000, 99999), 5, '0', STR_PAD_LEFT) }}</span>
                                </h5>
                            </div>
                            <div class="actionproducts">
                                <ul>
                                    <li>
                                        <a href="javascript:void(0);" class="deletebg confirm-text" id="clearAllCart"><img
                                                src="assets/img/icons/delete-2.svg" alt="img" /></a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false"
                                            class="dropset">
                                            <img src="assets/img/icons/ellipise1.svg" alt="img" />
                                        </a>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton"
                                            data-popper-placement="bottom-end">
                                            <li>
                                                <a href="#" class="dropdown-item" id="holdTransaction">Hold
                                                    Transaction</a>
                                            </li>
                                            <li>
                                                <a href="#" class="dropdown-item" id="printReceipt">Print Receipt</a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card card-order">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <a href="javascript:void(0);" class="btn btn-adds" data-bs-toggle="modal"
                                            data-bs-target="#create"><i class="fa fa-plus me-2"></i>Add Customer</a>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="select-split">
                                            <div class="select-group w-100">
                                                <select class="js-example-basic-single" id="customerSelect">
                                                    <option value="">Select Customer</option>
                                                    @foreach ($costumers as $costumer)
                                                        <option value="{{ $costumer->id }}">{{ $costumer->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="split-card"></div>
                            <div class="card-body pt-0">
                                <div class="totalitem">
                                    <h4 id="totalItemsText">Total items : 0</h4>
                                    <a href="javascript:void(0);" id="clearAll">Clear all</a>
                                </div>
                                <div class="product-table" id="cartItems">
                                    {{--  --}}
                                </div>
                            </div>
                            <div class="split-card"></div>
                            <div class="card-body pt-0 pb-2">
                                <div class="setvalue">
                                    <ul>
                                        <li>
                                            <h5>Subtotal</h5>
                                            <h6 id="subtotalDisplay">Rp0.00</h6>
                                        </li>
                                        <li>
                                            <h5>Tax (0%)</h5>
                                            <h6 id="taxDisplay">Rp.0.00</h6>
                                        </li>
                                        <li class="total-value">
                                            <h5>Total</h5>
                                            <h6 id="totalDisplay">Rp.0.00</h6>
                                        </li>
                                    </ul>
                                </div>

                                <div class="row">
                                    <x-form.input-text label="Bayar" placeholder="Rp." name="paid" />
                                    <x-form.input-text label="Kembali" placeholder="Rp." name="change" />
                                </div>

                                <button type="submit" style="width: 100%" class="btn-totallabel" id="checkoutBtn"
                                    disabled>
                                    <h5>Checkout</h5>
                                    <h6 id="checkoutTotal">Rp.0</h6>
                                </button>
                                <div class="btn-pos">
                                    <ul>
                                        <li>
                                            <a class="btn" data-bs-toggle="modal" data-bs-target="#recents"><img
                                                    src="assets/img/icons/transcation.svg" alt="img"
                                                    class="me-1" />
                                                Transaction</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Customer Modal -->
    <div class="modal fade" id="create" tabindex="-1" aria-labelledby="create" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create Customer</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="{{ route('costumer.store') }}" method="POST" class="modal-body" id="createCustomerForm">
                    @csrf
                    <div class="row">
                        <x-form.input-text label="Nama Costumer" name="name" placeholder="Masukkan Nama Costumer" />
                        <x-form.input-text label="Nomor Telephone" name="phone"
                            placeholder="Masukkan Nomor telephone" />
                        <x-form.input-text label="Alamat" name="address" placeholder="Masukkan Alamat" />
                    </div>
                    <div class="col-lg-12">
                        <button type="submit" class="btn btn-submit me-2">Submit</button>
                        <a class="btn btn-cancel" data-bs-dismiss="modal">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Product Modal -->
    <div class="modal fade" id="edit" tabindex="-1" aria-labelledby="edit" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Product Quantity</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Product Name</label>
                                <input type="text" id="editProductName" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Quantity</label>
                                <input type="number" id="editProductQty" class="form-control" min="1">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <button type="button" class="btn btn-submit me-2" id="updateProductQty">Update</button>
                            <a class="btn btn-cancel" data-bs-dismiss="modal">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-pos.recent-transaction :transactions="$transactions" />
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            function formatRupiah(angka, withDecimal = false) {
                return new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: withDecimal ? 2 : 0,
                    maximumFractionDigits: withDecimal ? 2 : 0,
                }).format(angka);
            }

            // Global variables
            let cart = [];
            const TAX_RATE = 0.10; // 10% tax
            let editingProductId = null;

            // Initialize
            updateCartDisplay();

            // Tab functionality
            $('.tabs li').on('click', function() {
                const tabId = $(this).attr('id');
                $('.tabs li').removeClass('active');
                $(this).addClass('active');

                $('.tab_content').removeClass('active');
                $(`.tab_content[data-tab="${tabId}"]`).addClass('active');
            });

            // Add product to cart
            $('.productset').on('click', function() {
                const productData = {
                    id: $(this).data('id'),
                    name: $(this).data('name'),
                    price: parseFloat($(this).data('price')),
                    category: $(this).data('category'),
                    stock: parseInt($(this).data('stock')),
                    image: $(this).data('image')
                };

                addToCart(productData);
            });

            // Customer selection
            $('#customerSelect').on('change', function() {
                $('#selectedCustomerId').val($(this).val());
                updateCheckoutButton();
            });

            // Increment/Decrement quantity
            $(document).on('click', '.button-plus', function() {
                const $input = $(this).closest('.input-groups').find('.quantity-field');
                const productId = $(this).closest('li').data('product-id');
                const newQty = parseInt($input.val()) + 1;

                updateCartItemQuantity(productId, newQty);
                $input.val(newQty);
            });

            $(document).on('click', '.button-minus', function() {
                const $input = $(this).closest('.input-groups').find('.quantity-field');
                const productId = $(this).closest('li').data('product-id');
                const newQty = parseInt($input.val()) - 1;

                if (newQty > 0) {
                    updateCartItemQuantity(productId, newQty);
                    $input.val(newQty);
                }
            });

            // Delete product from cart
            $(document).on('click', '.delete-item', function() {
                const productId = $(this).closest('li').data('product-id');
                removeFromCart(productId);
            });

            // Clear all cart
            $('#clearAll, #clearAllCart').on('click', function() {

                Swal.fire({
                    title: "Are you sure?",
                    text: "Hapus Semua!",
                    type: "warning",
                    showCancelButton: !0,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!",
                    confirmButtonClass: "btn btn-primary",
                    cancelButtonClass: "btn btn-danger ml-1",
                    cancelButtonText: "Cancel"
                }).then((result) => {
                    if (result.isConfirmed) {
                        cart = [];
                        updateCartDisplay();
                    }
                });

            });

            // Edit product quantity modal
            $(document).on('click', '.edit-item', function() {
                const productId = $(this).closest('li').data('product-id');
                const cartItem = cart.find(item => item.id == productId);

                if (cartItem) {
                    editingProductId = productId;
                    $('#editProductName').val(cartItem.name);
                    $('#editProductQty').val(cartItem.quantity);
                    $('#edit').modal('show');
                }
            });

            // Update product quantity from modal
            $('#updateProductQty').on('click', function() {
                const newQty = parseInt($('#editProductQty').val());
                if (newQty > 0 && editingProductId) {
                    updateCartItemQuantity(editingProductId, newQty);
                    $('#edit').modal('hide');
                }
            });

            // Form submission
            $('#checkoutForm').on('submit', function(e) {
                e.preventDefault();

                if (cart.length === 0) {
                    alert('Cart is empty!');
                    return;
                }

                if (!$('#selectedCustomerId').val()) {
                    alert('Please select a customer!');
                    return;
                }

                // Prepare data for submission
                const cartData = JSON.stringify(cart);
                $('#cartData').val(cartData);

                const totals = calculateTotals();
                $('#subtotalInput').val(totals.subtotal);
                $('#taxInput').val(totals.tax);
                $('#totalInput').val(totals.total);

                // Submit form
                this.submit();
            });

            // Create customer form
            $('#createCustomerForm').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.success) {
                            // Add new customer to select dropdown
                            $('#customerSelect').append(
                                `<option value="${response.customer.id}">${response.customer.name}</option>`
                            );

                            // Select the new customer
                            $('#customerSelect').val(response.customer.id).trigger('change');

                            // Close modal and reset form
                            $('#create').modal('hide');
                            $('#createCustomerForm')[0].reset();

                            alert('Customer created successfully!');
                        }
                    },
                    error: function(xhr) {
                        alert('Error creating customer: ' + xhr.responseJSON.message);
                    }
                });
            });

            // Hold transaction
            $('#holdTransaction').on('click', function() {
                if (cart.length > 0) {
                    localStorage.setItem('heldTransaction', JSON.stringify({
                        cart: cart,
                        customerId: $('#selectedCustomerId').val(),
                        transactionId: $('#transactionId').text()
                    }));
                    alert('Transaction held successfully!');
                }
            });

            // Print receipt
            $('#printReceipt').on('click', function() {
                if (cart.length > 0) {
                    printReceipt();
                }
            });

            // Functions
            function addToCart(product) {
                const existingItem = cart.find(item => item.id === product.id);

                if (existingItem) {
                    if (existingItem.quantity < product.stock) {
                        existingItem.quantity++;
                    } else {
                        alert('Insufficient stock!');
                        return;
                    }
                } else {
                    cart.push({
                        id: product.id,
                        name: product.name,
                        price: product.price,
                        category: product.category,
                        image: product.image,
                        quantity: 1,
                        stock: product.stock
                    });
                }

                updateCartDisplay();
            }

            function removeFromCart(productId) {
                cart = cart.filter(item => item.id != productId);
                updateCartDisplay();
            }

            function updateCartItemQuantity(productId, newQuantity) {
                const cartItem = cart.find(item => item.id == productId);
                if (cartItem) {
                    if (newQuantity <= cartItem.stock) {
                        cartItem.quantity = newQuantity;
                        updateCartDisplay();
                    } else {
                        alert('Insufficient stock!');
                    }
                }
            }

            function updateCartDisplay() {
                const $cartItems = $('#cartItems');
                $cartItems.empty();

                if (cart.length === 0) {
                    $cartItems.html(`
                       <ul class="product-lists" >
                                        <!-- Cart items will be dynamically added here -->
                                        <li class="empty-cart" style="text-align: center; padding: 20px; color: #666;">
                                            <p>No items in cart</p>
                                        </li>
                                    </ul>
                    `);
                } else {
                    cart.forEach(item => {
                        const itemTotal = item.price * item.quantity;
                        $cartItems.append(`
                            


 <ul class="product-lists" >
                                <li data-product-id="${item.id}">
                        <div class="productimg">
                          <div class="productimgs">
                            <img
                              src="assets/img/product/product30.jpg"
                              alt="img"
                            />
                          </div>
                          <div class="productcontet">
                            <h4>
                               ${item.name}
                              <a
                                href="javascript:void(0);"
                                class="ms-2"
                                data-bs-toggle="modal"
                                data-bs-target="#edit"
                                ><img
                                  src="assets/img/icons/edit-5.svg"
                                  alt="img"
                              /></a>
                            </h4>
                            <div class="productlinkset">
                              <h5>${item.category}</h5>
                            </div>
                            <div class="increment-decrement">
                              <div class="input-groups">
                                 <div class="input-groups">
                                                <input type="button" value="-"
                                                    class="button-minus dec button" />
                                                <input type="text" name="child" value="${item.quantity}"
                                                    class="quantity-field" readonly />
                                                <input type="button" value="+"
                                                    class="button-plus inc button" />
                                            </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </li>
                      <li>${formatRupiah(itemTotal)}</li>
                      <li>
                        <a class="confirm-text" href="javascript:void(0);"
                          ><img src="assets/img/icons/delete-2.svg" alt="img"
                        /></a>
                      </li>
                      </ul>
                        `);
                    });
                }

                updateTotals();
                updateCheckoutButton();
            }

            function calculateTotals() {
                const subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
                const tax = subtotal * TAX_RATE;
                const total = subtotal + tax;

                return {
                    subtotal,
                    tax,
                    total
                };
            }

            function updateTotals() {
                const totals = calculateTotals();
                const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);

                $('#totalItemsText').text(`Total items : ${totalItems}`);
                $('#subtotalDisplay').text(`${formatRupiah(totals.subtotal)}`);
                $('#taxDisplay').text(`${formatRupiah(totals.tax)}`);
                $('#totalDisplay').text(`${formatRupiah(totals.total)}`);
                $('#checkoutTotal').text(`${formatRupiah(totals.total)}`);
            }


            function calculatePaidChange(total, paid) {
                const result = paid - total;
                return result;
            }

            const totalYouShouldPay = $('#totalDisplay').text();

           
            $('#paid').on('input', function() {
                const total = calculateTotals();
                const change = calculatePaidChange(total.total, $(this).val());
                $('#change').val(change);
            });


            function updateCheckoutButton() {
                const hasItems = cart.length > 0;
                const hasCustomer = $('#selectedCustomerId').val() !== '';

                $('#checkoutBtn').prop('disabled', !(hasItems && hasCustomer));
            }

            function printReceipt() {
                const totals = calculateTotals();
                const customerName = $('#customerSelect option:selected').text();
                const transactionId = $('#transactionId').text();

                let receiptHTML = `
                    <div style="width: 300px; font-family: monospace;">
                        <h3 style="text-align: center;">RECEIPT</h3>
                        <p>Transaction ID: #${transactionId}</p>
                        <p>Customer: ${customerName}</p>
                        <p>Date: ${new Date().toLocaleString()}</p>
                        <hr>
                `;

                cart.forEach(item => {
                    receiptHTML += `
                        <p>${item.name}<br>
                        ${item.quantity} x ${formatRupiah(item.price)} = ${formatRupiah((item.quantity * item.price))}</p>
                    `;
                });

                receiptHTML += `
                        <hr>
                        <p>Subtotal: ${ formatRupiah(totals.subtotal)}</p>
                        <p>Tax (10%): ${formatRupiah(totals.tax)}</p>
                        <p><strong>Total: ${formatRupiah(totals.total)}</strong></p>
                        <hr>
                        <p style="text-align: center;">Thank you!</p>
                    </div>
                `;

                const printWindow = window.open('', '_blank');
                printWindow.document.write(receiptHTML);
                printWindow.document.close();
                printWindow.print();
            }
        });
    </script>
@endpush
