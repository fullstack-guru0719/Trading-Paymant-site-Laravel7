@if(\App\Models\Plugin::where('act', 'custom-captcha')->where('status', 1)->first())

    <div class="form-group">
        @php echo  getCustomCaptcha() @endphp
    </div>


    <div class="form-group">
        <input type="text" name="captcha" class="form-control" placeholder="{{trans('Enter code')}}" required>
    </div>
@endif


