@extends('frontend.layouts.app')

@section('content')

    <section class="gry-bg py-4 profile">
        <div class="container">
            <div class="row cols-xs-space cols-sm-space cols-md-space">
                <div class="col-lg-3 d-none d-lg-block">
                    @include('frontend.inc.seller_side_nav')
                </div>

                <div class="col-lg-9">
                    <div class="main-content">
                        <!-- Page title -->
                        <div class="page-title">
                            <div class="row align-items-center">
                                <div class="col-md-6 col-12">
                                    <h2 class="heading heading-6 text-capitalize strong-600 mb-0">
                                       Display Log
                                    </h2>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="float-md-right">
                                        <ul class="breadcrumb">
                                            <li><a href="{{ route('home') }}">{{__('Home')}}</a></li>
                                            <li><a href="{{ route('dashboard') }}">{{__('Dashboard')}}</a></li>
                                            <li class="active"><a href="{{ url('display_log') }}">{{__('Display Log')}}</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row no-border mt-4">
                            <div class="col-md-10">
                                <div class="form-group">
                                    <div id="reportrange" style="background: #fff; cursor: pointer; padding: 8px; border: 1px solid #ccc; width: 100%; border-radius: 3px;">
                                        <i class="fa fa-calendar"></i>&nbsp;
                                        <span></span> <i class="fa fa-caret-down"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <input type="hidden" name="date_start" id="date_start" value="">
                                <input type="hidden" name="date_end" id="date_end" value="">
                                <input type="hidden" name="status" id="status" value="">
                                <div class="form-group">
                                    <button onclick="findLogs()" class="btn btn-block btn-outline-info">Apply</button>
                                </div>
                            </div>
                        </div>

                        <!-- Order history table -->
                        <div class="card no-border mt-4">
                            <div>
                                <table class="table table-sm table-hover table-responsive-md" id="table">
                                    <thead>
                                        <tr>
                                            <th>Log ID</th>
                                            <th>{{__('Media Name')}}</th>
                                            <th>{{__('Media Type')}}</th>
                                            <th>{{__('Playlist Name')}}</th>
                                            <th>{{__('Device Group')}}</th>
                                            <th>{{__('Device ID')}}</th>
                                            <th>{{__('Display Date')}}</th>
                                            <th>{{__('Actions')}}</th>   
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($collect as $key => $val)
                                        <tr>
                                            <td>{{ $val->displaylogid }}</td>
                                            <td>{{ $val->media_name }}</td>
                                            <td>{{ $val->media_type }}</td>
                                            <td>{{ $val->playlistname }}</td>
                                            <td>{{ $val->devicegroupname }}</td>
                                            <td>{{ $val->deviceid }}</td>
                                            <td>{{ $val->displaydate_str }}</td>
                                            <td></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('script')
    <script>
        // date range picker
        var start = moment().subtract(29, 'days');
        var end = moment();

        function cb(start, end) {
            $('#reportrange span').html(start.format('D MMMM YYYY') + ' - ' + end.format('D MMMM YYYY'));
            var val_date_start = start.format('YYYY-MM-DD');
            var val_date_end = end.format('YYYY-MM-DD');
            $('#date_start').val(val_date_start);
            $('#date_end').val(val_date_end);
        }

        $('#reportrange').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
               'Today': [moment(), moment()],
               'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
               'Last 7 Days': [moment().subtract(6, 'days'), moment()],
               'Last 30 Days': [moment().subtract(29, 'days'), moment()],
               'This Month': [moment().startOf('month'), moment().endOf('month')],
               'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);

        cb(start, end);

        function findLogs() {
            $('.c-nav-load').show();
            var start = $('#date_start').val();
            var end = $('#date_end').val();

            var data = {
                _token:'{{ csrf_token() }}',
                start : start,
                end : end,
            }
            var myHeaders = new Headers();
                myHeaders.append("Authorization", $SESSION_['integrate']);

            var requestOptions = {
                method: 'GET',
                headers: myHeaders,
                redirect: 'follow'
            };

            fetch("http://192.168.100.64/api/reports/displaylog/all?deviceid=SmartMedia5054&interval=2017-04-01,2020-04-07&limit=20&media_type=Commercial&offset=0&order=displaydate&ordertype=desc&q=", requestOptions)
                .then(response => response.text())
                .then(result => console.log(result))
                .catch(error => console.log('error', error));

        }

        function findLogsProses(object, attr) {
            $.post('{{ route('find.orders') }}', object, function(data){
                $('.c-nav-load').hide();
                $(attr).html(data);
            });
        }
    </script>
@show
