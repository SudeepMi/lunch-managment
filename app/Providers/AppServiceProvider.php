<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Blade;
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
        Blade::directive('notactive', function ($guard) {
           return "<?php if(isset(Auth::guard($guard)->user()->name) && Auth::guard($guard)->user()->active == 0){ ?>";
        });
        Blade::directive('elseactive', function () {
            return "<?php }else{ ?>";
         });

         Blade::directive('endactive', function () {
            return "<?php } ?>";
         });
    }
}
