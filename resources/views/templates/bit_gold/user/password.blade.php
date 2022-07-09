@extends($activeTemplate.'layouts.master')
@section('content')
    @include($activeTemplate.'partials.user-breadcrumb')

    <section class="cmn-section">
        <div class="container">
            <div class="card">
                <form action="" method="post" enctype="multipart/form-data">
                        @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>@lang('Enter Old Password')</label>
                                <input type="password" name="current_password" class="form-control form-control-lg">
                            </div>
                            <div class="form-group">
                                <label>@lang('Enter New Password')</label>
                                <input type="password" name="password" class="form-control form-control-lg">
                            </div>
                            <div class="form-group">
                                <label>@lang('Re-type Password')</label>
                                <input type="password" name="password_confirmation" class="form-control form-control-lg">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-md w-100 cmn-btn">@lang('Update')</button>
                </div>
                </form>
            </div>
        </div>
    </section>
@endsection


@push('script')

@endpush

