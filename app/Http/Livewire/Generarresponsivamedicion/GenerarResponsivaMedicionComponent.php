<?php

namespace App\Http\Livewire\Generarresponsivamedicion;

use Livewire\Component;
use App\Models\Responsables;
use App\Models\Formato;
use App\Models\Responsivas_medicion;
use App\Models\Prestamos_medicion;
use Illuminate\Support\Facades\Auth;
use App\Models\Medicion;
use App\Models\Descripcion_medicion;
use DB;



class GenerarResponsivaMedicionComponent extends Component
{
    public $componentName;
    public $pageTitle;
    public $responsables = [];
    public $formatos = [];
    public $rol;
    public $responsiva, $obra, $encargado, $cargo_e, $responsable, $cargo, $fecha_r, $fecha_e, $status, $com;
    public $herr = [], $cantidad = [], $cantidad_e = [], $coms = [], $datos = [], $inf = [];


    public function mount()
    {
        $this->componentName = 'Medicion';
        $this->pageTitle = 'Generar Responsiva';
        $this->responsables   = Responsables::all();
        $this->herr[0] = 1;
        $this->formatos    = Formato::all();
        $this->rol = Auth::user()->rol;
    }

    public function render()
    {
        if ($this->responsiva != '') {
            $this->datos = Descripcion_medicion::where('ID_Resp', $this->responsiva)->get();
        }

        return view('livewire.generarresponsivamedicion.generar-responsiva-medicion-component', ['datos' => $this->datos])->extends('adminlte::page')->section('content');
    }

    public function guardar()
    {
        $rule = [
            'obra' => 'required',
            'encargado' => 'required',
            'cargo' => 'required',
            'responsiva' => 'required',
            'responsable' => 'required',
        ];

        $message = [
            'obra.required'   =>   '**Este campo es obligatorio.**',
            'encargado.required'   =>   '**Este campo es obligatorio.**',
            'cargo.required'      =>   '**Este campo es obligatorio.**',
            'responsiva.required'    =>   '**Este campo es obligatorio.**',
            'responsable.required'   =>   '**Este campo es obligatorio.**',
        ];

        $this->validate($rule, $message);

        DB::beginTransaction();

        try {
            $responsiva_med = new Responsivas_medicion();
            $responsiva_med->responsiva = $this->responsiva;
            $responsiva_med->obra       = $this->obra;
            $responsiva_med->encargado  = $this->encargado;
            $responsiva_med->cargo_e    = '.'; // Aquí faltaba asignar el valor del cargo_e
            $responsiva_med->responsable = $this->responsable;
            $responsiva_med->cargo      = $this->cargo;
            $responsiva_med->fecha_e    = date('Y-m-d');
            $responsiva_med->status     = 1;
            $responsiva_med->com        = $this->com;
            $responsiva_med->save();

            foreach ($this->herr as $row => $value) {
                $prestamos = new Prestamos_medicion();
                $prestamos->id_resp = $responsiva_med->id;
                $prestamos->herr = $this->herr[$row];
                $prestamos->com = 1;
                $prestamos->cantidad_e = $this->cantidad[$row];
                $prestamos->cantidad  = $this->cantidad[$row];
                $prestamos->responsable = $this->responsable;
                $prestamos->fecha = date('Y-m-d');
                $prestamos->hora   = date('h:i:s');
                $prestamos->stat   = 1;
                $prestamos->save();
            }

            DB::commit();
            $this->emit('success', 'Se agregó el dato');
        } catch (\Exception $e) {
            DB::rollBack();
            // Registrar cualquier excepción en los logs
            \Log::error('Error al guardar el origen: ' . $e->getMessage());
            // Emitir un mensaje de error
            $this->emit('error', 'Ocurrió un error al guardar el dato.' . $e->getMessage());
        }
    }

    public function resetUI()
    {
        $this->responsiva   = '';
        $this->obra = '';
        $this->encargado = '';
        $this->cargo_e = '';
        $this->responsable = '';
        $this->cargo = '';
        $this->fecha_r = '';
        $this->fecha_e = '';
        $this->status = '';
        $this->com = '';
        $this->herr = [];
        $this->cantidad = [];
        $this->cantidad_e = [];
        $this->coms = [];
        $this->datos = [];
        $this->inf = [];
    }
}
