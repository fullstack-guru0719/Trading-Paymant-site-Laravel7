@extends($extend_blade)

@section('content')

    @include($activeTemplate.'partials.user-breadcrumb')
<section class="cmn-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">


                <div class="card">
                    <div class="card-header card-header-bg d-flex flex-wrap justify-content-between align-items-center">
                        <h5 class="card-title mt-0">
                            @if($my_ticket->status == 0)
                                <span class="badge badge-success py-2 px-3">@lang('Open')</span>
                            @elseif($my_ticket->status == 1)
                                <span class="badge badge-primary py-2 px-3">@lang('Answered')</span>
                            @elseif($my_ticket->status == 2)
                                <span class="badge badge-warning py-2 px-3">@lang('Replied')</span>
                            @elseif($my_ticket->status == 3)
                                <span class="badge badge-dark py-2 px-3">@lang('Closed')</span>
                            @endif
                            <span class="text-dark">[Ticket#{{ $my_ticket->ticket }}] {{ $my_ticket->subject }}</span>
                        </h5>

                        <button class="btn btn-dark close-button" type="button" title="@lang('Close Ticket')"
                                data-toggle="modal"
                                data-target="#DelModal"><i class="fa fa-lg fa-times-circle"></i>

                        </button>

                    </div>

                    <div class="card-body">

                        @if($my_ticket->status != 4)
                                            <form method="post"
                                                  action="{{ route('ticket.reply', $my_ticket->id) }}"
                                                  enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="row justify-content-between">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <textarea name="message" class="form-control form-control-lg" id="inputMessage" placeholder="@lang('Your Reply') ..." rows="4" cols="10"></textarea>
                                                        </div>


                                                    </div>

                                                </div>

                                                <div class="row justify-content-between">

                                                    <div class="col-md-12">
                                                        <div class="row justify-content-between">
                                                            <div class="col-md-9">

                                                                <div class="form-group">
                                                                    <label for="inputAttachments">@lang('Attachments')</label>
                                                                    <input type="file"
                                                                           name="attachments[]"
                                                                           id="inputAttachments"
                                                                           class="form-control"/>
                                                                    <div id="fileUploadsContainer"></div>
                                                                    <p class="my-2 ticket-attachments-message text-muted">
                                                                        @lang("Allowed File Extensions: .jpg, .jpeg, .png, .pdf")
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 mt-3">
                                                                <div class="form-group">
                                                                    <a href="javascript:void(0)"
                                                                       class="btn cmn-btn mt-4 extraTicketAttachment">
                                                                        <i class="fa fa-plus"></i>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>


                                                    </div>

                                                    <div class="col-md-12">
                                                        <button type="submit"
                                                                class="btn cmn-btn w-100 mt-4"
                                                                name="replayTicket" value="1">
                                                            <i class="fa fa-reply"></i> @lang('Reply')
                                                        </button>
                                                    </div>

                                                </div>
                                            </form>
                                        @endif

                        


                        <div class="row mt-5">
                            <div class="col-md-12">


                                @foreach($messages as $message)
                                @if($message->admin_id == 0)



                                <div class="row border border-primary border-radius-3 my-3 py-3 mx-2">
                                    <div class="col-md-3 border-right text-right">
                                        <h5 class="my-3">{{ $message->ticket->name }}</h5>
                                    </div>

                                    <div class="col-md-9">
                                        <p class="text-muted font-weight-bold my-3">
                                            @lang('Posted on') {{ $message->created_at->format('l, dS F Y @ H:i') }}</p>
                                            <p>{{$message->message}}</p>
                                            @if($message->attachments()->count() > 0)
                                            <div class="mt-2">
                                                @foreach($message->attachments as $k=> $image)
                                                <a href="{{route('ticket.download',encrypt($image->id))}}" class="mr-3"><i class="fa fa-file"></i>  @lang('Attachment') {{++$k}} </a>
                                                @endforeach
                                            </div>
                                            @endif

                                        </div>

                                    </div>

                                    @else


                                    <div class="row border border-warning border-radius-3 my-3 py-3 mx-2 staff-reply">

                                        <div class="col-md-3 border-right text-right">
                                            <h5 class="my-3">{{ $message->admin->name }}</h5>
                                            <p class="lead text-muted">@lang('Staff')</p>

                                        </div>

                                        <div class="col-md-9">
                                            <p class="text-muted font-weight-bold my-3">
                                                @lang('Posted on') {{ $message->created_at->format('l, dS F Y @ H:i') }}</p>
                                                <p>{{$message->message}}</p>

                                                @if($message->attachments()->count() > 0)
                                                <div class="mt-2">
                                                    @foreach($message->attachments as $k=> $image)
                                                    <a href="{{route('ticket.download',encrypt($image->id))}}" class="mr-3"><i class="fa fa-file"></i>  @lang('Attachment') {{++$k}} </a>
                                                    @endforeach
                                                </div>
                                                @endif
                                            </div>

                                        </div>
                                        @endif
                                        @endforeach



                                        
                                    </div>



                        </div>


                    </div>
                </div>
            </div>
        </div>

</div>
</section>


    <div class="modal fade" id="DelModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content modal-content-bg">

                <form method="post" action="{{ route('ticket.reply', $my_ticket->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="modal-header">
                        <h5 class="modal-title"> @lang('Confirmation')!</h5>

                        <button type="button" class="close close-button" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <p class="text-white">@lang('Are you sure you want to Close This Support Ticket')?</p>
                    </div>
                    <div class="modal-footer">

                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i>
                            @lang('Close')
                        </button>

                        <button type="submit" class="btn cmn-btn" name="replayTicket"
                                value="2"><i class="fa fa-check"></i> @lang("Confirm")
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>

@endsection

@push('script')
    <script>
        $(document).ready(function () {
            "use strict";
            $('.delete-message').on('click', function (e) {
                $('.message_id').val($(this).data('id'));
            });
            $('.extraTicketAttachment').click(function(){
                $("#fileUploadsContainer").append('<input type="file" name="attachments[]" class="form-control mt-1" required />')
            });
        });
    </script>
@endpush
