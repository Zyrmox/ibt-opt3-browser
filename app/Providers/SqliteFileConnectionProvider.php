<?php

namespace App\Providers;

use App\Models\DatabaseFile;
use App\Traits\UsesDatabaseFileModel;
use Illuminate\Support\ServiceProvider;

class SqliteFileConnectionProvider extends ServiceProvider
{
    use UsesDatabaseFileModel;

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
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
