@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <form action="{{ route('admin.sms.template.setting') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label class="mb-4">@lang('Email Send Method')</label>
                                <select name="sms_method" class="form-control" >
                                    <option value="clickatell" @if(@$general->sms_config->name == 'clickatell') selected @endif>@lang('Clickatell')</option>
                                    <option value="infobip" @if(@$general->sms_config->name == 'infobip') selected @endif>@lang('Infobip')</option>
                                    <option value="messageBird" @if(@$general->sms_config->name == 'messageBird') selected @endif>@lang('Message Bird')</option>
                                    <option value="nexmo" @if(@$general->sms_config->name == 'nexmo') selected @endif>@lang('Nexmo')</option>
                                    <option value="smsBroadcast" @if(@$general->sms_config->name == 'smsBroadcast') selected @endif>@lang('Sms Broadcast')</option>
                                    <option value="twilio" @if(@$general->sms_config->name == 'twilio') selected @endif>@lang('Twilio')</option>
                                    <option value="textMagic" @if(@$general->sms_config->name == 'textMagic') selected @endif>@lang('Text Magic')</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6 text-right">
                                <h6 class="mb-4">&nbsp;</h6>
                                <button type="button" data-target="#testSMSModal" data-toggle="modal" class="btn btn--info">@lang('Send Test SMS')</button>
                            </div>
                        </div>
                        <div class="form-row mt-4 d-none configForm" id="clickatell">
                            <div class="col-md-12">
                                <h6 class="mb-2">@lang('Clickatell Configuration')</h6>
                            </div>
                            <div class="form-group col-md-12">
                                <label class="font-weight-bold">@lang('Api Key') <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="@lang('Api Key')" name="clickatell_api_key" value="{{ @$general->sms_config->clickatell_api_key }}"/>
                            </div>
                        </div>
                        <div class="form-row mt-4 d-none configForm" id="infobip">
                            <div class="col-md-12">
                                <h6 class="mb-2">@lang('Infobip Configuration')</h6>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="font-weight-bold">@lang('Username') <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="@lang('Username')" name="infobip_username" value="{{ @$general->sms_config->infobip_username }}"/>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="font-weight-bold">@lang('Password') <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="@lang('Password')" name="infobip_password" value="{{ @$general->sms_config->infobip_password }}"/>
                            </div>
                        </div>
                        <div class="form-row mt-4 d-none configForm" id="messageBird">
                            <div class="col-md-12">
                                <h6 class="mb-2">@lang('Message Bird Configuration')</h6>
                            </div>
                            <div class="form-group col-md-12">
                                <label class="font-weight-bold">@lang('Api Key') <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="@lang('Api Key')" name="message_bird_api_key" value="{{ @$general->sms_config->message_bird_api_key }}"/>
                            </div>
                        </div>
                        <div class="form-row mt-4 d-none configForm" id="nexmo">
                            <div class="col-md-12">
                                <h6 class="mb-2">@lang('Nexmo Configuration')</h6>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="font-weight-bold">@lang('Api Key') <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="@lang('Api Key')" name="nexmo_api_key" value="{{ @$general->sms_config->nexmo_api_key }}"/>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="font-weight-bold">@lang('Api Secret') <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="@lang('Api Secret')" name="nexmo_api_secret" value="{{ @$general->sms_config->nexmo_api_secret }}"/>
                            </div>
                        </div>
                        <div class="form-row mt-4 d-none configForm" id="smsBroadcast">
                            <div class="col-md-12">
                                <h6 class="mb-2">@lang('Sms Broadcast Configuration')</h6>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="font-weight-bold">@lang('Username') <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="@lang('Username')" name="sms_broadcast_username" value="{{ @$general->sms_config->sms_broadcast_username }}"/>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="font-weight-bold">@lang('Password') <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="@lang('Password')" name="sms_broadcast_password" value="{{ @$general->sms_config->sms_broadcast_password }}"/>
                            </div>
                        </div>
                        <div class="form-row mt-4 d-none configForm" id="twilio">
                            <div class="col-md-12">
                                <h6 class="mb-2">@lang('Twilio Configuration')</h6>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="font-weight-bold">@lang('Account SID') <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="@lang('Account SID')" name="account_sid" value="{{ @$general->sms_config->account_sid }}"/>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="font-weight-bold">@lang('Auth Token') <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="@lang('Auth Token')" name="auth_token" value="{{ @$general->sms_config->auth_token }}"/>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="font-weight-bold">@lang('From Number') <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="@lang('From Number')" name="from" value="{{ @$general->sms_config->from }}"/>
                            </div>
                        </div>
                        <div class="form-row mt-4 d-none configForm" id="textMagic">
                            <div class="col-md-12">
                                <h6 class="mb-2">@lang('Text Magic Configuration')</h6>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="font-weight-bold">@lang('Username') <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="@lang('Username')" name="text_magic_username" value="{{ @$general->sms_config->text_magic_username }}"/>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="font-weight-bold">@lang('Apiv2 Key') <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="@lang('Apiv2 Key')" name="apiv2_key" value="{{ @$general->sms_config->apiv2_key }}"/>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-block btn--primary mr-2">@lang('Update')</button>
                    </div>
                </form>
            </div><!-- card end -->
        </div>


    </div>


    {{-- TEST MAIL MODAL --}}
    <div id="testSMSModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Test SMS Setup')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.sms.template.test.sms') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label>@lang('Sent to') <span class="text-danger">*</span></label>
                                <input type="text" name="mobile" class="form-control" placeholder="@lang('Moble')">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--success">@lang('Send')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@push('script')
    <script>
        (function ($) {
            "use strict";
            
            var method = '{{ @$general->sms_config->name }}';

            if (!method) {
                method = 'clickatell';
            }

            smsMethod(method);
            $('select[name=sms_method]').on('change', function() {
                var method = $(this).val();
                smsMethod(method);
            });

            function smsMethod(method){
                $('.configForm').addClass('d-none');
                if(method != 'php') {
                    $(`#${method}`).removeClass('d-none');
                }
            }

        })(jQuery);

    </script>
@endpush
