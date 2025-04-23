<?php

namespace App\Http\Livewire\Tallerinterno;

use Livewire\Component;
use App\Models\Mecanico_Interno;
use Illuminate\Support\Facades\Auth;
use DB;

class TallerInternoComponent extends Component
{
    public $componentName;
    public $pageTitle;
    public $tabla   = [];
    public $contador = 1;
    public $Nombre, $Apellido_P, $Apellido_M, $Telefono, $Obra, $activo;
    public $val;
    public $accion;
    public $rol;

     public function mount()
    {
        $this->componentName = 'Configuracion';
        $this->pageTitle     = 'Mecanico Interno';
        $this->tabla = Mecanico_Interno::where('activo',1)->get();
        $this->rol = Auth::user()->rol;  

    }

    public function accion($opc, $val)
    {
        $this->accion = $opc;
        $this->val = $val;
        switch ($opc) {
        
            case 1:
                $this->crear();
                break;
            case 2:
                $this->editar();
                break;
          
        }
    }

    public function editar(){
        $data =  Mecanico_Interno::find($this->val);
        $this->Nombre = $data->Nombre;
        $this->Apellido_P = $data->Apellido_P;
        $this->Apellido_M = $data->Apellido_M; 
        $this->Telefono =  $data->Telefono; 
        $this->Obra = $data->Obra;
        $this->emit('show-modal');
    }
    public function crear()
    {
        $this->emit('show-modal');
    }

    public function render()
    {
        return view('livewire.tallerinterno.taller-interno-component')->extends('adminlte::page')->section('content');
    }
    public function Store(){
        $rule = [
             'Nombre'  => 'required' ,
             'Apellido_P'  => 'required' ,
             'Apellido_M'  => 'required' ,
             'Telefono'  => 'required' ,
             'Obra'  => 'required' ,
           
        ];

        $message = [
            'Nombre.required' => '**Este campo es obligatorio.**',
            'Apellido_P.required' => '**Este campo es obligatorio.**',
            'Apellido_M.required' => '**Este campo es obligatorio.**',
            'Telefono.required' => '**Este campo es obligatorio.**',
            'Obra.required' => '**Este campo es obligatorio.**',
            
        ];
        $this->validate($rule, $message);
        DB::beginTransaction();

        try {
            
            $data = new Mecanico_Interno();
            $data->Nombre  = $this->Nombre; 
            $data->Apellido_P = $this->Apellido_P;
            $data->Apellido_M  =  $this->Apellido_M;
            $data->Telefono  = $this->Telefono;
            $data->Obra  = $this->Obra; 
            $data->activo = 1;
            $data->save();

            DB::commit();
            $this->emit('success', 'Se guardo  el dato');
        } catch (\Exception $e) {
            DB::rollBack();
            // Registrar cualquier excepción en los logs
            \Log::error('Error al guardar el origen: ' . $e->getMessage());
            // Emitir un mensaje de error
            $this->emit('error', 'Ocurrió un error a estar el dato.' . $e->getMessage());
        }
    }
    
    public function Update(){
        $rule = [
             'Nombre'  => 'required' ,
             'Apellido_P'  => 'required' ,
             'Apellido_M'  => 'required' ,
             'Telefono'  => 'required' ,
             'Obra'  => 'required' ,
           
        ];

        $message = [
            'Nombre.required' => '**Este campo es obligatorio.**',
            'Apellido_P.required' => '**Este campo es obligatorio.**',
            'Apellido_M.required' => '**Este campo es obligatorio.**',
            'Telefono.required' => '**Este campo es obligatorio.**',
            'Obra.required' => '**Este campo es obligatorio.**',
         

        ];
        $this->validate($rule, $message);
        DB::beginTransaction();

        try {
            
            Mecanico_Interno::where('id',$this->val)->update([
            'Nombre'  => $this->Nombre, 
            'Apellido_P' => $this->Apellido_P,
            'Apellido_M'  =>  $this->Apellido_M,
            'Telefono'  => $this->Telefono,
            'Obra'  => $this->Obra,
    
           ]);
            
            DB::commit();
            $this->emit('success', 'Se edito  el dato');
        } catch (\Exception $e) {
            DB::rollBack();
            // Registrar cualquier excepción en los logs
            \Log::error('Error al guardar el origen: ' . $e->getMessage());
            // Emitir un mensaje de error
            $this->emit('error', 'Ocurrió un error a editar el dato.' . $e->getMessage());
        }
    }
    public function delete($id){
        Mecanico_Interno::where('id',$id)->update(['activo'=>0]);
        $this->emit('success','Se realizo ');
    }
    public function resetUI(){
        $this->Nombre = '';
        $this->Apellido_P = '';
        $this->Apellido_M = '';
        $this->Telefono = '';
        $this->Obra = '';
        $this->val = '';
        $this->accion = '';
    }
}
