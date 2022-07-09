<div class="header-top">
    <div class="container">


        <div class="header-top-area">
            <div class="header-wrapper">
                @if(@$contact->data_values->contact_details)
                    <div class="header-top-item">
                        <div class="header-top-icon">
                            <img src="{{asset($activeTemplateTrue.'images/map.png')}}" alt="logo">
                        </div>
                        <div class="header-top-content">
                            <h6 class="title">@lang('Location')</h6>
                            <span> {{@$contact->data_values->contact_details}}</span>
                        </div>
                    </div>
                @endif

                @if(@$contact->data_values->email_address)
                    <div class="header-top-item">
                        <div class="header-top-icon">
                            <img src="{{asset($activeTemplateTrue.'images/mail.png')}}" alt="logo">
                        </div>
                        <div class="header-top-content">
                            <h6 class="title">@lang('Email address')</h6>
                            <a href="javascript:void(0)">{{@$contact->data_values->email_address}}</a>
                        </div>
                    </div>
                @endif



                @if(@$contact->data_values->working_hours)
                    <div class="header-top-item">
                        <div class="header-top-icon">
                            <img src="{{asset($activeTemplateTrue.'images/clock.png')}}" alt="logo">
                        </div>
                        <div class="header-top-content">
                            <h6 class="title">@lang('Working hours')</h6>
                            <span>{{@$contact->data_values->working_hours}}</span>
                        </div>
                    </div>
                @endif

                <div class="header-top-item">
                    <select class="langSel">
                        @foreach($language as $item)
                            <option value="{{$item->code}}" @if(session('lang') == $item->code) selected  @endif>{{ __($item->name) }}</option>
                        @endforeach
                    </select>
                </div>

            </div>
        </div>
    </div>
</div>
