@extends($activeTemplate.'layouts.frontend')

@section('content')
    @include($activeTemplate.'partials.breadcrumb')
    @php
        $contactContent = getContent('contact.content',true);
        $contactElements = getContent('contact.element','','',1);
    @endphp
 <!-- contact section start -->
    <section class="pt-120 pb-120">
      <div class="container">
        <div class="contact-wrapper">
          <div class="row">
            <div class="col-lg-6 contact-thumb bg_img" data-background="{{ getImage('assets/images/frontend/contact/'.@$contactContent->data_values->image,'1920x1280') }}"></div>
            <div class="col-lg-6 contact-form-wrapper">
              <h2 class="font-weight-bold mb-2">@lang(@$contactContent->data_values->heading)</h2>
              <p class="font-weight-bold">@lang(@$contactContent->data_values->sub_heading)</p>
              <form action="" method="post" class="contact-form mt-4">
                @csrf
                <div class="form-row">
                  <div class="form-group col-lg-6">
                    <input type="text" name="name" placeholder="@lang('Full Name')" class="form-control">
                  </div>
                  <div class="form-group col-lg-6">
                    <input type="email" name="email" placeholder="@lang('Email Address')" class="form-control">
                  </div>
                  <div class="form-group col-lg-12">
                    <input name="subject" placeholder="@lang('Subject')" class="form-control">
                  </div>
                  <div class="form-group col-lg-12">
                    <textarea class="form-control" name="message" placeholder="@lang('Message')"></textarea>
                  </div>
                  <div class="col-lg-12">
                    <button type="submit" class="cmn-btn">@lang('Send Message')</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div><!-- contact-wrapper end -->
      </div>
      <div class="container pt-120">
        <div class="row justify-content-center">
          <div class="col-lg-10">
            <div class="row mb-none-30">
              @foreach($contactElements as $contactElement)
              <div class="col-md-4 col-sm-6 mb-30">
                <div class="contact-item">
                  @php echo $contactElement->data_values->icon @endphp
                  <h5 class="mt-2">{{ __(@$contactElement->data_values->title) }}</h5>
                  <div class="mt-4">
                    <p><a href="javascript:void(0)">{{ __(@$contactElement->data_values->content) }}</a></p>
                  </div>
                </div><!-- contact-item end -->
              </div>
              @endforeach
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- contact section end -->

@endsection

@push('script')
    <script src="https://maps.google.com/maps/api/js?key={{trim(@$contact->data_values->map_api_key)}}"></script>
    <script src="{{asset($activeTemplateTrue.'js/map.js')}}"></script>
@endpush
