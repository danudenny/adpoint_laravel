<div class="modal-body p-4">
    <div class="row no-gutters cols-xs-space cols-sm-space cols-md-space">
        <div class="col-lg-6">
            <table class="details-table table">
                <tr>
                    <td class="w-50 strong-600">{{__('Product Name')}}</td>
                    <td>: {{ $data->product_name }}</td>
                </tr>
                <tr>
                    <td class="w-50 strong-600">{{__('No Bukti Tayang')}}</td>
                    <td>: {{ $data->no_bukti }}</td>
                </tr>
                <tr>
                    <td class="w-50 strong-600">{{__('No Order')}}</td>
                    <td>: {{ $data->no_order }}</td>
                </tr>
                <tr>
                    <td class="w-50 strong-600">{{__('Seller Name')}}</td>
                    <td>: {{ $data->seller_name }}</td>
                </tr>
            </table>
        </div>
    </div>
    <hr>
    <div class="row">
        <section class="gallery-block cards-gallery">
            <div class="container">
                <div class="heading">
                  <h2>Bukti Tayang</h2>
                </div>
                <div class="row">
                    @php
                        $files = json_decode($data->file);
                    @endphp
                    @if ($files->gambar != null)
                        @foreach ($files->gambar as $key => $gambar)
                            <div class="col-md-6 col-lg-4">
                                <div class="card border-0 transform-on-hover">
                                    <a class="lightbox" href="{{ $gambar->filename }}">
                                        <img src="{{ $gambar->filename }}" alt="Card Image" class="card-img-top">
                                    </a>
                                    <div class="card-body">
                                        <h6><a href="#">Diambil sejak</a></h6>
                                        <p class="text-muted card-text">{{ date('d M Y h:i:s', strtotime($gambar->description)) }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                    @if ($files->video != null)
                        @foreach ($files->video as $key => $video)
                            <div class="col-md-6 col-lg-4">
                                <div class="card border-0 transform-on-hover">
                                    <a class="lightbox" href="{{ $video->filename }}">
                                        <img src="{{ $video->filename }}" alt="Card Image" class="card-img-top">
                                    </a>
                                    <div class="card-body">
                                        <h6><a href="#">Diambil sejak</a></h6>
                                        <p class="text-muted card-text">{{ date('d M Y h:i:s', strtotime($video->description)) }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                    @if ($files->zip != null)
                        @foreach ($files->zip as $key => $zip)
                            <div class="col-md-6 col-lg-4">
                                <div class="card border-0 transform-on-hover">
                                    <a class="lightbox" href="{{ $zip->filename }}">
                                        <img src="{{ $zip->filename }}" alt="Card Image" class="card-img-top">
                                    </a>
                                    <div class="card-body">
                                        <h6><a href="#">Diambil sejak</a></h6>
                                        <p class="text-muted card-text">{{ date('d M Y h:i:s', strtotime($zip->description)) }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </section>
    </div>
</div>

<script>
baguetteBox.run('.cards-gallery', { animation: 'slideIn'});
</script>