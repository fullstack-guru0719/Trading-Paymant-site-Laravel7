@auth
<div class="user-sidebar style--xl">
    <button type="button" class="dashboard-side-menu-close"><i class="fa fa-window-close"></i></button>
    <ul class="user-sidebar-menu">
        <li><a href="{{route('user.home')}}"> <i class="fas fa-tachometer-alt pr-1"></i>  @lang('Dashboard')</a></li>
        <li><a href="{{route('user.plan')}}"> <i class="fas fa-cubes pr-1"></i>  @lang('Investment')</a></li>
        <li><a href="{{route('user.deposit')}}"><i class="fa fa-credit-card pr-1" aria-hidden="true"></i>
                 @lang('Deposit')</a></li>

        <li><a href="{{route('user.withdraw')}}"><i class="fas fa-money-bill-wave pr-1"></i>
                @lang('Withdraw')</a></li>


        @if(Route::has('user.transactions.deposit'))
            <li><a href="{{route('user.transactions.deposit')}}"><i class="fas fa-exchange-alt pr-1"></i> @lang('Transaction Log')</a></li>
        @endif
        @if(Route::has('user.referral.users'))
            <li><a href="{{route('user.referral.users')}}"><i class="fa fa-users pr-1"></i>
                    @lang('Referred Users')</a></li>
        @endif
        @if(Route::has('user.referral.commissions.deposit'))
            <li><a href="{{route('user.referral.commissions.deposit')}}"><i class="fa fa-users pr-1"></i>
                    @lang('Referral Commissions')</a></li>
        @endif

        @if (Route::has('user.profile-setting'))
            <li><a href="{{route('user.profile-setting')}}"> <i class="fa fa-user pr-1"></i>
                    @lang('Profile Setting')</a></li>
        @endif

        @if (Route::has('user.transfer.balance'))
        @if($general->b_transfer)
            <li><a href="{{route('user.transfer.balance')}}"> <i class="fa fa-dollar-sign"></i>
                    @lang('Transfer Balance')</a></li>
        @endif
        @endif

        @if (Route::has('user.change-password'))
            <li><a href="{{route('user.change-password')}}"><i class="fa fa-unlock-alt pr-1" ></i>
                    @lang('Change Password')</a></li>
        @endif
        @if (Route::has('ticket'))
            <li><a href="{{route('ticket')}}"><i class="fas fa-ticket-alt pr-1" ></i>
                    @lang('Support Ticket')</a></li>
        @endif
        @if (Route::has('user.twofactor'))
            <li><a href="{{route('user.twofactor')}}"><i class="fa fa-user-secret pr-1" ></i>
                    @lang('2FA Security')</a></li>
        @endif
        <li><a href="{{ route('user.logout') }}"> <i class="fas fa-sign-out-alt pr-1"></i> {{ __('Logout') }}</a></li>
    </ul>
</div><!-- user-sidebar end -->
@endauth
