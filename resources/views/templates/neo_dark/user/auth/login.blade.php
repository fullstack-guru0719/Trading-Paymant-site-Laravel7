@extends($activeTemplate.'layouts.frontend')

@section('content')
    @include($activeTemplate.'partials.user-breadcrumb')
<section class="pt-150">
    <div class="signin-wrapper">
        <div class="outset-circle"></div>
        <div class="container">
            <div class="row justify-content-lg-between align-items-center">
                <div class="col-xl-5 col-lg-6">
                    <div class="signin-thumb"><img src="{{asset($activeTemplateTrue.'images/signin.png')}}" alt="image"></div>
                </div>
                <div class="col-xl-5 col-lg-6">
                    <div class="signin-form-area">
                        <h3 class="title text-capitalize text-shadow mb-30">{{__($page_title)}}</h3>
                        <form class="signin-form" action="{{ route('user.login')}}" method="post"  onsubmit="return submitUserForm();">
                            @csrf
                            <div class="form-group custom-form-field">
                                <i class="fa fa-user"></i>
                                <input type="text" name="username" id="signin_name" placeholder="{{trans('username')}}" value="{{ old('username') }}" required>
                            </div>

                            <div class="form-group custom-form-field">
                                <i class="fa fa-lock"></i>
                                <input type="password" name="password"  id="signin_pass"  placeholder="{{trans('password')}}" required autocomplete="current-password" required>
                            </div>


                            <div class="form-group custom-form-field">
                                @php echo recaptcha() @endphp
                            </div>

                            @include($activeTemplate.'partials.custom-captcha')
                            <div class="form-group">
                                <button type="submit" id="recaptcha" class="btn btn-success btn-small w-100 btn-primary">{{trans('Sign In')}}</button>
                            </div>
                            <p>{{trans('Forgot Your Password?')}}
                                <a href="{{route('user.password.request')}}" class="label-text base--color">{{trans('Reset Now')}}</a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
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
