<?php

use App\Http\Controllers\CampusController;
use App\Http\Controllers\IdCardTemplateController;
use App\Http\Controllers\PrintController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\SchoolClassController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public registration
|--------------------------------------------------------------------------
*/
Route::get('/registration', [RegistrationController::class, 'form'])->name('registration');
Route::post('/registration', [RegistrationController::class, 'submit'])->name('user.registration');
Route::get('/get-students-by-class/{class_id}/{campus}', [RegistrationController::class, 'studentsByClass']);

/*
|--------------------------------------------------------------------------
| Authenticated app
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::get('/', fn () => view('dashboard'))->name('dashboard');

    Route::get('/storage-link', function () {
        Artisan::call('storage:link');

        return response()->json(['message' => 'Storage link created successfully!']);
    });

    // Students
    Route::get('students', [StudentController::class, 'index'])->name('students.index');
    Route::get('students/create', [StudentController::class, 'create'])->name('students.create');
    Route::post('students', [StudentController::class, 'store'])->name('students.store');
    Route::get('students/{id}/edit', [StudentController::class, 'edit'])->name('students.edit');
    Route::put('students/{id}', [StudentController::class, 'update'])->name('students.update');
    Route::delete('students/{id}', [StudentController::class, 'destroy'])->name('students.destroy');
    Route::get('students/{id}', [StudentController::class, 'show'])->name('students.show');
    Route::post('students/import', [StudentController::class, 'import'])->name('students.import');

    // Registrations (admin)
    Route::get('registrations', [RegistrationController::class, 'index'])->name('registrations.index');
    Route::delete('registrations/{id}', [RegistrationController::class, 'reset'])->name('registrations.reset');

    // Print ID cards
    Route::get('print', [PrintController::class, 'index'])->name('print.index');
    Route::post('print', [PrintController::class, 'print'])->name('print.cards');
    Route::get('print/{student}/{type}', [PrintController::class, 'single'])
        ->whereIn('type', ['student', 'parent'])
        ->name('print.single');

    // ID card templates
    Route::get('templates', [IdCardTemplateController::class, 'index'])->name('templates.index');
    Route::get('templates/create', [IdCardTemplateController::class, 'create'])->name('templates.create');
    Route::post('templates', [IdCardTemplateController::class, 'store'])->name('templates.store');
    Route::get('templates/{id}/edit', [IdCardTemplateController::class, 'edit'])->name('templates.edit');
    Route::put('templates/{id}', [IdCardTemplateController::class, 'update'])->name('templates.update');
    Route::delete('templates/{id}', [IdCardTemplateController::class, 'destroy'])->name('templates.destroy');
    Route::post('templates/{id}/default', [IdCardTemplateController::class, 'setDefault'])->name('templates.default');
    Route::get('templates/{id}/preview', [IdCardTemplateController::class, 'preview'])->name('templates.preview');

    // Campuses
    Route::get('campuses', [CampusController::class, 'index'])->name('campuses.index');
    Route::get('campuses/create', [CampusController::class, 'create'])->name('campuses.create');
    Route::post('campuses', [CampusController::class, 'store'])->name('campuses.store');
    Route::get('campuses/{id}/edit', [CampusController::class, 'edit'])->name('campuses.edit');
    Route::put('campuses/{id}', [CampusController::class, 'update'])->name('campuses.update');
    Route::get('campuses/{id}', [CampusController::class, 'destroy'])->name('campuses.destroy');

    // Classes
    Route::get('classes', [SchoolClassController::class, 'index'])->name('classes.index');
    Route::get('classes/create', [SchoolClassController::class, 'create'])->name('classes.create');
    Route::post('classes', [SchoolClassController::class, 'store'])->name('classes.store');
    Route::get('classes/{id}/edit', [SchoolClassController::class, 'edit'])->name('classes.edit');
    Route::put('classes/{id}', [SchoolClassController::class, 'update'])->name('classes.update');
    Route::get('classes/{id}', [SchoolClassController::class, 'destroy'])->name('classes.destroy');
});

require __DIR__ . '/auth.php';
