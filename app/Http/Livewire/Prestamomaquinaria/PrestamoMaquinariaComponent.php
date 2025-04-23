<?php

namespace App\Http\Livewire\Prestamomaquinaria;

use Livewire\Component;
use App\Models\Maquinaria;
use App\Models\PrestamosMaquinaria;
use App\Models\Responsables;
use App\Models\Archivos_maquinaria;
use App\Models\Bitacora_maquinaria;
use App\Models\Prestamos;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;

use DB;

class PrestamoMaquinariaComponent extends Component
{
    use WithFileUploads;
    public $componentName;
    public $pageTitle;
    public $tabla   = [];
    public $responsables = [];
    public $maquinaria = [];
    public $archivos = [];
    public $reparacion = [];
    public $maquinarias = [];
    public $herr, $portador, $responsable, $stat, $com;
    public $cod_barras, $coment;
    public $factura;
    public $rol;
    public $val;
    public $accion;

    public function mount()
    {
        $this->componentName = 'Maquinaria Menor';
        $this->pageTitle     = 'Prestamos Maquinaria';
       
        $this->tabla        = PrestamosMaquinaria::select('codigo', 
        DB::raw('GROUP_CONCAT(id) as ids'),
        DB::raw('GROUP_CONCAT(herr) as herrs'),
        DB::raw('GROUP_CONCAT(portador) as portadores'),
        DB::raw('GROUP_CONCAT(responsable) as responsables'),
        DB::raw('GROUP_CONCAT(fecha) as fechas'),
        DB::raw('GROUP_CONCAT(hora) as horas'),
        DB::raw('GROUP_CONCAT(stat) as stats'),
        DB::raw('GROUP_CONCAT(com) as coms'),
        DB::raw('GROUP_CONCAT(status) as statuses'))
->groupBy('codigo')
->get(); 

$this->responsables = Responsables::where('ruta', 1)->get();
        $this->maquinaria   = Maquinaria::where('ruta', 1)->get();
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
           
                $data = PrestamosMaquinaria::find($this->val);
            $this->portador = $data->portador;
                $this->responsable = $data->responsable;
                $this->com = $data->com;
                $this->emit('show-modal');
                break;
            case 3:
                $this->archivos = Archivos_maquinaria::where('id_responsiva', $this->val)->get();
                $this->emit('show-modal');
                break;
            case 4:
             
                $this->emit('show-modal');
                break;
            case 5:
                $this->emit('show-modal');
                break;
            case 6:
                $this->reparacion  = Bitacora_maquinaria::where('id_retorno', $this->val)->get();
                $this->emit('show-modal');
                break;
                case 8:
                   $this->maquinarias = PrestamosMaquinaria::where('codigo', $this->val)->get();
                    $this->emit('show-modal');
                    break;
        }
    }
    public function crear()
    {
        $this->emit('show-modal');
    }

    public function render()
    {
        return view('livewire.prestamomaquinaria.prestamo-maquinaria-component')->extends('adminlte::page')->section('content');
    }

    public function Store()
    {

        $rule = [
            'herr' => 'required',
            'responsable'     => 'required',
            'portador'   => 'required',

        ];

        $message = [
            'herr.required' =>   '**Este campo es obligatorio.**',
            'responsable.required'     =>   '**Este campo es obligatorio.**',
            'portador.required'   =>   '**Este campo es obligatorio.**',

        ];
        $this->validate($rule, $message);

        DB::beginTransaction();

        try {

            $codigo = 'GROSE-MM-' . date('dmYhis');
            $data =  new  PrestamosMaquinaria();
            $data->herr = $this->herr;
            $data->portador = $this->portador;
            $data->responsable = $this->responsable;
            $data->stat = 1;
            $data->codigo = $codigo;
            $data->fecha = date('d-m-Y');
            $data->hora   = date('h:i:s');
            $data->com  = $this->com;
            $data->status = 0;
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
    pubLIC function Guardar(){
        
        $rule = [
            'herr' => 'required',
          
        ];

        $message = [
            'herr.required' =>   '**Este campo es obligatorio.**',
           
        ];
        $this->validate($rule, $message);

        DB::beginTransaction();

        try {

            $prestamo = PrestamosMaquinaria::where('codigo',$this->val)->first();
          
            $data =  new  PrestamosMaquinaria();
            $data->herr = $this->herr;
            $data->portador = $prestamo->portador;
            $data->responsable = $prestamo->responsable;
            $data->stat = 1;
            $data->codigo = $this->val;
            $data->fecha = date('d-m-Y');
            $data->hora   = date('h:i:s');
            $data->com  = $this->com;
            $data->status = 0;
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
    public function subir_documento()
    {
        $rule = [
            'factura' => 'required',
        ];

        $message = [
            'factura.required'   =>   '**Este campo es obligatorio.**',

        ];

        $this->validate($rule, $message);

        DB::beginTransaction();

        try {
            $name = $this->factura->getClientOriginalName();
            $salvar = $this->factura->storeAs('public/assets/documentos_maquinaria/', $name);
            $data = new Archivos_maquinaria();
            $data->id_responsiva = $this->val;
            $data->archivo = $name;
            $data->save();
            DB::commit();
            $this->emit('success1', 'Se agrego el dato');
        } catch (\Exception $e) {
            DB::rollBack();
            // Registrar cualquier excepción en los logs
            \Log::error('Error al guardar el origen: ' . $e->getMessage());
            // Emitir un mensaje de error
            $this->emit('error', 'Ocurrió un error al guardar el dato.' . $e->getMessage());
        }
    }
    public function get_maquinaria($id){
        $herramienta = Maquinaria::find($id);

        return $herramienta->Nombre_Id;
    }

    public function maquinaria($id)
    {
        $data = PrestamosMaquinaria::find($id)->herr;
        $herramienta = Maquinaria::find($data);

        return $herramienta->Nombre_Id;
    }
    public function guardar_danada()
    {
        $rule = [
            'cod_barras' => 'required',
            'coment' => 'required',
        ];

        $message = [
            'cod_barras.required'   =>   '**Este campo es obligatorio.**',
            'coment.required'   =>   '**Este campo es obligatorio.**',

        ];
        $this->validate($rule, $message);

        DB::beginTransaction();

        try {
            $datos_generales = PrestamosMaquinaria::find($this->val);
            $data = new Bitacora_maquinaria();
            $data->id_her = $datos_generales->herr;
            $data->cod_barras = $this->cod_barras;
            $data->codigo   = 'GROSE-RMM-' . rand();
            $data->fecha = date('Y-m-d');
            $data->hora = date('h:i:s');
            $data->id_retorno = $this->val;
            $data->comentario = $this->coment;
            $data->responsable = $datos_generales->responsable;
            $data->stat = 1;
            $data->save();
            PrestamosMaquinaria::where('id', $this->val)->update(['stat' => 3]);
            DB::commit();
            $this->emit('success1', 'Se agrego el dato');
        } catch (\Exception $e) {
            DB::rollBack();
            // Registrar cualquier excepción en los logs
            \Log::error('Error al guardar el origen: ' . $e->getMessage());
            // Emitir un mensaje de error
            $this->emit('error', 'Ocurrió un error al guardar el dato.' . $e->getMessage());
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

    public function retorno_taller(){
        $datos = Bitacora_maquinaria::find($this->val);
        Bitacora_maquinaria::where('id',$this->val)->update(['stat'=>1,'rep_fecha'=>date('Y-m-d'),'com_rep' => $this->coment]);
        PrestamosMaquinaria::where('id',$datos->id_retorno)->update(['stat'=>1]);
        $this->emit('success', 'Se retorno la maquinaria');
    }
    public function deshechar(){
        $datos = Bitacora_maquinaria::find($this->val);
        Bitacora_maquinaria::where('id',$this->val)->update(['stat'=>3,'rep_fecha'=>date('Y-m-d'),'com_rep' => $this->coment]);
        PrestamosMaquinaria::where('id',$datos->id_retorno)->update(['stat'=>4]);
        $this->emit('success', 'Se retorno la maquinaria');
    }
    public function delete_img($id)
    {
        $dato = Archivos_maquinaria::find($id);
        Storage::delete('public/assets/documentos_maquinaria/' . $dato->archivo);
        Archivos_maquinaria::where('id', $id)->delete();
        $this->emit('success1', 'Se elimino el archivo');
    }
    public function delete($id)
    {
        $datos = PrestamosMaquinaria::find($id);
        PrestamosMaquinaria::where('codigo', $datos->codigo)->delete();
        $this->emit('success', 'Se elimino el prestamo');
    }

    public function retorno($id)
    {
        PrestamosMaquinaria::where('id', $id)->update(['stat' => 2]);
        
        $this->emit('success', 'Se cambio el estatus del prestmo');
    }
    public function resetUI()
    {
        $this->herr = '';
        $this->portador = '';
        $this->responsable = '';
        $this->archivos = [];
        $this->factura = '';
        $this->com = '';
        $this->archivos = '';
        $this->reparacion  = '';
        $this->cod_barras = '';
        $this->reparacion  = [];
        $this->coment = '';
        $this->val = '';
        $this->accion = '';
    }
    public function resetUII()
    {
        $this->factura = '';
        $this->archivos = Archivos_maquinaria::where('id_responsiva', $this->val)->get();
        $this->reparacion  = Bitacora_maquinaria::where('id_retorno', $this->val)->get();
        $this->cod_barras = '';
        $this->coment = '';
    }
}
