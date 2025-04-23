<?php

namespace App\Http\Livewire\Herramientas;

use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;
use App\Models\Herramientas;
use App\Models\Requisicion;
use App\Models\TempCosto;
use App\Models\DocumentosRequisicion;
use DB;

class HerramientasComponent extends Component
{
    use WithFileUploads;
    public $componentName;
    public $pageTitle;
    public $tabla   = [];
    public $select = [];
    public $tmp = [];
    public $req = [];
    public $cont = [];
    public $archivos = [];
    public $contador = 1;
    public $Herramienta, $Cantidad, $Cant_his, $tipo, $activo;
    public $id_requisicion, $documento, $monto,$num_fact,$proveedor;
    public $folio, $herramienta, $cantidad, $costo;
    public $factura;
    public $foto;
    public $val;
    public $accion;
    public $rol;

    public function mount()
    {
        $this->componentName = 'Configuracion';
        $this->pageTitle     = 'Herramientas';
        $this->select = Herramientas::where('activo', 1)->get();
        $this->tmp = TempCosto::all();
        $this->req = Requisicion::select('folio')->distinct('folio')->get();
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
                $this->archivos = DocumentosRequisicion::where('id_requisicion', $this->val)->get();
                $this->emit('show-modal');
                break;
            case 4:
                $this->emit('show-modal');
                break;
            case 6:
                
                $this->cont = Requisicion::where('folio', $this->val)->get();
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
        $datos = Herramientas::find($this->val);
        $this->Herramienta    = $datos->Herramienta;
        $this->Cantidad = $datos->Cantidad;
        $this->tipo  = $datos->tipo;
 
        $this->emit('show-modal');
    }

