@extends($activeTemplate.'layouts.master')
@section('content')
    @include($activeTemplate.'partials.user-breadcrumb')
    <section class="feature-section pt-150 pb-150">
        <div class="container">
            <div class="row justify-content-center mt-2">
                @foreach($tools as $tool)
                    <div class="col-md-4">
                        <div class="card cmn--card">
                            <div class="thumb__350px">
                                <img src="{{ getImage(imagePath()['promotions']['path'].  '/'. @$tool->banner) }}">
                            </div>
                            <div class="referral-form mt-20">
                                    @php
                                        $string = '<a href="'.route('home').'?reference='.auth()->user()->username.'" target="_blank"> <img src="'.getImage(imagePath()['promotions']['path'].  '/'. @$tool->banner) .'" alt="image"/></a>';
                                    @endphp


                                    <textarea type="url" id="reflink{{ $tool->id }}" class="form--control form-control from-control-lg" rows="5" readonly>@php echo  $string @endphp</textarea>
                                    <div class="px-3 pb-3">
                                        <button  type="button"  data-copytarget="#reflink{{ $tool->id }}" class="input-group-text justify-content-center text-white copybtn btn-block"><i class="fa fa-copy"></i> &nbsp; @lang('Copy')</button>
                                    </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
@push('script')
<script>
    document.querySelectorAll('.copybtn').forEach((element)=>{
        element.addEventListener('click', copy, true);
    })

    function copy(e) {
        var
            t = e.target,
            c = t.dataset.copytarget,
            inp = (c ? document.querySelector(c) : null);
        if (inp && inp.select) {
            inp.select();
            try {
                document.execCommand('copy');
                inp.blur();
                t.classList.add('copied');
                setTimeout(function() { t.classList.remove('copied'); }, 1500);
            }catch (err) {
                alert(`@lang('Please press Ctrl/Cmd+C to copy')`);
            }
        }
    }

</script>
@endpush