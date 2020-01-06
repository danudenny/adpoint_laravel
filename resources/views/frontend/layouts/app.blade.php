<!DOCTYPE html>
@if(\App\Language::where('code', Session::get('locale', Config::get('app.locale')))->first()->rtl == 1)
    <html dir="rtl">
@else
    <html>
@endif
<head>


@php
    $seosetting = \App\SeoSetting::first();
    $product = \App\Product::first();
@endphp

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="robots" content="index, follow">
<meta name="description" content="@yield('meta_description', $seosetting->description)" />
<meta name="keywords" content="@yield('meta_keywords', $seosetting->keyword)">
<meta name="author" content="{{ $seosetting->author }}">
<meta name="sitemap_link" content="{{ $seosetting->sitemap_link }}">
@yield('meta')
<!-- Schema.org markup for Google+ -->
<meta itemprop="name" content="{{ config('app.name', 'Laravel') }}">
<meta itemprop="description" content="{{ $seosetting->description }}">
<meta itemprop="image" content="{{ asset(\App\GeneralSetting::first()->logo) }}">

<!-- Twitter Card data -->
<meta name="twitter:card" content="product">
<meta name="twitter:site" content="@publisher_handle">
<meta name="twitter:title" content="{{ config('app.name', 'Laravel') }}">
<meta name="twitter:description" content="{{ $seosetting->description }}">
<meta name="twitter:creator" content="@author_handle">
<meta name="twitter:image" content="{{ asset(\App\GeneralSetting::first()->logo) }}">

<!-- Open Graph data -->
<meta property="og:title" content="{{ config('app.name', 'Laravel') }}" />
<meta property="og:type" content="Ecommerce Site" />
<meta property="og:url" content="{{ route('home') }}" />
<meta property="og:image" content="{{ asset(\App\GeneralSetting::first()->logo) }}" />
<meta property="og:description" content="{{ $seosetting->description }}" />
<meta property="og:site_name" content="{{ env('APP_NAME') }}" />

<!-- Favicon -->
<link name="favicon" type="image/x-icon" href="{{ asset(\App\GeneralSetting::first()->favicon) }}" rel="shortcut icon" />

<title>@yield('meta_title', config('app.name', 'Laravel'))</title>

<!-- Fonts -->
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i" rel="stylesheet">

<!-- Bootstrap -->
<link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css') }}" type="text/css">
<link type="text/css" href="{{ asset('frontend/css/select2.min.css') }}" rel="stylesheet">
<link type="text/css" href="{{ asset('frontend/css/cards-gallery.css') }}" rel="stylesheet">
<link type="text/css" href="{{ asset('frontend/css/jquery.desoslide.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('frontend/css/bootstrap-select.min.css') }}">
<!-- Latest compiled and minified CSS -->

<!-- Icons -->
<link rel="stylesheet" href="{{ asset('frontend/css/font-awesome.min.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('frontend/css/line-awesome.min.css') }}" type="text/css">

<link type="text/css" href="{{ asset('frontend/css/bootstrap-tagsinput.css') }}" rel="stylesheet">
<link type="text/css" href="{{ asset('frontend/css/jodit.min.css') }}" rel="stylesheet">
<link type="text/css" href="{{ asset('frontend/css/sweetalert2.min.css') }}" rel="stylesheet">
<link type="text/css" href="{{ asset('frontend/css/slick.css') }}" rel="stylesheet">
<link type="text/css" href="{{ asset('frontend/css/xzoom.css') }}" rel="stylesheet">
<link type="text/css" href="{{ asset('frontend/css/jquery.share.css') }}" rel="stylesheet">


<style>
    .map {
        height: 400px;
        width: 100%;
    }
    #example_filter input {
        border-radius: 5px;
    }

    #pac-input {
        background-color: #fff;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        margin-left: 12px;
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
        width: 400px;
    }

    #pac-input:focus {
        border-color: #4d90fe;
    }
</style>

<!-- Global style (main) -->
<link type="text/css" href="{{ asset('frontend/css/active-shop.css') }}" rel="stylesheet" media="screen">
<!--Spectrum Stylesheet [ REQUIRED ]-->
<link href="{{ asset('css/spectrum.css')}}" rel="stylesheet">
<!-- Custom style -->
<link type="text/css" href="{{ asset('frontend/css/custom-style.css') }}" rel="stylesheet">

@if(\App\Language::where('code', Session::get('locale', Config::get('app.locale')))->first()->rtl == 1)
<!-- RTL -->
<link type="text/css" href="{{ asset('frontend/css/active.rtl.css') }}" rel="stylesheet">
@endif

<!-- Facebook Chat style -->
<link href="{{ asset('frontend/css/fb-style.css')}}" rel="stylesheet">

<!-- color theme -->
<link href="{{ asset('frontend/css/colors/'.\App\GeneralSetting::first()->frontend_color.'.css')}}" rel="stylesheet">

