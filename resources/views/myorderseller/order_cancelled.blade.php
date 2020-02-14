@if (count($order_details) > 0)
    @foreach ($order_details as $key => $od)
        <div style="border-bottom: 1px solid #ccc">
            <article class="card no-border mt-1">
                <div class="table-responsive">
                    <table class="table">
                        @php
                            $product = \App\Product::where('id', $od->product_id)->first();
                        @endphp
                        <tr>
                            <td width="100">
                                <img width="150" src="{{ url(json_decode($product->photos)[0]) }}" class="img-fluid" width="50">
                            </td>
                            <td width="250"> 
                                <a target="_blank" href="{{ route('product', $product->slug) }}">{{ $product->name }}</a><br>
                                {{ $od->variation }} 
                                <small>
                                    ( {{ date('d M Y', strtotime($od->start_date)) }} - {{ date('d M Y', strtotime($od->end_date)) }} )
                                </small>
                            </td>
                            <td width="200">
                                <div style="font-size: 11px;">
                                    Date: <br>
                                    {{ date('d M Y H:i:s', strtotime($od->created_at)) }}
                                </div>
                            </td>
                            <td align="right">
                                <button class="btn btn-outline-secondary btn-circle btn-sm" onclick="itemDetailsSeller({{ $od->id }})">
                                    <i class="fa fa-eye"></i> Details
                                </button>
                            </td>
                        </tr>
                    </table>
                </div>
            </article>
        </div>
    @endforeach
@else 
    @include('frontend.not_found')
@endif