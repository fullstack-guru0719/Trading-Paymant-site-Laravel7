@extends($activeTemplate.'layouts.frontend')
@section('content')
@php
    $loginContent = getContent('login.content',true);
@endphp
    <!-- account section start -->
    <div class="account-section bg_img" data-background="{{ getImage('assets/images/frontend/login/'.@$loginContent->data_values->section_bg) }}">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-xl-5 col-lg-7">
            <div class="account-card">
              <div class="account-card__header bg_img overlay--one" data-background="{{ getImage('assets/images/frontend/login/'.@$loginContent->data_values->card_bg) }}">
                <h2 class="section-title">{{ __(@$loginContent->data_values->heading_w) }} <span class="base--color">{{ __(@$loginContent->data_values->heading_c) }}</span></h2>
                <p>{{ __(@$loginContent->data_values->sub_heading) }}</p>
              </div>
              <div class="account-card__body">
                <form action="{{ route('user.login')}}" class="mt-4" method="post" onsubmit="return submitUserForm();">
                  @csrf
                  <div class="form-group">
                    <label>@lang('User Name')</label>
                    <input type="text" class="form-control" name="username" placeholder="@lang('Enter user name')" required>
                  </div>
                  <div class="form-group">
                    <label>@lang('Password')</label>
                    <input type="password" type="text" class="form-control" name="password" placeholder="@lang('Enter password')" required>
                  </div>
                  <div class="form-group d-flex justify-content-center">
                    @php echo recaptcha() @endphp
                  </div>
                  @include($activeTemplate.'partials.custom-captcha')
                  <div class="mt-3">
                    <button type="submit" class="cmn-btn">@lang('Login Now')</button>
                  </div>
                  <div class="form-row mt-2">
                    <div class="col-sm-6">
                      <div class="form-group form-check pl-0">
                        <p class="f-size-14">{{trans('Forgot Password?')}} <a href="{{route('user.password.request')}}" class="base--color">@lang('Reset Now')</a></p>
                      </div>
                    </div>
                    <div class="col-sm-6 text-sm-right">
                      <p class="f-size-14">@lang("Haven't an account?") <a href="{{ route('user.register') }}" class="base--color">@lang('Sign Up')</a></p>
                    </div>
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


@push('script')
    <script>
      "use strict";
        function submitUserForm() {
            var response = grecaptcha.getResponse();
            if (response.length == 0) {
                document.getElementById('g-recaptcha-error').innerHTML = '<span style="color:red;">@lang("Captcha field is required.")</span>';
                return false;
            }
            return true;
        }
        function verifyCaptcha() {
            document.getElementById('g-recaptcha-error').innerHTML = '';
        }
    </script>
@endpush
