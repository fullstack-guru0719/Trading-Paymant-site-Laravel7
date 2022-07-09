@extends('admin.layouts.app')
@section('panel')
    <div class="notify__area">
    	@foreach($notifications as $notification)
        <a class="notify__item @if($notification->read_status == 0) unread--notification @endif" href="{{ route('admin.notification.read',$notification->id) }}">
            <div class="notify__thumb bg--primary">
                <img src="{{ getImage(imagePath()['profile']['user']['path'].'/'.@$notification->user->image,imagePath()['profile']['user']['size'])}}">
            </div>
            <div class="notify__content">
                <h6 class="title">{{ __($notification->title) }}</h6>
                <span class="date"><i class="las la-clock"></i> {{ $notification->created_at->diffForHumans() }}</span>
            </div>
        </a>
        @endforeach
        {{ $notifications->links() }}
    </div>
@endsection
@push('breadcrumb-plugins')
<a href="{{ route('admin.notifications.readAll') }}" class="btn btn--primary">@lang('Mark all as read')</a>
@endpush