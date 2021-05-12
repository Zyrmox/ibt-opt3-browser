<?php
/**
 * Deadlines Controller - managing manufacturing order deadlines data
 *
 * @author Petr Vrtal <xvrtal01@fit.vutbr.cz>
 */
namespace App\Http\Controllers;

use App\Models\Opt3\VP;
use Carbon\Carbon;

class DeadlinesController extends Controller
{    
    /**
     * Method is responsible for returning all deadlines and their relevant
     * manufacturing orders in JSON format. Will be used as source for
     * month callendar (Fullcalendar) in vp-deadlines-insight.blade.
     *
     * @return void
     */
    public function index() {
        $data = VP::deadlinesWithCount()->get()->map(function($deadline){
            $arr["title"] = sprintf("%dx VP", $deadline->vps_count);
            $arr["start"] = Carbon::parse($deadline->deadline)->format("Y-m-d");
            return $arr; 
        });
        return response()->json($data);
    }
}