<!-- jQuery -->
<script src="{{ asset('frontend/js/vendor/jquery-3.3.1.js') }}"></script>
<script src="{{ asset('frontend/js/ekko-lightbox.js') }}"></script>
<script src="{{ asset('frontend/js/baguetteBox.min.js') }}"></script>
<script src="{{ asset('frontend/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('frontend/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('frontend/js/jquery-ui.js') }}"></script>
<script src="{{ asset('frontend/js/bootstrap-select.min.js') }}"></script>

@if (\App\BusinessSetting::where('type', 'google_analytics')->first()->value == 1)
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-133955404-1"></script>

<script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', @php env('TRACKING_ID') @endphp);
    </script>
@endif
{{-- Datepicker css --}}
<link href="{{ asset('frontend/css/gijgo.min.css')}}" rel="stylesheet">
<!-- Latest compiled and minified JavaScript -->

</head>
<body>
    
    
    <!-- MAIN WRAPPER -->
    <div class="body-wrap shop-default shop-cards shop-tech gry-bg">
        
        <!-- Header -->
        @include('frontend.inc.nav')
        
        @yield('content')
        
        @include('frontend.inc.footer')
        
        @include('frontend.partials.modal')
        
        <div class="modal fade" id="addToCart" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-zoom product-modal" id="modal-size" role="document">
                <div class="modal-content position-relative">
                <div class="c-preloader">
                    <i class="fa fa-spin fa-spinner"></i>
                </div>
                <button type="button" class="close absolute-close-btn" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div id="addToCart-modal-body">

                </div>
            </div>
        </div>
    </div>

    <div class="form-popup" id="myForm">
        <div class="form-container">
            <h5 class="text-center">Customer Services</h5>
            <hr>
            <span id="_cs" hidden>{{ \App\BusinessSetting::where('type', 'whatsapp_settings')->first()->value }}</span>
            <div class="cs">
                <ol class="rounded-list">
                                
                </ol>
            </div>
        </div>
    </div>
    <button id="btn_open" onclick="openForm()" class="open-button">
        <i class="fa fa-whatsapp my-float"></i> Contact us
    </button>
    <button id="btn_close" onclick="closeForm()" class="open-button" style="display: none;">
        <i class="fa fa-close"></i> Close
    </button>

    @if (\App\BusinessSetting::where('type', 'facebook_chat')->first()->value == 1)
        <div id="fb-root"></div>
        <!-- Your customer chat code -->
        <div class="fb-customerchat"
          attribution=setup_tool
          page_id="{{ env('FACEBOOK_PAGE_ID') }}">
        </div>
    @endif

</div><!-- END: body-wrap -->

<!-- SCRIPTS -->
<a href="#" class="back-to-top btn-back-to-top"></a>

<!-- Core -->
<script src="{{ asset('frontend/js/vendor/popper.min.js') }}"></script>
<script src="{{ asset('frontend/js/vendor/bootstrap.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('frontend/css/baguetteBox.min.css') }}" />

<!-- Plugins: Sorted A-Z -->
<script src="{{ asset('frontend/js/jquery.countdown.min.js') }}"></script>
<script src="{{ asset('frontend/js/nouislider.min.js') }}"></script>


<script src="{{ asset('frontend/js/sweetalert2.min.js') }}"></script>
<script src="{{ asset('frontend/js/slick.min.js') }}"></script>

<script src="{{ asset('frontend/js/jquery.share.js') }}"></script>
<script src="{{ asset('frontend/js/select2.min.js') }}"></script>

<script type="text/javascript">
    function showFrontendAlert(type, message){
        if(type == 'danger'){
            type = 'error';
        }
        swal({
            position: 'top-end',
            type: type,
            title: message,
            showConfirmButton: false,
            timer: 1500
        });
    }
</script>

@foreach (session('flash_notification', collect())->toArray() as $message)
    <script type="text/javascript">
        showFrontendAlert('{{ $message['level'] }}', '{{ $message['message'] }}');
    </script>
@endforeach

