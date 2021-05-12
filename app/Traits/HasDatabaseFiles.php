<?php
/**
 * Trait HasDatabaseFiles adding database file functionality
 * is used especially for User model
 *
 * @author Petr Vrtal <xvrtal01@fit.vutbr.cz>
 */
namespace App\Traits;

use App\Models\DatabaseFile;

trait HasDatabaseFiles
{    
    /**
     * Returns database file user is currently connected to
     *
     * @return App\Models\DatabaseFile
     */
    public function currentDatabaseFile() {
        return $this->belongsTo(DatabaseFile::class, 'current_database_file_id');
    }
    
    /**
     * Changes database file by associating new one
     *
     * @param  App\Models\DatabaseFile $file
     * @return void
     */
    public function changeDatabaseFile(DatabaseFile $file) {
        $this->currentDatabaseFile()->associate($file)->save();
    }
    
    /**
     * Clears user association with any Database file model (disconnects from file)
     *
     * @return void
     */
    public function clearDatabaseFile() {
        $this->currentDatabaseFile()->dissociate()->save();
    }
        
    /**
     * Return collection of all user uploaded database files
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function databaseFiles() {
        return $this->hasMany(DatabaseFile::class);
    }
    
    /**
     * Create and return user database connection key
     *
     * @return void
     */
    public function userDBConnectionKey() {
        return 'db_file_user_' . $this->id;
    }
    
    /**
     * Create container instance for currently connected database file
     *
     * @return void
     */
    public function currentDBConnection() {
        return app($this->userDBConnectionKey());
    }
}
