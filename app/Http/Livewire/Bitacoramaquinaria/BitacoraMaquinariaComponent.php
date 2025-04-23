<?php

namespace App\Http\Livewire\Bitacoramaquinaria;

use Livewire\Component;
use App\Models\Bitacora_maquinaria;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use App\Models\Mecanico_Externo;
use App\Models\Mecanico_Interno;
use App\Models\Responsables;
use App\Models\Proveedores;
use App\Models\Factura;
use App\Models\Historialmantvehiculos;
use App\Models\Maquinaria;
use DB;

class BitacoraMaquinariaComponent extends Component
{
    use WithFileUploads;
    public $componentName;
    public $pageTitle;
    public $table = [];
    public $mec_i = [];
    public $mec_e = [];
    public $historial = [];
    public $vehiculos = [];
    public $responsable = [];
    public $provedor = [];
    public $Nombre_Vehiculo, $Responsable, $Tipo_Servicio, $Mecanico, $Tipo_mecanico, $Proveedor, $Fecha_servicio, $Prox_Fecha_Serv, $Comentarios;
    public $num_int, $horometro;
    public $rol;
    public $accion;
    public $monto;
    public $factura;
    public $datos;
    public $val;
    public $subval;


    public function mount()
    {
        $this->componentName = 'Bitacora';
        $this->pageTitle = 'Maquinaria menor';
        $this->table    = Bitacora_maquinaria::all();
        $this->mec_e = Mecanico_Externo::all();
        $this->mec_i = Mecanico_Interno::all();
        $this->provedor = Proveedores::all();
        $this->responsable = Responsables::all();
        $this->rol = Auth::user()->rol;

    }
    public function accion($opc, $val)
    {
        $this->accion = $opc;
        $this->val = $val;
        switch ($opc) {
            case 0:
                $this->historiales();

                break;
            case 1:
                $this->emit('show-modal');
                break;
            case 2:
                $this->editar();
                break;
            case 3:
                $this->emit('show-modal');
                break;
            case 8:
                $data = Bitacora_maquinaria::find($this->val);

                $this->Fecha_servicio = $data->horometro;

                $this->emit('show-modal');
                break;
        }
    }
    public function subaccion($opc, $val)
    {
        $this->accion = $opc;
        $this->subval = $val;
        switch ($opc) {

            case  3:
                $this->emit('show-modal');
                break;
        }
    }
    public function render()
    {
        return view('livewire.bitacoramaquinaria.bitacora-maquinaria-component')->extends('adminlte::page')->section('content');
    }
    public function editar()
    {
        $datos = Bitacora_maquinaria::find($this->val);
        $this->Nombre_Vehiculo = $datos->Nombre_Vehiculo;
        $this->num_int = $datos->num_int;
        $this->Fecha_servicio = $datos->Fecha_servicio;
        $this->Responsable = $datos->Responsable;
        $this->emit('show-modal');
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
    public function Store()
    {


        $rule = [
            'Nombre_Vehiculo' => 'required',
            'Responsable'     => 'required',
            'Tipo_Servicio'   => 'required',
            'Mecanico'        => 'required',
            'Tipo_mecanico'   => 'required',
            'Proveedor'       => 'required',
            'Fecha_servicio'  => 'required',
            'Prox_Fecha_Serv' => 'required',
            'num_int'         => 'required',
        ];

        $message = [
            'Nombre_Vehiculo.required' =>   '**Este campo es obligatorio.**',
            'Responsable.required'     =>   '**Este campo es obligatorio.**',
            'Tipo_Servicio.required'   =>   '**Este campo es obligatorio.**',
            'Mecanico.required'        =>   '**Este campo es obligatorio.**',
            'Tipo_mecanico.required'   =>   '**Este campo es obligatorio.**',
            'Proveedor.required'       =>   '**Este campo es obligatorio.**',
            'Fecha_servicio.required'  =>   '**Este campo es obligatorio.**',
            'Prox_Fecha_Serv.required' =>   '**Este campo es obligatorio.**',
            'num_int.required'         =>   '**Este campo es obligatorio.**',
        ];
        $this->validate($rule, $message);

        DB::beginTransaction();

        try {
            $data = new Bitacora_maquinaria();
            $data->Nombre_Vehiculo =  $this->Nombre_Vehiculo;
            $data->Responsable     =  $this->Responsable;
            $data->Tipo_Servicio   =  $this->Tipo_Servicio;
            $data->Mecanico        =  $this->Mecanico;
            $data->Tipo_mecanico   =  $this->Tipo_mecanico;
            $data->Proveedor       =  $this->Proveedor;
            $data->Fecha_servicio  =  $this->Fecha_servicio;
            $data->Prox_Fecha_Serv =  $this->Prox_Fecha_Serv;
            $data->num_int         = $this->num_int;
            $data->save();
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
            'Nombre_Vehiculo' => 'required',
            'Responsable'     => 'required',
            'Fecha_servicio'  => 'required',
            'num_int'         => 'required',
        ];

        $message = [
            'Nombre_Vehiculo.required' =>   '**Este campo es obligatorio.**',
            'Responsable.required'     =>   '**Este campo es obligatorio.**',
            'Fecha_servicio.required'  =>   '**Este campo es obligatorio.**',
            'num_int.required'         =>   '**Este campo es obligatorio.**',
        ];
        $this->validate($rule, $message);

        DB::beginTransaction();

        try {
            Bitacora_maquinaria::where('id', $this->val)->update([
                'Nombre_Vehiculo' =>  $this->Nombre_Vehiculo,
                'Responsable'     =>  $this->Responsable,
                'Fecha_servicio'  =>  $this->Fecha_servicio,
                'num_int'         => $this->num_int
            ]);


            DB::commit();
            $this->emit('success', 'Se edito el dato');
        } catch (\Exception $e) {
            DB::rollBack();
            // Registrar cualquier excepción en los logs
            \Log::error('Error al guardar el origen: ' . $e->getMessage());
            // Emitir un mensaje de error
            $this->emit('error', 'Ocurrió un error al guardar el dato.' . $e->getMessage());
        }
    }
    public function Guardar()
    {
        
        $rule = [
          
            'Tipo_Servicio'   => 'required',
            'Mecanico'        => 'required',
            'Tipo_mecanico'   => 'required',
            'Proveedor'       => 'required',
            'Fecha_servicio'  => 'required',
            'Prox_Fecha_Serv' => 'required',
       
        ];

        $message = [
           
            'Tipo_Servicio.required'   =>   '**Este campo es obligatorio.**',
            'Mecanico.required'        =>   '**Este campo es obligatorio.**',
            'Tipo_mecanico.required'   =>   '**Este campo es obligatorio.**',
            'Proveedor.required'       =>   '**Este campo es obligatorio.**',
            'Fecha_servicio.required'  =>   '**Este campo es obligatorio.**',
            'Prox_Fecha_Serv.required' =>   '**Este campo es obligatorio.**',
        ];
        $this->validate($rule, $message);

        DB::beginTransaction();

        try {
            $data = new Historialmantvehiculos();
            $data->id_mant = $this->val;
            $data->tipo = 3;
            $data->fecha = date('Y-m-d');
            $data->servicio = $this->Tipo_Servicio;
            $data->proveedor = $this->Proveedor;
            $data->mecanico = $this->Mecanico;
            $data->taller = 0;
            $data->t_mecanico = $this->Tipo_mecanico;
            $data->km_anterior = $this->Fecha_servicio;
            $data->km_actual = $this->Prox_Fecha_Serv;
            $data->save();

            Bitacora_maquinaria::where('id', $this->val)->update([
               
            'Tipo_Servicio'   => $this->Tipo_Servicio,
            'Mecanico'        => $this->Mecanico,
            'Tipo_mecanico'   => $this->Tipo_mecanico,
            'Proveedor'       => $this->Proveedor,
            'Fecha_servicio'  => $this->Fecha_servicio,
            'Prox_Fecha_Serv' => $this->Prox_Fecha_Serv,
       
            ]);

            DB::commit();
            $this->emit('success', 'Se guardo el dato');
        } catch (\Exception $e) {
            DB::rollBack();
            // Registrar cualquier excepción en los logs
            \Log::error('Error al guardar el origen: ' . $e->getMessage());
            // Emitir un mensaje de error
            $this->emit('error', 'Ocurrió un error al guardar el dato.' . $e->getMessage());
        }
    }
    public function subir_documento()
    {
     
       
         $rule = [
            'factura' => 'required|max:2048',
            'monto'  => 'required' // Ejemplo: Acepta archivos PDF de hasta 2MB
        ];

        $message = [
            'factura.required' => '**Este campo es obligatorio.**',
            'monyo.required' => '**Este campo es obligatorio.**',
        ];
        $this->validate($rule, $message);
        DB::beginTransaction();

        try {
            $name = $this->factura->getClientOriginalName();    
           $salvar = $this->factura->storeAs('public/assets/vehiculos/factura/',$name);
                
    
           $docs = new Factura();
           $docs->tfactura = $this->subval;
           $docs->monto = $this->monto;
           $docs->Vh_ligado = $this->val;
           $docs->id_lig = 0;
           $docs->Archivo = $name;
           $docs->fecha = date('Y-m-d');
           $docs->hora = date('h:i:s');
           $docs->iden = 3;
           $docs->save();
                
           
            DB::commit();
            $this->emit('success1', 'Se subio  el archivo');
        } catch (\Exception $e) {
            DB::rollBack();
            // Registrar cualquier excepción en los logs
            \Log::error('Error al guardar el origen: ' . $e->getMessage());
            // Emitir un mensaje de error
            $this->emit('error', 'Ocurrió un error al subir el archivo.' . $e->getMessage());
        }
    }
    public function mecanico($id, $mec)
    {
        $dato = '';
        if ($mec != '') {
            if ($mec == 1) {
                $dato = Mecanico_Interno::where('id', $mec)
                    ->selectRaw("CONCAT(Nombre, ' ', Apellido_P, ' ', Apellido_M) as nombrex")
                    ->first();
            }
            if ($dato != null) {
                return   $dato->nombrex;
            }
        } else {
            $dato = Mecanico_Externo::where('id', $mec)
                ->selectRaw("CONCAT(Nombre, ' ', Apellido_P, ' ', Apellido_M) as nombrex")
                ->first();
            if ($dato != null) {
                return   $dato->nombrex;
            }
        }
    }
    public function herramientas($id){
        $herramienta = Maquinaria::find($id);
        return $herramienta->Nombre_Id;
    }
    public function delete_img($id)
    {
        $dato = Factura::find($id);

       
                Storage::delete('public/assets/vehiculos/factura/'.$dato->Archivo);
                Factura::where('id',$id)->delete();
         
       
        $this->emit('success', 'Se Elimino el dato');

    }
    public function delete($id){
        Bitacora_maquinaria::where('id',$id)->delete();
        $this->emit('success', 'Se elimino el documento');
    }
    public function eliminar_ser($id){

        Historialmantvehiculos::where('id',$id)->delete();
        $this->emit('success', 'Se elimino el servicio');
    }
 
    public function historiales()
    {
        $this->historial = Historialmantvehiculos::where('id_mant', $this->val)->where('tipo',3)->get();
        $this->emit('show-modal');
    }
    public function  editar_monto($id, $text)
    {
        Factura::where('id', $id)->update(['monto' => $text]);
    }
    public function provedor($id)
    {
        $dato = Proveedores::find($id);
        return $dato->Nombre_Proveedor;
    }

    public function resetUI()
    {
        $this->Nombre_Vehiculo = '';
        $this->Responsable = '';
        $this->Tipo_Servicio = '';
        $this->Mecanico = '';
        $this->Tipo_mecanico = '';
        $this->Proveedor = '';
        $this->Fecha_servicio = '';
        $this->Prox_Fecha_Serv = '';
        $this->Comentarios = '';
        $this->num_int = '';
        $this->accion = '';
        $this->val = '';
        $this->datos = '';
    }
    public function resetUII()
    {
        $this->monto = '';
        $this->factura = '';
    }
}
