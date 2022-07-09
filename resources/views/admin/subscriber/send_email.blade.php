@extends('admin.layouts.app')

@section('panel')
    <div class="row">

        <div class="col-xl-12">
            <div class="card">
                <form action="{{ route('admin.subscriber.sendEmail') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label class="font-weight-bold">@lang('Subject')</label>
                                <input type="text" class="form-control" placeholder="@lang('Email subject')" name="subject" value="{{ old('subject') }}" />
                            </div>
                            <div class="form-group col-md-12">
                                <label class="font-weight-bold">@lang('Email Body')</label>
                                <textarea name="body" rows="10" class="form-control nicEdit" placeholder="@lang('Your email template')">{{ old('body') }}</textarea>
                            </div>

                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-block btn--primary "><i class="fa fa-fw fa-paper-plane"></i>@lang('Send Mail')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <a href="{{ route('admin.subscriber.index') }}" class="btn btn-sm btn--primary box--shadow1 text--small"><i class="fa fa-fw fa-backward"></i> @lang('Go Back') </a>
@endpush
