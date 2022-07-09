@extends($activeTemplate.'layouts.master')

@section('content')
    @include($activeTemplate.'partials.user-breadcrumb')

    <section class="feature-section pt-150 pb-150">
        <div class="container">
            <div class="row justify-content-center">


                <div class="col-lg-6 col-md-6">
                    @if(Auth::user()->ts)
                        <div class="card card-bg">
                            <div class="card-header">
                                <h5 class="card-title">@lang('Two factor authenticator')</h5>
                            </div>
                            <div class="card-body register">
                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="text" value="{{$prevcode}}"
                                               class="form-control form-control-lg" id="referralURL"
                                               readonly>
                                        <div class="input-group-append">
                                            <span class="input-group-text copytext copyBoard" id="copyBoard"
                                                  onclick="myFunction()"> <i class="fa fa-copy"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mx-auto text-center">
                                    <img class="mx-auto" src="{{$prevqr}}">
                                </div>

                                <div class="form-group mx-auto text-center">
                                    <a href="#0" class="btn btn-block btn-lg btn-danger action-btn" data-toggle="modal"
                                       data-target="#disableModal">
                                        @lang('Disable two factor authenticator')</a>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="card card-bg">
                            <div class="card-header">
                                <h5 class="card-title">@lang('Two factor authenticator')</h5>
                            </div>
                            <div class="card-body register">
                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="text" name="key" value="{{$secret}}"
                                               class="form-control form-control-lg" id="referralURL" readonly>
                                        <div class="input-group-append">
                                            <span class="input-group-text copytext copyBoard" id="copyBoard"
                                                  onclick="myFunction()"> <i class="fa fa-copy"></i> </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mx-auto text-center">
                                    <img class="mx-auto" src="{{$qrCodeUrl}}">
                                </div>
                                <div class="form-group mx-auto text-center">
                                    <a href="#0" class="btn btn-primary action-btn btn-lg mt-3 mb-1 "
                                       data-toggle="modal"
                                       data-target="#enableModal">@lang('Enable two factor authenticator')</a>
                                </div>
                            </div>
                        </div>

                    @endif
                </div>

                <div class="col-lg-6 col-md-6">
                    <div class="card card-bg">
                        <div class="card-header">
                            <h5 class="card-title">@lang('Google Authenticator')</h5>
                        </div>
                        <div class=" card-body">
                            <h5 class="text-uppercase">@lang('USE GOOGLE AUTHENTICATOR TO SCAN THE QR CODE OR USE THE CODE')</h5>
                            <hr/>
                            <p>@lang('Google Authenticator is a multifactor app for mobile devices. It generates timed codes used during the 2-step verification process. To use Google Authenticator, install the Google Authenticator application on your mobile device.')</p>
                            <a class="btn btn-success btn-md mt-3 btn-primary"
                               href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=en"
                               target="_blank">@lang('DOWNLOAD APP')</a>
                        </div>
                    </div><!-- //. single service item -->
                </div>
            </div>
        </div>
    </section>



    <!--Enable Modal -->
    <div id="enableModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <!-- Modal content-->
            <div class="modal-content modal-content-bg">
                <div class="modal-header">
                    <h4 class="modal-title">@lang('Verify your OTP')</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form action="{{route('user.twofactor.enable')}}" method="POST" class="register">
                    @csrf
                    <div class="modal-body ">
                        <div class="form-group">
                            <input type="hidden" name="key" value="{{$secret}}">
                            <input type="text" class="form-control" name="code"
                                   placeholder="@lang('Enter Google Authenticator Code')">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger action-btn" data-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn-primary action-btn">@lang('Verify')</button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <!--Disable Modal -->
    <div id="disableModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <!-- Modal content-->
            <div class="modal-content modal-content-bg">
                <div class="modal-header">
                    <h4 class="modal-title">@lang('Verify your OTP disable')</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form action="{{route('user.twofactor.disable')}}" method="POST" class="register">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" class="form-control" name="code"
                                   placeholder="@lang('Enter Google Authenticator Code')">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger action-btn" data-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn-primary action-btn">@lang('Verify')</button>
                    </div>
                </form>
            </div>

        </div>
    </div>

@endsection

@push('script')
    <script>
        $('.copyBoard').click(function(){
        "use strict";
            var copyText = document.getElementById("referralURL");
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            /*For mobile devices*/
            document.execCommand("copy");
            iziToast.success({message: "Copied: " + copyText.value, position: "topRight"});
      });
    </script>
@endpush


