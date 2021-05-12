<?php
/**
 * Database File observer - used when deleting database files
 *
 * @author Petr Vrtal <xvrtal01@fit.vutbr.cz>
 */
namespace App\Observers;

use App\Models\DatabaseFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class DatabaseFileObserver
{
    /**
     * Handle the DatabaseFile "created" event.
     *
     * @param  \App\Models\DatabaseFile  $databaseFile
     * @return void
     */
    public function created(DatabaseFile $databaseFile)
    {
        //
    }

    /**
     * Handle the DatabaseFile "updated" event.
     *
     * @param  \App\Models\DatabaseFile  $databaseFile
     * @return void
     */
    public function updated(DatabaseFile $databaseFile)
    {
        //
    }

    /**
     * Handle the DatabaseFile "deleted" event.
     *
     * @param  \App\Models\DatabaseFile  $databaseFile
     * @return void
     */
    public function deleted(DatabaseFile $databaseFile)
    {
        // If database file exists in storage delete it
        if(File::exists($databaseFile->path())){
            File::delete($databaseFile->path());
        }

        // Also delete all substitution made for objects of this file
        shortId()->delete($databaseFile);

        // If any user of the application is currently connected to the file we disconnects all of them
        foreach ($databaseFile->currentUsers as $user) {
            $user->clearDatabaseFile();
        }
        
    }

    /**
     * Handle the DatabaseFile "restored" event.
     *
     * @param  \App\Models\DatabaseFile  $databaseFile
     * @return void
     */
    public function restored(DatabaseFile $databaseFile)
    {
        //
    }

    /**
     * Handle the DatabaseFile "force deleted" event.
     *
     * @param  \App\Models\DatabaseFile  $databaseFile
     * @return void
     */
    public function forceDeleted(DatabaseFile $databaseFile)
    {
        //
    }
}
