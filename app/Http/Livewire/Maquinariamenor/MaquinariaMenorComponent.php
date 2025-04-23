<?php

namespace App\Http\Livewire\Maquinariamenor;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;
use Livewire\Component;
use App\Models\Maquinaria;
use App\Models\Documentos;

use DB;



class MaquinariaMenorComponent extends Component
{

    use WithFileUploads;
    public $componentName;
    public $pageTitle;
    public $tabla   = [];
    public $imagen = [];
    public $documentos   = [];
    public $contador = 1;
    public $Nombre_Id, $Marca, $Modelo, $No_Serie, $Ano, $Color, $Kilometraje, $Placa, $Poliza, $Tipo, $Comentarios, $Ruta, $numint;
    public $val;
    public $tipo_doc = 1;
    public $factura;
    public $accion;
    public $rol;

    public function mount()
    {
        $this->componentName = 'Configuracion';
        $this->pageTitle     = 'Maquinaria';
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
        
        $datos = Maquinaria::find($this->val);
        $this->Nombre_Id    = $datos->Nombre_Id;
        $this->numint = $datos->numint;
        $this->Marca  = $datos->Marca;
        $this->Modelo = $datos->Modelo;
        $this->No_Serie = $datos->No_Serie;
        $this->Color = $datos->Color;
        $this->Ano = $datos->Ano;
        $this->Tipo = $datos->Tipo;
        $this->Comentarios = $datos->Comentarios;

        $this->emit('show-modal');
    }
    public function render()
    {
        $this->tabla = Maquinaria::all();
        return view('livewire.maquinariamenor.maquinaria-menor-component',['tabla', $this->tabla])->extends('adminlte::page')->section('content');
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
            'Nombre_Id'        => 'required',
            'Color'     => 'required',
           
        ];

        $message = [
            'Nombre_Id.required'   =>   '**Este campo es obligatorio.**',
            'numint.required'   =>   '**Este campo es obligatorio.**',
            'Marca.required'    =>   '**Este campo es obligatorio.**',
            'Ano.required'      =>   '**Este campo es obligatorio.**',
            'Modelo.required'   =>   '**Este campo es obligatorio.**',
            'Tipo.required'     =>   '**Este campo es obligatorio.**',
          
            'Color.required'    => '**Este campo es obligatorio.**',
          
        ];

        $this->validate($rule, $message);

        DB::beginTransaction();

        try {
            $datos = new Maquinaria();
            $datos->Nombre_Id  = $this->Nombre_Id;
            $datos->numint     = $this->numint;
            $datos->Marca      = $this->Marca;
            $datos->Modelo     = $this->Modelo;
            $datos->No_Serie   = $this->No_Serie;
            $datos->Ano        = $this->Ano;
			$datos->Color = $this->Color;
            $datos->Tipo       = $this->Tipo;
          
            $datos->Ruta      = 1;
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
                    $salvar = $this->factura->storeAs('public/assets/maquinaria/polizas',$name);
                    break;
                case 2:
                    $salvar = $this->factura->storeAs('public/assets/maquinaria/factura',$name);
                    break;
                case 3:
                    $salvar = $this->factura->storeAs('public/assets/maquinaria/manual',$name);
                     break;
                 case 4:
                    $salvar = $this->factura->storeAs('public/assets/maquinaria/foto',$name);
                    break;
                case 5:
                    $salvar = $this->factura->storeAs('public/assets/maquinaria/tarjeta',$name);
                    break;
    
    
            }
           $docs = new Documentos();
           $docs->Id_doc = $this->val;
           $docs->T_doc =  $this->tipo_doc; 
           $docs->Iden   =  3;
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
            'Nombre_Id'        => 'required',
            'Color'     => 'required',
            'Comentarios'      => 'required',
        ];

        $message = [
            'Nombre_Id.required'   =>   '**Este campo es obligatorio.**',
            'numint.required'   =>   '**Este campo es obligatorio.**',
            'Marca.required'    =>   '**Este campo es obligatorio.**',
            'Ano.required'      =>   '**Este campo es obligatorio.**',
            'Modelo.required'   =>   '**Este campo es obligatorio.**',
            'Tipo.required'     =>   '**Este campo es obligatorio.**',
            'Poliza.required' =>   '**Este campo es obligatorio.**',
            'Color.required'    => '**Este campo es obligatorio.**',
            'Comentarios.required'  =>   '**Este campo es obligatorio.**',
        ];


        $this->validate($rule, $message);

        DB::beginTransaction();

        try {
            Maquinaria::where('id', $this->val)->update([
                'Nombre_Id'  => $this->Nombre,
                'numint'     => $this->numint,
                'Marca'       => $this->Marca,
                'Modelo'      => $this->Modelo,
                'No_Serie'    => $this->No_Serie,
                'Ano'         => $this->Ano,
                'Color'       => $this->Color,
                'Tipo'        => $this->Tipo,
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
        $this->documentos   = Documentos::where('Id_doc', $this->val)->where('Iden',3)->get();
        $this->imagen  = Documentos::where('Id_doc', $this->val)->where('Iden',3)->where('T_doc', 4)->get();
        $this->emit('show-modal');
    }

    public function delete_img($id)
    {
        $dato = Documentos::find($id);

        switch($dato->T_doc){
            case 1:
                Storage::delete('public/assets/maquinaria/polizas/'.$dato->Doc);
                Documentos::where('id',$id)->delete();
                break;
            case 2:
                Storage::delete('public/assets/maquinaria/factura/'.$dato->Doc);
                Documentos::where('id',$id)->delete();
                break;
            case 3:
                Storage::delete('public/assets/maquinaria/manual/'.$dato->Doc);
                Documentos::where('id',$id)->delete();
                break;
            case 4:
                Storage::delete('public/assets/maquinaria/foto/'.$dato->Doc);
                Documentos::where('id',$id)->delete();
                break;
            case 5:
                Storage::delete('public/assets/maquinaria/tarjeta/'.$dato->Doc);
                Documentos::where('id',$id)->delete();
                 break;
    
        }
       
        $this->emit('success', 'Se Elimino el dato');

    }
    public function delete($id){
        Documentos::where('Id_doc',$id)->delete();
        Maquinaria::where('id',$id)->delete();
         $doc = Documentos::where('Id_doc',$id)->get();
         foreach($doc as $val){
           $this->delete_img($val->id);
         }
         $this->emit('success', 'Se Elimino el dato');
      }
    public function resetUI()
    {
     $this->documentos  = [];
     $this->Nombre_Id   = '';
     $this->Marca   = '';
     $this->Modelo  = '';
     $this->No_Serie = '' ;
     $this->Ano     = ''; 
     $this->Color   = ''; 
     $this->Kilometraje = ''; 
     $this->Placa   = '' ;
     $this->Poliza  = ''; 
     $this->Tipo        = ''; 
     $this->Comentarios = '';
     $this->Ruta    = '' ;
     $this->numint  = '';
     $this->accion  = '';
    }
}

