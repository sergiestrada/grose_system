<?php

namespace App\Http\Livewire\Vehiculos;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;
use Livewire\Component;
use App\Models\Vehiculos;
use App\Models\Documentos;

use DB;


class VehiculosComponent extends Component
{
    use WithFileUploads;
    public $componentName;
    public $pageTitle;
    public $tabla   = [];
    public $imagen = [];
    public $documentos   = [];
    public $contador = 1;
    public $Nombre, $numint, $Marca, $Modelo, $No_Serie, $Ano, $Color, $Kilometraje, $Placa, $tc, $Tipo, $Ruta = 1, $Comentarios;
    public $afianzadora,$vigencia_fianza, $no_gps, $estatus_gsp, $no_motor,$Poliza;
    public $val;
    public $tipo_doc = 1;
    public $rol;
    public $factura;
    public $accion;

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
        $datos = Vehiculos::find($this->val);
        $this->Nombre = $datos->Nombre_Id;
        $this->numint = $datos->numint;
        $this->Marca = $datos->Marca;
        $this->Modelo = $datos->Modelo;
        $this->No_Serie = $datos->No_Serie;
        $this->Ano = $datos->Ano;
        $this->Color = $datos->Color;
        $this->Kilometraje = $datos->Kilometraje;
        $this->Placa     = $datos->Placa;
        $this->tc = $datos->tc;
        $this->Tipo = $datos->Tipo;
        $this->afianzadora = $datos->afianzadora;
        $this->vigencia_fianza = $datos->vigencia_fianza;  
        $this->no_gps = $datos->no_gps; 
        $this->estatus_gsp = $datos->estatus_gsp;  
        $this->no_motor = $datos->no_motor; 
        $this->Poliza = $datos->Poliza ;
        $this->Comentarios = $datos->Comentarios;


