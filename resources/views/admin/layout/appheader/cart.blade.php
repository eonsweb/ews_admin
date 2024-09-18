<div class="header-element cart-dropdown">
    <!-- Start::header-link|dropdown-toggle -->
    <a href="javascript:void(0);" class="header-link dropdown-toggle" data-bs-auto-close="outside" data-bs-toggle="dropdown">
        <i class="bx bx-cart header-link-icon"></i>
        <span class="badge bg-primary rounded-pill header-icon-badge" id="cart-icon-badge">5</span>
    </a>
    <!-- End::header-link|dropdown-toggle -->
    <!-- Start::main-header-dropdown -->
    <div class="main-header-dropdown dropdown-menu dropdown-menu-end" data-popper-placement="none">
        <div class="p-3">
            <div class="d-flex align-items-center justify-content-between">
                <p class="mb-0 fs-17 fw-semibold">Cart Items</p>
                <span class="badge bg-success-transparent" id="cart-data">5 Items</span>
            </div>
        </div>
        <div><hr class="dropdown-divider"></div>
        <ul class="list-unstyled mb-0" id="header-cart-items-scroll">
            <li class="dropdown-item">
                <div class="d-flex align-items-start cart-dropdown-item">
                    <img src="{{ asset('admin/assets/images/ecommerce/jpg/1.jpg') }}" alt="img" class="avatar avatar-sm avatar-rounded br-5 me-3">
                    <div class="flex-grow-1">
                        <div class="d-flex align-items-start justify-content-between mb-0">
                            <div class="mb-0 fs-13 text-dark fw-semibold">
                                <a href="cart.html">SomeThing Phone</a>
                            </div>
                            <div>
                                <span class="text-black mb-1">$1,299.00</span>
                                <a href="javascript:void(0);" class="header-cart-remove float-end dropdown-item-close"><i class="ti ti-trash"></i></a>
                            </div>
                        </div>
                        <div class="min-w-fit-content d-flex align-items-start justify-content-between">
                            <ul class="header-product-item d-flex">
                                <li>Metallic Blue</li>
                                <li>6gb Ram</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </li>
            <li class="dropdown-item">
                <div class="d-flex align-items-start cart-dropdown-item">
                    <img src="{{ asset('admin/assets/images/ecommerce/jpg/3.jpg') }}" alt="img" class="avatar avatar-sm avatar-rounded br-5 me-3">
                    <div class="flex-grow-1">
                        <div class="d-flex align-items-start justify-content-between mb-0">
                            <div class="mb-0 fs-13 text-dark fw-semibold">
                                <a href="cart.html">Stop Watch</a>
                            </div>
                            <div>
                                <span class="text-black mb-1">$179.29</span>
                                <a href="javascript:void(0);" class="header-cart-remove float-end dropdown-item-close"><i class="ti ti-trash"></i></a>
                            </div>
                        </div>
                        <div class="min-w-fit-content d-flex align-items-start justify-content-between">
                            <ul class="header-product-item">
                                <li>Analog</li>
                                <li><span class="badge bg-pink-transparent fs-10">Free shipping</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </li>
            <li class="dropdown-item">
                <div class="d-flex align-items-start cart-dropdown-item">
                    <img src="{{ asset('admin/assets/images/ecommerce/jpg/5.jpg') }}" alt="img" class="avatar avatar-sm avatar-rounded br-5 me-3">
                    <div class="flex-grow-1">
                        <div class="d-flex align-items-start justify-content-between mb-0">
                            <div class="mb-0 fs-13 text-dark fw-semibold">
                                <a href="cart.html">Photo Frame</a>
                            </div>
                            <div>
                                <span class="text-black mb-1">$29.00</span>
                                <a href="javascript:void(0);" class="header-cart-remove float-end dropdown-item-close"><i class="ti ti-trash"></i></a>
                            </div>
                        </div>
                        <div class="min-w-fit-content d-flex align-items-start justify-content-between">
                            <ul class="header-product-item d-flex">
                                <li>Decorative</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </li>
            <li class="dropdown-item">
                <div class="d-flex align-items-start cart-dropdown-item">
                    <img src="{{ asset('admin/assets/images/ecommerce/jpg/4.jpg') }}" alt="img" class="avatar avatar-sm avatar-rounded br-5 me-3">
                    <div class="flex-grow-1">
                        <div class="d-flex align-items-start justify-content-between mb-0">
                            <div class="mb-0 fs-13 text-dark fw-semibold">
                                <a href="cart.html">Kikon Camera</a>
                            </div>
                            <div>
                                <span class="text-black mb-1">$4,999.00</span>
                                <a href="javascript:void(0);" class="header-cart-remove float-end dropdown-item-close"><i class="ti ti-trash"></i></a>
                            </div>
                        </div>
                        <div class="min-w-fit-content d-flex align-items-start justify-content-between">
                            <ul class="header-product-item d-flex">
                                <li>Black</li>
                                <li>50MM</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </li>
            <li class="dropdown-item">
                <div class="d-flex align-items-start cart-dropdown-item">
                    <img src="{{ asset('admin/assets/images/ecommerce/jpg/6.jpg') }}" alt="img" class="avatar avatar-sm avatar-rounded br-5 me-3">
                    <div class="flex-grow-1">
                        <div class="d-flex align-items-start justify-content-between mb-0">
                            <div class="mb-0 fs-13 text-dark fw-semibold">
                                <a href="cart.html">Canvas Shoes</a>
                            </div>
                            <div>
                                <span class="text-black mb-1">$129.00</span>
                                <a href="javascript:void(0);" class="header-cart-remove float-end dropdown-item-close"><i class="ti ti-trash"></i></a>
                            </div>
                        </div>
                        <div class="d-flex align-items-start justify-content-between">
                            <ul class="header-product-item d-flex">
                                <li>Gray</li>
                                <li>Sports</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
        <div class="p-3 empty-header-item border-top">
            <div class="d-grid">
                <a href="checkout.html" class="btn btn-primary">Proceed to checkout</a>
            </div>
        </div>
        <div class="p-5 empty-item d-none">
            <div class="text-center">
                <span class="avatar avatar-xl avatar-rounded bg-warning-transparent">
                    <i class="ri-shopping-cart-2-line fs-2"></i>
                </span>
                <h6 class="fw-bold mb-1 mt-3">Your Cart is Empty</h6>
                <span class="mb-3 fw-normal fs-13 d-block">Add some items to make me happy :)</span>
                <a href="products.html" class="btn btn-primary btn-wave btn-sm m-1" data-abc="true">continue shopping <i class="bi bi-arrow-right ms-1"></i></a>
            </div>
        </div>
    </div>
    <!-- End::main-header-dropdown -->
</div>