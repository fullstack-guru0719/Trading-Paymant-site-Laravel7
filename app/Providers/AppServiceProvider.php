<?php

namespace App\Providers;

use App\Models\AdminNotification;
use App\Models\Frontend;
use App\Models\GeneralSetting;
use App\Models\Language;
use App\Models\Page;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        Paginator::useBootstrap();

        $activeTemplate = activeTemplate();
        $activeTemplateTrue = activeTemplate(true);
        
        $viewShare['general'] = GeneralSetting::first();
        $viewShare['activeTemplate'] = $activeTemplate;
        $viewShare['activeTemplateTrue'] = $activeTemplateTrue;
        $viewShare['language'] = Language::all();
        $viewShare['pages'] = Page::where('tempname',$activeTemplate)->where('slug','!=','home')->get();
        $viewShare['contact'] =  Frontend::where('data_keys','contact_us.content')->first();
        $viewShare['socials'] = Frontend::where('data_keys','social_icon.element')->get();

        view()->share($viewShare);
        

        view()->composer('admin.partials.sidenav', function ($view) {
            $view->with([
                'banned_users_count'           => \App\Models\User::banned()->count(),
                'email_unverified_users_count' => \App\Models\User::emailUnverified()->count(),
                'sms_unverified_users_count'   => \App\Models\User::smsUnverified()->count(),
                'pending_ticket_count'         => \App\Models\SupportTicket::whereIN('status', [0,2])->count(),
                'pending_deposits_count'    => \App\Models\Deposit::pending()->count(),
                'pending_withdraw_count'    => \App\Models\Withdrawal::pending()->count(),
            ]);
        });

        view()->composer('admin.partials.topnav', function ($view) {
            $view->with([
                'adminNotifications'=>AdminNotification::where('read_status',0)->with('user')->orderBy('id','desc')->get(),
            ]);
        });

        view()->composer('partials.seo', function ($view) {
            $seo = \App\Models\Frontend::where('data_keys', 'seo.data')->first();
            $view->with([
                'seo' => $seo ? $seo->data_values : $seo,
            ]);
        });

    }
}
