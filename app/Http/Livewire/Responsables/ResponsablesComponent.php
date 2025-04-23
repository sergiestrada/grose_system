<?php

namespace App\Http\Livewire\Responsables;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Responsables;
use App\Models\Estados;
use DB;

class ResponsablesComponent extends Component
{
    public $componentName;
    public $pageTitle;
    public $table;
    public $accion;
    public $val;
    public $nombre;
    public $apellido_P;
    public $apellido_M;
    public $numero_contacto;
    public $no_Empleado;
    public $cargo;
    public $estado;
    public $antiguedad = 0;
    public $fecha_alta;
    public $estados = [];
    public $contador = 1;
    public $rol;


    public function mount()
    {
        $this->componentName = 'Configuracion';
        $this->pageTitle     = 'Responsables';
        $this->rol = Auth::user()->rol;        
        $this->estados       = Estados::all();
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

    public function editar()
    {
        $resp = Responsables::find($this->val);
     
        $this->nombre = $resp->Nombre ;
        $this->apellido_P = $resp->Apellido_P;
        $this->apellido_M = $resp->Apellido_M;
        $this->numero_contacto = $resp->Numero_contacto;
        $this->no_Empleado  = $resp->No_Empleado;
        $this->cargo        = $resp->Cargo;
        $this->estado       = $resp->Estado;
        $this->antiguedad   = $resp->Antiguedad;
        $this->fecha_alta   = $resp->Fecha_alta;
        $this->emit('show-modal');
    }


    public function render()
    {
        $this->table         = Responsables::where('ruta',1)->get();
        return view('livewire.responsables.responsables-component', ['table' => $this->table])->extends('adminlte::page')->section('content');
    }

    public function obtener_estado($id)
    {
        $datos = Estados::find($id);
        return $datos->estado;
    }
   public function Store()
   {
    $rule = [
        'nombre' => 'required',
        'apellido_P'=> 'required',
        'apellido_M' => 'required',
        'numero_contacto'=> 'required',
        'no_Empleado' => 'required',
        'cargo'        => 'required',
        'estado'      => 'required',
    ];

    $message = [
        'nombre.required'               =>   '**Este campo es obligatorio.**',
        'apellido_P.required'           =>   '**Este campo es obligatorio.**',
        'apellido_M.required'           =>   '**Este campo es obligatorio.**',
        'numero_contacto.required'      =>   '**Este campo es obligatorio.**',
        'no_Empleado.required'          =>   '**Este campo es obligatorio.**',
        'cargo.required'                =>   '**Este campo es obligatorio.**',
        'estado.required'               =>   '**Este campo es obligatorio.**',
        ];
    
        $this->validate($rule, $message);

        DB::beginTransaction();

        try {

            $resp = new Responsables();
            $resp->Nombre           =     $this->nombre;
            $resp->Apellido_P       =     $this->apellido_P;
            $resp->Apellido_M       =     $this->apellido_M;
            $resp->Numero_contacto  =     $this->numero_contacto;
            $resp->No_Empleado      =     $this->no_Empleado;
            $resp->Cargo            =     $this->cargo;
            $resp->Estado           =     $this->estado;
            $resp->ruta              =       1;
            $resp->Antiguedad       =     $this->antiguedad;
            $resp->Fecha_alta       =      date('Y-m-d');
            $resp->save();

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
    public function Update()
   {
    Responsables::where('id',$this->val)->update(
        [  
        'Nombre'           =>     $this->nombre,
        'Apellido_P'       =>     $this->apellido_P,
        'Apellido_M'       =>     $this->apellido_M,
        'Numero_contacto'  =>     $this->numero_contacto,
        'No_Empleado'      =>     $this->no_Empleado,
        'Cargo'            =>     $this->cargo,
        'Estado'           =>     $this->estado,
        'Antiguedad'       =>     $this->antiguedad  ]
    );
    $this->emit('success','Se actualizo el dato');
  
   }
    public function delete($id)
   {
    Responsables::where('id',$id)->update(['Rute'=>0]);
    $this->emit('success','Se elimino el dato');
   }
    public function resetUI()
    {
        $this->accion = '';
        $this->val    = '';
        $this->nombre = '';
        $this->apellido_P = '';
        $this->apellido_M = '';
        $this->numero_contacto = '';
        $this->no_Empleado  = '';
        $this->cargo        = '';
        $this->estado       = '';
        $this->antiguedad   = '';
        $this->fecha_alta   = '';
    }
}
