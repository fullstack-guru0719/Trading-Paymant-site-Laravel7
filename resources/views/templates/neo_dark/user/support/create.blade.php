@extends($activeTemplate.'layouts.master')

@section('content')

    @include($activeTemplate.'partials.user-breadcrumb')
    <section class="feature-section pt-150 pb-150">
        <div class="container">
            <div class="row justify-content-center">

                <div class="col-md-12">
                    <div class="dashboard__header mb-4">
                        <div class="left">
                            <h3>{{trans($page_title)}}</h3>
                        </div>
                        <div class="right">
                            <a href="{{route('ticket') }}" class="side-menu-action mx-2 btn btn-success btn-sm w-auto px-3 btn-primary" title="@lang('My Support Ticket')">
                                <i class="fa fa-eye"></i>
                            </a>
                        </div>
                    </div>
                </div>


                <div class="col-md-12">
                    <div class="card card-bg">

                        <div class="card-body">

                            <form action="{{route('ticket.store')}}" method="post" enctype="multipart/form-data"
                                  onsubmit="return submitUserForm();" class="register">
                                @csrf
                                <div class="row ">
                                    <div class="form-group col-md-6">
                                        <label for="name">@lang('Name')</label>
                                        <input type="text" name="name"
                                               value="{{@$user->firstname . ' '.@$user->lastname}}"
                                               class="form-control form-control-lg" placeholder="@lang('Enter Name')"
                                               required autocomplete="off">
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="email">@lang('Email address')</label>
                                        <input type="email" name="email" value="{{@$user->email}}"
                                               class="form-control form-control-lg"
                                               placeholder="@lang('Enter your Email')" required  autocomplete="off">
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label for="website">@lang('Subject')</label>
                                        <input type="text" name="subject" value="{{old('subject')}}"
                                               class="form-control form-control-lg" placeholder="@lang('Subject')"  autocomplete="off">
                                    </div>

                                    <div class="col-12 form-group">
                                        <label for="inputMessage">@lang('Message')</label>
                                        <textarea name="message" id="inputMessage" rows="6"
                                                  class="form-control form-control-lg"  autocomplete="off">{{old('message')}}</textarea>
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-sm-9 file-upload">
                                        <label for="inputAttachments">@lang('Attachments')</label>
                                        <input type="file" name="attachments[]" id="inputAttachments"
                                               class="form-control mb-2"/>
                                        <div id="fileUploadsContainer"></div>
                                        <p class="ticket-attachments-message text-muted">
                                            @lang("Allowed File Extensions: .jpg, .jpeg, .png, .pdf, .doc, .docx")
                                        </p>
                                    </div>

                                    <div class="col-sm-1">

                                        <label>&nbsp;</label>
                                        <button type="button" class="btn btn-success btn-sm btn-primary extraTicketAttachment"
                                               >
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="row form-group justify-content-center">
                                    <div class="col-md-12">
                                        <button class="btn btn-success m-1 btn-primary" type="submit" id="recaptcha"><i
                                                class="fa fa-paper-plane"></i>&nbsp;@lang('Submit')</button>
                                        <button class=" btn btn-danger m-1" type="button" onclick="formReset()">
                                            &nbsp;@lang('Cancel')</button>
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


@push('script')
    <script>
        $('.extraTicketAttachment').click(function(){
            "use strict";
            $("#fileUploadsContainer").append('<input type="file" name="attachments[]" class="form-control my-3" required />')
        });
    </script>
@endpush
