<?php

namespace App\Http\Livewire\Reporte;

use Livewire\Component;
use App\Models\Historial_responsivas;
use Illuminate\Support\Facades\Auth;
use App\Models\Responsables;

class ReporteComponent extends Component
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
        $this->pageTitle     = 'Reporte por Folio de prestamos';
        $this->responsables = Responsables::all();
        $this->rol = Auth::user()->rol;
    }
    
    public function render()
  {
        if($this->filtro ==''){
        $this->tabla = Historial_responsivas::join('responsable', 'historial_responsivas.reponsable', '=', 'responsable.id')
        ->join('responsable as portador', 'historial_responsivas.Portador', '=', 'portador.id')
        ->get();
        }else{
            $this->tabla = Historial_responsivas::where('reponsable',$this->filtro)->get();
        }

        return view('livewire.reporte.reporte-component',['tabla'=>$this->tabla])->extends('adminlte::page')->section('content');
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
