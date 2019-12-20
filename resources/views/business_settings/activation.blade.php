@extends('layouts.app')

@section('content')
<style>
    .logo_card {
        padding: 5px;
        border: 1px solid #004085;
        border-radius: 4px;
    }

</style>
<h3 class="text-center">{{__('Activation')}}</h3>
<div class="row">
    <div class="col-lg-4" hidden>
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title text-center">{{__('Vendor System Activation')}}</h3>
            </div>
            <div class="panel-body text-center">
                <label class="switch">
                    <input type="checkbox" onchange="updateSettings(this, 'vendor_system_activation')" <?php if(\App\BusinessSetting::where('type', 'vendor_system_activation')->first()->value == 1) echo "checked";?>>
                    <span class="slider round"></span>
                </label>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title text-center">{{__('Email Verification')}}</h3>
            </div>
            <div class="panel-body text-center">
                <label class="switch">
                    <input type="checkbox" onchange="updateSettings(this, 'email_verification')" <?php if(\App\BusinessSetting::where('type', 'email_verification')->first()->value == 1) echo "checked";?>>
                    <span class="slider round"></span>
                </label>
                <div class="alert" style="color: #004085;background-color: #cce5ff;border-color: #b8daff;margin-bottom:0;margin-top:10px;">
                    You need to configure SMTP correctly to enable this feature. <a href="{{ route('smtp_settings.index') }}">Configure Now</a>
                </div>
            </div>
        </div>
    </div>

</div>

<h3 class="text-center">{{__('Payment Method')}}</h3>

<div class="row">
    <div class="col-lg-4">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title text-center">{{__('Bank Transfer BCA & Mandiri')}}</h3>
            </div>
            <div class="panel-body text-center">
                <div class="clearfix">
                    <img class="logo_card" src="{{ asset('frontend/images/icons/cards/bca.png') }}" height="40">
                    <img class="logo_card" src="{{ asset('frontend/images/icons/cards/mandiri.png') }}" height="40">
                    <label class="switch pull-right">
                        <input type="checkbox" onchange="updateSettings(this, 'cash_payment')" <?php if(\App\BusinessSetting::where('type', 'cash_payment')->first()->value == 1) echo "checked";?>>
                        <span class="slider round"></span>
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@section('script')
    <script type="text/javascript">
        function updateSettings(el, type){
            if($(el).is(':checked')){
                var value = 1;
            }
            else{
                var value = 0;
            }
            console.log(value);
            $.post('{{ route('business_settings.update.activation') }}', {_token:'{{ csrf_token() }}', type:type, value:value}, function(data){
                if(data == '1'){
                    showAlert('success', 'Settings updated successfully');
                }
                else{
                    showAlert('danger', 'Something went wrong');
                }
            });
        }
    </script>
@endsection
