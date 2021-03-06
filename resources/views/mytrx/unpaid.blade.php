<style>

    .bg-pay {
        background-color: #f5f5f5;
        padding: 10px;
        border-radius: 10px;
        border: 1px dashed;
        text-align: center;
    }

</style>
@if (count($trx) > 0)
    @foreach ($trx as $no => $t)
        <div style="border-bottom: 1px solid #ccc">
            <div class="card no-border mt-2">
                <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <td>
                                <small>Code:</small><br>
                                <b>{{ $t->code }}</b>
                            </td>
                            <td>
                                <small>Date:</small><br>
                                <i class="fa fa-clock-o"></i> <b>{{ date('d M Y H:i:s', strtotime($t->created_at)) }}</b>
                            </td>
                            <td>
                                <small>Status:</small><br>
                                @if ($t->status == "on proses")
                                    <i class="text-primary">On proses</i>
                                @elseif ($t->status == "approved")
                                    <i class="text-success">Approved</i>
                                @elseif ($t->status == "rejected")
                                    <i class="text-danger">Rejected</i>
                                @elseif ($t->status == "ready")
                                    <i class="text-primary">Checked Seller</i>
                                @elseif ($t->status == "confirmed")
                                    <i class="text-primary">Confirmed</i>
                                @elseif ($t->status == "paid")
                                    <i class="text-success">Paid</i>
                                @endif
                            </td>
                            <td>
                                <button onclick="trxDetails({{ $t->id }})" class="btn btn-sm btn-circle btn-outline-info pull-right mr-2"><i class="fa fa-eye"></i> Details</button>
                            </td>
                            @if ($t->status === "confirmed")
                                <tr>
                                    <table class="table" style="width: 50%;" align="center">
                                        <tr>
                                            <td>
                                                <div class="row mt-2 bg-pay">
                                                    <div class="col-12">
                                                        <div class="text-center">
                                                            @php
                                                                $grand_total = 0;
                                                                foreach ($t->orders as $key => $o) {
                                                                    $grand_total += $o->grand_total;
                                                                }
                                                            @endphp
                                                            <p>
                                                                <strong>
                                                                    The total bill you must pay
                                                                </strong><br>
                                                                click <b>Yes</b> to continue or <b>No</b> to cancel the transaction
                                                            </p>
                                                            
                                                            <h4 class="text-danger">{{ single_price($grand_total) }}</h4>
                                                            <a href="{{ route('continue.payment', encrypt($t->id)) }}" class="btn btn-sm btn-outline-primary btn-circle">
                                                                <i class="fa fa-check"></i> Yes
                                                            </a>
                                                            <a href="" class="btn btn-sm btn-outline-danger btn-circle">
                                                                <i class="fa fa-times"></i> No
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </tr>
                            @endif
                            @if ($t->status === "continue")
                                <tr>
                                    <table class="table" style="width: 50%;" align="center">
                                        <tr>
                                            <td>
                                                <div class="row mt-2 bg-pay">
                                                    <div class="col-12">
                                                        <div class="text-info text-center">
                                                            @php
                                                                $orderdate = date('M d, Y H:i:s', strtotime($t->created_at));
                                                                $countdown = date('M d, Y H:i:s', strtotime(\Carbon\Carbon::createFromTimestamp(strtotime($t->created_at))->addHour(24)));
                                                                $grand_total = 0;
                                                                foreach ($t->orders as $key => $o) {
                                                                    $grand_total += $o->grand_total;
                                                                }
                                                            @endphp
                                                            
                                                           
                                                            <input type="hidden" id="od" value="{{ $orderdate  }}">
                                                            <input type="hidden" id="cd" value="{{ $countdown  }}">
                                                            The total bill you must pay:
                                                            <h5 class="text-danger strong-700">{{ single_price($grand_total) }}</h5>
                                                            Please make payment before <br> 
                                                            {{ date('d M Y H:i:s', strtotime(\Carbon\Carbon::createFromTimestamp(strtotime($t->created_at))->addHour(24))) }}
                                                            <br>
                                                            <h5 id="demo"></h5>
                                                            <a href="{{ route('confirm.payment.id', encrypt($t->id)) }}" class="btn btn-circle btn-sm btn-outline-warning"><i class="fa fa-money"></i> Pay Now</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </tr>
                            @endif
                            @if ($t->status === "paid")
                                <tr>
                                    <table class="table" style="width: 70%" align="center">
                                        <tr>
                                            <td>
                                                <div class="row mt-2 bg-pay">
                                                    <div class="col-12">
                                                        <div class="text-center">
                                                            @if ($t->status === "paid" || $t->payment_status === 1)
                                                                <h4 class="text-danger">
                                                                    <i class="fa fa-spin fa-spinner"></i> Waiting approval admin...
                                                                </h4>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </tr>
                            @endif
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    @endforeach
@else 
    @include('frontend.not_found')
@endif

<script>

    var od = $('#od').val();
    var cd = $('#cd').val();
    // Set the date we're counting down to
    var countDownDate = new Date(cd).getTime();

    // var orderDate = new Date(od).getTime();
    // Update the count down every 1 second
    var x = setInterval(function() {
        // Get today's date and time
        var now = new Date().getTime();
        
        // Find the distance between now and the count down date
        var distance = countDownDate - now;
        
        // Time calculations for days, hours, minutes and seconds
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);
            
        // Output the result in an element with id="demo"
        if (document.getElementById("demo") !== null) {
            document.getElementById("demo").innerHTML = days + "d " + hours + "h "
            + minutes + "m " + seconds + "s ";
        }
        
        // If the count down is over, write some text 
        if (distance < 0) {
            clearInterval(x);
            if (document.getElementById("demo") !== null) {
                document.getElementById("demo").innerHTML = "EXPIRED";
            }
        }
    }, 1000);
</script>
