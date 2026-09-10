<?php

namespace App\Providers;

use League\Flysystem\Filesystem;
use League\Flysystem\Sftp\SftpAdapter;
use Illuminate\Support\Facades\View;
use App\Models\Settings;
use App\Models\SettingsCont;
use App\Models\TermsPrivacy;
use App\Models\DemoAccountRequest;
use App\Models\SecondAccountRequest;
use Illuminate\Pagination\Paginator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Storage as FacadesStorage;
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
        FacadesStorage::extend('sftp', function ($app, $config) {
            return new Filesystem(new SftpAdapter($config));
        });

        Password::defaults(function () {
            $rule = Password::min(8);
            return $this->app->isProduction()
                ? $rule->mixedCase()->numbers()->symbols()->uncompromised()
                : $rule;
        });

        Paginator::useBootstrap();

        // Sharing settings with all view
        $settings = Settings::where('id', '1')->first();
        $terms =  TermsPrivacy::find(1);
        $moreset =  SettingsCont::find(1);

        View::share('settings', $settings);
        View::share('terms', $terms);
        View::share('moresettings', $moreset);
        View::share('mod', $settings->modules);

        // Share pending demo account requests count for admin sidebar badge
        View::composer('admin.sidebar', function ($view) {
            try {
                $pendingDemoCount   = DemoAccountRequest::where('status', 'pending')->count();
                $pendingSecondCount = SecondAccountRequest::where('status', 'pending')->count();
                $pendingThirdCount  = \Illuminate\Support\Facades\Schema::hasTable('third_account_requests') ? \App\Models\ThirdAccountRequest::where('status', 'pending')->count() : 0;
                $pendingFourthCount = \Illuminate\Support\Facades\Schema::hasTable('fourth_account_requests') ? \App\Models\FourthAccountRequest::where('status', 'pending')->count() : 0;
            } catch (\Exception $e) {
                $pendingDemoCount   = 0;
                $pendingSecondCount = 0;
                $pendingThirdCount  = 0;
                $pendingFourthCount = 0;
            }
            $view->with('pendingDemoCount', $pendingDemoCount);
            $view->with('pendingSecondCount', $pendingSecondCount);
            $view->with('pendingThirdCount', $pendingThirdCount);
            $view->with('pendingFourthCount', $pendingFourthCount);
        });
    }
}
