<?php

use App\Helpers\CollectionHelper;
use App\Helpers\ShortIdTranslator;
use App\Helpers\UserNavigationHistory;
use App\Http\Livewire\Molecules\SubstitutionToggle;
use App\Models\DatabaseFile;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

if (!function_exists('shortId()')) {    
        
    /**
     * Returns ShortIdTranslator class instance
     *
     * @return App\Helpers\ShortIdTranslator
     */
    function shortId()
    {
        return app(ShortIdTranslator::class);
    }
}

// if (!function_exists('configTenantDB')) {
//     function configTenantDB() {
//         config([
//             "database.connections.tenant.database" => Auth::user()->databaseFiles()->first()->path(),
//         ]);
//     }
// }

if (!function_exists('navigation()')) {    
        
    /**
     * Returns navigation history helper class
     *
     * @return App\Helpers\UserNavigationHistory
     */
    function navigation()
    {
        return app(UserNavigationHistory::class);
    }
}

if (!function_exists('dateFromDateTime()')) {    
        
    /**
     * Formats datetime to date format d.m.Y
     *
     * @param string timestamp
     * @return string
     */
    function dateFromDateTime($timestamp)
    {
        return Carbon::parse($timestamp)->format("d.m.Y");
    }
}

if (!function_exists('dbListEmpty()')) {    
        
    /**
     * Return true if no database file instance exists in database or nor database file is currently connected
     *
     * @return App\Helpers\UserNavigationHistory
     */
    function dbListEmpty()
    {
        return DatabaseFile::all()->isEmpty() || currentTenantDBFile() == null;
    }
}

if (!function_exists('currentTenantDBFile()')) {    
        
    /**
     * Returns current database file
     *
     * @return App\Models\DatabaseFile
     */
    function currentTenantDBFile()
    {
        return Auth::user()->currentDatabaseFile;
    }
}

if (!function_exists('noDatabaseFileExists()')) {    
        
    /**
     * Returns current database file
     *
     * @return bool
     */
    function noDatabaseFileExists()
    {
        return DatabaseFile::noDatabaseFileExists();
    }
}
