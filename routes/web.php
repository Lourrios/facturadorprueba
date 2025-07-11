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
use App\Http\Controllers\PagoController;


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
    Route::resource('roles', RolController::class);
    Route::resource('usuarios', UsuarioController::class);
    Route::resource('clientes', ClienteController::class);
    Route::resource('facturas', FacturaController::class);
    Route::get('/facturas/{id}/pdf', [FacturaController::class, 'generar_pdf'])->name('facturas.generar_pdf');
    Route::get('/facturas/{id}/enviar-pdf', [FacturaController::class, 'enviarPorCorreo'])->name('facturas.enviar-pdf');
    Route::get('pagos/create/{factura_id}/factura', [PagoController::class, 'create'])
        ->name('pagos.create.from.factura');
    Route::resource('pagos', PagoController::class);


});

