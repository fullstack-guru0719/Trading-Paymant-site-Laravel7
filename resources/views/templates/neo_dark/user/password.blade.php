@extends($activeTemplate.'layouts.master')
@section('content')
    @include($activeTemplate.'partials.user-breadcrumb')

    <div class="signup-wrapper pt-150 pb-150">
        <div class="container">
            <div class="row justify-content-center">
                

                <div class="col-xl-8">
                    <div class="signup-form-area">

                        <form class="signup-form" action="" method="post">
                            @csrf

                            <div class="form-row">

                                <div class="col-lg-12 form-group">
                                    <label for="phone">{{ trans('Current Password') }}</label>
                                    <input type="password" name="current_password" id="current_password">
                                </div>

                                <div class="col-lg-12 form-group">
                                    <label for="phone">{{ trans('Password') }}</label>
                                    <input type="password" name="password" id="password" >
                                </div>


                                <div class="col-lg-12 form-group">
                                    <label for="phone">{{ trans('Confirm Password') }}</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation">
                                </div>

                                <div class="col-lg-12 form-group">
                                    <button type="submit" class="btn btn-primary btn-small w-100">{{trans('Change Password')}}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('script')

@endpush

