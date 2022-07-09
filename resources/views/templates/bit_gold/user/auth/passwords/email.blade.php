@extends($activeTemplate.'layouts.frontend')
@section('content')
    <!-- account section start -->
    <div class="account-section bg_img">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-xl-5 col-lg-7">
            <div class="account-card">
              
              <div class="account-card__body">
                <h2>@lang('Reset Password')</h2>
                <form action="{{ route('user.password.email') }}" class="mt-4" method="post">
                  @csrf
                  <div class="form-group">
                    <label>{{ trans('Email Address') }}</label>
                    <input id="email" type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="{{trans('Email Address')}}" required autocomplete="email" autofocus>
                  </div>
                  <div class="mt-3">
                    <button type="submit" class="cmn-btn">@lang('Send Password Reset Code')</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- account section end -->
@endsection
