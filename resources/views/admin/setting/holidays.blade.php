@extends('admin.layouts.app')
@section('panel')


    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--md  table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                            <tr>
                                <th scope="col">@lang('SL')</th>
                                <th scope="col">@lang('Date')</th>
                                <th scope="col">@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($holidays as $holiday)
                            <tr>
                                <td data-label="@lang('SL')">{{ $loop->iteration }}</td>
                                <td data-label="@lang('Date')">{{ $holiday->date }}</td>
                                <td data-label="@lang('Action')">
                                    <button data-action="{{ route('admin.setting.remove', $holiday->id) }}" class="icon-btn btn--danger removeBtn"><i class="las la-trash text--shadow"></i></button>
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">@lang('Data not found')</td>
                                </tr>
                            @endforelse

                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
                <div class="card-footer py-4">
                    {{ $holidays->links('admin.partials.paginate') }}
                </div>
            </div><!-- card end -->
        </div>
    </div>
    



<div class="card mt-5">
    <div class="card-header"><b class="lead">@lang('Weekly Holidays')</b></div>
    <form action="{{route('admin.setting.offday')}}" method="post">
        @csrf
        <div class="card-body">
            <div class="row mb-none-30">
                <div class="form-group col-lg-3 col-sm-6 col-md-4">
                    <label class="form-control-label font-weight-bold"> @lang('Sunday')</label>
                    <input type="checkbox" data-width="100%" data-size="large" data-onstyle="-success" data-offstyle="-danger" data-toggle="toggle" data-on="@lang('Enable')" data-off="@lang('Disable')" name="off_day[sun]" @if(@$general->off_day->sun) checked @endif>
                </div>
                <div class="form-group col-lg-3 col-sm-6 col-md-4">
                    <label class="form-control-label font-weight-bold"> @lang('Monday')</label>
                    <input type="checkbox" data-width="100%" data-size="large" data-onstyle="-success" data-offstyle="-danger" data-toggle="toggle" data-on="@lang('Enable')" data-off="@lang('Disable')" name="off_day[mon]" @if(@$general->off_day->mon) checked @endif>
                </div>
                <div class="form-group col-lg-3 col-sm-6 col-md-4">
                    <label class="form-control-label font-weight-bold"> @lang('Tuesday')</label>
                    <input type="checkbox" data-width="100%" data-size="large" data-onstyle="-success" data-offstyle="-danger" data-toggle="toggle" data-on="@lang('Enable')" data-off="@lang('Disable')" name="off_day[tue]" @if(@$general->off_day->tue) checked @endif>
                </div>
                <div class="form-group col-lg-3 col-sm-6 col-md-4">
                    <label class="form-control-label font-weight-bold"> @lang('Wednesday')</label>
                    <input type="checkbox" data-width="100%" data-size="large" data-onstyle="-success" data-offstyle="-danger" data-toggle="toggle" data-on="@lang('Enable')" data-off="@lang('Disable')" name="off_day[wed]" @if(@$general->off_day->wed) checked @endif>
                </div>
                <div class="form-group col-lg-3 col-sm-6 col-md-4">
                    <label class="form-control-label font-weight-bold"> @lang('Thursday')</label>
                    <input type="checkbox" data-width="100%" data-size="large" data-onstyle="-success" data-offstyle="-danger" data-toggle="toggle" data-on="@lang('Enable')" data-off="@lang('Disable')" name="off_day[thu]" @if(@$general->off_day->thu) checked @endif>
                </div>
                <div class="form-group col-lg-3 col-sm-6 col-md-4">
                    <label class="form-control-label font-weight-bold"> @lang('Friday')</label>
                    <input type="checkbox" data-width="100%" data-size="large" data-onstyle="-success" data-offstyle="-danger" data-toggle="toggle" data-on="@lang('Enable')" data-off="@lang('Disable')" name="off_day[fri]" @if(@$general->off_day->fri) checked @endif>
                </div>
                <div class="form-group col-lg-3 col-sm-6 col-md-4">
                    <label class="form-control-label font-weight-bold"> @lang('Saturday')</label>
                    <input type="checkbox" data-width="100%" data-size="large" data-onstyle="-success" data-offstyle="-danger" data-toggle="toggle" data-on="@lang('Enable')" data-off="@lang('Disable')" name="off_day[sat]" @if(@$general->off_day->sat) checked @endif>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn--primary btn-block">@lang('Update')</button>
        </div>
    </form>
</div>




    <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">@lang('Add Holiday')</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" method="post">
          @csrf
          <div class="modal-body">
            <div class="form-group">
                <label>@lang('Enter Date')</label>
                <input type="date" class="form-control" name="date" placeholder="Type date">
            </div>
          </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('Close')</button>
        <button type="submit" class="btn btn--primary">@lang('Add')</button>
      </div>
      </form>
    </div>
  </div>
</div>
    
    <!--Remove Modal -->
<div class="modal fade" id="removeModal" tabindex="-1" role="dialog" aria-labelledby="removeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="removeModalLabel">@lang('Remove Holiday')</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" method="post">
          @csrf
          <div class="modal-body">
            <p class="text-center">@lang('Are you sure to remove this holiday ?')</p>
          </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('Close')</button>
        <button type="submit" class="btn btn--danger">@lang('Remove')</button>
      </div>
      </form>
    </div>
  </div>
</div>
@endsection

@push('breadcrumb-plugins')
    <button class="icon-btn" data-toggle="modal" data-target="#exampleModal">@lang('Add Holiday')</button>
@endpush
@push('script')
    <script>
        (function($){
            "use strct";
            $('.removeBtn').on('click',function(){
                var modal = $('#removeModal');
                modal.find('form').attr('action',$(this).data('action'));
                modal.modal('show');
            });
        })(jQuery);
    </script>
@endpush