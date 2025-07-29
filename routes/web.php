<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ClienteController;
use App\Models\Cliente;
use App\Http\Controllers\FacturaController;
use App\Http\Controllers\NotaController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\ReporteController;


Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Auth::routes();

Route::get('pagina', function(){
    return view('pagina');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware'=>['auth']],function(){
    Route::get('/facturas/facturacion-mensual', [FacturaController::class, 'facturacionMensual'])
        ->name('facturas.facturacion-mensual');
    Route::post('/facturas/{id}/dar-baja-mensualidad', [FacturaController::class, 'darBajaMensualidad'])
        ->name('facturas.dar-baja-mensualidad');
    Route::get('/facturas/recurrentes/{cliente_id}/{detalle}', [FacturaController::class, 'verFacturasRecurrentes'])
        ->name('facturas.recurrentes');


    Route::resource('roles', RolController::class);
    Route::resource('usuarios', UsuarioController::class);
    Route::resource('clientes', ClienteController::class);
    Route::resource('facturas', FacturaController::class);
    Route::get('/facturas/{id}/pdf', [FacturaController::class, 'generar_pdf'])->name('facturas.generar_pdf');
    Route::get('/facturas/{id}/enviar-pdf', [FacturaController::class, 'enviarPorCorreo'])->name('facturas.enviar-pdf');
    Route::get('pagos/create/{factura_id}/factura', [PagoController::class, 'create'])
        ->name('pagos.create.from.factura');
    Route::resource('pagos', PagoController::class);
    //Route::get('/notas/crear', [NotaController::class, 'formCreate'])->name('notas.create');
    Route::post('/notas',[NotaController::class, 'store'])->name('notas.store');
    Route::get('notas/index', [NotaController::class, 'index'])->name('notas.index');
    Route::get('/notas/crearNotaCredito/{factura}', [NotaController::class, 'formCredito'])->name('notas.create.credito');
    Route::get('/notas/crearNotaDebito/{factura}', [NotaController::class, 'formDebito'])->name('notas.create.debito');
    Route::get('/notas/{nota}', [NotaController::class, 'show'])->name('notas.show');
    Route::get('/notas/pdf/{nota}', [NotaController::class, 'generatePdf'])->name('notas.pdf');
    Route::get('reportes/index', [ReporteController::class,'index'])->name('reportes.index');
    Route::get('reportes/exportar', [ReporteController::class,'exportarExcel'])->name('reportes.exportarExcel');
    Route::get('reportes/mensual/exportar', [ReporteController::class, 'exportarReporteMensual'])->name('reportes.mensual.exportar');
    Route::get('reportes/mensual', [ReporteController::class, 'reporteMensual'])->name('reportes.mensual');


});

