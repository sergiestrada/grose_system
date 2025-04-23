<?php

namespace App\Http\Livewire\Herraminetasrep;

use Livewire\Component;
use App\Models\Prestamos;
use App\Models\Responsables;
use App\Models\Herramientas;
use Illuminate\Support\Facades\Auth;

class HerramientasRepComponent extends Component
{
    public $componentName;
    public $pageTitle;
    public $tabla   = [];
    public $responsables = [];
    public $filtro;
    public $rol;

    public function mount()
    {
        $this->componentName = 'Reportes';
        $this->pageTitle     = 'Reporte de herramienta';
        $this->rol = Auth::user()->rol;
        $this->responsables = Herramientas::all();
    }
    public function render()
    {
        if($this->filtro == ''){
        $this->tabla = Prestamos::where('status',0)->get();
        }else{
            $this->tabla = Prestamos::where('status',0)->where('herr',$this->filtro)->get();
        }
        return view('livewire.herraminetasrep.herramientas-rep-component',['tabla',$this->tabla])->extends('adminlte::page')->section('content');
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
