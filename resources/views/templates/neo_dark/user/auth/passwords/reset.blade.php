@extends($activeTemplate.'layouts.frontend')
@section('content')

    @include($activeTemplate.'partials.breadcrumb')
    <section class="account-section padding-top padding-bottom">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="section-header margin-olpo left-style">
                        <h2 class="title">{{__($page_title)}}</h2>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('user.password.update') }}"  class="register">
                @csrf


                <input type="hidden" name="email" value="{{ $email }}">
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="password">{{trans('New Password')}}</label>
                            <input id="password" type="password" placeholder="{{trans('New Password')}}"  name="password" required autocomplete="current-password">
                        </div>

                        <div class="form-group">
                            <label for="password">{{trans('Confirm Password')}}</label>
                            <input id="password" type="password" placeholder="{{trans('Confirm Password')}}" name="password_confirmation" required autocomplete="current-password">
                        </div>
                        <div class="form-group btn-area  justify-content-center">
                            <button type="submit" class="btn btn-primary w-100">@lang('Submit')</button>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="form-group checkgroup">
                            <label for="check02" class="w-100 p-0">{{trans('Already have an account')}} <a href="{{route('user.login')}}">{{trans('Sign In')}}</a></label>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </section>
@endsection
