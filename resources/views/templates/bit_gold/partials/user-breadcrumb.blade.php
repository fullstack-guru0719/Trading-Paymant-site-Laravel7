<!-- inner hero start -->
    <section class="inner-hero bg_img" data-background="{{ getImage('assets/images/frontend/breadcrumb/'.getContent('breadcrumb.content',true)->data_values->image,'1920x1280') }}">
      <div class="container">
        <div class="row">
          <div class="col-lg-6">
            <h2 class="page-title">{{ __($page_title) }}</h2>
            <ul class="page-breadcrumb">
              <li><a href="{{ route('home') }}">@lang('Home')</a></li>
              <li>@lang($page_title)</li>
            </ul>
          </div>
        </div>
      </div>
    </section>
    <!-- inner hero end -->