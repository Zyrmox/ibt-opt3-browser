<?php

namespace App\Traits;

use App\Models\DatabaseFile;

trait HasDatabaseFiles
{
    public function currentDatabaseFile() {
        return $this->belongsTo(DatabaseFile::class, 'current_database_file_id');
    }

    public function changeDatabaseFile(DatabaseFile $file) {
        $this->currentDatabaseFile()->associate($file)->save();
    }

    public function clearDatabaseFile() {
        $this->currentDatabaseFile()->dissociate()->save();
    }
    
    public function databaseFiles() {
        return $this->hasMany(DatabaseFile::class);
    }

    public function userDBConnectionKey() {
        return 'db_file_user_' . $this->id;
    }

    public function currentDBConnection() {
        return app($this->userDBConnectionKey());
    }
}
