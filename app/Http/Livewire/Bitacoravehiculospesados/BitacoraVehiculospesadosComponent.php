<?php

namespace App\Http\Livewire\Bitacoravehiculospesados;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;
use App\Models\Vehiculos_pesados;
use App\Models\Bitacora_vehiculos_pesados;
use App\Models\Mecanico_Externo;
use App\Models\Mecanico_Interno;
use App\Models\Responsables;
use App\Models\Proveedores;
use App\Models\Factura;
use App\Models\Historialmantvehiculos;
use DB;

class BitacoraVehiculospesadosComponent extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $componentName;
    public $pageTitle;
    public $mec_i = [];
    public $mec_e = [];
    public $historial = [];
    public $search;
    public $vehiculos = [];
    public $responsable = [];
    public $provedor = [];
    public $Nombre_Vehiculo,$Responsable,$horometro,$Tipo_Servicio,$Mecanico,$Tipo_mecanico,$Proveedor,$Fecha_servicio,$Prox_fecha_serv; 
    public $comentario,$num_int;
    public $accion;
    public $monto;
    public $factura;
    public $vhl;
    public $rol;
    protected $paginationTheme = 'bootstrap'; 
    public $datos;
    public $val;
    public $subval;
    
    public function mount(){
        $this->componentName = 'Bitatcora';
        $this->pageTitle     = 'Maquinaria pesada';
     
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
                $this->vhl  = Bitacora_vehiculos_pesados::where('id',$this->val)->first()->num_int;

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
                $data = Bitacora_vehiculos_pesados::find($this->val);
   
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
        $tabla = Bitacora_vehiculos_pesados::orderBy('updated_at', 'desc');

        if (strlen($this->search) >1) {
            $tabla->where(function($query) {
                $query->where('Nombre_Vehiculo', 'like', '%' . $this->search . '%')
                      ->orWhere('Servicio', 'like', '%' . $this->search . '%')
                      ->orWhere('num_int', 'like', '%' . $this->search . '%');
            });
        }
        
        $tabla = $tabla->paginate(10);
        return view('livewire.bitacoravehiculospesados.bitacora-vehiculospesados-component',['table'=> $tabla])->extends('adminlte::page')->section('content');
    }


        public function editar()
    {
        $datos = Bitacora_vehiculos_pesados::find($this->val);
        $this->Nombre_Vehiculo = $datos->Nombre_Vehiculo;
        $this->num_int = $datos->num_int;
        $this->Placa = $datos->Placa;
        $this->horometro = $datos->horometro;
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
    public function Store(){

        $rule = [
            'Nombre_Vehiculo' => 'required',
            'num_int' => 'required',
            'horometro' => 'required',
            'Responsable' => 'required',
            'Tipo_Servicio' => 'required', 
            'Mecanico' => 'required',
            'Tipo_mecanico' => 'required', 
            'Proveedor' => 'required',
            'Fecha_servicio' => 'required',
            'Prox_fecha_serv' => 'required',

        ];

        $message = [
         'Nombre_Vehiculo.required'  =>   '**Este campo es obligatorio.**',
            'num_int.required' =>   '**Este campo es obligatorio.**',
            'horometro.required' =>   '**Este campo es obligatorio.**',
            'Responsable.required' =>   '**Este campo es obligatorio.**',
            'Tipo_Servicio.required' =>   '**Este campo es obligatorio.**', 
            'Mecanico.required' =>   '**Este campo es obligatorio.**',
            'Tipo_mecanico.required' =>   '**Este campo es obligatorio.**', 
            'Proveedor.required' =>   '**Este campo es obligatorio.**',
            'Fecha_servicio.required' =>   '**Este campo es obligatorio.**',
            'Prox_fecha_serv.required'=>   '**Este campo es obligatorio.**',
            
        ];
        $this->validate($rule, $message);

        DB::beginTransaction();

        try {
            $datos = new Bitacora_vehiculos_pesados();
            $datos->Nombre_Vehiculo =  $this->Nombre_Vehiculo;
            $datos->Responsable     = $this->Responsable;
            $datos->Tipo_Servicio = $this->Tipo_Servicio;
            $datos->Mecanico    = $this->Mecanico; 
            $datos->Tipo_mecanico = $this->Tipo_mecanico; 
            $datos->Proveedor = $this->Proveedor; 
            $datos->Fecha_servicio = $this->Fecha_servicio; 
            $datos->Prox_fecha_serv = $this->Prox_fecha_serv;
            $datos->horometro = $this->horometro; 
            $datos->Ruta    = 1; 
            $datos->num_int = $this->num_int;
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
            'Nombre_Vehiculo' => 'required',
            'num_int' => 'required',
            'horometro' => 'required',
            'Responsable' => 'required',
       

        ];

        $message = [
         'Nombre_Vehiculo.required'  =>   '**Este campo es obligatorio.**',
            'num_int.required' =>   '**Este campo es obligatorio.**',
            'horometro.required' =>   '**Este campo es obligatorio.**',
            'Responsable.required' =>   '**Este campo es obligatorio.**',
          
            
        ];
        $this->validate($rule, $message);

        DB::beginTransaction();

        try {
            Bitacora_vehiculos_pesados::where('id',$this->val)->update(
                [
                    'Nombre_Vehiculo' => $this->Nombre_Vehiculo,
                    'num_int' => $this->num_int,
                    'horometro' =>$this->horometro,
                    'Responsable' => $this->Responsable, 
                ]
            );
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

    public function Guardar(){
        $rule = [

            'Tipo_Servicio' => 'required', 
            'Mecanico' => 'required',
            'Tipo_mecanico' => 'required', 
            'Proveedor' => 'required',
            'Fecha_servicio' => 'required',
            'Prox_fecha_serv' => 'required',

        ];

        $message = [
            'Tipo_Servicio.required' =>   '**Este campo es obligatorio.**', 
            'Mecanico.required' =>   '**Este campo es obligatorio.**',
            'Tipo_mecanico.required' =>   '**Este campo es obligatorio.**', 
            'Proveedor.required' =>   '**Este campo es obligatorio.**',
            'Fecha_servicio.required' =>   '**Este campo es obligatorio.**',
            'Prox_fecha_serv.required'=>   '**Este campo es obligatorio.**',
            
        ];
        $this->validate($rule, $message);

        DB::beginTransaction();

        try {
            $data = new Historialmantvehiculos();
            $data->id_mant = $this->val;
            $data->tipo = 2;
            $data->fecha = date('Y-m-d');
            $data->servicio = $this->Tipo_Servicio;
            $data->proveedor = $this->Proveedor;
            $data->mecanico = $this->Mecanico;
            $data->taller = 0;
            $data->t_mecanico = $this->Tipo_mecanico;
            $data->km_anterior = $this->Fecha_servicio;
            $data->km_actual = $this->Prox_fecha_serv;
            $data->save();

            Bitacora_vehiculos_pesados::where('id',$this->val)->update([
            'Tipo_Servicio' => $this->Tipo_Servicio, 
            'Mecanico' => $this->Mecanico,
            'Tipo_mecanico' => $this->Tipo_mecanico, 
            'Proveedor' => $this->Proveedor,
            'Fecha_servicio' => $this->Fecha_servicio,
            'Prox_fecha_serv' => $this->Prox_fecha_serv
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
    public function historiales(){
        $this->historial = Historialmantvehiculos::where('id_mant',$this->val)->where('tipo',2)->get();
        $this->emit('show-modal');
    }
    public function delete($id){
        Bitacora_vehiculos_pesados::where('id',$id)->delete();
        $this->emit('success', 'Se elimino el documento');
    }
    public function eliminar_ser($id){

        Historialmantvehiculos::where('id',$id)->delete();
        $this->emit('success', 'Se elimino el servicio');
    }
    public function  editar_monto($id,$text){
        Factura::where('id',$id)->update(['monto'=> $text]);
      }
    public function provedor($id)
    {
        $dato = Proveedores::find($id);
        return $dato->Nombre_Proveedor;
    }
    public function delete_img($id)
    {
        $dato = Factura::find($id);

       
                Storage::delete('public/assets/vehiculos/factura/'.$dato->Archivo);
                Factura::where('id',$id)->delete();
         
       
        $this->emit('success', 'Se Elimino el dato');

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
           $v = Bitacora_vehiculos_pesados::where('id',$this->val)->first()->num_int;
           $docs = new Factura();
           $docs->monto = $this->monto;
           $docs->Vh_ligado = $v;
           $docs->id_lig = $this->val;
           $docs->tfactura = $this->subval;
           $docs->Archivo = $name;
           $docs->fecha = date('Y-m-d');
           $docs->hora = date('h:i:s');
           $docs->iden = 2;
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
    public function resetUI(){
        $this->Nombre_Vehiculo = '';
        $this->Responsable = '';
        $this->horometro = '';
        $this->Tipo_Servicio = '';
        $this->Mecanico = '';
        $this->Tipo_mecanico = '';
        $this->Proveedor = '';
        $this->Fecha_servicio = '';
        $this->Prox_fecha_serv = '';
        $this->comentario = '';
        $this->num_int = '';
        $this->accion = '';
        $this->monto = '';
        $this->factura = '';
        $this->datos = '';
        $this->val = '';
        $this->subval = '';

    }
    public function resetUII()
    {
        $this->monto = '';
        $this->factura = '';
        
    }
}
