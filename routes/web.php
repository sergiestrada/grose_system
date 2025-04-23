<?php

use App\Http\Controllers\Pdfcontroller;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Home\HomeComponent;
use App\Http\Livewire\Usuarios\UsuariosComponent;
use App\Http\Livewire\Medicion\MedicionComponent;
use App\Http\Livewire\Responsables\ResponsablesComponent;
use App\Http\Livewire\Vehiculos\VehiculosComponent;
use App\Http\Livewire\Vehiculospresados\VehiculosPesadosComponent;
use App\Http\Livewire\Maquinariamenor\MaquinariaMenorComponent;
use App\Http\Livewire\Proveedores\ProveedoresComponent;
use App\Http\Livewire\Herramientas\HerramientasComponent;
use App\Http\Livewire\Herramientasmedicion\HerramientasMedicionComponent;
use App\Http\Livewire\Formato\FormatoComponent;
use App\Http\Livewire\Tallerinterno\TallerInternoComponent;
use App\Http\Livewire\Tallerexterno\TallerExternoComponent;
use App\Http\Livewire\Datosformatos\DatosFormatosComponent;
use App\Http\Livewire\Prestamosherramientas\PresamosHerramientasComponent;
use App\Http\Livewire\Impresionprestamo\ImpresionPresamoComponent;
use App\Http\Livewire\Listadoherramientas\ListadoHerramientasComponent;
use App\Http\Livewire\Bitacoramedicion\BitacoraMedicionComponent;
use App\Http\Livewire\Bitacoravehiculos\BitacoraVehiculosComponent;
use App\Http\Livewire\Bitacoravehiculospesados\BitacoraVehiculospesadosComponent;
use App\Http\Livewire\Bitacoramaquinaria\BitacoraMaquinariaComponent;
use App\Http\Livewire\Bitacoraherramientas\BitacoraHerramientasComponent;
use App\Http\Livewire\Responsivasmedicion\ResponsivasMedicionComponent;
use App\Http\Livewire\Herramientasmediciondanada\HerramientasMedicionDanadanComponent;
use App\Http\Livewire\Generarresponsivamedicion\GenerarResponsivaMedicionComponent;
use App\Http\Livewire\Reporte\ReporteComponent;
use App\Http\Livewire\Reportevehiculo\ReporteVhiculoComponent;
use App\Http\Livewire\Empleadorep\EmpeladoRepComponent;
use App\Http\Livewire\Herraminetasrep\HerramientasRepComponent;
use App\Http\Livewire\Prestamomaquinaria\PrestamoMaquinariaComponent;
use App\Http\Livewire\Reportesvehiculos\ReporteVehiculopesadosComponent;
use App\Http\Livewire\Settings\SettingsComponent;


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
    return view('auth.login');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/home', HomeComponent::class);

    Route::get('/admin/settings', SettingsComponent::class);


    Route::get('/prestamos_herramientas',PresamosHerramientasComponent::class);
    Route::get('/prestamos_maquinaria',PrestamoMaquinariaComponent::class);

    Route::get('/prestamos_herramientas/impresion/{id}',ImpresionPresamoComponent::class);
    Route::get('/bouche/{id}',[Pdfcontroller::class,'bouche'])->name('bouche');
    Route::get('/responsiva_pdf/{rep}/{id}',[Pdfcontroller::class,'responsiva_pdf'])->name('responsiva_pdf');
    Route::get('/prestamos_herramienta/listado/{id}',ListadoHerramientasComponent::class);

    Route::get('/prestamos_maquinaria/bouche/{id}',[Pdfcontroller::class,'bouche_maquinaria'])->name('bouche_maquinaria');

    Route::get('/responsivas_medicion', ResponsivasMedicionComponent::class);
    Route::get('/responsivas_medicion/generar',GenerarResponsivaMedicionComponent::class);
    Route::get('/herramientas_medicion_danada', HerramientasMedicionDanadanComponent::class);

    Route::get('/reportes', ReporteComponent::class);
    Route::get('/rep_emp', EmpeladoRepComponent::class);
    Route::get('/rep_herramientas', HerramientasRepComponent::class);



    /* BITACORAS */
    Route::get('/bitacora_medicion',BitacoraMedicionComponent::class);
    Route::get('/bitacora_vehiculos',BitacoraVehiculosComponent::class);
    Route::get('/bitacora_vehiculos/reporte/{id}/{tipo}/{numint}',ReporteVhiculoComponent::class);
    
    Route::get('/bitacora_vehiculos_pesados',BitacoraVehiculospesadosComponent::class);
    Route::get('/bitacora_vehiculos_pesados/reporte/{id}/{tipo}/{numint}',ReporteVehiculopesadosComponent::class);

    Route::get('/bitacora_maquinaria',BitacoraMaquinariaComponent::class);
    Route::get('/bitacora_herramientas',BitacoraHerramientasComponent::class);

    /*   Catalogos  */
   
    Route::get('/usuarios', UsuariosComponent::class);
    Route::get('/categoria_medicion', MedicionComponent::class);
    Route::get('/responsables', ResponsablesComponent::class);
    Route::get('/vehiculos_catalogo', VehiculosComponent::class);
    Route::get('/vehiculospesados_catalogo', VehiculosPesadosComponent::class);
    Route::get('/maquinariamenor_catalogo', MaquinariaMenorComponent::class);
    Route::get('/proveedores', ProveedoresComponent::class);
    Route::get('/herramientas_catalogo', HerramientasComponent::class);
    Route::get('/herramientasmedicion_catalogo', HerramientasMedicionComponent::class);
    Route::get('/formatos', FormatoComponent::class);
    Route::get('/taller_interno', TallerInternoComponent::class);
    Route::get('/taller_externo', TallerExternoComponent::class);
    Route::get('/formatos/datos_formatos/{id}', DatosFormatosComponent::class);
});
