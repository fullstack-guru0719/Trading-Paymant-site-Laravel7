@extends($activeTemplate.'layouts.frontend')

@section('content')
    @include($activeTemplate.'partials.breadcrumb')



    <!-- contact-section start -->
    <section class="contact-section pt-150 pb-150">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="section-header">
                        <h2 class="section__title">{{__(@$contact->data_values->title)}}</h2>
                        <p>{{__(@$contact->data_values->short_details)}}</p>
                    </div>
                    <div>
                        @if(@$contact->data_values->address)
                            <div class="contact-item">
                                <div class="icon"><i class="las la-map-marker"></i></div>
                                <div class="content">
                                    <h3 class="title text-shadow">@lang('Office Address')</h3>
                                    <p>@php echo @$contact->data_values->address; @endphp</p>
                                </div>
                            </div>
                        @endif
                        @if(@$contact->data_values->contact_number)
                            <div class="contact-item">
                                <div class="icon"><i class="las la-phone"></i></div>
                                <div class="content">
                                    <h3 class="title text-shadow">@lang('Phone Number')</h3>
                                    <a href="javascript:void(0)">@php echo @$contact->data_values->contact_number; @endphp</a>
                                </div>
                            </div>
                        @endif
                        @if(@$contact->data_values->email_address)
                            <div class="contact-item">
                                <div class="icon"><i class="las la-envelope"></i></div>
                                <div class="content">
                                    <h3 class="title text-shadow">@lang('Email Address')</h3>
                                    <a href="javascript:void(0)">{{@$contact->data_values->email_address}}</a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="map">
                        <div class="maps" id="maps" data-latitude="{{trim(@$contact->data_values->latitude)}}" data-longitude="{{trim(@$contact->data_values->longitude)}}"></div>
                    </div>
                </div>
            </div>



            <div class="row pt-150">
                <div class="col-lg-12">
                    <div class="contact-form-wrapper">
                        <h3 class="contact-form__title text-shadow">@lang('Hello With Us')</h3>
                        <form class="contact-form" action="" method="post">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-lg-6">
                                    <label>@lang('Your Name')</label>
                                    <input name="name" type="text" placeholder="@lang('Enter your name')" class="form-control" value="{{old('name')}}" required autocomplete="off">
                                </div>
                                <div class="form-group col-lg-6">
                                    <label for="email">@lang('Email Address')</label>
                                    <input name="email" type="text" class="form-control" placeholder="@lang('Enter your email')" value="{{old('email')}}" required autocomplete="off">
                                </div>
                                <div class="form-group col-lg-12">
                                    <label for="phone">@lang('Subject')</label>
                                    <input name="subject" type="text"  class="form-control" placeholder="@lang('Write your subject')" value="{{old('subject')}}" required autocomplete="off">
                                </div>
                                <div class="form-group col-lg-12">
                                    <label for="message">@lang('Your Message')</label>
                                    <textarea name="message" id="message" placeholder="@lang('Write your message')" autocomplete="off">{{old('message')}}</textarea>
                                </div>

                                <div class="col-lg-12">
                                    <button type="submit" class="btn btn-primary btn-small w-100">@lang('Send Message')</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- contact-section end -->
@endsection

@push('script')
    <script src="https://maps.google.com/maps/api/js?key={{trim(@$contact->data_values->map_api_key)}}"></script>
    <script src="{{asset($activeTemplateTrue.'js/map.js')}}"></script>
@endpush
