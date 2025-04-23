<?php

namespace App\Http\Livewire\Impresionprestamo;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Responsables;
use App\Models\Herramientas;
use App\Models\Historial_responsivas;
use App\Models\Prestamos;

class ImpresionPresamoComponent extends Component
{
    public $idx;
    public $componentName;
    public $pageTitle;
    public $herramientas;
    public $responsables;
    public $prestamo;
    public $dataToPrint;
    public $tabla;
    public $user;
    public $rol;

    public function mount($id)
    {
        $this->idx = $id;
        $this->user = Auth::user()->name;
        $this->componentName = 'Prestamos herramientas';
        $this->pageTitle     = 'Impresion';
        $this->prestamo = Historial_responsivas::find($id);
        $this->tabla = Prestamos::where('codigo','=',$this->prestamo->codigo)->get();
        $this->rol = Auth::user()->rol;
    }
   
   public function herramientas($id){
            $dato = Herramientas::find($id);
            return $dato->Herramienta;
   }
   public function suma($id){
    $totalCantidad = Prestamos::where('codigo', $this->prestamo->codigo)
    ->where('herr', $id)
    ->sum('cantidad');
    return  $totalCantidad;
   }
    public function render()
    {
        return view('livewire.impresionprestamo.impresion-presamo-component')->extends('adminlte::page')->section('content');
    }

    public function responsable($id)
    {
        $dato = '';
        $nombre = '';
     if($id != null){
        $dato = Responsables::find($id);
        $nombre = $dato->Nombre.' '.$dato->Apellido_P.' '.$dato->Apellido_M;
     }else{
        $nombre = '';
     }   
    return $nombre;
    }
    
    public function datos_responsable($id)
    {
        $dato = Responsables::find($id);
        return $dato->Cargo;
    }
}
