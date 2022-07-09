@php
$blogs = getContent('blog.element',false,3);
$blogContent = getContent('blog.content',true);

@endphp

<!-- blog-section start -->
<section class="blog-section pt-150 pb-150">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="section-header text-center">
                    <h2 class="section__title">@lang(@$blogContent->data_values->heading)</h2>
                    <div class="header__divider">
                        <span class="left-dot"></span>
                        <span class="right-dot"></span>
                    </div>
                    <p>@lang(@$blogContent->data_values->sub_heading)</p>
                </div><!-- section-header end -->
            </div>
        </div>

        <div class="row mb-none-30 justify-content-center">
            @foreach($blogs as $k=> $data)
            <div class="col-lg-4 col-md-6 mb-30">
                <div class="post-item">
                    <div class="post-item__thumb"><img src="{{getImage('assets/images/frontend/blog/thumb_'.@$data->data_values->image)}}" alt="image"></div>
                    <div class="post-item__content">
                        <h3 class="post__title text-shadow">
                            <a href="{{route('blog.details',[str_slug($data->data_values->title),$data->id])}}">
                                {{__(@$data->data_values->title)}}
                            </a>
                        </h3>

                        <p>@lang(str_limit(strip_tags(@$data->data_values->description),180))</p>
                        <a href="{{route('blog.details',[str_slug($data->data_values->title),$data->id])}}"
                                   class="btn btn-primary btn-small mt-4">{{trans('Read More')}}</a>
                    </div>
                </div><!-- post-item end -->
            </div>
            @endforeach
            
        </div>
    </div>
</section>
<!-- blog-section end -->
