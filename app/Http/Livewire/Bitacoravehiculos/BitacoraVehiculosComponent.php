<?php

namespace App\Http\Livewire\Bitacoravehiculos;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use App\Models\Bitacora_vehiculos;
use App\Models\Mecanico_Externo;
use App\Models\Mecanico_Interno;
use App\Models\Responsables;
use App\Models\Proveedores;
use App\Models\Vehiculos;
use App\Models\Factura;
use App\Models\Historialmantvehiculos;
use DB;


class BitacoraVehiculosComponent extends Component
{

    use WithPagination;
    use WithFileUploads;
    public $componentName;
    public $pageTitle;
    public $costos = [];
    public $search;
    public $historial = [];
    public $vehiculos = [];
    public $responsable = [];
    public $provedor = [];
    public $mec_i = [];
    public $mec_e = [];
    public $Nombre_Vehiculo, $Placa, $Kilometraje, $Responsable,$Tipo_Servicio, $Mecanico, $Tipo_mecanico, $Proveedor, $Fecha_servicio;
    public $Prox_Fecha_Serv, $Comentarios;
    protected $paginationTheme = 'bootstrap'; 
    public $num_int, $revision, $medida;
    public $monto;
    public $vhl;
    public $factura;
    public $datos;
    public $val;
    public $rol;
    public $subval;
    public $accion;

