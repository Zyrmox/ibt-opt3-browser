<?php

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

    public static function current(): ?self {
        $key = "db_file_user_1";

        if (!app()->has($key)) {
            return null;
        }

        return app($key);
    }

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

    public function name() {
        return $this->original_name;
    }

    public function path() {
        return Storage::disk('databases')->path($this->url);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function currentUsers() {
        return $this->hasMany(User::class, 'current_database_file_id');
    }

    public function isOwner(): bool {
        return $this->user->id == Auth::id();
    }

    public function isSelected(): bool {
        return currentTenantDBFile() != null ? currentTenantDBFile()->id == $this->id : false;
    }

    public static function noDatabaseFileExists(): bool {
        return self::all()->isEmpty();
    }
}
