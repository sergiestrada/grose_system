<?php

namespace App\Http\Livewire\Vehiculospresados;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;
use Livewire\Component;
use App\Models\Vehiculos_pesados;
use App\Models\Documentos;

use DB;

class VehiculosPesadosComponent extends Component
{
    use WithFileUploads;
    public $componentName;
    public $pageTitle;
    public $tabla   = [];
    public $imagen = [];
    public $documentos   = [];
    public $contador = 1;
    public $Marca, $Modelo, $No_Serie, $Ano, $Poliza, $Tipo, $Comentarios, $Ruta, $numint;
    public $val;
    public $tipo_doc = 1;
    public $factura;
    public $accion;
    public $rol;



    public function mount()
    {
        $this->componentName = 'Configuracion';
        $this->pageTitle     = 'Vehiculos';
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
        $datos = Vehiculos_pesados::find($this->val);
        $this->numint = $datos->numint;
        $this->Marca  = $datos->Marca;
        $this->Modelo = $datos->Modelo;
        $this->No_Serie = $datos->No_Serie;
        $this->Ano = $datos->Ano;
        $this->Poliza = $datos->Poliza;
        $this->Tipo = $datos->Tipo;
        $this->Comentarios = $datos->Comentarios;


        $this->emit('show-modal');
    }

    public function render()
    {
        $this->tabla = Vehiculos_pesados::where('Ruta',1)->get();
        return view('livewire.vehiculospresados.vehiculos-pesados-component',['tabla', $this->tabla])->extends('adminlte::page')->section('content');
    }
     public function Store()
    {
        $rule = [
            'numint' => 'required',
            'Marca'  => 'required',
            'Ano' => 'required',
            'Modelo' => 'required',
            'Tipo'        => 'required',
            'No_Serie' => 'required',
            'Poliza'        => 'required',
            
        ];

        $message = [
            'numint.required'   =>   '**Este campo es obligatorio.**',
            'Ano.required'      =>   '**Este campo es obligatorio.**',
            'Modelo.required'   =>   '**Este campo es obligatorio.**',
            'Tipo.required'     =>   '**Este campo es obligatorio.**',
            'Poliza.required' =>   '**Este campo es obligatorio.**',
            'Kilometraje.required'  =>   '**Este campo es obligatorio.**',
            
        ];

        $this->validate($rule, $message);

        DB::beginTransaction();

        try {
            $datos = new Vehiculos_pesados();
            $datos->numint     = $this->numint;
            $datos->Marca      = $this->Marca;
            $datos->Modelo     = $this->Modelo;
            $datos->No_Serie   = $this->No_Serie;
            $datos->Ano        = $this->Ano;
            $datos->Tipo       = $this->Tipo;
            $datos->Poliza     = $this->Poliza;
            $datos->ruta       = 1;
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
    public function subir_documento()
    {
     
       
         $rule = [
            'factura' => 'required|max:2048',
            'tipo_doc'  => 'required' // Ejemplo: Acepta archivos PDF de hasta 2MB
        ];

        $message = [
            'factura.required' => '**Este campo es obligatorio.**',
            'tipo_doc.required' => '**Este campo es obligatorio.**',
        ];
        $this->validate($rule, $message);
        DB::beginTransaction();

        try {
            $name = $this->factura->getClientOriginalName();
            switch($this->tipo_doc)
            {
                case 1:
                    $salvar = $this->factura->storeAs('public/assets/vehiculos_pesado/polizas',$name);
                    break;
                case 2:
                    $salvar = $this->factura->storeAs('public/assets/vehiculos_pesado/factura',$name);
                    break;
                case 3:
                    $salvar = $this->factura->storeAs('public/assets/vehiculos_pesado/manual',$name);
                     break;
                 case 4:
                    $salvar = $this->factura->storeAs('public/assets/vehiculos_pesado/foto',$name);
                    break;
                case 5:
                    $salvar = $this->factura->storeAs('public/assets/vehiculos_pesado/tarjeta',$name);
                    break;
    
    
            }
           $docs = new Documentos();
           $docs->Id_doc = $this->val;
           $docs->T_doc =  $this->tipo_doc; 
           $docs->Iden   =  2;
           $docs->Doc   = $name;
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
    public function Update()
    {
        $rule = [
            'numint' => 'required',
            'Marca'  => 'required',
            'Ano' => 'required',
            'Modelo' => 'required',
            'Tipo'        => 'required',
            'No_Serie' => 'required',
            'Poliza'        => 'required',
        ];

        $message = [
            'numint.required'   =>   '**Este campo es obligatorio.**',
            'Ano.required'      =>   '**Este campo es obligatorio.**',
            'Modelo.required'   =>   '**Este campo es obligatorio.**',
            'Tipo.required'     =>   '**Este campo es obligatorio.**',
            'Poliza.required' =>   '**Este campo es obligatorio.**',
            'Kilometraje.required'  =>   '**Este campo es obligatorio.**',
        ];

        $this->validate($rule, $message);

        DB::beginTransaction();

        try {
            Vehiculos_pesados::where('id', $this->val)->update([
                'numint'     => $this->numint,
                'Marca'      => $this->Marca,
                'Modelo'     => $this->Modelo,
                'No_Serie'   => $this->No_Serie,
                'Ano'        => $this->Ano,
                'Tipo'       => $this->Tipo,
                'Poliza'     => $this->Poliza,
                'Comentarios' => $this->Comentarios
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
    public function Archivos()
    {
        $this->documentos   = Documentos::where('Id_doc', $this->val)->where('Iden',2)->get();
        $this->imagen  = Documentos::where('Id_doc', $this->val)->where('Iden',2)->where('T_doc', 4)->get();
        $this->emit('show-modal');
    }

    public function delete_img($id)
    {
        $dato = Documentos::find($id);

        switch($dato->T_doc){
            case 1:
                Storage::delete('public/assets/vehiculos/polizas/'.$dato->Doc);
                Documentos::where('id',$id)->delete();
                break;
            case 2:
                Storage::delete('public/assets/vehiculos/factura/'.$dato->Doc);
                Documentos::where('id',$id)->delete();
                break;
            case 3:
                Storage::delete('public/assets/vehiculos_pesado/manual/'.$dato->Doc);
                Documentos::where('id',$id)->delete();
                break;
            case 4:
                Storage::delete('public/assets/vehiculos_pesado/foto/'.$dato->Doc);
                Documentos::where('id',$id)->delete();
                break;
            case 5:
                Storage::delete('public/assets/vehiculos_pesado/tarjeta/'.$dato->Doc);
                Documentos::where('id',$id)->delete();
                 break;
    
        }
       
        $this->emit('success', 'Se Elimino el dato');

    }
    public function delete($id){
        Documentos::where('Id_doc',$id)->delete();
        Vehiculos_pesados::where('id',$id)->update(['Ruta'=>0]);
         $doc = Documentos::where('Id_doc',$id)->get();
         foreach($doc as $val){
           $this->delete_img($val->id);
         }
         $this->emit('success', 'Se Elimino el dato');
      }
    public function resetUI()
    {
     $this->documentos   = [];
     $this->Marca   = '';
     $this->Modelo  = '';
     $this->No_Serie= '';
     $this->Ano     = '';
     $this->Poliza  = '';
     $this->Tipo    = '';
     $this->Comentarios = '';
     $this->Ruta    = '';
     $this->numint  = '';
     $this->val     = '';
     $this->tipo_doc = 1;
     $this->factura = '';
     $this->accion  = '';
    }
}
