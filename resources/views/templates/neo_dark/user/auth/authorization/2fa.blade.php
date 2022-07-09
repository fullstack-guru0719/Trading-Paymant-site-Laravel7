@extends($activeTemplate .'layouts.frontend')

@section('content')


@include($activeTemplate.'partials.breadcrumb')


        <section class="contact-section pt-150 pb-150">
            <div class="container">
                <div class="row justify-content-lg-center align-items-center">
                    <div class="col-md-8">
                        <div class="contact-form-wrapper">


                            <h3 class="contact-form__title text-shadow text-center">
                                @lang('2FA Verification')
                            </h3>

                            <form action="{{route('user.go2fa.verify')}}" method="post" class="contact-form">
                                @csrf
                                <div class="form-row">
                                    <div class="form-group col-lg-12">
                                        <p class="text-center">@lang('Current Time'): {{\Carbon\Carbon::now()}}</p>
                                    </div>

                                    <div class="form-group col-lg-12">

                                        <div id="phoneInput">
                                            <div class="field-wrapper">
                                                <div class="phone">
                                                    <input type="text" name="code[]" class="letter"
                                                           pattern="[0-9]*" inputmode="numeric" maxlength="1">
                                                    <input type="text" name="code[]" class="letter"
                                                           pattern="[0-9]*" inputmode="numeric" maxlength="1">
                                                    <input type="text" name="code[]" class="letter"
                                                           pattern="[0-9]*" inputmode="numeric" maxlength="1">
                                                    <input type="text" name="code[]" class="letter"
                                                           pattern="[0-9]*" inputmode="numeric" maxlength="1">
                                                    <input type="text" name="code[]" class="letter"
                                                           pattern="[0-9]*" inputmode="numeric" maxlength="1">
                                                    <input type="text" name="code[]" class="letter"
                                                           pattern="[0-9]*" inputmode="numeric" maxlength="1">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-12 text-center">
                                        <button type="submit" class="btn btn-primary btn-small btn-primary w-100">@lang('Submit')</button>
                                    </div>
                                </div>
                            </form>



                        </div>

                    </div>
                </div>
            </div>
        </section>

        
@endsection

@push('script-lib')
    <script src="{{ asset($activeTemplateTrue.'js/jquery.inputLettering.js') }}"></script>
@endpush
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
            border: 1px solid #0e0d35;
        }

        #phoneInput .letter + .letter {
        }

        @media (max-width: 767px) {
            .contact-form-wrapper .contact-form__title {
                font-size: 20px;
                margin-bottom: 30px;
            }
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


        @media (max-width: 320px){
            .contact-form-wrapper .contact-form__title {
                font-size: 13px;
                margin-bottom: 30px;
            }
        }

    </style>
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