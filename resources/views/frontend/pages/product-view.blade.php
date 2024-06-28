@extends('frontend.layouts.master')

@section('content')
    <!--=============================
                                    BREADCRUMB START
                                 ==============================-->
    <section class="fp__breadcrumb" style="background: url(images/counter_bg.jpg);">
        <div class="fp__breadcrumb_overlay">
            <div class="container">
                <div class="fp__breadcrumb_text">
                    <h1>menu Details</h1>
                    <ul>
                        <li><a href="{{ url('/') }}">home</a></li>
                        <li><a href="javascript:;">menu Details</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!--=============================
                                    BREADCRUMB END
                                ==============================-->


    <!--=============================
                                    MENU DETAILS START
                                ==============================-->
    <section class="fp__menu_details mt_115 xs_mt_85 mb_95 xs_mb_65">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 col-md-9 wow fadeInUp" data-wow-duration="1s">
                    <div class="exzoom hidden" id="exzoom">
                        <div class="exzoom_img_box fp__menu_details_images">
                            <ul class='exzoom_img_ul'>
                                <li><img class="zoom ing-fluid w-100" src="{{ asset($product->thumb_image) }}"
                                        alt="product"></li>
                                @foreach ($product->productImages as $image)
                                    <li><img class="zoom ing-fluid w-100" src="{{ asset($image->image) }}" alt="product">
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="exzoom_nav"></div>
                        <p class="exzoom_btn">
                            <a href="javascript:void(0);" class="exzoom_prev_btn"> <i class="far fa-chevron-left"></i>
                            </a>
                            <a href="javascript:void(0);" class="exzoom_next_btn"> <i class="far fa-chevron-right"></i>
                            </a>
                        </p>
                    </div>
                </div>
                <div class="col-lg-7 wow fadeInUp" data-wow-duration="1s">
                    <div class="fp__menu_details_text">
                        <h2>{!! $product->name !!}</h2>
                        <h3 class="price">
                            @if ($product->offer_price > 0)
                                {{ currencyPosition($product->offer_price) }}
                                <del>{{ currencyPosition($product->price) }}</del>
                            @else
                                {{ currencyPosition($product->price) }}
                            @endif
                        </h3>
                        <p class="short_description">{!! $product->short_description !!}
                        <form action="" id="v_add_to_cart_form">
                            @csrf
                            <input type="hidden" name="base_price" class="v_base_price"
                                value="{{ $product->offer_price > 0 ? $product->offer_price : $product->price }}">
                            <input type="hidden" name="product_id" value="{{ $product->id }}" id="">
                            @if ($product->productOptions()->exists())
                                <div class="details_size">
                                    <h5>select</h5>
                                    @foreach ($product->productOptions as $productOption)
                                        <div class="form-check">
                                            <input class="form-check-input v_product_option" type="radio"
                                                name="product_option" id="option-{{ $productOption->product_id }}"
                                                data-price="{{ $productOption->price }}" value="{{ $productOption->id }}">
                                            <label class="form-check-label" for="option-{{ $productOption->product_id }}">
                                                {{ $productOption->name }} <span>+
                                                    {{ currencyPosition($productOption->price) }}</span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            @if ($product->productAdds()->exists())
                                <div class="details_extra_item">
                                    <h5>select option <span>(optional)</span></h5>
                                    @foreach ($product->productAdds as $productAdd)
                                        <div class="form-check">
                                            <input class="form-check-input v_product_add" type="checkbox"
                                                id="add-{{ $productAdd->product_id }}" name="product_add[]"
                                                value="{{ $productAdd->id }}"
                                                data-price="{{ $productAdd->price }}">
                                            <label class="form-check-label"
                                                for="add-{{ $productAdd->product_id }}">
                                            {{ $productAdd->name }} <span>+
                                                {{ currencyPosition($productAdd->price) }}</span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            <div class="details_quentity">
                                <h5>Quantity</h5>
                                <div class="quentity_btn_area d-flex flex-wrapa align-items-center">
                                    <div class="quentity_btn">
                                        <button class="btn btn-danger v_decrement"><i class="fal fa-minus"></i></button>
                                        <input type="text" name="quantity" placeholder="1" value="1" readonly
                                            id="v_quantity">
                                        <button class="btn btn-success v_increment"><i class="fal fa-plus"></i></button>
                                    </div>
                                    <h3 id="v_total_price">
                                        {{ $product->offer_price > 0 ? currencyPosition($product->offer_price) : currencyPosition($product->price) }}
                                    </h3>
                                </div>
                            </div>
                        </form>

                        <ul class="details_button_area d-flex flex-wrap">
                            @if ($product->quantity === 0)
                            <li><a class="common_btn bg-danger" href="javascript:;">Out of Stock</a></li>
                            @else
                            <li><a class="common_btn v_submit_button" href="#">add to cart</a></li>
                            @endif
                        </ul>
                    </div>
                </div>
                    <div class="fp__menu_description_area mt_100 xs_mt_70 ">
                        <h3><b>Description</b></h3>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                                aria-labelledby="pills-home-tab" tabindex="0">
                                <div class="menu_det_description">
                                    <p>{!! $product->long_description !!}</p>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            @if (count($relatedProducts) > 0)
                <div class="fp__related_menu mt_90 xs_mt_60">
                    <h2>related item</h2>
                    <div class="row related_product_slider">
                        @foreach ($relatedProducts as $relatedProduct)
                            <div class="col-xl-3 wow fadeInUp" data-wow-duration="1s">
                                <div class="fp__menu_item">
                                    <div class="fp__menu_item_img">
                                        <img src="{{ asset($relatedProduct->thumb_image) }}"
                                            alt="{{ $relatedProduct->name }}" class="img-fluid w-100">
                                        <a class="category" href="#">{{ @$relatedProduct->category->name }}</a>
                                    </div>
                                    <div class="fp__menu_item_text">
                                        <a class="title"
                                            href="{{ route('product.show', $relatedProduct->slug) }}">{!! $relatedProduct->name !!}</a>
                                        <h5 class="price">
                                            @if ($relatedProduct->offer_price > 0)
                                                {{ currencyPosition($relatedProduct->offer_price) }}
                                                <del>{{ currencyPosition($relatedProduct->price) }}</del>
                                            @else
                                                {{ currencyPosition($relatedProduct->price) }}
                                            @endif
                                        </h5>
                                        <ul class="d-flex flex-wrap justify-content-center">
                                            <li><a href="javascript:;" onclick="loadProductModal('{{ $relatedProduct->id }}')"><i class="fas fa-shopping-basket"></i></a></li>
                                            <li><a href="{{ route('product.show', $product->slug) }}"><i class="far fa-eye"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </section>

    <!--=============================
                                    MENU DETAILS END
                                ==============================-->
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.v_product_option').prop('checked', false);
            $('.v_product_add').prop('checked', false);
            $('.quantity').val(1);

            $('.v_product_option').on('change', function() {
                v_updateTotalPrice();

            });

            $('.v_product_add').on('change', function() {
                v_updateTotalPrice();
            });

            // Event handlers for increment button and decrement button
            $('.v_increment').on('click', function(e) {
                e.preventDefault();
                let quantity = $('#v_quantity');
                let currentQuantity = parseFloat(quantity.val());
                quantity.val(currentQuantity + 1);
                v_updateTotalPrice();
            })

            $('.v_decrement').on('click', function(e) {
                e.preventDefault();
                let quantity = $('#v_quantity');
                let currentQuantity = parseFloat(quantity.val());
                if (currentQuantity > 1) {
                    quantity.val(currentQuantity - 1);
                }
                v_updateTotalPrice();
            })

            // Function for updating the total price base on selected options
            function v_updateTotalPrice() {
                let basePrice = parseFloat($('.v_base_price').val());
                let selectedOptionPrice = 0;
                let selectedAddPrice = 0;
                let quantity = parseFloat($('#v_quantity').val());

                // Calculate the selected option price
                let selectedOption = $('.v_product_option:checked');
                if (selectedOption.length > 0) {
                    selectedOptionPrice = parseFloat(selectedOption.data("price"));
                }

                // Calculate the selected add-ons price
                let selectedAdds = $('.v_product_add:checked');
                $(selectedAdds).each(function() {
                    selectedAddPrice += parseFloat($(this).data("price"));
                });


                // Calculate the total custom price
                let totalPrice = (basePrice + selectedOptionPrice + selectedAddPrice) * quantity;
                $('#v_total_price').text("{{ config('settings.site_currency_icon') }}" + totalPrice)
            }

            $('.v_submit_button').on('click', function(e){
                e.preventDefault();
                $('#v_add_to_cart_form').submit();
            })
            // Add to cart function
            $('#v_add_to_cart_form').on('submit', function(e) {
                e.preventDefault();
                let formData = $(this).serialize();

                // Validation
                let selectedOption = $(".v_product_option");
                if (selectedOption.length > 0) {
                    if ($(".v_product_option:checked").val() === undefined) {
                        toastr.error('Please select an option');
                        console.log('Please select an option');
                        return;
                    }
                }

                $.ajax({
                    method: 'POST',
                    url: '{{ route("add-to-cart") }}',
                    data: formData,
                    beforeSend: function() {
                        $('.v_submit_button').attr('disable', true);
                        $('.v_submit_button').html(
                            ' <span class="spinner-border spinner-border-sm text-light" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span>'
                            )
                    },
                    success: function(response) {
                        updateSidebarCart();
                        toastr.success(response.message);
                    },
                    error: function(xhr, status, error) {
                        let errorMessage = xhr.responseJSON.message;
                        toastr.error(errorMessage);
                    },
                    complete: function() {
                        $('.v_submit_button').html('Add to Cart');
                        $('.v_submit_button').attr('disable', false);
                    }
                });
            });
        })
    </script>
@endpush
