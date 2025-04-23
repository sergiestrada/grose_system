<?php

namespace App\Http\Livewire\Bitacoraherramientas;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\bitacora_herramienta;

use App\Models\Herramientas;
use App\Models\Responsables;

class BitacoraHerramientasComponent extends Component
{
    public $componentName;
    public $pageTitle;
    public $table = [];
    public $fecha_inicial;
    public $fecha_fin;
    public $estatus;


    public $rol;
    public $val;
    public $accion;

    public function mount(){
        $this->componentName = 'Bitacora';
        $this->pageTitle = 'Herramientas'; 

        $this->rol = Auth::user()->rol;
       
    }

    public function render()
    {
        $query = bitacora_herramienta::query();

    // Filtro por fechas si se establecen
    if ($this->fecha_inicial != '' && $this->fecha_fin != '') {
        $query->whereBetween('fecha', [$this->fecha_inicial, $this->fecha_fin]);
    }

    // Filtro por estatus si se establece
    if ($this->estatus != '') {
        $query->where('stat', $this->estatus);
    }

    // Ejecutar el query y asignar los resultados
    $this->table = $query->orderBy('fecha','desc')->get();
        return view('livewire.bitacoraherramientas.bitacora-herramientas-component')->extends('adminlte::page')->section('content');
    }
    
    public function herramientas($id){
        $herramienta = Herramientas::find($id);
		$data = '';
		if($herramienta){
			$data = $herramienta->Herramienta;
		}else{
			$data = '';
		}	
        return $data;
		}
}
