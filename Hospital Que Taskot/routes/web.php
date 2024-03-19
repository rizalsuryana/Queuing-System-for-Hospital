<?php

use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/tes', function () {
    return view('patient.registerDownload');
});



Auth::routes();
Route::get('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout']);
Route::get('/', [App\Http\Controllers\HomeController::class, 'patientDashboard'])->name('dashboard');

Route::middleware(['auth', 'role:pasien|adminRegister'])->group(function () {
    Route::controller(App\Http\Controllers\PoliController::class)->group(function () {
        Route::prefix('poli')->group(function () {             
            Route::get('/getPoliNote/{poliId}', 'getPoliNote')->name('poli.getPoliNote');      
        });
    });
//kuota
Route::get('/getQuota/{date}/{poli}', [\App\Http\Controllers\PatientQueueController::class, 'getQuota']);

Route::get('/poli/get-quota-info', [PoliController::class, 'getQuotaInfo']);

    Route::controller(App\Http\Controllers\PatientQueueController::class)->group(function () {
        Route::prefix('antrian')->group(function () {
            Route::post('/store', 'store')->name('patientQueue.store');
            Route::get('/download', 'downloadRegisterNumber')->name('patientQueue.downloadRegisterNumber');
            Route::post('/cek', 'checkQueue')->name('patientQueue.checkQueue');
            Route::get('/data/{nik}', 'getPatientQueue')->name('patientQueue.getPatientQueue');
            Route::get('/cek/semua', 'checkAllQueue')->name('patientQueue.checkAllQueue');
            
        });
    });
});

Route::middleware(['auth', 'role:admin|adminPoli|adminRegister'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::controller(App\Http\Controllers\PoliController::class)->group(function () {
        Route::prefix('poli')->group(function () {
            Route::get('/', 'index')->name('poli');
            Route::post('/store', 'store')->name('poli.store');
            Route::get('/detail/{id}', 'showDetail')->name('poli.showDetail');
            Route::post('/detail', 'save')->name('poli.save');
            Route::delete('/schedule', 'deleteSchedule')->name('poli.deleteSchedule');
            Route::post('/schedule', 'addSchedule')->name('poli.addSchedule');
            Route::get('/schedule', 'getSchedule')->name('poli.getSchedule');
            
        });
    });
    Route::controller(App\Http\Controllers\DoctorController::class)->group(function () {
        Route::prefix('doctor')->group(function () {
            Route::get('/', 'index')->name('doctor');
            Route::post('/store', 'store')->name('doctor.store');
            Route::get('/add', 'showAdd')->name('doctor.showAdd');
            Route::get('/data', 'showData')->name('doctor.showData');
            Route::get('/detail/{id}', 'showDetail')->name('doctor.showDetail');
            Route::post('/detail', 'save')->name('doctor.save');
            Route::delete('/delete', 'delete')->name('doctor.delete');
            Route::get('/schedule/data/{id}', 'getSchedule')->name('doctor.getSchedule');
            Route::post('/schedule', 'addSchedule')->name('doctor.addSchedule');
            Route::get('/poli-schedule/data/{id}', 'getPoliSchedule')->name('doctor.getPoliSchedule');
            Route::delete('/schedule', 'deleteSchedule')->name('doctor.deleteSchedule');
            
        });
    });

    Route::controller(App\Http\Controllers\PatientController::class)->group(function () {
        Route::prefix('patient')->group(function () {
            Route::get('/', 'index')->name('patient');
            Route::get('/add', 'showAdd')->name('patient.showAdd');
            Route::post('/store', 'store')->name('patient.store');
            Route::get('/detail/{id}', 'showDetail')->name('patient.showDetail');
            Route::get('/data', 'showData')->name('patient.showData');
            Route::get('/print', 'showPrint')->name('patient.showPrint');
            Route::post('/detail', 'save')->name('patient.save');
            Route::delete('/data', 'deleteData')->name('patient.deleteData');
            Route::get('/downloadRegisterPatient', 'downloadRegisterPatient')->name('patient.downloadRegisterPatient');
        });
    });

    Route::controller(App\Http\Controllers\PatientQueueController::class)->group(function () {
        Route::prefix('patient_queue')->group(function () {
            Route::get('/', 'index')->name('patientQueue');
            Route::get('/add', 'showAdd')->name('patientQueue.showAdd');
            //Route::post('/store', 'store')->name('patientQueue.store');
            Route::get('/detail/{id}', 'showDetail')->name('patientQueue.showDetail');
            Route::get('/data', 'showData')->name('patientQueue.showData');            
            Route::post('/changeQuota', 'changeQuota')->name('patientQueue.changeQuota');       
            Route::post('/changeStatus', 'changeStatus')->name('patientQueue.changeStatus');
            Route::get('/cancelOne','cancelOne')->name('patientQueue.cancelOne');
            Route::get('/cancel','cancel')->name('patientQueue.cancel');
        });
    });

    // Route::get('/patientQueue', [App\Http\Controllers\PatientQueueController::class, 'index'])->name('patientQueue');
});
// Memisah dua admin
//route web admin controller
Route::middleware(['auth', 'role:adminRegister|pasien'])->group(function () {
    Route::get('/adminRegisterDashboard',[App\Http\Controllers\AdminRegist::class,'index'])->name('adminRegisterDashboard');
    Route::controller(App\Http\Controllers\AdminRegist::class)->group(function(){
        Route::prefix('daftarOffline')->group(function(){
            Route::get('/', 'index')->name('daftarOffline');
            Route::get('/cek', 'cekIndex')->name('cekDaftar');
            Route::get('/daftarAntrian', 'daftarAntrian')->name('daftarAntrian');
            Route::get('/antrian','antrianShowData')->name('antrian.ShowData');
            Route::delete('/antrian', 'deleteAntrian')->name('antrian.deleteData');
            Route::get('/antrian/{id}', 'editAntrian')->name('edit.antrian');
            Route::post('/antrian', 'save')->name('antrian.savee');
        });
    });
    Route::controller(App\Http\Controllers\AdminRegist::class)->group(function () {
        Route::prefix('daftar')->group(function () {
            Route::post('/store', 'store')->name('adminRegister.store');
            Route::get('/download', 'downloadRegisterNumber')->name('adminRegister.downloadRegisterNumber');
            Route::post('/cek', 'checkQueue')->name('adminRegister.checkQueue');
            Route::get('/data/{nik}', 'getadminRegister')->name('adminRegister.getadminRegister');
            Route::get('/cek/semua', 'checkAllQueue')->name('patientQueue.checkAllQueue');
            
        });
    });

});

