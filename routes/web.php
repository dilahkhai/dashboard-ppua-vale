<?php

use App\Http\Controllers\ExportController;
use App\Http\Controllers\FMDSController;
use App\Http\Controllers\InitialDetailController;
use App\Http\Controllers\KeyPerformanceIndexController;
use App\Http\Controllers\ManPowerController;
use App\Http\Controllers\OvertimeHourController;
use App\Http\Controllers\SharingController;
use App\Http\Controllers\SimperController;
use App\Http\Controllers\StudyController;
use App\Http\Controllers\SubTrainingController;
use App\Http\Controllers\TrainingStatusController;
use App\Http\Controllers\UpdatePasswordController;
use App\Http\Controllers\WFHRoosterInitialDetailController;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
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

Route::get('/signin', function () {
    return view('welcome');
})->name("signin");
Route::get('/', [App\Http\Controllers\LandingPageImageController::class, 'landing']);

Auth::routes();

Route::middleware([
    "auth"
])->group(function () {
    Route::get("logout-user", [App\Http\Controllers\crudusercontroller::class, 'logout']);
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/import-excel', [App\Http\Controllers\ImportController::class, 'index']);
    Route::post('/import-excel', [App\Http\Controllers\ImportController::class, 'import']);
    Route::get('/export-excel', [ExportController::class, 'index']);
    Route::post('/export-excel', [ExportController::class, 'export']);
    Route::get('/fmds', [FMDSController::class, 'index'])->name('fmds.index');
    Route::post('/fmds-download', [FMDSController::class, 'download'])->name('fmds.download');
    Route::post('/fmds-upload', [FMDSController::class, 'upload'])->name('fmds.upload');

    Route::get('/update-password', [UpdatePasswordController::class, 'index']);
    Route::post('/update-password', [UpdatePasswordController::class, 'update']);

    Route::get('/dashboardfurconv', [App\Http\Controllers\dashboardfurconvcontroller::class, 'index']);
    Route::get('/dashboarddryerkiln', [App\Http\Controllers\dashboarddryerkilncontroller::class, 'index']);
    Route::get('/dashboardinfra', [App\Http\Controllers\dashboardinfracontroller::class, 'index']);
    Route::get('/dashboardutl', [App\Http\Controllers\dashboardutlcontroller::class, 'index']);

    Route::get('/cruduser', [App\Http\Controllers\crudusercontroller::class, 'index']);
    Route::post('/updateuser/{id}', [App\Http\Controllers\crudusercontroller::class, 'update']);
    Route::post('/resetpassword/{id}', [App\Http\Controllers\crudusercontroller::class, 'resetPassword']);
    Route::get('/edituser/{id}', [App\Http\Controllers\crudusercontroller::class, 'edit']);
    Route::post('/simpanuser', [App\Http\Controllers\crudusercontroller::class, 'store']);
    Route::get('/tambahuser', [App\Http\Controllers\crudusercontroller::class, 'create']);
    Route::delete('/deleteuser/{id}', [App\Http\Controllers\crudusercontroller::class, 'destroy']);

    Route::get('/inputfurconv', [App\Http\Controllers\inputfurconvcontroller::class, 'index']);
    Route::post('/inputfurconv', [App\Http\Controllers\inputfurconvcontroller::class, 'store']);
    Route::post('/inputfurconvProductivity', [App\Http\Controllers\inputfurconvcontroller::class, 'storeProductivity']);
    Route::post('/inputfurconvWorkingWeek', [App\Http\Controllers\inputfurconvcontroller::class, 'storeWorkingWeek']);
    Route::post('/inputfurconvStatusPerDay', [App\Http\Controllers\inputfurconvcontroller::class, 'storeStatusPerDay']);
    Route::post('/inputfurconvOrganization', [App\Http\Controllers\inputfurconvcontroller::class, 'storeOrganization']);
    Route::post('/inputfurconvKaizen', [App\Http\Controllers\inputfurconvcontroller::class, 'storeKaizen']);
    Route::post('/inputfurconvMcu', [App\Http\Controllers\inputfurconvcontroller::class, 'storeMcu']);
    Route::post('/inputfurconvTask', [App\Http\Controllers\inputfurconvcontroller::class, 'storeTask']);
    Route::post('/updatefurconvTask', [App\Http\Controllers\inputfurconvcontroller::class, 'updateTask']);

    Route::get('/inputdryerkiln', [App\Http\Controllers\inputdryerkilncontroller::class, 'index']);
    Route::post('/inputdryerkilnProductivity', [App\Http\Controllers\inputdryerkilncontroller::class, 'storeProductivity']);
    Route::post('/inputdryerkilnOrganization', [App\Http\Controllers\inputdryerkilncontroller::class, 'storeOrganization']);
    Route::post('/inputdryerkilnKaizen', [App\Http\Controllers\inputdryerkilncontroller::class, 'storeKaizen']);
    Route::post('/inputdryerMcu', [App\Http\Controllers\inputdryerkilncontroller::class, 'storeMcu']);
    Route::post('/inputdryerTask', [App\Http\Controllers\inputdryerkilncontroller::class, 'storeTask']);
    Route::post('/updatedryerTask', [App\Http\Controllers\inputdryerkilncontroller::class, 'updateTask']);
    Route::get('/task/{id}/delete', [App\Http\Controllers\inputdryerkilncontroller::class, 'deleteTask']);

    Route::get('/inputinfra', [App\Http\Controllers\inputinfracontroller::class, 'index']);
    Route::post('/inputinfraProductivity', [App\Http\Controllers\inputinfracontroller::class, 'storeProductivity']);
    Route::post('/inputinfraOrganization', [App\Http\Controllers\inputinfracontroller::class, 'storeOrganization']);
    Route::post('/inputinfraKaizen', [App\Http\Controllers\inputinfracontroller::class, 'storeKaizen']);
    Route::post('/inputinfraMcu', [App\Http\Controllers\inputinfracontroller::class, 'storeMcu']);
    Route::post('/inputinfraTask', [App\Http\Controllers\inputinfracontroller::class, 'storeTask']);
    Route::post('/updateinfraTask', [App\Http\Controllers\inputinfracontroller::class, 'updateTask']);

    Route::get('/inpututl', [App\Http\Controllers\inpututlcontroller::class, 'index']);
    Route::post('/inpututlProductivity', [App\Http\Controllers\inpututlcontroller::class, 'storeProductivity']);
    Route::post('/inpututlOrganization', [App\Http\Controllers\inpututlcontroller::class, 'storeOrganization']);
    Route::post('/inpututlKaizen', [App\Http\Controllers\inpututlcontroller::class, 'storeKaizen']);
    Route::post('/inpututlMcu', [App\Http\Controllers\inpututlcontroller::class, 'storeMcu']);
    Route::post('/inpututlTask', [App\Http\Controllers\inpututlcontroller::class, 'storeTask']);
    Route::post('/updateutlTask', [App\Http\Controllers\inpututlcontroller::class, 'updateTask']);

    Route::get('/oncall', [App\Http\Controllers\oncallcontroller::class, 'index'])->name('oncall.index');
    Route::post('/oncall', [App\Http\Controllers\oncallcontroller::class, 'store']);
    Route::patch('/oncall/{oncall}', [App\Http\Controllers\oncallcontroller::class, 'update'])->name('oncall.update');
    Route::get('/oncall-source', [App\Http\Controllers\oncallcontroller::class, 'source']);
    Route::post('/oncallfile/{oncall}', [App\Http\Controllers\oncallcontroller::class, 'upload'])->name('oncall.upload');
    Route::get('/oncall-detail', [App\Http\Controllers\oncallcontroller::class, 'show']);
    Route::delete('/oncall-delete/{oncall}', [App\Http\Controllers\oncallcontroller::class, 'destroy'])->name('oncall.destroy');

    Route::post('/initial-detail', [InitialDetailController::class, 'store']);
    Route::delete('/initial-detail/{initialDetail}', [InitialDetailController::class, 'destroy']);

    Route::get('/knowledge', [App\Http\Controllers\knowledgecontroller::class, 'index']);
    Route::post('/sharingknowledge', [App\Http\Controllers\knowledgecontroller::class, 'upload']);

    Route::post("/importData", [App\Http\Controllers\inputdryerkilncontroller::class, 'import']);

    Route::get('/wfhrooster', [App\Http\Controllers\WfhRoosterController::class, 'index']);
    Route::post('/wfhrooster', [App\Http\Controllers\WfhRoosterController::class, 'store']);
    Route::get('/wfhrooster-source', [App\Http\Controllers\WfhRoosterController::class, 'source']);

    Route::resource('overtime-hour', OvertimeHourController::class);
    Route::post('overtime-hour-export', [OvertimeHourController::class, 'export']);

    Route::post('/wfh-initial-detail', [WFHRoosterInitialDetailController::class, 'store']);
    Route::delete('/wfh-initial-detail/{initialDetail}', [WFHRoosterInitialDetailController::class, 'destroy']);

    Route::get('/mod', [App\Http\Controllers\ModController::class, 'index']);
    Route::post('/mod', [App\Http\Controllers\ModController::class, 'upload']);


    Route::get('/image-landing', [App\Http\Controllers\LandingPageImageController::class, 'index']);
    Route::post('/image-landing', [App\Http\Controllers\LandingPageImageController::class, 'upload']);


    Route::get('/mcu', [App\Http\Controllers\mcucontroller::class, 'index']);
    Route::get('/tambahmcu', [App\Http\Controllers\mcucontroller::class, 'create']);
    Route::post('/updatemcu/{id}', [App\Http\Controllers\mcucontroller::class, 'update']);
    Route::get('/editmcu/{id}', [App\Http\Controllers\mcucontroller::class, 'edit']);
    Route::get('/donemcu/{id}', [App\Http\Controllers\mcucontroller::class, 'done']);
    Route::get('/undonemcu/{id}', [App\Http\Controllers\mcucontroller::class, 'undone']);
    Route::post('/simpanmcu', [App\Http\Controllers\mcucontroller::class, 'store']);
    Route::delete('/deletemcu/{id}', [App\Http\Controllers\mcucontroller::class, 'destroy']);


    Route::get("tasks", [App\Http\Controllers\TaskController::class, 'index']);
    Route::get("manage-tasks", [App\Http\Controllers\TaskController::class, 'manageTask']);
    Route::post('/inputMainTask', [App\Http\Controllers\TaskController::class, 'storeTask']);
    Route::post('/updateMainTask', [App\Http\Controllers\TaskController::class, 'updateTask']);

    Route::resource('training-status', TrainingStatusController::class);
    Route::resource('sub-training', SubTrainingController::class);

    Route::patch('/training-status/sub-training/{subTraining}', [SubTrainingController::class, 'update'])->name('sub-training.update');
    Route::delete('/training-status/sub-training/{subTraining}', [SubTrainingController::class, 'destroy'])->name('sub-training.destroy');
    Route::get('/training-status/{trainingStatus}/sub-training', [SubTrainingController::class, 'index'])->name('sub-training.index');
    Route::get('/training-status/{trainingStatus}/sub-training/create', [SubTrainingController::class, 'create'])->name('sub-training.create');
    Route::post('/training-status/{trainingStatus}/sub-training', [SubTrainingController::class, 'store'])->name('sub-training.store');
    Route::get('/training-status/{trainingStatus}/sub-training/{subTraining}/edit', [SubTrainingController::class, 'edit'])->name('sub-training.edit');

    Route::resource('man-power', ManPowerController::class);
    Route::get('/man-power-history', [ManPowerController::class, 'history'])->name('man-power.history');

    Route::get('/key-performance-index', [KeyPerformanceIndexController::class, 'home'])->name('key-performance-index.home');
    Route::get('/key-performance-index/{area}', [KeyPerformanceIndexController::class, 'index'])->name('key-performance-index.index');
    Route::get('/key-performance-index/{area}/create', [KeyPerformanceIndexController::class, 'create'])->name('key-performance-index.create');
    Route::post('/key-performance-index/{area}/store', [KeyPerformanceIndexController::class, 'store'])->name('key-performance-index.store');
    Route::get('/key-performance-index/{keyPerformanceIndex}/edit', [KeyPerformanceIndexController::class, 'edit'])->name('key-performance-index.edit');
    Route::get('key-performance-index/{keyPerformanceIndex}/input', [KeyPerformanceIndexController::class, 'input'])->name('key-performance-index.input');
    Route::post('key-performance-index/{keyPerformanceIndex}/input', [KeyPerformanceIndexController::class, 'storeInput'])->name('key-performance-index.storeInput');
    Route::patch('key-performance-index/{keyPerformanceIndex}/update', [KeyPerformanceIndexController::class, 'update'])->name('key-performance-index.update');
    Route::delete('key-performance-index/{keyPerformanceIndex}/destroy', [KeyPerformanceIndexController::class, 'destroy'])->name('key-performance-index.destroy');

    Route::resource('simper', SimperController::class);

    Route::get('/sharing-schedule', [SharingController::class, 'index'])->name('sharing-schedule.index');
    Route::post('/sharing-schedule', [SharingController::class, 'store'])->name('sharing-schedule.store');
    Route::post('/sharing-schedule-file', [SharingController::class, 'storeFile'])->name('sharing-schedule.store-file');
    Route::get('/sharing-schedule-source', [SharingController::class, 'source'])->name('sharing-schedule.source');
    Route::get('/sharing-schedule-source-detail', [SharingController::class, 'sourceDetail'])->name('sharing-schedule.source-detail');
    Route::delete('/destroy-sharing-schedule/{sharing}', [SharingController::class, 'destroy'])->name('sharing-schedule.destroy');

    Route::get('/study-schedule', [StudyController::class, 'index'])->name('study-schedule.index');
    Route::post('/study-schedule', [StudyController::class, 'store'])->name('study-schedule.store');
    Route::post('/study-schedule-update', [StudyController::class, 'update'])->name('study-schedule.update');
    Route::get('/study-schedule-source', [StudyController::class, 'source'])->name('study-schedule.source');
    Route::get('/study-schedule-source-detail', [StudyController::class, 'sourceDetail'])->name('study-schedule.source-detail');

    Route::get('/menuarea', [App\Http\Controllers\menuareacontroller::class, 'index']);

    Route::get('/read-notif', function () {
        Notification::query()
            ->where('receiver_id', auth()->user()?->id)
            ->latest()
            ->get()
            ->each(function ($notification) {
                $notification->update([
                    'is_read' => 1
                ]);
            });

        return response()->json(['success' => true]);
    });
});
