<?php

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
        // Storage::disk('databases')->delete($databaseFile->url);
        if(File::exists($databaseFile->path())){
            File::delete($databaseFile->path());
        }
        shortId()->delete($databaseFile);

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
