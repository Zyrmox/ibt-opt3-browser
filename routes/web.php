<?php
/**
 * Web Routes file
 *
 * @author Petr Vrtal <xvrtal01@fit.vutbr.cz>
 */

use App\Http\Controllers\DeadlinesController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

/*
| Section of application protected by Laravel Sanctum
| Only authenticated users get passed the 'auth:sanctum' to other routes,
| specified in the closure.
*/
Route::middleware(['auth:sanctum', 'verified', 'livewire'])->group(function(){
    Route::middleware(['has.files'])->group(function(){

        /*
        | Returns Dashboard view - default location after login / register
        */
        Route::get('/dashboard', function () {
            return view('dashboard');
        })->name('dashboard');
    
        /*
        | Group of all database views implemented in the application
        */
        Route::prefix('view')->group(function() {
            Route::get('/deadlines', App\Http\Livewire\Pages\Insights\VPDeadlinesInsight::class)->name('insights.vp-deadlines');
            Route::get('/vps', App\Http\Livewire\Pages\Insights\VPsInsight::class)->name('insights.vps');
            Route::get('/jobs', App\Http\Livewire\Pages\Insights\Jobs::class)->name('insights.jobs');
            Route::get('/resources', App\Http\Livewire\Pages\Insights\ResourcesInsight::class)->name('insights.resources');
            Route::get('/job-resources', App\Http\Livewire\Pages\Insights\JobResourcesInsight::class)->name('insights.job-resources');
            Route::get('/materials', App\Http\Livewire\Pages\Insights\MaterialsInsight::class)->name('insights.materials');
            Route::get('/cprops', App\Http\Livewire\Pages\Insights\CPropsInsight::class)->name('insights.c-props');
            Route::get('/vp/{id}', App\Http\Livewire\Pages\Insights\VPInsight::class)->name('insights.vp');
            Route::get('/job/{id}', App\Http\Livewire\Pages\Insights\JobInsight::class)->name('insights.job');
            Route::get('/resource/{id}', App\Http\Livewire\Pages\Insights\ResourceInsight::class)->name('insights.resource');
            Route::get('/material/{id}', App\Http\Livewire\Pages\Insights\MaterialInsight::class)->name('insights.material');
            Route::get('/log-opts', App\Http\Livewire\Pages\Insights\LogOpts::class)->name('insights.log-opts');
        });
        
        /*
        | Route returning deadlines in JSON format to be used in month calendar inside Production Orders Deadlines view
        */
        Route::prefix('json')->group(function() {
            Route::get('/deadlines', [DeadlinesController::class, 'index'])->name('json.deadlines');
        });
    });

    /*
    | Route returning User Accounts view
    */
    Route::prefix('user')->get('/uzivatelske-ucty', function () {
        return view('user-accounts');
    })->name('user.accounts');

});
