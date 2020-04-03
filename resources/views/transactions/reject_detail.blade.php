<div class="modal-header">
    <h5 class="modal-title strong-600 heading-5">
        @php
            $product = \App\Product::where('id', $order_detail->product_id)->first();
        @endphp
        # {{ $product->name }}
    </h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<div class="modal-body px-3 pt-0">
    <table class="table">
        <tr>
            <td>Name</td>
            <td>:</td>
            <td>{{ $product->name }}</td>
        </tr>
        <tr>
            <td>Decription</td>
            <td>:</td>
            <td>{{ $order_detail->quantity }} <i>({{$order_detail->variation}})</i> </td>
        </tr>
        <tr>
            <td>Price</td>
            <td>:</td>
            <td>{{ single_price($order_detail->price) }}</td>
        </tr>
        <tr>
            <td>Alasan Reject</td>
            <td>:</td>
            <td>
                <i class="text-danger"><b>{{ $order_detail->rejected }}</b></i>
            </td>
        </tr>
    </table>
</div>

<script>
    
</script>