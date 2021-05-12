<?php

namespace App\Providers;

use App\Models\CProp;
use App\Models\DatabaseFile;
use App\Observers\DatabaseFileObserver;
use Illuminate\Database\Eloquent\Relations\Relation;
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
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Fixes error with string length
        Schema::defaultStringLength(191);

        // Register DatabaseFile model observer
        DatabaseFile::observe(DatabaseFileObserver::class);

        // Creates map for polymorphic relation between specified models
        Relation::morphMap([
            CProp::TYPE_OPERATION => 'App\Models\Opt3\Job',
            CProp::TYPE_RESOURCE_MACHINE => 'App\Models\Opt3\Resource',
        ]);
    }
}