        $this->emit('show-modal');
    }

    public function render()
    {
        $this->tabla = Vehiculos::where('Ruta',1)->get();
        return view('livewire.vehiculos.vehiculos-component', ['tabla', $this->tabla])->extends('adminlte::page')->section('content');
    }

    public function Store()
    {
        $rule = [
            'numint' => 'required',
            'Nombre' => 'required',
            'Ano' => 'required',
            'Placa' => 'required',
            'Modelo' => 'required',
            'Tipo'        => 'required',
            'Color'      => 'required',
            'No_Serie' => 'required',
            'Kilometraje' => 'required',
            'tc'        => 'required',
            'afianzadora' => 'required',
            'vigencia_fianza'=> 'required',
            'no_gps'=> 'required',
            'estatus_gsp' => 'required',
            'no_motor'=> 'required',
            'Poliza'=> 'required',
            
          
        ];

        $message = [
            'numint.required'   =>   '**Este campo es obligatorio.**',
            'Nombre.required'   =>   '**Este campo es obligatorio.**',
            'Ano.required'      =>   '**Este campo es obligatorio.**',
            'Placa.required'    =>   '**Este campo es obligatorio.**',
            'Modelo.required'   =>   '**Este campo es obligatorio.**',
            'Tipo.required'     =>   '**Este campo es obligatorio.**',
            'Color.required'    =>   '**Este campo es obligatorio.**',
            'No_Serie.required' =>   '**Este campo es obligatorio.**',
            'Kilometraje.required'  =>   '**Este campo es obligatorio.**',
            'tc.required'       =>   '**Este campo es obligatorio.**',
            'afianzadora.required'   =>   '**Este campo es obligatorio.**',
            'vigencia_fianza.required' =>   '**Este campo es obligatorio.**',
            'no_gps.required' =>   '**Este campo es obligatorio.**',
            'estatus_gsp.required'=>   '**Este campo es obligatorio.**',
            'no_motor.required'=>   '**Este campo es obligatorio.**',
            'Poliza.required'=>   '**Este campo es obligatorio.**',
           
        ];

        $this->validate($rule, $message);

        DB::beginTransaction();

        try {
            $datos = new Vehiculos();
            $datos->Nombre_Id  = $this->Nombre;
            $datos->numint     = $this->numint;
            $datos->Marca      = $this->Marca;
            $datos->Modelo     = $this->Modelo;
            $datos->No_Serie   = $this->No_Serie;
            $datos->Ano        = $this->Ano;
            $datos->Color      = $this->Color;
            $datos->Kilometraje = $this->Kilometraje;
            $datos->Placa       = $this->Placa;
            $datos->tc          = $this->tc;
            $datos->afianzadora  =  $this->afianzadora;
            $datos->vigencia_fianza = $this->vigencia_fianza;
            $datos->no_gps  =   $this->no_gps;
            $datos->estatus_gsp =   $this->estatus_gsp;
            $datos->no_motor =  $this->no_motor;
            $datos->Poliza =   $this->Poliza;
            $datos->Ruta        = 1;
            $datos->Tipo        = $this->Tipo;
            $datos->Comentarios = $this->Comentarios;
         $datos->save();
     //  dd($datos);  
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
            'factura' => 'required|max:50048',
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
                    $salvar = $this->factura->storeAs('public/assets/vehiculos/polizas',$name);
                    break;
                case 2:
                    $salvar = $this->factura->storeAs('public/assets/vehiculos/factura',$name);
                    break;
                case 3:
                    $salvar = $this->factura->storeAs('public/assets/vehiculos/manual',$name);
                     break;
                 case 4:
                    $salvar = $this->factura->storeAs('public/assets/vehiculos/foto',$name);
                    break;
                case 5:
                    $salvar = $this->factura->storeAs('public/assets/vehiculos/tarjeta',$name);
                    break;
    
    
            }
           $docs = new Documentos();
           $docs->Id_doc = $this->val;
           $docs->T_doc =  $this->tipo_doc; 
           $docs->Iden   =  1;
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
            'Nombre' => 'required',
            'Ano' => 'required',
            'Placa' => 'required',
            'Modelo' => 'required',
            'Tipo'        => 'required',
            'Color'      => 'required',
            'No_Serie' => 'required',
            'Kilometraje' => 'required',
            'tc'        => 'required',
            'afianzadora' => 'required',
            'vigencia_fianza'=> 'required',
            'no_gps'=> 'required',
            'estatus_gsp' => 'required',
            'no_motor'=> 'required',
            'Poliza'=> 'required',
        ];

        $message = [
            'numint.required'   =>   '**Este campo es obligatorio.**',
            'Nombre.required'   =>   '**Este campo es obligatorio.**',
            'Ano.required'      =>   '**Este campo es obligatorio.**',
            'Placa.required'    =>   '**Este campo es obligatorio.**',
            'Modelo.required'   =>   '**Este campo es obligatorio.**',
            'Tipo.required'     =>   '**Este campo es obligatorio.**',
            'Color.required'    =>   '**Este campo es obligatorio.**',
            'No_Serie.required' =>   '**Este campo es obligatorio.**',
            'Kilometraje.required'  =>   '**Este campo es obligatorio.**',
            'tc.required'       =>   '**Este campo es obligatorio.**',
            'afianzadora.required'   =>   '**Este campo es obligatorio.**',
            'vigencia_fianza.required' =>   '**Este campo es obligatorio.**',
            'no_gps.required' =>   '**Este campo es obligatorio.**',
            'estatus_gsp.required'=>   '**Este campo es obligatorio.**',
            'no_motor.required'=>   '**Este campo es obligatorio.**',
            'Poliza.required'=>   '**Este campo es obligatorio.**',
        ];

        $this->validate($rule, $message);

        DB::beginTransaction();

        try {
            Vehiculos::where('id', $this->val)->update([
                'Nombre_Id'  => $this->Nombre,
                'numint'     => $this->numint,
                'Marca'       => $this->Marca,
                'Modelo'      => $this->Modelo,
                'No_Serie'    => $this->No_Serie,
                'Ano'         => $this->Ano,
                'Color'       => $this->Color,
                'Kilometraje' => $this->Kilometraje,
                'Placa'       => $this->Placa,
                'tc'          => $this->tc,
                'Tipo'        => $this->Tipo,
                'afianzadora' => $this->afianzadora,
                'vigencia_fianza'=> $this->vigencia_fianza,
                'no_gps'=> $this->no_gps,
                'estatus_gsp' => $this->estatus_gsp,
                'no_motor'=> $this->no_motor,
                'Poliza'=> $this->Poliza,
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
        $this->documentos   = Documentos::where('Id_doc', $this->val)->where('Iden',1)->get();
        $this->imagen  = Documentos::where('Id_doc', $this->val)->where('Iden',1)->where('T_doc', 4)->get();
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
                Storage::delete('public/assets/vehiculos/manual/'.$dato->Doc);
                Documentos::where('id',$id)->delete();
                break;
            case 4:
                Storage::delete('public/assets/vehiculos/foto/'.$dato->Doc);
                Documentos::where('id',$id)->delete();
                break;
            case 5:
                Storage::delete('public/assets/vehiculos/tarjeta/'.$dato->Doc);
                Documentos::where('id',$id)->delete();
                 break;
    
        }
       
        $this->emit('success', 'Se Elimino el dato');

    }
    public function delete($id){
      Documentos::where('Id_doc',$id)->delete();
      Vehiculos::where('id',$id)->update(['Ruta'=>0]);
       $doc = Documentos::where('Id_doc',$id)->get();
       foreach($doc as $val){
         $this->delete_img($val->id);
       }
       $this->emit('success', 'Se Elimino el dato');
    }
    public function resetUI()
    {
        $this->Nombre = '';
        $this->numint = '';
        $this->Marca  = '';
        $this->Modelo = '';
        $this->No_Serie = '';
        $this->Ano      = '';
        $this->Color    = '';
        $this->Kilometraje = '';
        $this->Placa  = '';
        $this->tc = '';
        $this->Comentarios = '';
        $this->val    = '';
        $this->tipo_doc = 1;
        $this->factura  = ''; 
        $this->accion = '';
        $this->Tipo = '';
        $this->afianzadora = '';
        $this->vigencia_fianza = '';
        $this->no_gps = '';
        $this->estatus_gsp = '';
        $this->no_motor = '';
        $this->Poliza = '';
        $this->imagen = [];
        $this->documentos   = [];
    }
}