    public function mount()
    {
        $this->componentName = 'Bitatcora';
        $this->pageTitle     = 'Vehiculos';
        $this->vehiculos    = Vehiculos::all();
       
        $this->mec_e = Mecanico_Externo::all();
        $this->mec_i = Mecanico_Interno::all();
        $this->provedor = Proveedores::all();
        $this->responsable = Responsables::all();
        $this->costos   =   DB::select('select distinct Vh_ligado  from factura ');
        $this->Fecha_servicio = date('Y-m-d');
        $this->rol = Auth::user()->rol;
    }
    public function accion($opc, $val)
    {
        $this->accion = $opc;
        $this->val = $val;

        switch ($opc) {
            case 0:
                $this->historial = Historialmantvehiculos::where('id_mant',$this->val)->where('tipo',1)->get();
                $this->vhl  = Bitacora_vehiculos::where('id',$this->val)->first()->num_int;
            
                $this->emit('show-modal');
               
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
            case 5:
                    $this->emit('show-modal');
                    break;
            case 8:
                $data = Bitacora_vehiculos::find($this->val);
                $this->revision = $data->Kilometraje;

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
     // Obtén la tabla ordenada por 'updated_at' en orden descendente
$tabla = Bitacora_vehiculos::all();



        return view('livewire.bitacoravehiculos.bitacora-vehiculos-component',['tabla'=> $tabla])->extends('adminlte::page')->section('content');
    }
    public function historiales(){
        $this->historial = Historialmantvehiculos::where('id_mant',$this->val)->where('tipo',1)->get();
        $this->emit('show-modal');
    }
    public function editar()
    {
        $datos = Bitacora_vehiculos::find($this->val);
        $this->Nombre_Vehiculo = $datos->Nombre_Vehiculo;
        $this->num_int = $datos->num_int;
        $this->Placa = $datos->Placa;
        $this->Kilometraje = $datos->Kilometraje;
        $this->Responsable = $datos->Responsable;
        $this->Tipo_Servicio = $datos->Tipo_Servicio;
        $this->Mecanico = $datos->Mecanico;
        $this->Tipo_mecanico = $datos->Tipo_mecanico;
        $this->Proveedor = $datos->Proveedor;
        $this->revision = $datos->revision;
        $this->Prox_Fecha_Serv = $datos->Prox_Fecha_Serv;
        $this->Comentarios = $datos->Comentarios;
        $this->emit('show-modal');
    }
    
    public function Store()
    {
        
        $rule = [

            'Nombre_Vehiculo' => 'required',
            'num_int' => 'required',
            'Placa' => 'required',
            'Kilometraje' => 'required',
            'Responsable' => 'required',
            'Tipo_Servicio' => 'required', 
            'Mecanico' => 'required',
            'Tipo_mecanico' => 'required', 
            'Proveedor' => 'required',
           
            'revision' => 'required',
            'Prox_Fecha_Serv' => 'required',

        ];

        $message = [
         'Nombre_Vehiculo.required'  =>   '**Este campo es obligatorio.**',
            'num_int.required' =>   '**Este campo es obligatorio.**',
            'Placa.required'  =>   '**Este campo es obligatorio.**',
            'Kilometraje.required' =>   '**Este campo es obligatorio.**',
            'Responsable.required' =>   '**Este campo es obligatorio.**',
            'Tipo_Servicio.required' =>   '**Este campo es obligatorio.**', 
            'Mecanico.required' =>   '**Este campo es obligatorio.**',
            'Tipo_mecanico.required' =>   '**Este campo es obligatorio.**', 
            'Proveedor.required' =>   '**Este campo es obligatorio.**',
            'revision.required' =>   '**Este campo es obligatorio.**',
            'Prox_Fecha_Serv.required'=>   '**Este campo es obligatorio.**',
           
            
        ];

        $this->validate($rule, $message);

        DB::beginTransaction();

        try {
         $datos = new Bitacora_vehiculos();
        $datos->Nombre_Vehiculo = $this->Nombre_Vehiculo;
        $datos->num_int  =  $this->num_int;
        $datos->Placa   = $this->Placa;
        $datos->Kilometraje = $this->Kilometraje;
        $datos->Responsable = $this->Responsable;
        $datos->Tipo_Servicio = $this->Tipo_Servicio;
        $datos->Mecanico =  $this->Mecanico;
        $datos->Tipo_mecanico = $this->Tipo_mecanico;
        $datos->Proveedor = $this->Proveedor;
        $datos->medida  = 'Km';
        $datos->Fecha_servicio = $this->revision;
        $datos->revision = $this->revision;
        $datos->Prox_Fecha_Serv = $this->Prox_Fecha_Serv;
        $datos->Comentarios = $this->Comentarios;
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


    public function Guardar()
    {
       
            $data = new Historialmantvehiculos();
            $data->id_mant = $this->val;
            $data->tipo = 1;
            $data->fecha = date('Y-m-d');
            $data->servicio = $this->Tipo_Servicio;
            $data->proveedor = $this->Proveedor;
            $data->mecanico = $this->Mecanico;
            $data->taller = 0;
            $data->t_mecanico = $this->Tipo_mecanico;
            $data->comentario = $this->Comentarios;
            $data->km_anterior = $this->revision;
            $data->km_actual = $this->Prox_Fecha_Serv;
            $data->save();

            Bitacora_vehiculos::where('id', $this->val)->update([
               
               
                'Tipo_Servicio' => $this->Tipo_Servicio,
                'Mecanico' =>  $this->Mecanico,
                'Tipo_mecanico' => $this->Tipo_mecanico,
                'Proveedor' => $this->Proveedor,
                'Fecha_servicio' =>$this->revision,
                'revision' => $this->revision,
                'Prox_Fecha_Serv' => $this->Prox_Fecha_Serv,
                'Comentarios' => $this->Comentarios
            ]);

            DB::commit();
            $this->emit('success', 'Se agrego el dato');
      
    }

    public function Update(){
        $rule = [

            'Kilometraje' => 'required',
            'num_int' => 'required', 'Nombre_Vehiculo' => 'required',
            'Nombre_Vehiculo' => 'required',
            'Placa' => 'required', 'Nombre_Vehiculo' => 'required',
           

        ];

        $message = [

            'Kilometraje.required'   =>   '**Este campo es obligatorio.**',
            'num_int.required'   =>   '**Este campo es obligatorio.**',
            'Nombre_Vehiculo.required'   =>   '**Este campo es obligatorio.**',
            'Placa.required'   =>   '**Este campo es obligatorio.**',
           

        ];
        $this->validate($rule, $message);

        DB::beginTransaction();
        try {
            $datos = Bitacora_vehiculos::where('id',$this->val)->update(
          [
            'Responsable' => $this->Responsable,
                'Nombre_Vehiculo' => $this->Nombre_Vehiculo,
                'num_int'  =>  $this->num_int,
                'Placa'   => $this->Placa,
                'Kilometraje' => $this->Kilometraje
          ]);
          DB::commit();
          $this->emit('success', 'Se Edito el dato');
      } catch (\Exception $e) {
          DB::rollBack();
          // Registrar cualquier excepción en los logs
          \Log::error('Error al guardar el origen: ' . $e->getMessage());
          // Emitir un mensaje de error
          $this->emit('error', 'Ocurrió un error al editar el dato.' . $e->getMessage());
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
            
         $v = Bitacora_vehiculos::where('id',$this->val)->first()->num_int;
           $docs = new Factura();
           $docs->tfactura = 0;
           $docs->monto = $this->monto;
           $docs->Vh_ligado = $v;
           $docs->id_lig = $this->val;
           $docs->tfactura = $this->subval;
           $docs->Archivo = $name;
           $docs->fecha = date('Y-m-d');
           $docs->hora = date('h:i:s');
           $docs->iden = 1;
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
    
        if ($id == 1) {
            $mecanico = Mecanico_Interno::where('id', $mec)
                ->selectRaw("CONCAT(Nombre, ' ', Apellido_P, ' ', Apellido_M) as nombrex")
                ->first();
        } else {
            $mecanico = Mecanico_Externo::where('id', $mec)
                ->selectRaw("CONCAT(Nombre, ' ', Apellido_P, ' ', Apellido_M) as nombrex")
                ->first();
        }
    
        // Verificar si $mecanico no es nulo antes de acceder a sus propiedades
        if ($mecanico) {
            $dato = $mecanico->nombrex;
        } else {
            // Puedes manejar el caso de que no se encuentre ningún registro según lo necesario
            $dato = 'No se encontró mecánico';
        }
    
        return $dato;
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
    public function delete($id){
        Bitacora_vehiculos::where('id',$id)->delete();
        $this->emit('success', 'Se elimino el documento');
    }
    public function eliminar_ser($id){

        Historialmantvehiculos::where('id',$id)->delete();
        $this->emit('success', 'Se elimino el servicio');
    }
    public function costox($id)
    {
        $dato = '';
        $dato =   Factura::where('Vh_ligado', $id)->sum('monto');
        return '$ ' . number_format($dato, 2);
    }
   public function  editar_monto($id,$text){
      Factura::where('id',$id)->update(['monto'=> $text]);
    }
    public function resetUI()
    {
        $this->Nombre_Vehiculo = '';
        $this->Placa = '';
        $this->Kilometraje = '';
        $this->Responsable = '';
        $this->Tipo_Servicio = '';
        $this->Mecanico = '';
        $this->Tipo_mecanico = '';
        $this->Proveedor = '';
        $this->Fecha_servicio = '';
        $this->Prox_Fecha_Serv = '';
        $this->Comentarios = '';
        $this->num_int = '';
        $this->revision = '';
        $this->medida = '';
        $this->val = '';
        $this->accion = '';
    }
    public function resetUII()
    {
        $this->monto = '';
        $this->factura = '';
        
    }
}
