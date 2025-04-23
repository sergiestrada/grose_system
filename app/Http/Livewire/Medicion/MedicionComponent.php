<?php

namespace App\Http\Livewire\Medicion;

use Livewire\Component;
use App\Models\Categoria_medicion;
use Illuminate\Support\Facades\Auth;
use DB;

class MedicionComponent extends Component
{
    public $componentName;
    public $pageTitle;
    public $tabla   = [];
    public $contador = 1;
    public $categoria;
    public $val;
    public $accion;
    public $rol;

    public function mount()
    {
        $this->componentName = 'Configuracion';
        $this->pageTitle     = 'Medicion';
        $this->rol = Auth::user()->rol;
      

    }

    public function accion($opc,$val)
    {
        $this->accion = $opc;
        $this->val = $val;
        switch($opc){
            case 1: 
                $this->crear();
                break;
            case 2: 
                $this->editar();
                break;
            
        }

    }

    public function crear()
    {
        $this->emit('show-modal');
    }
    public function editar()
    {
         $datos = Categoria_medicion::find($this->val);
        $this->categoria = $datos->categoria;
        $this->emit('show-modal');
    }
    public function render()
    {
        $this->tabla         = Categoria_medicion::where('estatus',1)->get(); 
        return view('livewire.medicion.medicion-component',['tabla',$this->tabla])->extends('adminlte::page')->section('content');
    }
    public function Store()
    {
        $rule = [
            'categoria'   => 'required|string',
        ];

        $message = [
            'categoria.required'     =>   '**Este campo es obligatorio.**',
           
        ];
        $this->validate($rule, $message);

        DB::beginTransaction();
        try {
            $cat = new Categoria_medicion();
            $cat->categoria = $this->categoria;
            $cat->estatus    = 1;
          
            $cat->save();
            
            DB::commit();
            $this->emit('success','Se agrego el dato');
        }catch (\Exception $e) {
            DB::rollBack();
          // Registrar cualquier excepción en los logs
          \Log::error('Error al guardar el origen: ' . $e->getMessage());
          // Emitir un mensaje de error
          $this->emit('error', 'Ocurrió un error al guardar el dato.'.$e->getMessage());
      }
    }
    public function delete($id)
    {
        Categoria_medicion::where('id',$id)->update(['estatus'=>1]);
        $this->emit('success','Se elimino el dato');
    }
    public function Update()
    {
        Categoria_medicion::where('id',$this->val)->update(
            ['categoria'=>$this->categoria]
        );
        $this->emit('success','Se edito el dato');
    }
    public function resetUI()
    {
        $this->categoria        = '';
        $this->val              = '';
        $this->accion           = '';
    }
}
