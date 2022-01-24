<?php

namespace App\Providers;

use App\Helper\JiraHelper;
use Illuminate\Support\ServiceProvider;

class JiraServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $url = config('jira.host');
        $email = config('jira.auth.email');
        $token = config('jira.auth.token');

        $this->app->bind('App\Helper\JiraHelper', function () use ($url, $email, $token){
            return new JiraHelper($url, $email, $token);
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
    }
}
