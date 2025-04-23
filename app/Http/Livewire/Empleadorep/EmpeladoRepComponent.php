<?php

namespace App\Http\Livewire\Empleadorep;

use Livewire\Component;
use App\Models\Historial_responsivas;
use App\Models\Responsables;
use App\Models\Prestamos;
use Illuminate\Support\Facades\Auth;

class EmpeladoRepComponent extends Component
{
    public $componentName;
    public $pageTitle;
    public $tabla   = [];
    public $responsables = [];
    public $rol;
    public $filtro;
    
    public function mount()
    {
        $this->componentName = 'Reportes';
        $this->pageTitle     = 'Reporte por Empleado';
        $this->responsables = Responsables::all();
        $this->rol = Auth::user()->rol;
    }
    
    public function render()
    {
        $this->tabla = Prestamos::where('status',1)->get();
        return view('livewire.empleadorep.empelado-rep-component',['tabla'=>$this->tabla])->extends('adminlte::page')->section('content');
    }
    
    public function responsable($id)
    {
        $dato = '';
        $nombre = '';
        if ($id != null) {
            $dato = Responsables::find($id);
            $nombre = $dato->Nombre . ' ' . $dato->Apellido_P . ' ' . $dato->Apellido_M;
        } else {
            $nombre = '';
        }

        return $nombre;
    }
}
