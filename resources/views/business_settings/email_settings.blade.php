@extends('layouts.app')

@section('content')

@php
    $data = json_decode($email_settings->value);
@endphp
<div class="row">
    <div class="col-lg-12">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title text-center">{{__('Email Settings')}}</h3>
            </div>
            <input type="hidden" id="data" value="{{ json_encode($data->data) }}">
            <div class="panel-body">
                <form action="{{ route('update.email.settings') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label>Logo Header</label>
                        <input type="file" class="form-control" name="logo_email">
                        <img src="{{ url($data->logo) }}" alt="" height="50">
                    </div>
                    <div class="form-group">
                        <label>Footer</label>
                        <textarea name="footer_email" class="form-control" cols="10" rows="5">{{$data->footer}}</textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success"><i class="fa fa-refresh"></i> Update Logo And Footer</button>
                    </div>
                </form>
                <hr style="height: 3px; background-color: black">
                <div class="form-group">
                    <label>Data Email</label>
                    <div class="row">
                        <div class="col-md-4">
                            <h4>Proses Registrasi User</h4>
                            @foreach ($data->data as $key => $d)
                                @if ($key <= 4)
                                    <div>
                                        <a class="btn btn-primary" style="margin-top:10px" data-toggle="modal" data-target="#collapse{{$key}}" aria-expanded="false" aria-controls="collapse{{$key}}">
                                            <b>{{ $d->judul }}</b> <i class="fa fa-edit"></i> Edit
                                        </a>
                                    </div>
                                @endif
        
                                <!-- Modal -->
                                <div class="modal fade" id="collapse{{$key}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">{{ $d->judul }} (Email)</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="{{ route('update.content.email') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="key" value="{{$key}}">
                                        <div class="modal-body">
                                            <div class="card card-body">
                                                <div class="row" style="margin-top:10px">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>Subject</label>
                                                            <input type="text" class="form-control" id="subject_email_{{$key}}" name="subject_email" value="{{$d->subject}}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Content</label>
                                                            <textarea class="form-control" id="content_email_{{$key}}" name="content_email" cols="10" rows="5" required>{{$d->content}}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                        </div>
                                    </form>
                                    </div>
                                </div>
                                </div>
                             @endforeach
                        </div>
                        <div class="col-md-4">
                            <h4>Proses Registrasi Shop</h4>
                            @foreach ($data->data as $key => $d)
                                @if ($key==5 || $key==6 || $key==7)
                                    <div>
                                        <a class="btn btn-primary" style="margin-top:10px" data-toggle="modal" data-target="#collapse{{$key}}" aria-expanded="false" aria-controls="collapse{{$key}}">
                                            <b>{{ $d->judul }}</b> <i class="fa fa-edit"></i> Edit
                                        </a>
                                    </div>
                                @endif
        
                                <!-- Modal -->
                                <div class="modal fade" id="collapse{{$key}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">{{ $d->judul }} (Email)</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="{{ route('update.content.email') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="key" value="{{$key}}">
                                        <div class="modal-body">
                                            <div class="card card-body">
                                                <div class="row" style="margin-top:10px">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>Subject</label>
                                                            <input type="text" class="form-control" id="subject_email_{{$key}}" name="subject_email" value="{{$d->subject}}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Content</label>
                                                            <textarea class="form-control" id="content_email_{{$key}}" name="content_email" cols="10" rows="5" required>{{$d->content}}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                        </div>
                                    </form>
                                    </div>
                                </div>
                                </div>
                             @endforeach
                        </div>
                        <div class="col-md-4">
                            <h4>Proses Order</h4>
                            @foreach ($data->data as $key => $d)
                                @if ($key>=8)
                                    <div>
                                        <a class="btn btn-primary" style="margin-top:10px" data-toggle="modal" data-target="#collapse{{$key}}" aria-expanded="false" aria-controls="collapse{{$key}}">
                                            <b>{{ $d->judul }}</b> <i class="fa fa-edit"></i> Edit
                                        </a>
                                    </div>
                                @endif
        
                                <!-- Modal -->
                                <div class="modal fade" id="collapse{{$key}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">{{ $d->judul }} (Email)</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="{{ route('update.content.email') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="key" value="{{$key}}">
                                        <div class="modal-body">
                                            <div class="card card-body">
                                                <div class="row" style="margin-top:10px">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>Subject</label>
                                                            <input type="text" class="form-control" id="subject_email_{{$key}}" name="subject_email" value="{{$d->subject}}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Content</label>
                                                            <textarea class="form-control" id="content_email_{{$key}}" name="content_email" cols="10" rows="5" required>{{$d->content}}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                        </div>
                                    </form>
                                    </div>
                                </div>
                                </div>
                             @endforeach
                        </div>
                    </div>

                   
                </div>
            </div>
        </div>
    </div>
</div>
    
@endsection
@section('script')
    <script>
        CKEDITOR.replace('footer_email');
        var data = JSON.parse($('#data').val());
        data.forEach((e, i)=> {
            CKEDITOR.replace('content_email_'+i);
        });
    </script>
@endsection