<?php

namespace App\Http\Livewire\Proveedores;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Proveedores;
use DB;

class ProveedoresComponent extends Component
{
    public $componentName;
    public $pageTitle;
    public $tabla   = [];
    public $Nombre_Proveedor, $Ciudad, $Telefono, $Nombre_contacto, $Tipo, $activo;
    public $contador = 1;
    public $val;
    public $accion;
    public $rol;


    public function mount()
    {
        $this->componentName = 'Configuracion';
        $this->pageTitle     = 'Proveedores';
        $this->tabla = Proveedores::where('activo',1)->get();
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
    public function editar()
    {
        $datos = Proveedores::find($this->val);
        $this->Nombre_Proveedor    = $datos->Nombre_Proveedor;
        $this->Nombre_contacto = $datos->Nombre_contacto;
        $this->Ciudad  = $datos->Ciudad;
        $this->Telefono = $datos->Telefono;
        $this->Tipo = $datos->Tipo;
        $this->emit('show-modal');

    }
    public function render()
    {
     
        return view('livewire.proveedores.proveedores-component')->extends('adminlte::page')->section('content');
    }

    public function Store()
    {
        $rule = [
            'Nombre_Proveedor' => 'required',
            'Nombre_contacto'  => 'required',
            'Ciudad' => 'required',
            'Telefono' => 'required',
            'Tipo'        => 'required',
        ];

        $message = [
            'Nombre_Proveedor.required'   =>   '**Este campo es obligatorio.**',
            'Nombre_contacto.required'  =>   '**Este campo es obligatorio.**',
            'Ciudad.required'  =>   '**Este campo es obligatorio.**',
            'Telefono.required'  =>   '**Este campo es obligatorio.**',
            'Tipo.required'  =>   '**Este campo es obligatorio.**',
           
        ];

        $this->validate($rule, $message);

        DB::beginTransaction();

        try {
            $datos = new Proveedores();
            $datos->Nombre_Proveedor  = $this->Nombre_Proveedor;
            $datos->Ciudad     = $this->Ciudad;
            $datos->Telefono      = $this->Telefono;
            $datos->Nombre_contacto     = $this->Nombre_contacto;
            $datos->Tipo   = $this->Tipo;
            $datos->activo  = 1;
            $datos->save();
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

    public function Update()
    {
        $rule = [
            'Nombre_Proveedor' => 'required',
            'Nombre_contacto'  => 'required',
            'Ciudad' => 'required',
            'Telefono' => 'required',
            'Tipo'        => 'required',
        ];

        $message = [
            'Nombre_Proveedor.required'   =>   '**Este campo es obligatorio.**',
            'Nombre_contacto.required'  =>   '**Este campo es obligatorio.**',
            'Ciudad.required'  =>   '**Este campo es obligatorio.**',
            'Telefono.required'  =>   '**Este campo es obligatorio.**',
            'Tipo.required'  =>   '**Este campo es obligatorio.**',
           
        ];

        $this->validate($rule, $message);


        $this->validate($rule, $message);

        DB::beginTransaction();

        try {
            Proveedores::where('id', $this->val)->update([
              'Nombre_Proveedor'  => $this->Nombre_Proveedor,
              'Ciudad'            => $this->Ciudad,
              'Telefono'          => $this->Telefono,
              'Nombre_contacto'   => $this->Nombre_contacto,
              'Tipo'              => $this->Tipo
            
            ]);
            DB::commit();
            $this->emit('success', 'Se Edito el dato');
        } catch (\Exception $e) {
            DB::rollBack();
            // Registrar cualquier excepción en los logs
            \Log::error('Error al guardar el origen: ' . $e->getMessage());
            // Emitir un mensaje de error
            $this->emit('error', 'Ocurrió un error al guardar el dato.' . $e->getMessage());
        }
    }

    public function delete($id){
        Proveedores::where('id',$id)->delete();
        $this->emit('success', 'Se elimino el dato');

    }
    public function resetUI()
    {
    $this->Nombre_Proveedor = '';
    $this->Ciudad   = '';
    $this->Telefono = '';
    $this->Nombre_contacto = '';
    $this->Tipo = '';
    $this->activo = '';
    $this->val = '';
    $this->accion = '';
    }
}

