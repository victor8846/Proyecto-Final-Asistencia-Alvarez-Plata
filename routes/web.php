<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    ProfileController,
    AsistenciaController,
    ReporteController,
    EstudianteController,
    DocenteController,
    AsignacionDocenteController,
    DashboardController,
    CursoController,
    CarreraController,
    AulaController,
    MateriaController,
    HorarioController,
    UsuarioController
};

// Ruta raíz → si está logueado va al dashboard, si no al login
Route::get('/', function () {
    return redirect()->route('login');
});
//
Auth::routes(['verify' => true]);

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

// Rutas autenticadas
Route::middleware(['auth', 'password.change'])->group(function () {

    // Perfil de usuario
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Recursos principales
    Route::resources([
        'estudiantes' => EstudianteController::class,
        'docentes' => DocenteController::class,
        'cursos' => CursoController::class,
        'carreras' => CarreraController::class,
        'materias' => MateriaController::class,
        'aulas' => AulaController::class,
        'asistencias' => AsistenciaController::class,
        'asignacion-docentes' => AsignacionDocenteController::class,
        'horarios' => HorarioController::class,
    ]);

    // Estudiantes: materias asignadas
    Route::get('/estudiantes/{id}/materias', [EstudianteController::class, 'verMateriasAsignadas'])
        ->name('estudiantes.materias');

    // Materias por carrera
    Route::get('materias/por-carrera/{carrera_id}', [MateriaController::class, 'porCarrera'])
        ->name('materias.porCarrera');

    // Cursos por carrera
    Route::get('/cursos/por-carrera/{id}', [CursoController::class, 'porCarrera'])
        ->name('cursos.porCarrera');

    // Horarios personalizados
    Route::get('/horarios/seleccionar', [HorarioController::class, 'formSeleccion'])
        ->name('horarios.seleccionar');
    Route::get('/horario/{carrera}/{curso}', [HorarioController::class, 'verHorarioPorCurso'])
        ->name('horarios.ver');
    Route::get('/horario/{carrera}/{curso}/pdf', [HorarioController::class, 'exportarPDF'])
        ->name('horarios.exportar.pdf');
    Route::get('/horario/{carrera}/{curso}/excel', [HorarioController::class, 'exportarExcel'])
        ->name('horarios.exportar.excel');

    // Exportar materias
    Route::get('materias/exportar/pdf', [MateriaController::class, 'exportarPDF'])
        ->name('materias.exportar.pdf');
    Route::get('materias/exportar/excel', [MateriaController::class, 'exportarExcel'])
        ->name('materias.exportar.excel');

    // Reportes
    Route::get('/reportes', [ReporteController::class, 'index'])
        ->name('reportes.index');
    Route::get('/reportes/estudiantes-por-carrera', [ReporteController::class, 'resumenPorCarrera'])
        ->name('reportes.estudiantes_por_carrera');
});

// Solo para usuarios con rol admin → gestión de usuarios
Route::middleware(['auth', 'password.change', 'role:admin'])->group(function () {
  Route::resource('usuarios', UsuarioController::class);
});

// Rutas de cambio de contraseña
Route::middleware('auth')->group(function () {
    Route::get('/change-password', [App\Http\Controllers\PasswordChangeController::class, 'showChangeForm'])->name('password.change');
    Route::post('/change-password', [App\Http\Controllers\PasswordChangeController::class, 'change']);
});

// Rutas de autenticación
require __DIR__.'/auth.php';
