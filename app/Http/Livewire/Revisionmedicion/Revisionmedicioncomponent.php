<?php

namespace App\Http\Livewire\Revisionmedicion;

use Livewire\Component;
use App\Models\MedicionReparacion;
use App\Models\Responsivas_medicion;
use App\Models\ComentarioMedicion;
use DB;

class Revisionmedicioncomponent extends Component
{
    public $componentName;
    public $pageTitle;
    public $table = [];
    public $comens = [];
    public $comentario;
    public $val;
    public $x = 1;
    public $accion = 1;


    public function mount()
    {
        $this->componentName = 'Medicion ';
        $this->pageTitle = 'Revision';
        $this->table    = MedicionReparacion::all();
    }
    public function render()
    {
        return view('livewire.revisionmedicion.revisionmedicioncomponent')->extends('adminlte::page')->section('content');
    }

    public function comentario($id)
    {
        $this->val = $id;
        $this->comens = ComentarioMedicion::where('medicion', $id)->get();
        $this->emit('show-modal');
    }

    public function Store()
    {
        $rule = [

            'comentario' => 'required',

        ];

        $message = [
            'comentario.required'  =>   '**Este campo es obligatorio.**',


        ];

        $this->validate($rule, $message);

        DB::beginTransaction();

        try {
            ComentarioMedicion::create([
                'comentario' => $this->comentario,
                'medicion' => $this->val
            ]);
            $this->comentario($this->val);
            DB::commit();
            $this->emit('success', 'Se agrego el dato');
        } catch (\Exception $e) {
            DB::rollBack();
            // Registrar cualquier excepción en los logs
            \Log::error('Error al guardar el origen: ' . $e->getMessage());
            // Emitir un mensaje de error
            $this->emit('error', 'Ocurrió un error al guardar el dato.' . $e->getMessage());
        }
    }

    public function aceptar($id,$origen)
    {
        MedicionReparacion::where('id', $origen)->update([
            'estatus' => 'Dado de alta'
        ]);
        Responsivas_medicion::where('id',$id)->update([
            'status' => 1
        ]);

        $this->table = MedicionReparacion::all();
        $this->emit('success1', 'Se dio de alta');
    }
    public function eliminar($id,$origen)
    {
        MedicionReparacion::where('id', $origen)->update([
            'estatus' => 'Baja'
        ]);
        Responsivas_medicion::where('id',$id)->update([
            'status' => 4
        ]);

        $this->table = MedicionReparacion::all();
        $this->emit('success1', 'Se dio de baja');
    }

    public function resetUI()
    {
        $this->comentario = '';
    }
}
