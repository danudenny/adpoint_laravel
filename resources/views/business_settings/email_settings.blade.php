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
                <div class="form-group">
                    <label>Logo Header</label>
                    <input type="file" class="form-control" name="logo_email">
                    <img src="{{ url($data->logo) }}" alt="" height="50">
                </div>
                <div class="form-group">
                    <label>Data Email</label>
                    @foreach ($data->data as $key => $d)
                        <div style="margin-top: 10px">
                            <a class="btn btn-primary btn-sm" data-toggle="collapse" data-target="#collapse{{$key}}" aria-expanded="false" aria-controls="collapse{{$key}}">
                                {{ $d->judul }}
                            </a>
                            <div class="collapse" id="collapse{{$key}}">
                                <div class="card card-body">
                                    <div class="row" style="margin-top:10px">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Subject</label>
                                                <input type="text" class="form-control" name="subject_email" value="{{$d->subject}}" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Content</label>
                                                <textarea class="form-control" name="content_email_{{$key}}" cols="10" rows="5" required>{{$d->content}}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
    
@endsection
@section('script')
    <script>
        var data = JSON.parse($('#data').val());
        data.forEach((e, i)=> {
            CKEDITOR.replace('content_email_'+i);
        });
    </script>
@endsection