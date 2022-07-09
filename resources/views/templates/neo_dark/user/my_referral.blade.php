@extends($activeTemplate.'layouts.master')
@section('content')
    @include($activeTemplate.'partials.user-breadcrumb')

    <section class="feature-section pt-150 pb-150">
        <div class="container">


            <div class="row justify-content-center mt-2">
            @for($i = 1; $i <= $lev; $i++)
                    <div class="col-md-2 pb-3">
                        <a href="{{route('user.referral.users',$i)}}" class="btn btn-primary w-100 mb-3 text-center">@lang('Level '.$i)</a>
                    </div>
                @endfor
                <div class="col-md-12">
                    <div class="table-responsive--sm neu--table">
                        <table class="table table-striped text-white">
                            <thead>
                            <tr>
                                <th scope="col">@lang('SL')</th>
                                <th scope="col">@lang('Fullname')</th>
                                <th scope="col">@lang('Joined At')</th>
                            </tr>
                            </thead>
                            <tbody>
                                {{ showUserLevel(auth()->user()->id, $lv_no) }}
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </section>


@endsection
