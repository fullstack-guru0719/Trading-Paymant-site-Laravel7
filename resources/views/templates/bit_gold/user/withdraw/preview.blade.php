@extends($activeTemplate.'layouts.master')
@push('style-lib')
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/bootstrap-fileinput.css')}}">
@endpush
@push('script-lib')
    <script src="{{ asset($activeTemplateTrue.'js/bootstrap-fileinput.js') }}"></script>
@endpush

@section('content')
    @include($activeTemplate.'partials.breadcrumb')

<section class="cmn-section">
        <div class="container">
        <div class="row justify-content-center mt-2">
            <div class="col-lg-12 ">
                <div class="">

                    <div class="mt-4">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body">
                                        
                                        <ul class="list-group text-center">
                                            <li class="list-group-item">
                                                @lang('Current Balance'): {{getAmount(auth()->user()->balance)  }} {{ $general->cur_text }}
                                            </li>
                                            <li class="list-group-item">
                                                @lang('Request Balance'): {{getAmount($withdraw->amount)  }} {{$general->cur_text }}
                                            </li>
                                            <li class="list-group-item">
                                                @lang('Withdrawal Charge'): {{getAmount($withdraw->charge) }} {{$general->cur_text }}
                                            </li>
                                            <li class="list-group-item">
                                                @lang('After Charge'): {{getAmount($withdraw->after_charge) }} {{$general->cur_text }}
                                            </li>
                                            <li class="list-group-item">
                                                @lang('Conversion Rate'): 1 {{$general->cur_text }} = {{getAmount($withdraw->rate)  }} {{$withdraw->currency }}
                                            </li>
                                            <li class="list-group-item">
                                                @lang('You Will Get'): {{getAmount($withdraw->final_amount) }} {{$withdraw->currency }}
                                            </li>
                                            <li class="list-group-item">
                                                @lang('Balance Will be'):  {{getAmount(auth()->user()->interest_wallet - $withdraw->amount)}}
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="card">
                                    <div class="card-body">
                                        
                                        <p class="my-3">
                                            @php echo $withdraw->method->description; @endphp
                                        </p>
                                        <form action="{{route('user.withdraw.submit')}}" method="post" enctype="multipart/form-data">
                                            @csrf


                                            @if($withdraw->method->user_data)
                                            @foreach($withdraw->method->user_data as $k => $v)
                                                @if($v->type == "text")
                                                    <div class="form-group">
                                                        <label><strong>{{__($v->field_level)}} @if($v->validation == 'required') <span class="text-danger">*</span>  @endif</strong></label>
                                                        <input type="text" name="{{$k}}" class="form-control" value="{{old($k)}}" placeholder="{{__($v->field_level)}}" @if($v->validation == "required") required @endif>
                                                        @if ($errors->has($k))
                                                            <span class="text-danger">{{ __($errors->first($k)) }}</span>
                                                        @endif
                                                    </div>
                                                @elseif($v->type == "textarea")
                                                    <div class="form-group">
                                                        <label><strong>{{__($v->field_level)}} @if($v->validation == 'required') <span class="text-danger">*</span>  @endif</strong></label>
                                                        <textarea name="{{$k}}"  class="form-control"  placeholder="{{__($v->field_level)}}" rows="3" @if($v->validation == "required") required @endif>{{old($k)}}</textarea>
                                                        @if ($errors->has($k))
                                                            <span class="text-danger">{{ __($errors->first($k)) }}</span>
                                                        @endif
                                                    </div>
                                                @elseif($v->type == "file")

                                                    <label><strong>{{__($v->field_level)}} @if($v->validation == 'required') <span class="text-danger">*</span>  @endif</strong></label>
                                                    <div class="form-group">
                                                        <div class="fileinput fileinput-new " data-provides="fileinput">
                                                            <div class="fileinput-new thumbnail withdraw-thumbnail"
                                                                 data-trigger="fileinput">
                                                                <img class="w-100" src="{{ getImage(imagePath()['image']['default'])}}">
                                                            </div>
                                                            <div class="fileinput-preview fileinput-exists thumbnail wh-200-150"></div>

                                                            <div class="img-input-div">
                                                                        <span class="btn btn-info btn-file">
                                                                            <span class="fileinput-new "> @lang('Select') {{$v->field_level}}</span>
                                                                            <span class="fileinput-exists"> @lang('Change')</span>
                                                                            <input type="file" name="{{$k}}" accept="image/*" @if($v->validation == "required") required @endif>
                                                                        </span>
                                                                <a href="#" class="btn btn-danger fileinput-exists"
                                                                   data-dismiss="fileinput"> @lang('Remove')</a>
                                                            </div>

                                                        </div>
                                                        @if ($errors->has($k))
                                                            <br>
                                                            <span class="text-danger">{{ __($errors->first($k)) }}</span>
                                                        @endif
                                                    </div>
                                                @endif
                                            @endforeach
                                            @endif

                                            <div class="form-group">
                                                <button type="submit" class="cmn-btn btn-block btn-lg mt-4 text-center">@lang('Confirm')</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    </section>
@endsection
@push('style')

<style>
.withdraw-details {
    padding: 10px 0;
    border-bottom: 1px solid #ddd;
}
.withdraw-thumbnail{
    max-width: 220px;
}
</style>
    @endpush

    @push('style-lib')
<link rel="stylesheet" href="{{asset($activeTemplateTrue.'/css/bootstrap-fileinput.css')}}">
@endpush
@push('script-lib')
<script src="{{asset($activeTemplateTrue.'/js/bootstrap-fileinput.js')}}"></script>
@endpush


