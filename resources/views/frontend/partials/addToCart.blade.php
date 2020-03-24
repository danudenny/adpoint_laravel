<div class="modal-body p-4">
    <div class="row no-gutters cols-xs-space cols-sm-space cols-md-space">
        <div class="col-lg-6">
            <div class="product-gal d-flex flex-row-reverse">
                <div class="product-gal-img">
                    <img class="xzoom img-fluid" src="{{ asset(json_decode($product->photos)[0]) }}" xoriginal="{{ asset(json_decode($product->photos)[0]) }}" />
                </div>
                <div class="product-gal-thumb">
                    <div class="xzoom-thumbs">
                        @foreach (json_decode($product->photos) as $key => $photo)
                            <a href="{{ asset($photo) }}">
                                <img class="xzoom-gallery" width="80" src="{{ asset($photo) }}"  @if($key == 0) xpreview="{{ asset($photo) }}" @endif>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <!-- Product description -->
            <div class="product-description-wrapper">
                <!-- Product title -->
                <h2 class="product-title">
                    {{ __($product->name) }}
                </h2>

                <div class="row no-gutters mt-3">
                    <div class="col-2">
                        <div class="product-description-label">{{__('Price')}}:</div>
                    </div>
                    <div class="col-10">
                        <div class="product-price">
                            @if (Auth::check())
                                <strong>
                                    {{ home_discounted_price($product->id) }}
                                </strong>
                                <span class="piece">{{ $product->unit }}</span>
                            @else 
                                <strong title="Please login for show price">XXX</strong>
                            @endif
                        </div>
                    </div>
                </div>
                <hr>
                <form id="option-choice-form">
                    @csrf
                    <input type="hidden" name="id" value="{{ $product->id }}">

                    @foreach (json_decode($product->choice_options) as $key => $choice)

                    <div class="row no-gutters">
                        <div class="col-2">
                            <div class="product-description-label mt-2 ">{{ $choice->title }}:</div>
                        </div>
                        <div class="col-10">
                            <ul class="list-inline checkbox-alphanumeric checkbox-alphanumeric--style-1 mb-2">
                                @foreach ($choice->options as $key => $option)
                                    <li>
                                        <input type="radio" id="{{ $choice->title }}-{{ $option }}" name="{{ $choice->title }}" value="{{ $option }}" @if($key == 0) checked @endif>
                                        <label for="{{ $choice->title }}-{{ $option }}">{{ $option }}</label>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    @endforeach

                    <hr>
                    <!-- Quantity + Add to cart -->
                    <div class="row no-gutters">
                        <div class="col-2">
                            <div class="product-description-label mt-2">{{__('Quantity')}}:</div>
                        </div>
                        <div class="col-10">
                            <div class="product-quantity d-flex align-items-center">
                                <div class="input-group input-group--style-2 pr-3" style="width: 160px;">
                                    <span class="input-group-btn">
                                        <button class="btn btn-number" type="button" data-type="minus" data-field="quantity" disabled="disabled">
                                            <i class="la la-minus"></i>
                                        </button>
                                    </span>
                                    <input type="text" name="quantity" id="quantity" class="form-control input-number text-center" placeholder="1" value="1" min="1" max="10">
                                    <span class="input-group-btn">
                                        <button class="btn btn-number" type="button" data-type="plus" data-field="quantity">
                                            <i class="la la-plus"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>
                    
                    <div class="row no-gutters">
                        <div class="col-2">
                            <div class="product-description-label mt-2">{{__('Date')}}:</div>
                        </div>
                        <div class="col-10">
                            <div class="row">
                                <div class="col-md-5">
                                    <input type="text" class="form-control" name="start_date" id="startDateModal" autocomplete="off" required>
                                </div>
                                <p>To</p>
                                <div class="col-md-5">
                                    <input type="text" class="form-control" name="end_date" id="endDateModal" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    @if (Auth::check())
                        <div class="row no-gutters pb-3 d-none" id="chosen_price_div">
                            <div class="col-2">
                                <div class="product-description-label">{{__('Total Price')}}:</div>
                            </div>
                            <div class="col-10">
                                <div class="product-price">
                                    <strong id="chosen_price">

                                    </strong>
                                </div>
                            </div>
                        </div>
                    @endif

                </form>

                <div class="d-table width-100 mt-3">
                    <div class="d-table-cell">
                        <!-- Add to cart button -->
                        <button type="button" id="addtocartModal" class="btn btn-orange btn-circle" onclick="addToCart()">
                            <i class="fa fa-cart-plus"></i> {{__('Add to cart')}}
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    cartQuantityInitialize();
    $('#addtocartModal').prop('disabled', true);
    $('#option-choice-form input').on('change', function(e){
        getVariantPrice();
        var periode = $(this).val();
        var start_date = $('#startDateModal').val();

        if (start_date != '') {
            if (periode === 'Harian') {
                dateEndByDay();
            }else if (periode === 'Mingguan') {
                dateEndByWeek();
            }else if(periode === 'Bulanan'){
                dateEndByMonth();
            }else if (periode === 'TigaBulan') {
                dateEndByThreeMonth();
            }else if (periode === 'EnamBulan') {
                dateEndBySixMonth();
            }else if (periode === 'Tahunan') {
                dateEndByYear();
            }
        }else{
            $('#endDateModal').attr('value', '');
        }
    });
    // Datepicker
    var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
    $('#startDateModal').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'dd mmm yyyy',
        iconsLibrary: 'fontawesome',
        minDate: today,
        close: function(e) {
            let checked = $('input[name=Periode]:checked').val();
            $('#addtocartModal').prop('disabled', false);
            switch (checked) {
                case 'Harian':
                    dateEndByDay();
                    break;
                case 'Mingguan':                        
                    dateEndByWeek();
                    break;
                case 'Bulanan':                        
                    dateEndByMonth();
                    break;
                case 'TigaBulan':                        
                    dateEndByThreeMonth();
                    break;
                case 'EnamBulan':
                    dateEndBySixMonth();
                    break;
                case 'Tahunan':
                    dateEndByYear();
                    break;
                default:
                    break;
            }
        }
    });

    function dateEndByDay() {
        $('#endDateModal').empty();
        const quantity = parseInt($('#quantity').val());
        let currentDate = new Date($('#startDateModal').val());
        let newDate = new Date(currentDate.getFullYear(), currentDate.getMonth() , currentDate.getDate() + quantity);
        $('#endDateModal').attr('value', dateFormat(newDate))
    }
    function dateEndByWeek(){
        $('#endDateModal').empty();
        const quantity = parseInt($('#quantity').val()) * 7;
        let currentDate = new Date($('#startDateModal').val());
        let newDate = new Date(currentDate.getFullYear(), currentDate.getMonth() , currentDate.getDate() + quantity);
        $('#endDateModal').attr('value', dateFormat(newDate))
    }
    function dateEndByMonth() {
        $('#endDateModal').empty();
        const quantity = parseInt($('#quantity').val());
        changeDate(quantity);
    }
    function dateEndByThreeMonth() {
        $('#endDateModal').empty();
        const quantity = parseInt($('#quantity').val()) * 3;
        changeDate(quantity);
    }
    function dateEndBySixMonth() {
        $('#endDateModal').empty();
        const quantity = parseInt($('#quantity').val()) * 6;
        changeDate(quantity);
    }
    function dateEndByYear() {
        $('#endDateModal').empty();
        const quantity = parseInt($('#quantity').val()) * 12;
        changeDate(quantity);
    }

    function changeDate(qty){
        let currentDate = new Date($('#startDateModal').val());
        let newDate = new Date(currentDate.getFullYear(), currentDate.getMonth() + qty, currentDate.getDate());
        let month =new Date(currentDate.getFullYear(), currentDate.getMonth() + (qty + 1), 0);
        if(newDate.getMonth() != month.getMonth()){
            newDate = month;
        }
        $('#endDateModal').attr('value', dateFormat(newDate))
    }
    

    $('#quantity').change(function(){
        let checked = $('input[name=Periode]:checked').val();
        if (checked === 'Harian') {
            if($('#endDateModal').val() != ''){
                dateEndByDay();
            }
        }else if (checked === 'Mingguan') {
            if($('#endDateModal').val() != ''){
                dateEndByWeek();
            }
        }else if (checked === 'Bulanan') {
            if($('#endDateModal').val() != ''){
                dateEndByMonth();
            }
        }else if (checked === 'TigaBulan') {
            if($('#endDateModal').val() != ''){
                dateEndByThreeMonth();
            }
        }else if (checked === 'EnamBulan') {
            if($('#endDateModal').val() != ''){
                dateEndBySixMonth();
            }
        }else if (checked === 'Tahunan') {
            if($('#endDateModal').val() != ''){
                dateEndByYear();
            }
        }
    })

        
    function nol(x){
        const y = (x>9)?(x>99)?x:''+x:'0'+x;
        return y; 
    }

    function dateFormat(date){
        const bulan = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        const year = date.getFullYear();
        const month = date.getMonth();
        const dates = date.getDate();
        return nol(dates) + ' ' + bulan[month] + ' ' + year;
    }

</script>
