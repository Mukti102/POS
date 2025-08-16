@extends('layouts.main')
@section('content')
    <x-alert />
    <div>
        <x-layout.page-header title="Tambah Mutasi" subtitle="View/Search Mutasi Stock">
        </x-layout.page-header>
        <form action="{{ route('mutasi-stock.store') }}" method="POST" class="card">
            @csrf
            <div class="card-body">
                <div class="row">
                    <x-form.input-text label="Tanggal" type="date" name="date" col="col-lg-3 col-sm-6 col-12" required />

                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Cabang Asal</label>
                            <select class="form-select" id="from_branch_id" name="from_branch_id" required>
                                <option selected disabled>Pilih Cabang Asal</option>
                                @foreach ($branches as $branch)
                                    <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Cabang Tujuan</label>
                            <select class="select" id="to_branch_id" name="to_branch_id" required>
                                <option selected disabled>Pilih Cabang Tujuan</option>
                                @foreach ($branches as $branch)
                                    <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- <div class="col-lg-3 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Status</label>
                            <select class="select" name="status" required>
                                <option selected disabled>Choose Status</option>
                                <option value="completed">Completed</option>
                                <option value="inprogress">Inprogress</option>
                            </select>
                        </div>
                    </div> --}}

                    <div class="col-lg-12 col-sm-6 col-12">
                        <ul class="tabs owl-carousel owl-theme owl-product border-0">
                            @foreach ($categories as $key => $category)
                                <li class="category-tab {{ $key === 0 ? 'active' : '' }}"
                                    data-category="{{ $category->id }}">
                                    <div class="product-details">
                                        <img src="{{ asset('storage/' . $category->photo) }}" alt="img" />
                                        <h6>{{ $category->name }}</h6>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div class="row">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>QTY</th>
                                    <th>Price</th>
                                    <th>Stock</th>
                                    <th>Total Cost ($)</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="product-table-body">
                                <tr>
                                    <td colspan="6" class="text-center">
                                        <p class="mb-0">Pilih cabang asal terlebih dahulu untuk melihat produk</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12 float-md-right">
                        <div class="total-order">
                            <ul>
                                <li class="total">
                                    <h4>Grand Total</h4>
                                    <h5 id="grand-total">Rp</h5>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Description</label>
                            <textarea class="form-control" name="description" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <button type="submit" class="btn btn-submit me-2">Submit</button>
                        <a href="{{ route('mutasi-stock.index') }}" class="btn btn-cancel">Cancel</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {


            function formatRupiah(angka, withDecimal = false) {
                return new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: withDecimal ? 2 : 0,
                    maximumFractionDigits: withDecimal ? 2 : 0,
                }).format(angka);
            }


            // Category tab functionality
            document.querySelectorAll('.category-tab').forEach(tab => {
                tab.addEventListener('click', function() {
                    // Remove active class from all tabs
                    document.querySelectorAll('.category-tab').forEach(t => t.classList.remove(
                        'active'));
                    this.classList.add('active');

                    const catId = this.dataset.category;

                    // Show only products from selected category
                    document.querySelectorAll('.product-row').forEach(row => {
                        if (row.dataset.category === catId) {
                            row.classList.remove('d-none');
                        } else {
                            row.classList.add('d-none');
                        }
                        // Initialize calculations
                        updateGrandTotal();
                    });
                });
            });

            // Plus button functionality
            document.addEventListener('click', function(e) {
                if (e.target.closest('.plus-btn')) {
                    const input = e.target.closest('.input-group').querySelector('.qty-input');
                    const max = parseInt(input.getAttribute('max'));
                    const current = parseInt(input.value);

                    if (current < max) {
                        input.value = current + 1;
                        updateRowTotal(input);
                        updateGrandTotal();
                    }
                }
            });

            // Minus button functionality
            document.addEventListener('click', function(e) {
                if (e.target.closest('.minus-btn')) {
                    const input = e.target.closest('.input-group').querySelector('.qty-input');
                    const min = parseInt(input.getAttribute('min'));
                    const current = parseInt(input.value);

                    if (current > min) {
                        input.value = current - 1;
                        updateRowTotal(input);
                        updateGrandTotal();
                    }
                }
            });

            // Quantity input change
            document.addEventListener('input', function(e) {
                if (e.target.classList.contains('qty-input')) {
                    const input = e.target;
                    const max = parseInt(input.getAttribute('max'));
                    const min = parseInt(input.getAttribute('min'));
                    let value = parseInt(input.value);

                    // Validate input
                    if (isNaN(value) || value < min) {
                        input.value = min;
                        value = min;
                    } else if (value > max) {
                        input.value = max;
                        value = max;
                    }

                    updateRowTotal(input);
                    updateGrandTotal();
                }
            });

            // Delete row functionality
            document.addEventListener('click', function(e) {
                if (e.target.closest('.delete-set')) {
                    const row = e.target.closest('tr');
                    const input = row.querySelector('.qty-input');
                    input.value = 0;
                    updateRowTotal(input);
                    updateGrandTotal();
                }
            });

            // Branch validation
            const fromBranchSelect = document.getElementById('from_branch_id');
            const toBranchSelect = document.getElementById('to_branch_id');

            function validateBranches() {
                const fromValue = fromBranchSelect.value;
                const toValue = toBranchSelect.value;

                if (fromValue && toValue && fromValue === toValue) {
                    alert('Cabang asal dan cabang tujuan tidak boleh sama!');
                    toBranchSelect.value = '';
                }
            }

            // Branch change functionality - Load products dynamically
            fromBranchSelect.addEventListener('change', function() {
                const branchId = this.value;
                if (branchId) {
                    loadProductsByBranch(branchId);
                    validateBranches();
                } else {
                    clearProductTable();
                }
            });
            toBranchSelect.addEventListener('change', validateBranches);

            // Form submission validation
            document.querySelector('form').addEventListener('submit', function(e) {
                const fromBranch = document.getElementById('from_branch_id').value;
                const toBranch = document.getElementById('to_branch_id').value;

                if (!fromBranch || !toBranch) {
                    e.preventDefault();
                    alert('Silakan pilih cabang asal dan cabang tujuan!');
                    return;
                }

                if (fromBranch === toBranch) {
                    e.preventDefault();
                    alert('Cabang asal dan cabang tujuan tidak boleh sama!');
                    return;
                }

                // Check if any products selected
                let hasProducts = false;
                document.querySelectorAll('.qty-input').forEach(input => {
                    if (parseInt(input.value) > 0) {
                        hasProducts = true;
                    }
                });

                if (!hasProducts) {
                    e.preventDefault();
                    alert('Silakan pilih minimal satu produk untuk dimutasi!');
                    return;
                }
            });

            // Update row total
            function updateRowTotal(input) {
                const row = input.closest('tr');
                const quantity = parseInt(input.value) || 0;
                const price = parseFloat(input.dataset.price) || 0;
                const total = quantity * price;

                // cari hidden input di row ini
                const priceInput = row.querySelector('.input-price');
                priceInput.value = total;

                const totalCell = row.querySelector('.total-cost');
                totalCell.textContent = formatRupiah(total);
            }

            // Update grand total
            function updateGrandTotal() {
                let total = 0;

                document.querySelectorAll('.qty-input').forEach(input => {
                    if (!input.closest('tr').classList.contains('d-none')) {
                        const quantity = parseInt(input.value) || 0;
                        const price = parseFloat(input.dataset.price) || 0;
                        total += quantity * price;
                    }
                });

                document.getElementById('grand-total').textContent = formatRupiah(total);
            }

            // Load products by branch via AJAX
            function loadProductsByBranch(branchId) {
                const tableBody = document.getElementById('product-table-body');

                // Show loading
                tableBody.innerHTML = `
                    <tr>
                        <td colspan="6" class="text-center">
                            <div class="d-flex justify-content-center align-items-center">
                                <div class="spinner-border spinner-border-sm me-2" role="status"></div>
                                <span>Loading products...</span>
                            </div>
                        </td>
                    </tr>
                `;

                // AJAX request
                fetch(`{{ route('mutasi-stock.get-products') }}?branch_id=${branchId}`, {
                        method: 'GET',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute(
                                'content') || document.querySelector('input[name="_token"]').value
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            renderProducts(data.categories);
                            updateGrandTotal();
                        } else {
                            throw new Error(data.message || 'Failed to load products');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        tableBody.innerHTML = `
                        <tr>
                            <td colspan="6" class="text-center text-danger">
                                <p class="mb-0">Error loading products. Please try again.</p>
                            </td>
                        </tr>
                    `;
                    });
            }

            // Render products to table
            function renderProducts(categories) {
                const tableBody = document.getElementById('product-table-body');
                let html = '';

                if (!categories || categories.length === 0) {
                    html = `
                        <tr>
                            <td colspan="6" class="text-center">
                                <p class="mb-0">No products found for this branch</p>
                            </td>
                        </tr>
                    `;
                } else {
                    categories.forEach((category, categoryIndex) => {
                        category.products.forEach(product => {
                            const isVisible = categoryIndex === 0 ? '' : 'd-none';
                            const stock = product.pivot ? product.pivot.stock : 0;
                            const price = product.pivot ? product.pivot.cost_price : 0;

                            html += `
                                <tr class="product-row ${isVisible}" data-category="${category.id}" data-product-id="${product.id}">
                                    <td class="productimgname">
                                        <a class="product-img">
                                            <img src="/storage/${product.image}" alt="product" />
                                        </a>
                                        <a href="javascript:void(0);">${product.name}</a>
                                    </td>
                                    <td>
                                        <div class="input-group form-group mb-0">
                                            <button type="button" class="scanner-set plus-btn input-group-text">
                                                <img src="/assets/img/icons/plus1.svg" alt="img" />
                                            </button>
                                            <input type="number" 
                                                   name="products[${product.id}][quantity]" 
                                                   value="0" 
                                                   class="form-control calc-no qty-input" 
                                                   min="0" 
                                                   max="${stock}"
                                                   data-price="${price}">
                                            <button type="button" class="scanner-set minus-btn input-group-text">
                                                <img src="/assets/img/icons/minus.svg" alt="img" />
                                            </button>
                                        </div>
                                        <input type="hidden" name="products[${product.id}][product_id]" value="${product.id}">
                                        <input type="hidden" class="input-price" id="input-price"
                                         value="${price}"
                                        name="products[${product.id}][price]" >
                                    </td>
                                    <td class="product-price">${formatRupiah(price)}</td>
                                    <td class="product-stock">${stock}</td>
                                    <td class="total-cost">Rp.0</td>
                                    <td>
                                        <a href="javascript:void(0);" class="delete-set">
                                            <img src="/assets/img/icons/delete.svg" alt="svg" />
                                        </a>
                                    </td>
                                </tr>
                            `;
                        });
                    });
                }

                tableBody.innerHTML = html;

                // Update category tabs visibility
                updateCategoryTabs(categories);
            }

            // Update category tabs
            function updateCategoryTabs(categories) {
                const categoryTabs = document.querySelectorAll('.category-tab');

                categoryTabs.forEach(tab => {
                    const categoryId = tab.dataset.category;
                    const categoryExists = categories.some(cat => cat.id == categoryId);

                    if (categoryExists) {
                        tab.style.display = 'block';
                        // Set first category as active
                        if (categories[0] && categories[0].id == categoryId) {
                            tab.classList.add('active');
                        } else {
                            tab.classList.remove('active');
                        }
                    } else {
                        tab.style.display = 'none';
                        tab.classList.remove('active');
                    }
                });
            }

            // Clear product table
            function clearProductTable() {
                document.getElementById('product-table-body').innerHTML = `
                    <tr>
                        <td colspan="6" class="text-center">
                            <p class="mb-0">Pilih cabang asal terlebih dahulu untuk melihat produk</p>
                        </td>
                    </tr>
                `;
                updateGrandTotal();
            }
        });
    </script>
@endpush
