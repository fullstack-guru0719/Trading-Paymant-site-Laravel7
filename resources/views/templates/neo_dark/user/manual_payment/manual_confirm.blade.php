@extends($activeTemplate.'layouts.master')

@section('content')

    @include($activeTemplate.'partials.user-breadcrumb')
    <section class="feature-section pb-150 pt-150">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card card-bg ">

                    <div class="dashboard__header mb-4">
                        <div class="left">
                            <h3>{{trans($page_title)}}</h3>
                        </div>
                    </div>

                    <div class="card-body  ">
                        <form action="{{ route('user.deposit.manual.update') }}" method="POST" enctype="multipart/form-data" class="register">
                            @csrf
                            <div class="row">
                                <div class="col-md-12 text-center text-white">
                                    <p class="text-center mt-2">@lang('You have requested ') <b
                                            class="text-success">{{ getAmount($data['amount'])  }} {{$general->cur_text}}</b> @lang('Please pay ')
                                        <b class="text-success">{{getAmount($data['final_amo']) .' '.$data['method_currency'] }}</b> @lang('for successful payment')
                                    </p>
                                    <h4 class="text-center mb-4">@lang('Please follow the instruction bellow')</h4>

                                    <div class="my-4 text-center deposit-info"> @php echo  $data->gateway->description @endphp</div>

                                </div>

                                @if($method->gateway_parameter)

                                    @foreach(json_decode($method->gateway_parameter) as $k => $v)

                                        @if($v->type == "text")
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label><strong>{{__(inputTitle($v->field_level))}} @if($v->validation == 'required') <span class="text-danger">*</span>  @endif</strong></label>
                                                    <input type="text" class="form-control form-control-lg"
                                                           name="{{$k}}"  value="{{old($k)}}" placeholder="{{__(inputTitle($v->field_level))}}">
                                                </div>
                                            </div>
                                        @elseif($v->type == "textarea")
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label><strong>{{__(inputTitle($v->field_level))}} @if($v->validation == 'required') <span class="text-danger">*</span>  @endif</strong></label>
                                                        <textarea name="{{$k}}"  class="form-control"  placeholder="{{__(inputTitle($v->field_level))}}" rows="3">{{old($k)}}</textarea>

                                                    </div>
                                                </div>
                                        @elseif($v->type == "file")
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label><strong>{{__(inputTitle($v->field_level))}} @if($v->validation == 'required') <span class="text-danger">*</span>  @endif</strong></label>
                                                    <input type="file" name="{{$k}}" accept="image/*" class="form-control">

                                                </div>
                                            </div>
                                        @endif

                                    @endforeach

                                @endif


                                <div class="col-md-12">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary w-100 mt-2 text-center">@lang('Pay Now')</button>
                                    </div>
                                </div>

                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </section>
@endsection
