<div class="modal-header">
    <h5 class="modal-title strong-600 heading-5">
        # {{ \App\Product::where('id', $query->product_id)->first()->name}}
    </h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<style>
/* Rating Star Widgets Style */
.rating-stars ul {
  list-style-type:none;
  padding:0;
  
  -moz-user-select:none;
  -webkit-user-select:none;
}
.rating-stars ul > li.star {
  display:inline-block;
}

/* Idle State of the stars */
.rating-stars ul > li.star > i.fa {
  font-size:2.5em; /* Change the size of the stars */
  color:#ccc; /* Color on idle state */
}

/* Hover state of the stars */
.rating-stars ul > li.star.hover > i.fa {
  color:orange;
}

/* Selected state of the stars */
.rating-stars ul > li.star.selected > i.fa {
  color:orange;
}
</style>

<div class="modal-body px-3 pt-0">
    @php
        $review = \App\Review::where(['product_id' => $query->product_id, 'user_id' => Auth::user()->id])->first();
        $product = \App\Product::where('id', $query->product_id)->first();
    @endphp
    @if ($review !== null)
        <div class="row">
            <div class="col-md-12">
                <div class="star-rating mb-1">
                    {{ renderStarRating($product->rating) }}
                </div>
                <div class="alert alert-success">{{ $review->comment }}</div>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-md-12">
                <form action="{{ route('create.review.product') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <!-- Rating Stars Box -->
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class='rating-stars text-center'>
                                    <ul id='stars'>
                                        <li class='star' title='Poor' data-value='1'>
                                            <i class='fa fa-star fa-fw'></i>
                                        </li>
                                        <li class='star' title='Fair' data-value='2'>
                                            <i class='fa fa-star fa-fw'></i>
                                        </li>
                                        <li class='star' title='Good' data-value='3'>
                                            <i class='fa fa-star fa-fw'></i>
                                        </li>
                                        <li class='star' title='Excellent' data-value='4'>
                                            <i class='fa fa-star fa-fw'></i>
                                        </li>
                                        <li class='star' title='WOW!!!' data-value='5'>
                                            <i class='fa fa-star fa-fw'></i>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        
                        <div class="alert alert-success" id="msg">
                            
                        </div>
                    </div>
                    <input type="hidden" name="product_id" value="{{ $query->product_id }}">
                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                    <input type="hidden" name="rating" id="rating" value="">
                    <div class="form-group">
                        <label>Comment</label>
                        <textarea name="comment" class="form-control" cols="10" rows="5"></textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
    
</div>

<script>
$(document).ready(function(){
    $('#msg').hide();
    /* 1. Visualizing things on Hover - See next part for action on click */
    $('#stars li').on('mouseover', function(){
        var onStar = parseInt($(this).data('value'), 10); // The star currently mouse on
    
        // Now highlight all the stars that's not after the current hovered star
        $(this).parent().children('li.star').each(function(e){
        if (e < onStar) {
            $(this).addClass('hover');
        }
        else {
            $(this).removeClass('hover');
        }
        });
        
    }).on('mouseout', function(){
        $(this).parent().children('li.star').each(function(e){
        $(this).removeClass('hover');
        });
    });
  
  
    /* 2. Action to perform on click */
    $('#stars li').on('click', function(){
        var onStar = parseInt($(this).data('value'), 10); // The star currently selected
        var stars = $(this).parent().children('li.star');
        
        for (i = 0; i < stars.length; i++) {
        $(stars[i]).removeClass('selected');
        }
        
        for (i = 0; i < onStar; i++) {
        $(stars[i]).addClass('selected');
        }
        
        // JUST RESPONSE (Not needed)
        var ratingValue = parseInt($('#stars li.selected').last().data('value'), 10);
        $('#rating').val(ratingValue);
        var msg = "";
        if (ratingValue > 1) {
            msg = "Thanks! You rated this " + ratingValue + " stars.";
        }
        else {
            msg = "We will improve ourselves. You rated this " + ratingValue + " stars.";
        }
        responseMessage(msg);
    });
  
  
});

function responseMessage(msg) {
    $('#msg').show();
    $('#msg').fadeIn(200);  
    $('#msg').html("<span>" + msg + "</span>");
}
</script>