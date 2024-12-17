<?php

use Illuminate\Support\Facades\Route;
use Laravel\Horizon\Horizon;
use Laravel\Horizon\Http\Controllers\HomeController;
use Laravel\Horizon\Http\Controllers\DashboardStatsController;
use Laravel\Horizon\Http\Controllers\WorkloadController;
use Laravel\Horizon\Http\Controllers\MasterSupervisorController;
use Laravel\Horizon\Http\Controllers\MonitoringController;
use Laravel\Horizon\Http\Controllers\JobMetricsController;
use Laravel\Horizon\Http\Controllers\QueueMetricsController;
use Laravel\Horizon\Http\Controllers\BatchesController;
use Laravel\Horizon\Http\Controllers\PendingJobsController;
use Laravel\Horizon\Http\Controllers\CompletedJobsController;
use Laravel\Horizon\Http\Controllers\FailedJobsController;
use Laravel\Horizon\Http\Controllers\RetryController;
use Laravel\Horizon\Http\Controllers\JobsController;
use App\Jobs\TestJob;
use App\Jobs\SendEmailJob;


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
Route::get('/readme', function () {
    return view('readme');
});

// Register Horizon routes manually
Route::prefix('horizon')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('horizon.index');
    Route::get('/stats', [DashboardStatsController::class, 'index'])->name('horizon.stats.index');
    Route::get('/workload', [WorkloadController::class, 'index'])->name('horizon.workload.index');
    Route::get('/masters', [MasterSupervisorController::class, 'index'])->name('horizon.masters.index');
    Route::get('/monitoring', [MonitoringController::class, 'index'])->name('horizon.monitoring.index');
    Route::post('/monitoring', [MonitoringController::class, 'store'])->name('horizon.monitoring.store');
    Route::get('/monitoring/{tag}', [MonitoringController::class, 'paginate'])->name('horizon.monitoring-tag.paginate');
    Route::delete('/monitoring/{tag}', [MonitoringController::class, 'destroy'])->name('horizon.monitoring-tag.destroy');
    Route::get('/metrics/jobs', [JobMetricsController::class, 'index'])->name('horizon.jobs-metrics.index');
    Route::get('/metrics/jobs/{id}', [JobMetricsController::class, 'show'])->name('horizon.jobs-metrics.show');
    Route::get('/metrics/queues', [QueueMetricsController::class, 'index'])->name('horizon.queues-metrics.index');
    Route::get('/metrics/queues/{id}', [QueueMetricsController::class, 'show'])->name('horizon.queues-metrics.show');
    Route::get('/batches', [BatchesController::class, 'index'])->name('horizon.jobs-batches.index');
    Route::get('/batches/{id}', [BatchesController::class, 'show'])->name('horizon.jobs-batches.show');
    Route::post('/batches/retry/{id}', [BatchesController::class, 'retry'])->name('horizon.jobs-batches.retry');
    Route::get('/jobs/pending', [PendingJobsController::class, 'index'])->name('horizon.pending-jobs.index');
    Route::get('/jobs/completed', [CompletedJobsController::class, 'index'])->name('horizon.completed-jobs.index');
    Route::get('/jobs/failed', [FailedJobsController::class, 'index'])->name('horizon.failed-jobs.index');
    Route::get('/jobs/failed/{id}', [FailedJobsController::class, 'show'])->name('horizon.failed-jobs.show');
    Route::post('/jobs/retry/{id}', [RetryController::class, 'store'])->name('horizon.retry-jobs.show');
    Route::get('/jobs/{id}', [JobsController::class, 'show'])->name('horizon.jobs.show');
});

Route::get('/dispatch-job', function () {
    TestJob::dispatch();
    return 'Job dispatched!';
});

Route::get('/dispatch-email-job', function () {
    $email = 'josecortesdev@gmail.com';
    SendEmailJob::dispatch($email);
    return 'Email job dispatched!';
});