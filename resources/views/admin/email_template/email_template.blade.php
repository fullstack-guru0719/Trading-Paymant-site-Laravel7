@extends('admin.layouts.app')

@section('panel')

    <div class="row">

        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive table-responsive-xl">
                        <table class=" table align-items-center table--light">
                            <thead>
                            <tr>
                                <th>@lang('Short Code') </th>
                                <th>@lang('Description')</th>
                            </tr>
                            </thead>
                            <tbody class="list">
                            <tr>
                                <td>@{{name}}</td>
                                <td>@lang('User Name')</td>
                            </tr>
                            <tr>
                                <td>@{{message}}</td>
                                <td>@lang('Message')</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>



        <div class="col-lg-12">
            <div class="card mt-5">
                <div class="card-body">
                    <form action="{{ route('admin.email-template.global') }}" method="POST">
                        @csrf
                        <div class="form-row">

                            <div class="form-group col-md-12">
                                <label class="font-weight-bold">@lang('Email Sent From') <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-lg" placeholder="Email address" name="email_from" value="{{ $general_setting->email_from }}"  required/>
                            </div>
                            <div class="form-group col-md-12">
                                <label class="font-weight-bold">@lang('Email Body') <span class="text-danger">*</span></label>
                                <textarea name="email_template" rows="10" class="form-control form-control-lg nicEdit" placeholder="Your email template">{{ $general_setting->email_template }}</textarea>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-block btn--primary mr-2">@lang('Update')</button>


                    </form>
                </div>
            </div><!-- card end -->
        </div>


    </div>

@endsection


