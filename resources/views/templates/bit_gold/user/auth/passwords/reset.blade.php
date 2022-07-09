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
                <form method="POST" action="{{ route('user.password.update') }}">
                        @csrf

                        <input type="hidden" name="email" value="{{ $email }}">
                        <input type="hidden" name="token" value="{{ $token }}">
                  <div class="form-group">
                    <label>{{ trans('Password') }}</label>
                    <input type="password" id="email" name="password" class="form-control" placeholder="{{trans('Password')}}" required>
                  </div>
                  <div class="form-group">
                    <label>{{ __('Confirm Password') }}</label>
                    <input type="password" id="email" name="password_confirmation" class="form-control" placeholder="{{trans('Confirm Password')}}" required>
                  </div>
                  <div class="mt-3">
                    <button type="submit" class="cmn-btn">@lang('Reset Password')</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

@endsection
