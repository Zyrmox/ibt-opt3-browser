<?php

namespace App\Http\Controllers;

use App\Models\Opt3\VP;
use Carbon\Carbon;

class DeadlinesController extends Controller
{
    public function index() {
        $data = VP::deadlinesWithCount()->get()->map(function($deadline){
            $arr["title"] = sprintf("%dx VP", $deadline->vps_count);
            $arr["start"] = Carbon::parse($deadline->deadline)->format("Y-m-d");
            return $arr; 
        });
        return response()->json($data);
    }
}
