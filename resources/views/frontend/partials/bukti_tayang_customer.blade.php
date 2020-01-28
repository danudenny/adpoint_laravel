<div class="modal-header">
    <h5 class="modal-title strong-600 heading-5">
        Code Bukti: {{ $query->no_bukti }} | Code Order : {{ $query->no_order }}
    </h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<div class="modal-body px-3 pt-0">
    <div class="container">
        <div class="row">
           <div class="col-md-12">
                <section class="gallery-block cards-gallery">
                    <div class="container">
                        <div class="heading">
                        <h2>File Image</h2>
                        </div>
                        <div class="row">
                            @foreach (json_decode($query->file)->gambar as $key => $g)
                                <div class="col-md-4">
                                    <div class="card border-0 transform-on-hover">
                                        <a class="lightbox" href="{{ url($g) }}">
                                            <img src="{{ url($g) }}" alt="Card Image" class="card-img-top">
                                        </a>
                                        <div class="card-body">
                                            <h6><a href="#">Diambil sejak</a></h6>
                                            <p class="text-muted card-text"></p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </section>
           </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                 <section class="gallery-block cards-gallery">
                     <div class="container">
                         <div class="heading">
                         <h2>File Video</h2>
                         </div>
                         <div class="row">
                             @foreach (json_decode($query->file)->video as $key => $g)
                                 <div class="col-md-4">
                                     <div class="card border-0 transform-on-hover">
                                         <div class="embed-responsive embed-responsive-16by9">
                                            <video controls="true" class="embed-responsive-item">
                                              <source src="{{ url($g) }}" type="video/mp4" />
                                            </video>
                                         </div>
                                         <div class="card-body">
                                             <h6><a href="#">Diambil sejak</a></h6>
                                             <p class="text-muted card-text"></p>
                                         </div>
                                     </div>
                                 </div>
                             @endforeach
                         </div>
                     </div>
                 </section>
            </div>
         </div>
    </div>
</div>

<script>
baguetteBox.run('.cards-gallery', { animation: 'slideIn'});
</script>