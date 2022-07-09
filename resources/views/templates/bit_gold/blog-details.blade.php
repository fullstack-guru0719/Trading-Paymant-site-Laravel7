@extends($activeTemplate.'layouts.frontend')
@section('content')
    @include($activeTemplate.'partials.breadcrumb')

<!-- blog-details-section start -->
    <section class="blog-details-section pt-150 pb-150">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 col-md-8">
            <div class="blog-details-wrapper">
              <div class="blog-details__thumb">
                <img src="{{getImage('assets/images/frontend/blog/'.$post->data_values->image,'920x483')}}" alt="image">
              </div><!-- blog-details__thumb end -->
              <div class="blog-details__content">
                <h4 class="blog-details__title">{{__($post->data_values->title)}}</h4>
                <p>{{strip_tags($post->data_values->description)}}</p>
              </div><!-- blog-details__content end -->
              <div class="blog-details__footer">
                <h4 class="caption">@lang('Share This Post')</h4>
                <ul class="social__links">
                  <li><a href="https://www.facebook.com/sharer/sharer.php?u={{urlencode(url()->current()) }}"><i class="fab fa-facebook-f"></i></a></li>
                  <li><a href="#0"><i class="fab fa-twitter"></i></a></li>
                  <li><a href="https://twitter.com/intent/tweet?text=my share text&amp;url={{urlencode(url()->current())}}"><i class="fab fa-pinterest-p"></i></a></li>
                  <li><a href="http://www.linkedin.com/shareArticle?mini=true&amp;url={{urlencode(url()->current()) }}&amp;title=my share text&amp;summary=dit is de linkedin summary"><i class="fab fa-linkedin"></i></a></li>
                </ul>
              </div><!-- blog-details__footer end -->
            </div><!-- blog-details-wrapper end -->
            <div class="comments-area">
              <div class="comment-area comments-list">
                            <div class="fb-comments" data-href="{{url()->current()}}" data-numposts="5"></div>
                        </div>
            </div><!-- comments-area end -->
          </div>
          <div class="col-lg-4 col-md-4">
            <div class="sidebar">
              <div class="widget">
                <h5 class="widget__title">@lang('Latest News Post')</h5>
                <ul class="small-post-list">
                @foreach($blogs as $k=> $data)
                  <li class="small-post">
                    <div class="small-post__thumb"><img src="{{getImage('assets/images/frontend/blog/thumb_'.$data->data_values->image,'920x483')}}" alt="image"></div>
                    <div class="small-post__content">
                      <h5 class="post__title"><a href="{{route('blog.details',[str_slug($data->data_values->title),$data->id])}}">{{__($data->data_values->title)}}</a></h5>
                    </div>
                  </li>
                  @endforeach
                </ul><!-- small-post-list end -->
              </div><!-- widget end -->
            </div><!-- sidebar end -->
          </div>
        </div>
      </div>
    </section>
    <!-- blog-details-section end -->
@endsection