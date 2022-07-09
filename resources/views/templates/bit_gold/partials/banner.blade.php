 @php
    $banner = getContent('banner.content',true);
@endphp
 <!-- hero start -->
    <section class="hero bg_img" data-background="{{ getImage('assets/images/frontend/banner/'.@$banner->data_values->image,'1920x896') }}">
      <div class="container">
        <div class="row">
          <div class="col-lg-5">
            <div class="hero__content">
              <h2 class="hero__title"><span class="text-white font-weight-normal">{{ __(@$banner->data_values->heading_w) }}</span> <b class="base--color">{{ __(@$banner->data_values->heading_c) }}</b></h2>
              <p class="text-white f-size-18 mt-3">{{ __(@$banner->data_values->sub_heading) }}</p>
              <a href="{{ __(@$banner->data_values->button_link) }}" class="cmn-btn text-uppercase font-weight-600 mt-4">{{ __(@$banner->data_values->button_name) }}</a>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- hero end -->