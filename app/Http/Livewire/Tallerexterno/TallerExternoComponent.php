<?php

namespace App\Http\Livewire\Tallerexterno;

use Livewire\Component;
use App\Models\Mecanico_Externo;
use Illuminate\Support\Facades\Auth;
use DB;

class TallerExternoComponent extends Component
{
    public $componentName;
    public $pageTitle;
    public $tabla   = [];
    public $contador = 1;
    public $Nombre, $Apellido_P, $Apellido_M, $Telefono, $Ciudad, $Nombre_Taller, $activo;
    public $val;
    public $accion;
    public $rol;

    public function mount()
    {
        $this->componentName = 'Configuracion';
        $this->pageTitle     = 'Mecanico Externo';
        $this->tabla = Mecanico_Externo::where('activo',1)->get();
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
    public function crear()
    {
        $this->emit('show-modal');
    }

    public function editar(){
        $data =  Mecanico_Externo::find($this->val);
        $this->Nombre    = $data->Nombre;
        $this->Apellido_P = $data->Apellido_P;
        $this->Apellido_M = $data->Apellido_M; 
        $this->Telefono = $data->Telefono; 
        $this->Ciudad = $data->Ciudad;
        $this->Nombre_Taller = $data->Nombre_Taller;
    
        $this->emit('show-modal');
    }
    public function render()
    {
        return view('livewire.tallerexterno.taller-externo-component')->extends('adminlte::page')->section('content');
    }

    public function Store(){
        $rule = [
             'Nombre'  => 'required' ,
             'Apellido_P'  => 'required' ,
             'Apellido_M'  => 'required' ,
             'Telefono'  => 'required' ,
             'Ciudad'  => 'required' ,
             'Nombre_Taller'  => 'required' 

        ];

        $message = [
            'Nombre.required' => '**Este campo es obligatorio.**',
            'Apellido_P.required' => '**Este campo es obligatorio.**',
            'Apellido_M.required' => '**Este campo es obligatorio.**',
            'Telefono.required' => '**Este campo es obligatorio.**',
            'Ciudad.required' => '**Este campo es obligatorio.**',
            'Nombre_Taller.required' => '**Este campo es obligatorio.**',


        ];
        $this->validate($rule, $message);
        DB::beginTransaction();

        try {
            
            $data = new Mecanico_Externo();
            $data->Nombre  = $this->Nombre; 
            $data->Apellido_P = $this->Apellido_P;
            $data->Apellido_M  =  $this->Apellido_M;
            $data->Telefono  = $this->Telefono;
            $data->Ciudad  = $this->Ciudad; 
            $data->Nombre_Taller  = $this->Nombre_Taller;
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
             'Ciudad'  => 'required' ,
             'Nombre_Taller'  => 'required' 

        ];

        $message = [
            'Nombre.required' => '**Este campo es obligatorio.**',
            'Apellido_P.required' => '**Este campo es obligatorio.**',
            'Apellido_M.required' => '**Este campo es obligatorio.**',
            'Telefono.required' => '**Este campo es obligatorio.**',
            'Ciudad.required' => '**Este campo es obligatorio.**',
            'Nombre_Taller.required' => '**Este campo es obligatorio.**',


        ];
        $this->validate($rule, $message);
        DB::beginTransaction();

        try {
            
           Mecanico_Externo::where('id',$this->val)->update([
            'Nombre'  => $this->Nombre, 
            'Apellido_P' => $this->Apellido_P,
            'Apellido_M'  =>  $this->Apellido_M,
            'Telefono'  => $this->Telefono,
            'Ciudad'  => $this->Ciudad,
            'Nombre_Taller'  => $this->Nombre_Taller
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
        Mecanico_Externo::where('id',$id)->update(['activo'=>0]);
        $this->emit('success','Se realizo ');
    }

    public function resetUI(){
        $this->Nombre = '';
        $this->Apellido_P = '';
        $this->Apellido_M = '';
        $this->Telefono = '';
        $this->Ciudad = '';
        $this->Nombre_Taller = '';
        $this->val = '';
        $this->accion = '';
    }
    }

