<?php

namespace App\Http\Livewire\Bitacoramedicion;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Bitacora_medicion;
use App\Models\Medicion;
use App\Models\Herramienta_medicion;
use App\Models\Responsables;
use App\Models\Historialmantenimientosmedicion;
use DB;

class BitacoraMedicionComponent extends Component
{
    public $componentName;
    public $pageTitle;
    public $table = [];
    public $medicion = [];
    public $herramienta_med = [];
    public $herramenta, $codigo;
    public $cod_barras, $marca, $status,$id_her, $fecha, $fecha_prox, $comentario;
    public $rol;
    public $val;

    public $accion;

    public function mount(){
        $this->componentName = 'Bitacora';
        $this->pageTitle = 'Herramientas Medicion Dañada'; 
        $this->table    = Bitacora_medicion::all();
        $this->medicion = Medicion::all();
        $this->herramienta_med = Herramienta_medicion::where('status',1)->get();
        $this->rol = Auth::user()->rol;
    }

    public function accion($opc, $val)
    {
        $this->accion = $opc;
        $this->val = $val;
        switch ($opc) {
            case 0:
                $this->emit('show-modal');
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
            case 7:
                $this->Actualizar_bitacora();
                break;
          
        }
    }
    public function crear()
    {
        $this->emit('show-modal');
    }

    public function editar()
    {
        $this->emit('show-modal');
    }
    public function Actualizar_bitacora()
    {
        $datos = Bitacora_medicion::find($this->val);
         $this->id_her =  $datos->id_her;
         $this->fecha = $datos->fecha;
         $this->fecha_prox = $datos->fecha_prox;
         $this->comentario = $datos->comentario;
        $this->emit('show-modal');
    }
    public function GuardarActualizacion()
    {
        $rule = [
            'id_her' => 'required',
            'fecha' => 'required',
            'fecha_prox' => 'required',    
            'comentario' => 'required',        
        ];

        $message = [
            'id_her.required'   =>   '**Este campo es obligatorio.**',
            'fecha.required'   =>   '**Este campo es obligatorio.**',
            'marca.required'      =>   '**Este campo es obligatorio.**',
            'comentario.required'      =>   '**Este campo es obligatorio.**',

        ];

        $this->validate($rule, $message);

        DB::beginTransaction();

        try {
         
          $datos =  Bitacora_medicion::where('id',$this->val)->update([
            'id_her' => $this->id_her,
            'fecha' => $this->fecha,
            'fecha_prox'      => $this->fecha_prox,
            'comentario'      => $this->comentario

          ]);

           $historial =  new Historialmantenimientosmedicion();
           $historial->id_her = $this->id_her;
           $historial->fecha = $this->fecha;
           $historial->fecha_prox      = $this->fecha_prox;
           $historial->comentario      = $this->comentario;
            $historial->save();  

          DB::commit();
          $this->emit('success','Exito se guardo' );
              
        }catch (\Exception $e) {
            DB::rollBack();
            // Registrar cualquier excepción en los logs
            \Log::error('Error al guardar el origen: ' . $e->getMessage());
            // Emitir un mensaje de error
            $this->emit('error', 'Ocurrió un error al guardar el dato.' . $e->getMessage());
        }

    }
    public function render()
    {
        return view('livewire.bitacoramedicion.bitacora-medicion-component')->extends('adminlte::page')->section('content');
    }
    public function Store()
    {
        $rule = [
            'cod_barras' => 'required',
            'herramenta' => 'required',
            'marca' => 'required',        
        ];

        $message = [
            'cod_barras.required'   =>   '**Este campo es obligatorio.**',
            'herramenta.required'   =>   '**Este campo es obligatorio.**',
            'marca.required'      =>   '**Este campo es obligatorio.**',
        ];

        $this->validate($rule, $message);

        DB::beginTransaction();

        try {
          $codigo = Medicion::where('id', $this->herramenta)->value('codigo');
          $cant = Medicion::where('id', $this->herramenta)->value('cantidad');
          $cont = Herramienta_medicion::where('herramenta', $this->herramenta)->count();
          
          
          if ($cant >= $cont) {

          $datos =  new Herramienta_medicion();
          $datos->cod_barras = $this->cod_barras;
          $datos->herramenta = $this->herramenta;
          $datos->marca      = $this->marca;
          $datos->codigo      = $codigo;
          $datos->status     = 1;

          $datos->save();
          DB::commit();
          $this->emit('success','Exito se guardo' );
          }else {
            $this->emit('error', 'Todas tus herramientas están codificadas' );
        }

        }catch (\Exception $e) {
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
                'id_her' => 'required',
                'fecha' => 'required',
                'fecha_prox' => 'required',    
                'comentario' => 'required',        
            ];
    
            $message = [
                'id_her.required'   =>   '**Este campo es obligatorio.**',
                'fecha.required'   =>   '**Este campo es obligatorio.**',
                'marca.required'      =>   '**Este campo es obligatorio.**',
                'comentario.required'      =>   '**Este campo es obligatorio.**',

            ];
    
            $this->validate($rule, $message);
    
            DB::beginTransaction();
    
            try {
             
              $datos =  new Bitacora_medicion();
              $datos->id_herr = $this->id_her;
              $datos->fecha = $this->fecha;
              $datos->fecha_prox      = $this->fecha_prox;
              $datos->comentario      = $this->comentario;
               $datos->save();

               $historial =  new Historialmantenimientosmedicion();
               $historial->id_her = $this->id_her;
               $historial->fecha = $this->fecha;
               $historial->fecha_prox      = $this->fecha_prox;
               $historial->comentario      = $this->comentario;
                $historial->save();  

              DB::commit();
              $this->emit('success','Exito se guardo' );
                  
            }catch (\Exception $e) {
                DB::rollBack();
                // Registrar cualquier excepción en los logs
                \Log::error('Error al guardar el origen: ' . $e->getMessage());
                // Emitir un mensaje de error
                $this->emit('error', 'Ocurrió un error al guardar el dato.' . $e->getMessage());
            }

    }
    public function medicion_herr($id){
        $datos = Medicion::find($id)->instrumento;
        return $datos;

    }
    public function resetUI()
    {
        $this->herramenta = ''; 
        $this->codigo = ''; 
        $this->cod_barras = ''; 
        $this->marca = '';
        $this->status = '';
        $this->id_her = '';
        $this->fecha = '';
        $this->fecha_prox = ''; 
        $this->comentario = '';
        $this->val    = '';
        $this->accion = '';  
    }
}