    public function render()
    {
        $this->tabla = Herramientas::where('activo', 1)->get();
        return view('livewire.herramientas.herramientas-component', ['tabla', $this->tabla])->extends('adminlte::page')->section('content');
    }
    public function Store()
    {

        $rule = [
            'Herramienta' => 'required',
            'Cantidad'  => 'required',
            'tipo' => 'required',
           


        ];

        $message = [
            'Herramienta.required'   =>   '**Este campo es obligatorio.**',
            'Cantidad.required'  =>   '**Este campo es obligatorio.**',
            'tipo.required'  =>   '**Este campo es obligatorio.**',
      



        ];

        $this->validate($rule, $message);

        DB::beginTransaction();


        try {
        
            $datos = new Herramientas();
            $datos->Herramienta  = $this->Herramienta;
            $datos->Cantidad     = $this->Cantidad;
            $datos->tipo         = $this->tipo;
      
            $datos->activo  = 1;
            $datos->save();
            DB::commit();
            $this->emit('success', 'Se agrego el dato');
        } catch (\Exception $e) {
            DB::rollBack();
            // Registrar cualquier excepción en los logs
            \Log::error('Error al guardar el origen: ' . $e->getMessage());
            // Emitir un mensaje de error
            $this->emit('error', 'Ocurrió un error al guardar el dato.' . $e->getMessage());
			dd($e->getMessage());
        }
    }
    public function Update()
    {
        $rule = [
            'Herramienta' => 'required',
            'Cantidad'  => 'required',
            'tipo' => 'required',

        ];

        $message = [
            'Herramienta.required'   =>   '**Este campo es obligatorio.**',
            'Cantidad.required'  =>   '**Este campo es obligatorio.**',
            'tipo.required'  =>   '**Este campo es obligatorio.**',


        ];

        $this->validate($rule, $message);

        DB::beginTransaction();

        try {
            Herramientas::where('id', $this->val)->update(
                [
                    'Herramienta'  => $this->Herramienta,
                    'Cantidad'     => $this->Cantidad,
                    'tipo'         => $this->tipo

                ]
            );
           
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
            'num_fact' => 'required',
            'proveedor' => 'required',
            'factura' => 'required',
            'monto'  => 'required',

        ];

        $message = [
            'num_fact.required' => '**Este campo es obligatorio**',
            'proveedor.required'=> '**Este campo es obligatorio**',
            'factura.required'   =>   '**Este campo es obligatorio.**',
            'monto.required'  =>   '**Este campo es obligatorio.**',


        ];

        $this->validate($rule, $message);

        DB::beginTransaction();

        try {
            $name = $this->factura->getClientOriginalName();    
            $salvar = $this->factura->storeAs('public/assets/facturas_requisicion',$name);
            $data = new DocumentosRequisicion();
            $data->id_requisicion = $this->val;
            $data->documento = $name;
            $data->num_fact = $this->num_fact;
            $data->proveedor = $this->proveedor;
            $data->monto = $this->monto;
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
    public function agregar_tmp()
    {

        $rule = [
            'herramienta' => 'required',
            'cantidad'  => 'required',
        ];

        $message = [
            'herramienta.required'   =>   '**Este campo es obligatorio.**',
            'cantidad.required'  =>   '**Este campo es obligatorio.**',

        ];
        $this->validate($rule, $message);

        DB::beginTransaction();

        try {
            $val = TempCosto::where('material', $this->herramienta)->first();
            if ($val == null) {
                $data = new TempCosto();
                $data->material = $this->herramienta;
                $data->cantidad = $this->cantidad;
                $data->save();

                DB::commit();
                $this->emit('success1', 'Se agrego el dato');
            } else {
                $this->emit('error', 'Ya existe');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            // Registrar cualquier excepción en los logs
            \Log::error('Error al guardar el origen: ' . $e->getMessage());
            // Emitir un mensaje de error
            $this->emit('error', 'Ocurrió un error al guardar el dato.' . $e->getMessage());
        }
    }

    public function finalizar_req()
    {
        $data = TempCosto::all();
        $folio = 'Grose-inv-req-' . rand();
        foreach ($data as $row) {
            $base = new Requisicion();
            $base->folio = $folio;
            $base->herramienta = $row->material;
            $base->cantidad = $row->cantidad;
            $base->save();

            $herr_existencia =  Herramientas::find($row->material);

            Herramientas::where('id', $row->material)->update(
                [
                    'cantidad' => $herr_existencia->Cantidad + $row->cantidad
                ]
            );
            TempCosto::truncate();
            $this->emit('success', 'Se agrego el dato');
        }
    }

    public function delete_img($id)
    {
        $dato = Herramientas::find($id);
        Storage::delete('public/assets/imagenes_herramienta/' . $dato->foto);
        Herramientas::where('id', $id)->update(['foto' => '']);
        $this->emit('success', 'Se elimino la foto');
    }
    public function delete($id)
    {
        Herramientas::where('id', $id)->update(['activo'=>0]);
        $this->emit('success', 'Se elimino el dato');
    }
    public function delete_tmp($id)
    {
        TempCosto::where('id', $id)->delete();
        $this->emit('success1', 'Se elimino el dato');
    }
    public function delete_archivo($id){
        $dato = DocumentosRequisicion::find($id);
        Storage::delete('public/assets/facturas_requisicion/' . $dato->documento);
        DocumentosRequisicion::where('id', $id)->delete();
        $this->emit('success1', 'Se elimino el archivo');
    }

    public function delete_req($id){
        $dato = DocumentosRequisicion::where('id_requisicion',$id)->get();
        foreach($dato as $row){
            Storage::delete('public/assets/facturas_requisicion/' . $row->documento);
        }
        DocumentosRequisicion::where('id_requisicion',$id)->delete();
        Requisicion::where('id',$id)->delete();
        $this->emit('success1', 'Se elimino el archivo');
    }
    public function herr($id)
    {
        $data = Herramientas::find($id);
        return $data->Herramienta;
    }
    public function resetUI()
    {
        $this->tabla   =  Herramientas::all();
        $this->Herramienta = '';
        $this->Cantidad = '';
        $this->Cant_his;
        $this->tipo = '';

        $this->val = '';
        $this->accion = '';
    }
    public function resetUII()
    {
        $this->herramienta = '';
        $this->cantidad = '';
        $this->monto='';
        $this->tmp = TempCosto::all();
        $this->archivos = DocumentosRequisicion::where('id_requisicion', $this->val)->get();
        $this->req = Requisicion::all();
    }
}
