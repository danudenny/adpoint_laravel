@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="panel">
            {{--            <div class="panel-title"><strong>{{__("Tour Filters")}}</strong></div>--}}
            <div class="panel-body">
                <div class="filter-div d-flex justify-content-between ">
                    <div class="col-left">
                        {!! $calendar->calendar() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    {!! $calendar->script() !!}
@endsection

