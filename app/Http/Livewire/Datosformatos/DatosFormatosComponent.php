<?php

namespace App\Http\Livewire\Datosformatos;

use Livewire\Component;

use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use App\Models\Categoria_medicion;
use App\Models\Medicion;
use App\Models\Descripcion_medicion;
use App\Models\Imagenes_medicion;
use App\Models\Formato;

use DB;

class DatosFormatosComponent extends Component
{
   use WithFileUploads;
    public $Descripcion, $ID_Resp, $Cantidad, $tipo;
    public $categorias =  [];
    public $imagenes =  [];
    public $idx;
    public $descripciones = [];
    public $componentName;
    public $pageTitle;
    public $factura;
    public $rol;

    public function mount($id)
    {
      $this->idx = $id;
      $this->categorias = Categoria_medicion::where('estatus',1)->get();
      $this->descripciones  = Descripcion_medicion::where('ID_Resp',$id)->get();
      $this->imagenes   = Imagenes_medicion::where('Resp',$id)->get();
      $this->componentName = 'Formatos';
      $this->pageTitle  = Formato::find($id)->Nombre;
      $this->rol = Auth::user()->rol;

    }
    public function render()
    {
        return view('livewire.datosformatos.datos-formatos-component')->extends('adminlte::page')->section('content');
    }

    public function Save()
    {
      
       
        $rule = [
            'Cantidad' => 'required',
            'tipo' => 'required',
            
        ];

        $message = [
            'Cantidad.required'  =>   '**Este campo es obligatorio.**',
            'tipo.required'  =>   '**Este campo es obligatorio.**',
        
           
        ];

        $this->validate($rule, $message);

        DB::beginTransaction();

        try {
            $desc = Categoria_medicion::where('id',$this->tipo)->first()->categoria;
            $datos = new Descripcion_medicion();
            $datos->ID_Resp  = $this->idx;
            $datos->Cantidad     = $this->Cantidad;
            $datos->Descripcion  = $desc;
            $datos->tipo         = $this->tipo;
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
    public function Subir()
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
           $this->factura->storeAs('public/assets/images/',$name);
           $docs = new Imagenes_medicion();
           $docs->Dir = $name;
           $docs->Resp =  $this->idx; 
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
    public function delete($id){
       
        Descripcion_medicion::where('id',$id)->delete();
        $this->emit('success', 'Se elimino el dato');
    }
    public function delete_img($id)
    {
        $dato = Imagenes_medicion::find($id);
          Storage::delete('public/assets/images'.$dato->Dir);
           Imagenes_medicion::where('id',$id)->delete();
                                  
        $this->emit('success', 'Se Elimino el dato');

    }

    public function resetUI(){
     $this->Descripcion = '';
     $this->ID_Resp = '';
     $this->Cantidad = '';
     $this->tipo  = '';
     $this->categorias =  [];
     $this->imagenes =  [];
     $this->descripciones = [];
    $this->factura = '';
    }
}
