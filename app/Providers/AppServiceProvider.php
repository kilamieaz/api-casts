<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
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
        $this->app->bind(
            'App\Screencast\Repositories\Contracts\VideoInterface',
            'App\Screencast\Repositories\Eloquents\VideoEloquent'
        );

        $this->app->bind(
            'App\Screencast\Repositories\Contracts\TagInterface',
            'App\Screencast\Repositories\Eloquents\TagEloquent'
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
    }
}
