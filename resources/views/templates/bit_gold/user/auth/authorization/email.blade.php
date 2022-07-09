@extends($activeTemplate.'layouts.frontend')
@section('content')
    <!-- account section start -->
    <div class="account-section bg_img">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-xl-5 col-lg-7">
            <div class="account-card">
              
              <div class="account-card__body">
                <h2 class="text-center">@lang($page_title)</h2>
                <form action="{{route('user.verify_email')}}" method="POST">
                                @csrf

                                <div class="form-group">
                                    <h5 class="mb-4 text-center">@lang('Enter Verification Code')</h5>
                                    <div id="phoneInput">

                                        <div class="field-wrapper">
                                            <div class=" phone">
                                                <input type="text" name="email_verified_code[]" class="letter" pattern="[0-9]*" inputmode="numeric" maxlength="1">
                                                <input type="text" name="email_verified_code[]" class="letter" pattern="[0-9]*" inputmode="numeric" maxlength="1">
                                                <input type="text" name="email_verified_code[]" class="letter" pattern="[0-9]*" inputmode="numeric" maxlength="1">
                                                <input type="text" name="email_verified_code[]" class="letter" pattern="[0-9]*" inputmode="numeric" maxlength="1">
                                                <input type="text" name="email_verified_code[]" class="letter" pattern="[0-9]*" inputmode="numeric" maxlength="1">
                                                <input type="text" name="email_verified_code[]" class="letter" pattern="[0-9]*" inputmode="numeric" maxlength="1">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="btn-area  justify-content-center">
                                        <button type="submit" class="btn-md cmn-btn w-100">@lang('Submit')</button>
                                    </div>
                                </div>

                                <div class="form-group">
                                        <p>@lang('Please check including your Junk/Spam Folder. if not found, you can ') <a href="{{route('user.send_verify_code')}}?type=email" class="forget-pass base--color"> @lang('Resend code')</a></p>
                                        @if ($errors->has('resend'))
                                            <br/>
                                            <small class="text-danger">{{ $errors->first('resend') }}</small>
                                        @endif
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
@push('style')

    <style>
        #phoneInput .field-wrapper {
            position: relative;
            text-align: center;
        }

        #phoneInput .form-group {
            min-width: 300px;
            width: 50%;
            margin: 4em auto;
            display: flex;
            border: 1px solid rgba(96, 100, 104, 0.3);
        }

        #phoneInput .letter {
            height: 50px;
            border-radius: 0;
            border: none;
            text-align: center;
            max-width: calc((100% / 10) - 1px);
            flex-grow: 1;
            flex-shrink: 1;
            flex-basis: calc(100% / 10);
            outline-style: none;
            padding: 5px 0;
            font-size: 18px;
            font-weight: bold;
            color: red;
        }

        #phoneInput .letter + .letter {
            border-left: 1px solid #0e0d35;
        }

        @media (max-width: 480px) {
            #phoneInput .field-wrapper {
                width: 100%;
            }

            #phoneInput .letter {
                font-size: 16px;
                padding: 2px 0;
                height: 35px;
            }

            #phoneInput .letter {
                max-width: calc((100% / 7) - 1px);
            }
        }

    </style>
@endpush


@push('script-lib')
    <script src="{{ asset($activeTemplateTrue.'js/jquery.inputLettering.js') }}"></script>
@endpush


@push('script')
    <script>
        $(function () {
            "use strict";
            $('#phoneInput').letteringInput({
                inputClass: 'letter',
                onLetterKeyup: function ($item, event) {
                    console.log('$item:', $item);
                    console.log('event:', event);
                },
                onSet: function ($el, event, value) {
                    console.log('element:', $el);
                    console.log('event:', event);
                    console.log('value:', value);
                }
            });
        });
    </script>
@endpush
