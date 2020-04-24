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
                            <div class="col-md-5">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Start Date" id="Awal">
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="End Date" id="Akhir">
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <button onclick="findLogs()" id="btn-apply" class="btn btn-block btn-info">Apply</button>
                                </div>
                            </div>
                        </div>
                        <!-- Order history table -->
                        <div class="card no-border mt-4">
                            <div>
                                <table class="table table-sm table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Log ID</th>
                                            <th>{{__('Media Name')}}</th>
                                            <th>{{__('Media Type')}}</th>
                                            <th>{{__('Playlist Name')}}</th>
                                            <th>{{__('Device Group')}}</th>
                                            <th>{{__('Device ID')}}</th>
                                            <th>{{__('Display Date')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody id="data-display-log">
                                        <div class="c-nav-load">
                                            <div class="ph-item border-0 p-0 mt-3">
                                                <div class="ph-col-12">
                                                    <div class="ph-row">
                                                        <div class="ph-col-12 big"></div>
                                                        <div class="ph-col-12 big"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
        $('#Awal').datepicker({
            uiLibrary: 'bootstrap4',
            iconsLibrary: 'fontawesome',
            format: 'dd mmm yyyy',
            maxDate: function () {
                return $('#Akhir').val();
            }
        });
        $('#Akhir').datepicker({
            uiLibrary: 'bootstrap4',
            iconsLibrary: 'fontawesome',
            format: 'dd mmm yyyy',
            minDate: function () {
                return $('#Awal').val();
            }
        });

        var d = new Date();
        var month = new Array();
        month[0] = "Jan";
        month[1] = "Feb";
        month[2] = "Mar";
        month[3] = "Apr";
        month[4] = "May";
        month[5] = "Jun";
        month[6] = "Jul";
        month[7] = "Aug";
        month[8] = "Sep";
        month[9] = "Oct";
        month[10] = "Nov";
        month[11] = "Dec";
        var date = d.getDate().toString();
        var month = month[d.getMonth()];
        var year = d.getFullYear().toString();
        var result = date+' '+month+' '+year;

        $('#Awal').val(result);
        $('#Akhir').val(result);

        changeFormatTglAwal($('#Awal').val());
        changeFormatTglAkhir($('#Akhir').val());

        function changeFormatTglAwal(awal) {
            var dAwal = new Date(awal);
            var bulan = new Array();
                bulan[0] = "01";
                bulan[1] = "02";
                bulan[2] = "03";
                bulan[3] = "04";
                bulan[4] = "05";
                bulan[5] = "06";
                bulan[6] = "07";
                bulan[7] = "08";
                bulan[8] = "09";
                bulan[9] = "10";
                bulan[10] = "11";
                bulan[11] = "12";
            var tglAwalParam = dAwal.getFullYear().toString()+'-'+bulan[dAwal.getMonth()]+'-'+dAwal.getDate().toString();
            return tglAwalParam;
        }

        function changeFormatTglAkhir(akhir) {
            var dAkhir = new Date(akhir);
            var bulan = new Array();
                bulan[0] = "01";
                bulan[1] = "02";
                bulan[2] = "03";
                bulan[3] = "04";
                bulan[4] = "05";
                bulan[5] = "06";
                bulan[6] = "07";
                bulan[7] = "08";
                bulan[8] = "09";
                bulan[9] = "10";
                bulan[10] = "11";
                bulan[11] = "12";
            var tglAkhirParam = dAkhir.getFullYear().toString()+'-'+bulan[dAkhir.getMonth()]+'-'+dAkhir.getDate().toString();
            return tglAkhirParam;
        }

        function getTokenSmartMedia(){
            var token = "";
            $.ajax({
                async: false,
                url: "https://aps.jaladara.com/api/users/login",
                type: "POST",
                dataType: "JSON",
                crossDomain: true,
                data: {
                    'email':'adpoint@imaniprima.com',
                    'password': '123456'
                },
                success: function(res){
                    token = res.token;
                },
                error: function(err) {
                    console.log(err);
                }
            })
            return token;
        }

        var tokenSmart = getTokenSmartMedia();

        function getDisplayLog(s, e) {
            $.ajax({
                url: 'https://aps.jaladara.com/api/reports/displaylog/all?deviceid=SmartMedia5054&interval='+s+','+e+'&limit=20&media_type=Commercial&offset=0&order=displaydate&ordertype=desc&q=',
                type: 'GET',
                dataType: 'JSON',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${tokenSmart}`,
                },
                success: function(res) {
                    var result = res.data;
                    if (result.length > 0) {
                        $.each(result, function(i, data){
                            var row = `<tr>
                                            <td>`+data.displaylogid+`</td>
                                            <td>`+data.media_name+`</td>
                                            <td>`+data.media_type+`</td>
                                            <td>`+data.playlistname+`</td>
                                            <td>`+data.devicegroupname+`</td>
                                            <td>`+data.deviceid+`</td>
                                            <td>`+data.displaydate_str+`</td>
                                        </tr>`
                            $('#data-display-log').append(row);
                        });
                    }else {
                        var row = `<tr>
                                    <td colspan="7" align="center">Tidak ada log</td>
                                </tr>`
                        $('#data-display-log').append(row);
                    }
                    $('#btn-apply').html('Apply');
                    $('.c-nav-load').hide();
                },
                error: function(err) {
                    console.log(err)
                }
            })
        }

        
        getDisplayLog(changeFormatTglAwal($('#Awal').val()), changeFormatTglAkhir($('#Akhir').val()));

        function findLogs() {
            $('#btn-apply').html('<i class="fa fa-spin fa-spinner"></i> Loading...');
            $('.c-nav-load').show();
            $('#data-display-log').empty();
            getDisplayLog(changeFormatTglAwal($('#Awal').val()), changeFormatTglAkhir($('#Akhir').val()));
        }
    </script>    
@endsection


