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
    <form action="{{ route('reject.detail.proses') }}" method="POST">
        @csrf
        <input type="hidden" name="order_detail_id" value="{{ $order_detail->id }}">
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
                    <i class="text-warning">{{ $order_detail->rejected }}</i>
                </td>
            </tr>
        </table>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-check"></i> Yes, reject to continue
            </button>
        </div>
    </form>
</div>

<script>
    
</script>