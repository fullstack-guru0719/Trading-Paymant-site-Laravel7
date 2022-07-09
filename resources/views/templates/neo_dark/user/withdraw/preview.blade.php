@extends($activeTemplate.'layouts.master')
@push('style-lib')
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/bootstrap-fileinput.css')}}">
@endpush
@push('script-lib')
    <script src="{{ asset($activeTemplateTrue.'js/bootstrap-fileinput.js') }}"></script>
@endpush

@section('content')
    @include($activeTemplate.'partials.breadcrumb')

    <section class="feature-section padding-top padding-bottom">
        <div class="container">
            <div class="row justify-content-center mt-2">
                <div class="col-lg-12 ">
                    <div class="card card-bg">
                        <div class="card-header">
                            <h5 class="text-center my-1">@lang('Current Balance') :
                                <strong>{{ getAmount(auth()->user()->interest_wallet)}}  {{ trans($general->cur_text) }}</strong></h5>
                        </div>

                        <div class="card-body mt-4">
                            <div class="row">
                                <div class="col-md-4 register">

                                    <ul class="list-group ">
                                        <li class="list-group-item bg-transparent d-flex justify-content-between align-items-center">
                                            @lang('Request Amount')
                                            <span>{{getAmount($withdraw->amount)  }} {{trans($general->cur_text) }}</span>
                                        </li>

                                        <li class="list-group-item bg-transparent d-flex justify-content-between align-items-center text-danger">
                                            @lang('Withdrawal Charge')
                                            <span>{{getAmount($withdraw->charge)  }} {{trans($general->cur_text) }}</span>
                                        </li>

                                        <li class="list-group-item bg-transparent d-flex justify-content-between align-items-center text-info">
                                            @lang('After Charge')
                                            <span>{{getAmount($withdraw->after_charge)  }} {{trans($general->cur_text)}}</span>
                                        </li>

                                        <li class="list-group-item bg-transparent d-flex justify-content-between align-items-center">
                                            @lang('Conversion Rate')
                                            <span>1 {{trans($general->cur_text) }} = {{getAmount($withdraw->rate)  }} {{trans($withdraw->currency) }}</span>
                                        </li>

                                        <li class="list-group-item bg-transparent d-flex justify-content-between align-items-center text-success">
                                            @lang('You Will Get')
                                            <span>{{getAmount($withdraw->final_amount)  }} {{trans($withdraw->currency)  }}</span>
                                        </li>

                                        <li class="list-group-item bg-transparent">
                                            <div class="form-group ">
                                                <label class="font-weight-bold">@lang('Balance Will be')</label>
                                                <div class="input-group ">
                                                    <input type="text" value="{{getAmount(auth()->user()->interest_wallet - $withdraw->amount)}}"  class="input-addon-bg form-control form-control-lg" readonly>
                                                    <div class="input-group-prepend ">
                                                        <span class="input-group-text input-addon-bg text-white addon-bg">{{ trans($general->cur_text) }} </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>



                                <div class="col-md-8">
                                    <form action="{{route('user.withdraw.submit')}}" method="post" enctype="multipart/form-data" class="register">
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

                                                    <div class="form-group">
                                                    <label><strong>{{__($v->field_level)}} @if($v->validation == 'required') <span class="text-danger">*</span>  @endif</strong></label>
                                                        <input type="file" class="form-control" name="{{ $k }}" accept="image/*" @if($v->validation == "required") required @endif> 
                                                        @if ($errors->has($k))
                                                            <br>
                                                            <span class="text-danger">{{ __($errors->first($k)) }}</span>
                                                        @endif
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endif

                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary w-100 btn-lg mt-4 text-center">@lang('Confirm')</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('script')
@endpush

