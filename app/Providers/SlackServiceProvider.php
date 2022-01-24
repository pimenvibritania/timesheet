<?php

namespace App\Providers;

use App\Helper\SlackHelper;
use Illuminate\Support\ServiceProvider;

class SlackServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $hook = config('slack.hook');
        $url = config('slack.host');
        $token = config('slack.token');

        $this->app->bind('App\Helper\SlackHelper', function () use ($hook, $url, $token){
            return new SlackHelper($hook, $url, $token);
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