<script>

    $(document).ready(function() { 
        if ($('#lang-change').length > 0) {
            $('#lang-change .dropdown-item a').each(function() {
                $(this).on('click', function(e){
                    e.preventDefault();
                    var $this = $(this);
                    var locale = $this.data('flag');
                    $.post('{{ route('language.change') }}',{_token:'{{ csrf_token() }}', locale:locale}, function(data){
                        location.reload();
                    });

                });
            });
        }   

        if ($('#currency-change').length > 0) {
            $('#currency-change .dropdown-item a').each(function() {
                $(this).on('click', function(e){
                    e.preventDefault();
                    var $this = $(this);
                    var currency_code = $this.data('currency');
                    $.post('{{ route('currency.change') }}',{_token:'{{ csrf_token() }}', currency_code:currency_code}, function(data){
                        location.reload();
                    });

                });
            });
        }
        // get propinsi kabupaten dan kecamatan

        function getToken(){
            var endpoint = "https://x.rajaapi.com/poe";
            var result;
            $.ajax({
                async: false,
                url: endpoint,
                type: 'get',
                dataType: 'json',
                success: function(data){
                    result = data.token
                }
            })
            return result;
        }

        // var token = 'ZG0MysXFq2utuYL96oPI3P08EMl8E7i1IVDw3MHOdedBgrRoik';
        var token = getToken();
        var url = 'https://x.rajaapi.com/MeP7c5ne'+ token +'/m/wilayah/';

        // --load data awal--
        $.ajax({
            url : url+'provinsi',
            type : "get",
            dataType : "json"
        }).done(function(result){
            let provinsi = result.data;
            $.each(provinsi, function (i, data) {
                $('#prov').append(`<option id="`+ data.id +`" value="`+ data.name +`">`+ data.name +`</option>`)
            })
        }).fail(function(xhr, status, error){
            console.log(xhr.status)
        })

        // get data kabupaten berdasarkan provinsi
        $('#prov').on('change',function(){
            let id_prov = $(this).children(':selected').attr('id');
            $('#kab').empty();
            if (id_prov) {
                $.ajax({
                    url : url + 'kabupaten?idpropinsi=' + id_prov,
                    type : "get",
                    dataType : "json"
                    }).done(function(result){
                        let kabupaten = result.data;
                        // console.log(kabupaten);
                        $.each(kabupaten, function (i, data) {
                            var kab = `<option id="`+ data.id +`" value="`+ data.name +`">`+ data.name +`</option>`;
                            $('#kab').append(kab);
                            if (i === 0) {
                                $('#kec').empty();
                                $.ajax({
                                    url: url +'kecamatan?idkabupaten='+ data.id,
                                    type: 'get',
                                    dataType: 'json',
                                    success: function(result){
                                        var kecamatan = result.data;
                                        $.each(kecamatan, function(i, data){
                                            var kec = `<option id="`+ data.id +`" value="`+ data.name +`">`+ data.name +`</option>`;
                                            $('#kec').append(kec);
                                        });
                                    }
                                });
                            }
                        })
                    }).fail(function(xhr, error, status){
                        console.log(xhr);
                    })
            }else{
                $('#kab').empty();
            }
            // var kabup = $("select#kab").children(':selected')[0];
            // console.log(kabup);
        });
        // ambil data kecamatan berdasarkan kabupaten
        $('#kab').on('change', function(){
            let id_kec = $(this).children(':selected').attr('id');
            $('#kec').empty();
            if (id_kec) {
                $.ajax({
                    url : url + 'kecamatan?idkabupaten=' + id_kec,
                    type : "get",
                    dataType : "json"
                    }).done(function(result){
                        let kecamatan = result.data;
                        // console.log(kecamatan);
                        $.each(kecamatan, function (i, data) {
                            var kec = `<option value="`+ data.name +`">`+ data.name +`</option>`;
                            $('#kec').append(kec);
                        })
                    }).fail(function(xhr, error, status){
                        console.log(xhr);
                    })
            }else{
                $('#kec').empty();
            }
        })
        // end get prov kab kec

        // get data wilayah indonesia di edit product
        var namaProv = $('#namaProv').text();
        $.ajax({
            url: url+'provinsi',
            type: 'get',
            dataType: 'json',
            success: function(result){
                var prov = result.data;
                $.each(prov, function(i, data){
                    $('#provEdit').append(`<option class="provEdit" id="`+ data.id +`" value="`+ data.name +`">`+ data.name +`</option>`);
                    if (namaProv === data.name) {
                        getKab(data.id);
                        $('.provEdit').prop('selected',true);
                    }
                });
            },
            error: function(err){
                console.log(err);
            }
        });

        var namaKota = $('#namaKota').text();
        function getKab(id){
            $.ajax({
                url: url +'kabupaten?idpropinsi='+ id,
                type: 'get',
                dataType: 'json',
                success: function(result){
                    var kec = result.data;
                    $.each(kec, function(i, data){
                        $('#kotaEdit').append(`<option class="kotaEdit" id="`+ data.id +`" value="`+ data.name +`">`+ data.name +`</option>`);
                        if (namaKota === data.name) {
                            getKec(data.id);
                            $('.kotaEdit').prop('selected',true);
                        }
                    });
                },
                error: function(err){
                    console.log(err);
                }
            });
        }

        var namaKec = $('#namaKec').text();
        function getKec(id){
            $.ajax({
                url: url +'kecamatan?idkabupaten='+ id,
                type: 'get',
                dataType: 'json',
                success: function(result){
                    var kab = result.data;
                    $.each(kab, function(i, data){
                        $('#kecEdit').append(`<option class="kecEdit" id="`+ data.id +`" value="`+ data.name +`">`+ data.name +`</option>`);
                        if (namaKec === data.name) {
                            $('.kecEdit').prop('selected',true);
                        }
                    });
                },
                error: function(err){
                    console.log(err);
                }
            });
        }

        $('#provEdit').on('change',function(){
            let id_prov = $(this).children(':selected').attr('id');
            $('#kotaEdit').empty();
            if (id_prov) {
                $.ajax({
                    url : url + 'kabupaten?idpropinsi=' + id_prov,
                    type : "get",
                    dataType : "json"
                }).done(function(result){
                    let kabupaten = result.data;
                    // console.log(kabupaten);
                    $.each(kabupaten, function (i, data) {
                        var kab = `<option id="`+ data.id +`" value="`+ data.name +`">`+ data.name +`</option>`;
                        $('#kotaEdit').append(kab);
                        if (i === 0) {
                            $('#kecEdit').empty();
                            $.ajax({
                                url: url +'kecamatan?idkabupaten='+ data.id,
                                type: 'get',
                                dataType: 'json',
                                success: function(result){
                                    var kecamatan = result.data;
                                    $.each(kecamatan, function(i, data){
                                        var kec = `<option id="`+ data.id +`" value="`+ data.name +`">`+ data.name +`</option>`;
                                        $('#kecEdit').append(kec);
                                    });
                                }
                            });
                        }
                    })
                }).fail(function(xhr, error, status){
                    console.log(xhr);
                })
            }else{
                $('#kotaEdit').empty();
            }
        });
        // ambil data kecamatan berdasarkan kabupaten
        $('#kotaEdit').on('change', function(){
            let id_kec = $(this).children(':selected').attr('id');
            $('#kecEdit').empty();
            if (id_kec) {
                $.ajax({
                    url : url + 'kecamatan?idkabupaten=' + id_kec,
                    type : "get",
                    dataType : "json"
                }).done(function(result){
                    let kecamatan = result.data;
                    // console.log(kecamatan);
                    $.each(kecamatan, function (i, data) {
                        var kec = `<option value="`+ data.name +`">`+ data.name +`</option>`;
                        $('#kecEdit').append(kec);
                    })
                }).fail(function(xhr, error, status){
                    console.log(xhr);
                })
            }else{
                $('#kecEdit').empty();
            }
        })

        // end get edit

    });

    $('#search').on('keyup', function(){
        search();
    });

    $('#search').on('focus', function(){
        search();
    });

    function search(){
        var search = $('#search').val();
        if(search.length > 0){
            $('body').addClass("typed-search-box-shown");

            $('.typed-search-box').removeClass('d-none');
            $('.search-preloader').removeClass('d-none');
            $.post('{{ route('search.ajax') }}', { _token: '{{ @csrf_token() }}', search:search}, function(data){
                if(data == '0'){
                    // $('.typed-search-box').addClass('d-none');
                    $('#search-content').html(null);
                    $('.typed-search-box .search-nothing').removeClass('d-none').html('Sorry, nothing found for <strong>"'+search+'"</strong>');
                    $('.search-preloader').addClass('d-none');

                }
                else{
                    $('.typed-search-box .search-nothing').addClass('d-none').html(null);
                    $('#search-content').html(data);
                    $('.search-preloader').addClass('d-none');
                }
            });
        }
        else {
            $('.typed-search-box').addClass('d-none');
            $('body').removeClass("typed-search-box-shown");
        }
    }
   
    function updateNavCart(){
        $.post('{{ route('cart.nav_cart') }}', {_token:'{{ csrf_token() }}'}, function(data){
            $('#cart_items').html(data);
        });
    }

    function removeFromCart(key){
        $.post('{{ route('cart.removeFromCart') }}', {_token:'{{ csrf_token() }}', key:key}, function(data){
            updateNavCart();
            $('#cart-summary').html(data);
            showFrontendAlert('success', 'Item has been removed from cart');
            $('#cart_items_sidenav').html(parseInt($('#cart_items_sidenav').html())-1);
        });
    }

    function addToCompare(id){
        $.post('{{ route('compare.addToCompare') }}', {_token:'{{ csrf_token() }}', id:id}, function(data){
            $('#compare').html(data);
            showFrontendAlert('success', 'Item has been added to compare list');
            $('#compare_items_sidenav').html(parseInt($('#compare_items_sidenav').html())+1);
        });
    }

    function addToWishList(id){
        @if (Auth::check())
            $.post('{{ route('wishlists.store') }}', {_token:'{{ csrf_token() }}', id:id}, function(data){
                if(data != 0){
                    $('#wishlist').html(data);
                    showFrontendAlert('success', 'Item has been added to wishlist');
                }
                else{
                    showFrontendAlert('warning', 'Please login first');
                }
            });
        @else
            showFrontendAlert('warning', 'Please login first');
        @endif
    }

    function showGaleriModal(order_detail_id){
        if(!$('#modal-size').hasClass('modal-lg')){
            $('#modal-size').addClass('modal-lg');
        }
        $('#addToCart-modal-body').html(null);
        $('#addToCart').modal();
        $('.c-preloader').show();
        $.post('{{ route('broadcast.details') }}', {_token:'{{ csrf_token() }}', order_detail_id:order_detail_id}, function(data){
            $('.c-preloader').hide();
            $('#addToCart-modal-body').html(data);
        });
    }

    function showAddToCartModal(id){
        if(!$('#modal-size').hasClass('modal-lg')){
            $('#modal-size').addClass('modal-lg');
        }
        $('#addToCart-modal-body').html(null);
        $('#addToCart').modal();
        $('.c-preloader').show();
        $.post('{{ route('cart.showCartModal') }}', {_token:'{{ csrf_token() }}', id:id}, function(data){
            $('.c-preloader').hide();
            $('#addToCart-modal-body').html(data);
            $('.xzoom, .xzoom-gallery').xzoom({
                Xoffset: 20,
                bg: true,
                tint: '#000',
                defaultScale: -1
            });
            getVariantPrice();
        });
    }

    function getVariantPrice(){
        if($('#option-choice-form input[name=quantity]').val() > 0 && checkAddToCartValidity()){
            $.ajax({
               type:"POST",
               url: '{{ route('products.variant_price') }}',
               data: $('#option-choice-form').serializeArray(),
               success: function(data){
                   $('#option-choice-form #chosen_price_div').removeClass('d-none');
                   $('#option-choice-form #chosen_price_div #chosen_price').html(data.price);
                   $('#available-quantity').html(data.quantity);
               }
           });
        }
    }

    function checkAddToCartValidity(){
        var names = {};
        $('#option-choice-form input:radio').each(function() { // find unique names
              names[$(this).attr('name')] = true;
        });
        var count = 0;
        $.each(names, function() { // then count them
              count++;
        });
        if($('input:radio:checked').length == count){
            return true;
        }
        return false;
    }


    function addToCart(){
        if(checkAddToCartValidity()) {
            $('#addToCart').modal();
            $('.c-preloader').show();
            $.ajax({
               type:"POST",
               url: '{{ route('cart.addToCart') }}',
               data: $('#option-choice-form').serializeArray(),
               success: function(data){
                   $('#addToCart-modal-body').html(null);
                   $('.c-preloader').hide();
                   $('#modal-size').removeClass('modal-lg');
                   $('#addToCart-modal-body').html(data);
                   updateNavCart();
                   $('#cart_items_sidenav').html(parseInt($('#cart_items_sidenav').html())+1);
               }
           });
        }
        else{
            showFrontendAlert('warning', 'Please choose all the options');
        }
    }

    function buyNow(){
        if(checkAddToCartValidity()) {
            $('#addToCart').modal();
            $('.c-preloader').show();
            $.ajax({
               type:"POST",
               url: '{{ route('cart.addToCart') }}',
               data: $('#option-choice-form').serializeArray(),
               success: function(data){
                   //$('#addToCart-modal-body').html(null);
                   //$('.c-preloader').hide();
                   //$('#modal-size').removeClass('modal-lg');
                   //$('#addToCart-modal-body').html(data);
                   updateNavCart();
                   $('#cart_items_sidenav').html(parseInt($('#cart_items_sidenav').html())+1);
                   window.location.replace("{{ route('checkout.shipping_info') }}");
               }
           });
        }
        else{
            showFrontendAlert('warning', 'Please choose all the options');
        }
    }

    function show_purchase_history_details(order_id)
    {
        $('#order-details-modal-body').html(null);

        if(!$('#modal-size').hasClass('modal-lg')){
            $('#modal-size').addClass('modal-lg');
        }

        $.post('{{ route('purchase_history.details') }}', { _token : '{{ @csrf_token() }}', order_id : order_id}, function(data){
            $('#order-details-modal-body').html(data);
            $('#order_details').modal();
            $('.c-preloader').hide();
        });
    }

    function show_order_details(order_id)
    {
        $('#order-details-modal-body').html(null);

        if(!$('#modal-size').hasClass('modal-lg')){
            $('#modal-size').addClass('modal-lg');
        }

        $.post('{{ route('orders.details') }}', { _token : '{{ @csrf_token() }}', order_id : order_id}, function(data){
            $('#order-details-modal-body').html(data);
            $('#order_details').modal();
            $('.c-preloader').hide();
        });
    }

    function cartQuantityInitialize(){
        $('.btn-number').click(function(e) {
            e.preventDefault();

            fieldName = $(this).attr('data-field');
            type = $(this).attr('data-type');
            var input = $("input[name='" + fieldName + "']");
            var currentVal = parseInt(input.val());

            if (!isNaN(currentVal)) {
                if (type == 'minus') {

                    if (currentVal > input.attr('min')) {
                        input.val(currentVal - 1).change();
                    }
                    if (parseInt(input.val()) == input.attr('min')) {
                        $(this).attr('disabled', true);
                    }

                } else if (type == 'plus') {

                    if (currentVal < input.attr('max')) {
                        input.val(currentVal + 1).change();
                    }
                    if (parseInt(input.val()) == input.attr('max')) {
                        $(this).attr('disabled', true);
                    }

                }
            } else {
                input.val(0);
            }
        });

        $('.input-number').focusin(function() {
            $(this).data('oldValue', $(this).val());
        });

        $('.input-number').change(function() {

            minValue = parseInt($(this).attr('min'));
            maxValue = parseInt($(this).attr('max'));
            valueCurrent = parseInt($(this).val());

            name = $(this).attr('name');
            if (valueCurrent >= minValue) {
                $(".btn-number[data-type='minus'][data-field='" + name + "']").removeAttr('disabled')
            } else {
                alert('Sorry, the minimum value was reached');
                $(this).val($(this).data('oldValue'));
            }
            if (valueCurrent <= maxValue) {
                $(".btn-number[data-type='plus'][data-field='" + name + "']").removeAttr('disabled')
            } else {
                alert('Sorry, the maximum value was reached');
                $(this).val($(this).data('oldValue'));
            }


        });
        $(".input-number").keydown(function(e) {
            // Allow: backspace, delete, tab, escape, enter and .
            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
                // Allow: Ctrl+A
                (e.keyCode == 65 && e.ctrlKey === true) ||
                // Allow: home, end, left, right
                (e.keyCode >= 35 && e.keyCode <= 39)) {
                // let it happen, don't do anything
                return;
            }
            // Ensure that it is a number and stop the keypress
            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                e.preventDefault();
            }
        });
    }

     function imageInputInitialize(){
         $('.custom-input-file').each(function() {
             var $input = $(this),
                 $label = $input.next('label'),
                 labelVal = $label.html();

             $input.on('change', function(e) {
                 var fileName = '';

                 if (this.files && this.files.length > 1)
                     fileName = (this.getAttribute('data-multiple-caption') || '').replace('{count}', this.files.length);
                 else if (e.target.value)
                     fileName = e.target.value.split('\\').pop();

                 if (fileName)
                     $label.find('span').html(fileName);
                 else
                     $label.html(labelVal);
             });

             // Firefox bug fix
             $input
                 .on('focus', function() {
                     $input.addClass('has-focus');
                 })
                 .on('blur', function() {
                     $input.removeClass('has-focus');
                 });
         });
     }