Route::middleware(['auth', 'role:adminPoli|admin'])->group(function () {
    Route::get('/adminPoliDashboard',[App\Http\Controllers\AdminPoli::class,'index'])->name('adminPoliDashboard');
    Route::controller(App\Http\Controllers\AdminPoli::class)->group(function(){
        Route::prefix('adminPoli')->group(function(){
            Route::get('/', 'index')->name('adminPoli');
            Route::get('/export/pdf','exportPDF')->name('exportDetail.pdf');
            Route::get('/exportHariIni/pdf','exportHariIniPDF')->name('exportHariIni.pdf');
        });
    });
    Route::post('/adminPoli/register',[App\Http\Controllers\PoliController::class, 'adminPoliRegister'])->name('adminPoli.Register');
    Route::get('/adminPoliRegister',[App\Http\Controllers\PoliController::class, 'adminPoliRegisterPage'])->name('adminPoli.Register.Page');
    Route::get('/adminPoliRegister/showData',[App\Http\Controllers\PoliController::class, 'adminPoliRegisterShowData'])->name('adminPoli.Register.ShowData');
    Route::delete('/poli/detail/{id}',[App\Http\Controllers\PoliController::class, 'destroy'])->name('adminPoli.destroy');
    Route::get('/adminPoli/edit/{id}', [App\Http\Controllers\PoliController::class,'edit'])->name('adminPoli.Edit');
    Route::post('/adminPoli/update/{id}', [App\Http\Controllers\PoliController::class,'update'])->name('adminPoli.Update');
    Route::delete('/adminPoli/delete/{id}',[App\Http\Controllers\PoliController::class,'delete'])->name('adminPoli.Delete');
    Route::get('/adminPoliSearch', 'PoliController@search')->name('adminPoli.search');

});

// route
// Route::get('/', function () {
//     if (Auth::check()) {
//         if (Auth::user()->hasRole('adminRegister')) {
//             return redirect()->route('adminRegisterDashboard');
//         } elseif (Auth::user()->hasRole('adminPoli')) {
//             return redirect()->route('adminPoliDashboard');
//         } elseif (Auth::user()->hasRole('pasien')) {
//             return redirect()->route('dashboard');
//         } else {
//             // Handle other roles or unauthorized access
//             abort(403, 'Unauthorized action.');
//         }
//     } else {
//         return redirect()->route('login');
//     }
// });