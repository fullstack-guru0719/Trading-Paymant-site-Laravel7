@extends($activeTemplate.'layouts.frontend')
@section('content')

    @include($activeTemplate.'partials.breadcrumb')

    <section class="account-section padding-top padding-bottom">
        <div class="container">
            <form action="{{ route('user.password.email') }}" method="post" class="register">
                @csrf
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="email">{{ trans('Email Address') }}</label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="{{trans('Email Address')}}" required autocomplete="email" autofocus>
                        </div>


                        <div class="form-group btn-area  justify-content-center">
                            <button type="submit" class="btn btn-primary w-100">@lang('Send Password Reset Code')</button>
                        </div>


                    </div>
                </div>
            </form>
        </div>
    </section>

@endsection