</script>

<script src="{{ asset('frontend/js/bootstrap-tagsinput.min.js') }}"></script>
<script src="{{ asset('frontend/js/jodit.min.js') }}"></script>
<script src="{{ asset('frontend/js/xzoom.min.js') }}"></script>
<script src="{{ asset('frontend/js/jquery.desoslide.min.js') }}"></script>


<!-- App JS -->
<script src="{{ asset('frontend/js/gijgo.min.js') }}"></script>
<script src="{{ asset('frontend/js/active-shop.js') }}"></script>
<script src="{{ asset('frontend/js/main.js') }}"></script>
<script src="{{ asset('frontend/js/fb-script.js') }}"></script>
<script src="{{ asset('frontend/js/moment.min.js') }}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBsVHufr4pDssMKPVCFZO6yXe58oalrtHs&libraries=places"></script>
<script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js">
</script>
@yield('script')


<script>

    $(document).ready(function(){
        function getDataProduct(){
            var dataProduct = [];
            $.ajax({
                async: false,
                url: '{{ url("/listproduct") }}',
                type: 'get',
                dataType: 'json',
                success: function(result){
                    dataProduct = result;
                }
            });
            return dataProduct;
        }

        // console.log(getDataProduct());
        var map;
        var key = 'AIzaSyBsVHufr4pDssMKPVCFZO6yXe58oalrtHs';
        var idMap = $('.map').attr('id');
        // handle error
        function handleLocationError(browserHasGeolocation, infoWindow, pos) {
            infoWindow.setPosition(pos);
            infoWindow.setContent(browserHasGeolocation ?
                                'Error: The Geolocation service failed.' :
                                'Error: Your browser doesn\'t support geolocation.');
            infoWindow.open(map);
        }

        function reverseGeocode(_lat, _lng) {
            fetch('https://maps.googleapis.com/maps/api/geocode/json?latlng='+_lat+','+_lng+'&key=' + key)
                .then(function(response) {
                    return response.json();
                }).then(function(json) {
                    // data
                    var plus_code = json.plus_code;
                    var data = json.results;
                    var address = data[0].formatted_address;
                    document.getElementById('alamat').innerHTML = address;
                });
        }

        if (idMap === 'addProductMap') {
            map = new google.maps.Map(document.getElementById('addProductMap'), {
                center: {lat: -2.6000285, lng: 118.015776},
                zoom: 10,
                gestureHandling: 'greedy'
            });

            var input = document.getElementById('pac-input');
            var searchBox = new google.maps.places.SearchBox(input);
            map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

            map.addListener('bounds_changed', function() {
                searchBox.setBounds(map.getBounds());
            });
            var markers = [];
            searchBox.addListener('places_changed', function() {
                var places = searchBox.getPlaces();

                if (places.length == 0) {
                    return;
                }

                // Clear out the old markers.
                markers.forEach(function(marker) {
                    marker.setMap(null);
                });

                markers = [];

                // For each place, get the icon, name and location.
                var bounds = new google.maps.LatLngBounds();
                places.forEach(function(place) {
                    if (!place.geometry) {
                        console.log("Returned place contains no geometry");
                        return;
                    }
                    var base_url = {!! json_encode(url('/')) !!};
                    var icon = {
                        url: base_url+'/img/marker/hand.png'
                    };

                    markers.push(new google.maps.Marker({
                        map: map,
                        icon: icon,
                        animation: google.maps.Animation.BOUNCE,
                        position: place.geometry.location
                    }));

                    reverseGeocode(place.geometry.location.lat(),place.geometry.location.lng());

                    if (place.geometry.viewport) {
                        bounds.union(place.geometry.viewport);
                    } else {
                        bounds.extend(place.geometry.location);
                    }
                });
                map.fitBounds(bounds);
            });

            var marker;
            function placeMarker(position, map) {
                if (marker) {
                    marker.setPosition(position)
                } else {
                    marker = new google.maps.Marker({
                        position: position, 
                        map: map
                    });
                }
                map.panTo(position);
            }

            map.addListener('click', function(e){
                var result = "";
                var coords = e.latLng;
                result += coords.lat() + ",";
                result += coords.lng();
                var latlong = document.getElementById('latlong');
                latlong.setAttribute('value', result)
                reverseGeocode(coords.lat(), coords.lng());
                placeMarker(e.latLng, map);
            });

            // Try HTML5 geolocation.
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var pos = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                    };
                    map.setCenter(pos);
                    map.setZoom(15);
                }, function() {
                    handleLocationError(true, map.getCenter());
                });
            } else {
                handleLocationError(false, map.getCenter());
            }

        }else if(idMap === 'editProductMap'){
            var latlong = $('#latlong').val();
            var koordinat = latlong.split(',');
            // console.log(koordinat);
            var lat = Number(koordinat[0]);
            var lng = Number(koordinat[1]);
            // console.log(lat);
            var position = {lat: lat, lng: lng};
            map = new google.maps.Map(document.getElementById('editProductMap'), {
                center: {lat: lat, lng: lng},
                zoom: 10,
                gestureHandling: 'greedy'
            });

            var input = document.getElementById('pac-input');
            var searchBox = new google.maps.places.SearchBox(input);
            map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

            map.addListener('bounds_changed', function() {
                searchBox.setBounds(map.getBounds());
            });
            var markers = [];
            searchBox.addListener('places_changed', function() {
                var places = searchBox.getPlaces();

                if (places.length == 0) {
                    return;
                }

                // Clear out the old markers.
                markers.forEach(function(marker) {
                    marker.setMap(null);
                });

                markers = [];

                // For each place, get the icon, name and location.
                var bounds = new google.maps.LatLngBounds();
                places.forEach(function(place) {
                    if (!place.geometry) {
                        console.log("Returned place contains no geometry");
                        return;
                    }
                    var base_url = {!! json_encode(url('/')) !!};
                    var icon = {
                        url: base_url+'/img/marker/hand.png'
                    };

                    markers.push(new google.maps.Marker({
                        map: map,
                        icon: icon,
                        animation: google.maps.Animation.BOUNCE,
                        position: place.geometry.location
                    }));

                    reverseGeocode(place.geometry.location.lat(),place.geometry.location.lng());

                    if (place.geometry.viewport) {
                        bounds.union(place.geometry.viewport);
                    } else {
                        bounds.extend(place.geometry.location);
                    }
                });
                map.fitBounds(bounds);
            });

            var marker = new google.maps.Marker({
                position: position,
                map: map,
                title: latlong
            });

            var marker;
            function placeMarker(position, map) {
                if (marker) {
                    marker.setPosition(position)
                } else {
                    marker = new google.maps.Marker({
                        position: position, 
                        map: map
                    });
                }
                map.panTo(position);
            }

            map.addListener('click', function(e){
                console.log(e.latLng);
                var result = "";
                var coords = e.latLng;
                result += coords.lat() + ",";
                result += coords.lng();
                var latlong = document.getElementById('latlong');
                latlong.setAttribute('value', result)
                reverseGeocode(coords.lat(), coords.lng());
                placeMarker(e.latLng, map);
            });

            // Try HTML5 geolocation.
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function() {
                    var pos = {
                        lat: lat,
                        lng: lng
                    };
                    map.setCenter(pos);
                    map.setZoom(15);
                }, function() {
                    handleLocationError(true, map.getCenter());
                });
            } else {
                handleLocationError(false, map.getCenter());
            }
        }else if(idMap === 'dashboardMap'){
            map = new google.maps.Map(document.getElementById('dashboardMap'), {
                center: {lat: -2.6000285, lng: 118.015776},
                zoom: 15,
                gestureHandling: 'greedy'
            });

            var product = getDataProduct();
            var markers = [];
            $.each(product, function(i, data){
                var name = data.name;
                var alamat = data.alamat;
                var photos = JSON.parse(data.photos);
                var coords = data.latlong;
                var latlong;
                if (coords === null) {
                    coords = "-6.566656540244916,106.62076009899442";
                    latlong = coords.split(",");
                }else{
                    latlong = coords.split(",");
                }
                var base_url = {!! json_encode(url('/')) !!};
                var poto = base_url+'/'+photos[0];
                var detail = '{{ url("/product/") }}';
                var template = `<div class="card" style="width: 18rem; border: none">
                                <div class="card-body pt-1 pb-1 pr-1 pl-1">
                                    <strong class="text-primary text-uppercase">`+name+`</strong>
                                    <br>
                                    <br>
                                    <img src="`+poto+`" class="card-img-top">
                                    <i class="fa fa-map-marker"></i>
                                    <small class="text-primary">`+alamat+`</small>
                                </div>
                                </div>`;
                
                var infowindow = new google.maps.InfoWindow({
                    content: template,
                    disableAutoPan: true,
                });

                var lat = Number(latlong[0]);
                var lng = Number(latlong[1]);
                var posisi = {lat: lat, lng: lng};
                

                function markerByCategory(category_id){
                    var icon = {
                        url: base_url + '/marker/'+category_id+'.png',
                        scaledSize: new google.maps.Size(40, 40),
                        origin: new google.maps.Point(0,0), 
                        anchor: new google.maps.Point(0,0)
                    };
                    return icon;
                }
                var marker = new google.maps.Marker({
                    position: posisi,
                    map: map,
                    icon: markerByCategory(data.category_id),
                    title: name,
                    url: detail+ '/' + data.slug,
                    animation:google.maps.Animation.DROP
                });

                // var markerCluster = new MarkerClusterer(map, marker,{imagePath: 'https://github.com/googlearchive/js-marker-clusterer/blob/gh-pages/images/m4.png'});

                marker.addListener('mouseover', function() {
                    infowindow.open(map, marker);
                });

                marker.addListener('mouseout', function() {
                    infowindow.close();
                });

                marker.addListener('click', function() {
                    window.open(marker.url);
                })    

            });
            
            // Try HTML5 geolocation.
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var pos = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                    };
                    map.setCenter(pos);
                    map.setZoom(15);
                }, function() {
                    handleLocationError(true, map.getCenter());
                });
            } else {
                handleLocationError(false, map.getCenter());
            }
        }else if(idMap === 'detailsProductMap'){
            map = new google.maps.Map(document.getElementById('detailsProductMap'), {
                center: {lat: -2.6000285, lng: 118.015776},
                zoom: 10,
                gestureHandling: 'greedy'
            });

            var alamat = $('#alamat').text();
            var coords = $('#coords').text();
            var latlong;
            if (coords === null) {
                coords = "-6.566656540244916,106.62076009899442";
                latlong = coords.split(",");
            }else{
                latlong = coords.split(",");
            }
            var lat = Number(latlong[0]);
            var lng = Number(latlong[1]);
            var posisi = {lat: lat, lng: lng};

            var template = `<div class="card" style="width: 14rem;">
                            <div class="card-body">
                                <strong class="text-primary">`+alamat+`</strong>
                            </div>
                            </div>`;
                
            var infowindow = new google.maps.InfoWindow({
                content: template
            });

            var marker = new google.maps.Marker({
                position: posisi,
                map: map,
                title: coords
            });

            marker.addListener('mouseover', function() {
                infowindow.open(map, marker);
            });
            marker.addListener('mouseout', function() {
                infowindow.open(map, marker);
            });
            // Try HTML5 geolocation.
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var pos = {
                    lat: lat,
                    lng: lng
                    };
                    map.setCenter(pos);
                    map.setZoom(15);
                }, function() {
                    handleLocationError(true, map.getCenter());
                });
            } else {
                handleLocationError(false, map.getCenter());
            }
        }

    });


    // whatsapp chat
    var url_send_wa = 'https://api.whatsapp.com/send?phone=';
    var base_url = {!! json_encode(url('/')) !!};
    var image = `<img id="img" class="rounded-circle" src="`+base_url+'/img/icon-wa.png'+`" data-holder-rendered="true">`;
    var cs = JSON.parse($('#_cs').text());
    if (cs.active != "0") {
        $('#btn_open').show();
    } else{
        $('#btn_open').hide();
    }
    var msg = cs.message.replace(/\s/g,"%20");
    $.each(cs.cs, function(i, data){
        var temp = `<li><a target="_blank" href="`+url_send_wa+data.contact+'&text='+msg+`">`+image+data.name+`</a></li>`;
        $('.rounded-list').append(temp);
    });

    function openForm() {
        $('#myForm').attr('style','display:block');
        $("#btn_open").hide();
        $('#btn_close').show();
        
    }

    function closeForm() {
        $('#myForm').attr('style','display:none');
        $('#btn_open').show();
        $('#btn_close').hide();
    }
    // end whatsapp

    
    $('#table').DataTable();
    $('.dataTables_filter').addClass('pull-right');
    $('#table_paginate').addClass('pull-right');
    
</script>

</body>
</html>
