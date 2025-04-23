<?php

namespace App\Http\Livewire\Reportevehiculo;

use Livewire\Component;
use App\Models\Historialmantvehiculos;
use Illuminate\Support\Facades\Auth;
use App\Models\Factura;


class ReporteVhiculoComponent extends Component
{
    public $componentName;
    public $idx;
    public $pageTitle;
    public $tipo;
    public $numint;
    public $tabla = [];
    public $facturas = [];
    public $rol;

   
    public function mount($id,$tipo,$numint)
    {   
        $this->idx = $id;
        $this->tipo = $tipo;
        $this->numint = $numint;
        $this->componentName = 'Bitatcora';
        $this->pageTitle     = 'Reporte de Servicio de Vehiculos';
        $this->tabla        =  Historialmantvehiculos::where('id_mant',$id)->where('tipo',$this->tipo)->get();
        $this->rol = Auth::user()->rol;        
 
    }
    public function render()
    {
        return view('livewire.reportevehiculo.reporte-vhiculo-component')->extends('adminlte::page')->section('content');
    }
}
