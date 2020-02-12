<style>
    .card-unpaid{
        background-color: #F5EFCF;
        font-style: italic;
        border-radius: 5px;
        padding: 10px;
        color: #F27455;
    }
    .card-unpaid b {
        color: #517D8A;
        text-decoration: underline;
    }

</style>
@if (count($trx) > 0)
    @foreach ($trx as $no => $t)
        <div style="border-bottom: 1px solid #ccc">
            <div class="card no-border mt-2">
                <table class="table">
                    <tr>
                        <td>
                            <b>{{ $t->code }}</b> | Date: <i class="fa fa-clock-o"></i> <i>{{ date('d M Y H:i:s', strtotime($t->created_at)) }}</i>
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
                                <i class="badge badge-success">Paid</i>
                            @elseif ($t->status == "cancelled")
                                <h5 class="badge badge-danger">Cancelled</h5>
                            @endif
                            @if ($t->status === "confirmed")
                                <a href="{{ route('confirm.payment.id', encrypt($t->id)) }}" class="btn btn-sm btn-circle btn-outline-warning pull-right"><i class="fa fa-money"></i> Pay</a>
                            @endif
                            <button onclick="trxDetails({{ $t->id }})" class="btn btn-sm btn-circle btn-outline-info pull-right mr-2"><i class="fa fa-eye"></i> Details</button>
                            @if ($t->status === "confirmed")
                                <hr style="background: red">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="text-info">
                                            @php
                                                $orderdate = date('M d, Y H:i:s', strtotime($t->created_at));
                                                $countdown = date('M d, Y H:i:s', strtotime(\Carbon\Carbon::createFromTimestamp(strtotime($t->created_at))->addHour(24)));
                                            @endphp
                                            Silahkan melakukan pembayaran sebelum {{ date('d M Y H:i:s', strtotime(\Carbon\Carbon::createFromTimestamp(strtotime($t->created_at))->addHour(24))) }}
                                            <br>
                                            <input type="hidden" id="od" value="{{ $orderdate  }}">
                                            <input type="hidden" id="cd" value="{{ $countdown  }}">
                                            <h1 id="demo"></h1>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="text-right">
                                            
                                        </div>
                                    </div>
                                </div>
                            @elseif ($t->status === "cancelled")
                                <div class="row">
                                    <div class="col-md-7">
                                        <div class="card-unpaid">
                                            Transaksi anda telah dibatalkan karena belum ada pembayaran yang kami terima.
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if ($t->status === "paid")
                                <hr>
                                <div class="row">
                                    <div class="col-md-8">
                                        
                                    </div>
                                    <div class="col-md-4">
                                        <div class="text-right">
                                            @if ($t->status === "paid" || $t->payment_status === 1)
                                                <span class="badge badge-danger">Waiting approval admin...</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </td>
                    </tr>
                </table>
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
        document.getElementById("demo").innerHTML = days + "d " + hours + "h "
        + minutes + "m " + seconds + "s ";
        
        // If the count down is over, write some text 
        if (distance < 0) {
            clearInterval(x);
            document.getElementById("demo").innerHTML = "EXPIRED";
        }
    }, 1000);
</script>
