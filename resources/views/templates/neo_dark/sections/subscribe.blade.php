@php
    $subscribeContent = getContent('subscribe.content',true);
@endphp

<!--=======Subscribe-Section Starts Here=======-->
<section class="newsletter-section  pt-150  pb-150 " id="subscribe">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-lg-7">
                <div class="section-header margin-olpo">
                    <h2 class="section__title">@lang(@$subscribeContent->data_values->heading)</h2>
                    <p>@lang(@$subscribeContent->data_values->sub_heading)</p>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-7">
                <form class="newslater-form" method="post">
                    @csrf
                    <input type="email" name="email" placeholder="@lang('Email Address')">
                    <button type="submit">
                        <i class="fa fa-paper-plane"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>
<!--=======Subscribe-Section Ends Here=======-->

@push('script')
<script type="text/javascript">

    (function ($) {
        "use strict";
            $('.newslater-form').on('submit',function(e){

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });


                e.preventDefault();
                var email = $('input[name=email]').val();
                $.post('{{route('subscribe')}}',{email:email}, function(response){
                    if(response.errors){
                        for (var i = 0; i < response.errors.length; i++) {
                            iziToast.error({message: response.errors[i], position: "topRight"});
                        }
                    }else{
                        iziToast.success({message: response.success, position: "topRight"});
                    }
                });
            });

    })(jQuery);
</script>
@endpush