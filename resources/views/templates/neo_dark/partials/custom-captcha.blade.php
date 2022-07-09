@if(\App\Models\Plugin::where('act', 'custom-captcha')->where('status', 1)->first())

    <div class="col-lg-12 form-group custom-form-field d-flex justify-content-center">
        @php echo  getCustomCaptcha() @endphp
    </div>


    <div class="col-lg-12 form-group custom-form-field align-item-center">
        <input type="text" name="captcha" placeholder="{{trans('Enter code')}}" required>
    </div>
@endif


