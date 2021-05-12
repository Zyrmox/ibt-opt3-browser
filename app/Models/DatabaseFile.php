<?php
/**
 * Database File Model - Represent Database file
 *
 * @author Petr Vrtal <xvrtal01@fit.vutbr.cz>
 */
namespace App\Models;

use App\Observers\DatabaseFileObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DatabaseFile extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id", "url", "original_name"
    ];
    
    /**
     * Returns DatabaseFile instance marked as current for a user
     *
     * @return self
     */
    public static function current(): ?self {
        $key = "db_file_user_1";

        if (!app()->has($key)) {
            return null;
        }

        return app($key);
    }
    
    /**
     * Switches current database file
     *
     * @return self
     */
    public function makeCurrent(): self {
        config([
            "database.connections.tenant.database" => $this->path(),
        ]);

        DB::purge("tenant");

        $key = "db_file_user_" . $this->user->id;
        app()->forgetInstance($key);
        app()->instance($key, DB::connection('tenant'));
        
        return $this;
    }

        
    /**
     * Returns original name of the uploaded database file
     *
     * @return string
     */
    public function name() {
        return $this->original_name;
    }

    /**
     * Returns absolute path to the uploaded database file
     *
     * @return string
     */
    public function path() {
        return Storage::disk('databases')->path($this->url);
    }
    
    /**
     * Returns the author of this database file
     *
     * @return void
     */
    public function user() {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Returns collection of users currently connected to this database file
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function currentUsers() {
        return $this->hasMany(User::class, 'current_database_file_id');
    }
    
    /**
     * Checks whether currently logged user is owner of this database file model instance
     *
     * @return bool
     */
    public function isOwner(): bool {
        return $this->user->id == Auth::id();
    }
    
    /**
     * Checks whether databse file is selected
     *
     * @return bool
     */
    public function isSelected(): bool {
        return currentTenantDBFile() != null ? currentTenantDBFile()->id == $this->id : false;
    }
    
    /**
     * Returns true when there is no uploaded database file yet
     *
     * @return bool
     */
    public static function noDatabaseFileExists(): bool {
        return self::all()->isEmpty();
    }
}
