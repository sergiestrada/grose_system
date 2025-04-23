<?php

namespace App\Http\Livewire\Herramientasmedicion;

use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;
use App\Models\Medicion;
use App\Models\Manuales;
use App\Models\Categoria_medicion;
use DB;

class HerramientasMedicionComponent extends Component
{
    use WithFileUploads;
     public $componentName;
     public $pageTitle;
     public $factura;
     public $categorias = [];
     public $imagen = [];
     public $documentos = [];
     public $rol;
     public  $contador = 1;
     public $codigo, $cantidad, $instrumento, $descripcion, $status, $codigob, $modelo, $clasificacion;
     public $val;
     public $accion;



     public function mount()
     {
         $this->componentName = 'Configuracion';
         $this->pageTitle     = 'Medicion';
         $this->categorias    = Categoria_medicion::all();
         $this->rol = Auth::user()->rol;
     
     }
     public function accion($opc, $val)
     {
         
        $this->accion = $opc;
         $this->val = $val;
         switch ($opc) {
             case 0:
                 $this->Archivos();
                 break;
             case 1:
                 $this->crear();
                 break;
             case 2:
                 $this->editar();
                 break;
             case 3:
                 $this->emit('show-modal');
                 break;
         }
     }
     public function crear()
     {
         $this->emit('show-modal');
     }
     public function editar()
     {
         $datos = Medicion::find($this->val);
         $this->codigo = $datos->codigo;
         $this->codigob = $datos->codigob;
         $this->modelo = $datos->modelo;
         $this->instrumento = $datos->instrumento;
         $this->descripcion = $datos->descripcion;
         $this->clasificacion = $datos->clasificacion;

         $this->emit('show-modal');
     }
    public function render()
    {
        $this->tabla = Medicion::where('status',1)->get();
        return view('livewire.herramientasmedicion.herramientas-medicion-component',['tabla', $this->tabla])->extends('adminlte::page')->section('content');
    }

    public function Store()
    {
        $rule = [
            'codigo' => 'required',
            'codigob' => 'required',
            'modelo' => 'required',
            'instrumento' => 'required',
            'clasificacion'        => 'required',
        
        ];

        $message = [
            'codigo.required'   =>   '**Este campo es obligatorio.**',
            'codigob.required'   =>   '**Este campo es obligatorio.**',
            'modelo.required'      =>   '**Este campo es obligatorio.**',
            'instrumento.required'    =>   '**Este campo es obligatorio.**',
            'clasificacion.required'     =>   '**Este campo es obligatorio.**',
        ];

        $this->validate($rule, $message);

        DB::beginTransaction();

        try {
            $datos = new Medicion();
            $datos->codigo  = $this->codigo;
            $datos->codigob     = $this->codigob;
            $datos->modelo      = $this->modelo;
            $datos->instrumento     = $this->instrumento;
            $datos->descripcion   = $this->descripcion;
            $datos->clasificacion        = $this->clasificacion;
            $datos->status = 1;
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
            'codigo' => 'required',
            'codigob' => 'required',
            'modelo' => 'required',
            'instrumento' => 'required',
          
            'clasificacion'        => 'required',
        
        ];

        $message = [
            'codigo.required'   =>   '**Este campo es obligatorio.**',
            'codigob.required'   =>   '**Este campo es obligatorio.**',
            'modelo.required'      =>   '**Este campo es obligatorio.**',
            'instrumento.required'    =>   '**Este campo es obligatorio.**',
            'clasificacion.required'     =>   '**Este campo es obligatorio.**',
        ];


        $this->validate($rule, $message);

        DB::beginTransaction();

        try {
                Medicion::where('id', $this->val)->update([
                'codigo'  => $this->codigo,
                'codigob'     => $this->codigob,
                'modelo'       => $this->modelo,
                'instrumento'      => $this->instrumento,
                'descripcion'    => $this->descripcion,
                'clasificacion'         => $this->clasificacion,
              
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
    public function subir_documento()
    {
     
       
         $rule = [
            'factura' => 'required|max:2048',
       
        ];

        $message = [
            'factura.required' => '**Este campo es obligatorio.**',
         
        ];
        $this->validate($rule, $message);
        DB::beginTransaction();

        try {
           $name = $this->factura->getClientOriginalName();
           $this->factura->storeAs('public/assets/manuales/',$name);
           $docs = new Manuales();
           $docs->lig = $this->val;
           $docs->Manual =  $name; 
           $docs->fecha   =  date('Y-m-d');
            $docs->save();
                
           
            DB::commit();
            $this->emit('success', 'Se subio  el archivo');
        } catch (\Exception $e) {
            DB::rollBack();
            // Registrar cualquier excepción en los logs
            \Log::error('Error al guardar el origen: ' . $e->getMessage());
            // Emitir un mensaje de error
            $this->emit('error', 'Ocurrió un error al subir el archivo.' . $e->getMessage());
        }
    }
    public function delete_img($id)
    {
        $dato = Manuales::find($id);
        Storage::delete('public/assets/manuales/'.$dato->Manual);
        Manuales::where('id',$id)->delete();                 
        $this->emit('success', 'Se Elimino el dato');

    }
    public function delete($id){
        Manuales::where('lig',$id)->delete();
        Medicion::where('id',$id)->delete();
         $doc = Manuales::where('lig',$id)->get();
             foreach($doc as $val){
           $this->delete_img($val->id);
        
         }
         $this->emit('success', 'Se Elimino el dato');
      }
    public function Archivos()
    {
        $this->documentos   = Manuales::where('lig', $this->val)->get();       
        $this->emit('show-modal');
    }
    public function resetUI()
    {
       $this->imagen = [];
       $this->factura = '';
       $this->documentos = []; 
       $this->codigo = '';
       $this->cantidad = '';
       $this->instrumento = '';
       $this->descripcion = '';
       $this->codigob = '';
       $this->modelo = '';
       $this->clasificacion = '';
       $this->val = '';
       $this->accion = '';
    }
}
