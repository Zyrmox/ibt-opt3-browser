<?php
/**
 * Trait HasDBFileConnection
 *
 * @author Petr Vrtal <xvrtal01@fit.vutbr.cz>
 */
namespace App\Traits;

use App\Models\DatabaseFile;
use App\Models\User;
use Illuminate\Support\Facades\DB;

trait HasDBFileConnection
{
    public function connectFile(DatabaseFile $file) {
        config([
            "database.connections.tenant.database" => $file->url,
        ]);
        DB::purge('tenant');
        $this->setConnection('tenant');
    }
}
