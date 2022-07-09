@extends($activeTemplate.'layouts.frontend')
@section('content')
    @include($activeTemplate.'partials.breadcrumb')

    <!-- blog-details start -->
    <section class="blog-details pt-150 pb-150">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="single-post-details">
                        <div class="single-post__content">
                            <div class="single-post__header">
                                <div class="left">
                                    <h5 class="post__title text-shadow">{{__($post->data_values->title)}}</h5>
                                </div>
                                <div class="right"><a href="javascript:void(0)" class="post__date">{{showDateTime($post->created_at)}}</a></div>
                            </div>
                            <div class="single-post__thumb">
                                <img src="{{asset($data['image'])}}" alt="{{$data['title']}}"  >
                            </div>
                            <p>{{strip_tags($post->data_values->description)}}</p>
                        </div>


                        <div class="single-post__footer">
                            <div class="share ">
                                <span>@lang('Share')</span>
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{urlencode(url()->current()) }}" ><i class="fab fa-facebook-f"></i></a>
                                <a href="https://twitter.com/intent/tweet?text=my share text&amp;url={{urlencode(url()->current())}}"><i class="fab fa-twitter"></i></a>
                                <a href="http://www.linkedin.com/shareArticle?mini=true&amp;url={{urlencode(url()->current()) }}&amp;title=my share text&amp;summary=dit is de linkedin summary" >
                                    <i class="fab fa-linkedin-in"></i></a>
                            </div>
                        </div>


                        <div class="comment-area comments-list">
                            <div class="fb-comments" data-href="{{url()->current()}}" data-numposts="5"></div>
                        </div>

                    </div><!-- single-post-details end -->


                </div>

                <div class="col-lg-4">
                    <div class="sidebar">

                        <div class="widget">
                            <h3 class="widget__title text-shadow">@lang('Latest News Post')</h3>
                            <ul class="small-post-list">
                                @foreach($blogs as $k=> $data)
                                <li class="small-post">
                                    <h5 class="post__title"><a href="{{route('blog.details',[str_slug($data->data_values->title),$data->id])}}">{{__($data->data_values->title)}}</a></h5>
                                    <ul class="post__meta">
                                        <li><a href="javascript:void(0)">@lang('By Admin') </a></li>
                                        <li><a href="javascript:void(0)">{{showDateTime($data->created_at)}}</a></li>
                                    </ul>
                                </li>
                                @endforeach
                            </ul>
                        </div><!-- widget end -->

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- blog-details end -->
@endsection