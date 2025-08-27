<?php

namespace App\Http\Livewire\Listadoherramientas;


use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;
use App\Models\Herramientas;
use App\Models\Prestamos;
use App\Models\Comentarios;
use App\Models\Responsables;
use App\Models\Historial_responsivas;
use App\Models\bitacora_herramienta;
use App\Models\Herramientas_mantenimiento;
use App\Models\Facturas_herramienta;
use DB;

class ListadoHerramientasComponent extends Component
{
    use WithFileUploads;
    public $her_mano = [];
    public $herr_mayor = [];
    public $danada = [];
    public $responsables = [];
    public $accion;
    public $data = [];
    public $herr, $cantidad, $portador, $responsable, $fecha, $hora, $stat, $codigo, $marca, $modelo, $numser, $com;
    public $id_herramientas, $herramienta,  $cod_barras, $cod, $com_rep;
    public $fecha_baja, $coms, $fecha_rep, $comr, $comentario, $idx;
    public $resp;
    public $rol;
    public $factura;
    public $h, $nh;
    public $val, $val1;
    public $cambio;
    public $pza;
    public $cantidad1;
    public $componentName;
    public $pageTitle;

    public function mount($id)
    {
        $this->val = $id;
        $this->idx = $id;
        $this->componentName = 'Herramientas';
        $this->pageTitle     = 'Listado de herramientas';
        $this->her_mano  = Prestamos::where('codigo', $id)
            ->where('marca', '!=', '')
            ->where('status', 0)
            ->get();

        $this->herr_mayor = Prestamos::select('herr')
            ->where('codigo', $id)
            ->where('status', 0)
            ->where('marca', '')
            ->where('modelo', '')
            ->orderBy('id', 'asc')
            ->distinct()
            ->get();
        $this->rol = Auth::user()->rol;
        //   dd($this->herr_mayor);

        $this->danada = Comentarios::where('codigo', $this->idx)->get();

        $this->responsables = Historial_responsivas::all();
    }

    public function accion($opc, $val)
    {
        $this->accion = $opc;
        $this->val1 = $val;
        switch ($opc) {
            case 0:
                $this->historiales();

                break;
            case 1:
                $this->cambios();
                break;
            case 2:
                $this->editar();
                break;

            case 3:
                $this->subir_factura();

                break;
            case 4:
                $this->reporte();

                break;
            case 7:
                $this->danado();

                break;
            case 8:
                $datos = Prestamos::find($this->val1);
                $this->pza = $datos->cantidad;
                $this->emit('show-modal');
                break;
        }
    }

    public function editar()
    {
        $datos = Prestamos::find($this->val1);

        // Verifica si no se encontró el préstamo
        if (!$datos) {
            $this->marca = null;
            $this->modelo = null;
            $this->numser = null;
            $this->com = null;
        } else {
            // Si se encontró, asigna los valores a las propiedades
            $this->marca = $datos->marca;
            $this->modelo = $datos->modelo ?? '';
            $this->numser = $datos->numser;
            $this->com = $datos->com;
        }

        $this->emit('show-modal');
    }
    public function reporte()
    {
        $datos = Comentarios::find($this->val);
        $prestamo = Prestamos::find($datos->origen);
        $bitacora = bitacora_herramienta::where('id_retorno', $datos->origen)->first();

        $this->fecha_baja = $datos->created_at;
        $this->modelo = $prestamo->modelo;

        $this->nh = $this->herramientas($datos->herr);
        $this->com = $datos->comentario;

        // Verificar si $bitacora está presente antes de acceder a sus propiedades
        if ($bitacora) {
            $this->fecha_rep = $bitacora->rep_fecha ?? '';
            $this->com_rep = $bitacora->comentario ?? '';
            $this->codigo = $bitacora->codigo ?? '';
        } else {
            $this->fecha_rep = '';
            $this->codigo = '';
            $this->com_rep = '';
        }
        $this->emit('show-modal');
    }
    public function Update()
    {
        $datos = Prestamos::where('id', $this->val1)->update(
            [
                'marca' => $this->marca,
                'modelo' => $this->modelo,
                'numser' => $this->numser,
                'com' => $this->com
            ]
        );

        $this->emit('success', 'Se edito la informacion');
    }
    public function subir_factura()
    {

        $this->data = Facturas_herramienta::where('idher', $this->val1)->get();

        $this->emit('show-modal');
    }
    public function danado()
    {

        $datos = Comentarios::find($this->val1);
        $prestamo = Prestamos::find($datos->origen);
        $bitacora = bitacora_herramienta::where('id_retorno', $datos->origen)->first();

        $this->fecha_baja = $datos->created_at;
        $this->modelo = $prestamo->modelo;

        $this->nh = $this->herramientas($datos->herr);
        $this->com = $datos->comentario;

        // Verificar si $bitacora está presente antes de acceder a sus propiedades
        if ($bitacora) {
            $this->fecha_rep = $bitacora->rep_fecha ?? '';
            $this->com_rep = $bitacora->comentario ?? '';
            $this->codigo = $bitacora->codigo ?? '';
            $this->cantidad1 = $bitacora->cantidad ?? '';
        } else {
            $this->fecha_rep = '';
            $this->codigo = '';
            $this->com_rep = '';
        }

        $this->emit('show-modal');
    }

    public function GuardarActualizacion()
    {
        $rule = [
            'comentario' => 'required',

        ];

        $message = [
            'comentario.required' => '**Este campo es obligatorio.**',

        ];
        $this->validate($rule, $message);
        DB::beginTransaction();

        try {

            $comentarios = Comentarios::find($this->val1);

            bitacora_herramienta::where('id_retorno', $comentarios->origen)->update(
                [
                    'rep_fecha' => date('Y-d-m'),
                    'stat' => 1,
                    'comentario' => $this->comentario,
                ]
            );

            Comentarios::where('id', $this->val)->update([
                'status' => 0
            ]);

            $dato = Prestamos::where('id', $comentarios->origen)->get();
             if($dato->status == 2){
            Prestamos::where('id', $comentarios->origen)->update([
                'status' => 0
            ]);
        }else{
            
            Prestamos::where('id', $comentarios->origen)->update([
                'cantidad' => $dato->cantidad + $comentarios->cantidad
            ]);
        }
            Herramientas_mantenimiento::where('id_herramientas', $comentarios->origen)->update(
                ['status' => 0]
            );

            // Herramientas_mantenimiento::where()
            DB::commit();
            $this->emit('success', 'Se retorno la herramienta');
        } catch (\Exception $e) {
            DB::rollBack();
            // Registrar cualquier excepción en los logs
            \Log::error('Error al guardar el origen: ' . $e->getMessage());
            // Emitir un mensaje de error
            $this->emit('error', $e->getMessage());
        }
    }

    public function cambios()
    {
        $datos = Prestamos::find($this->val1);
        $this->nh = $this->herramientas($datos->herr);
        $this->h = $datos->herr;
        $this->pza = $datos->cantidad;


        $this->emit('show-modal');
    }
    public function render()
    {
        $this->cod = rand();
        return view('livewire.listadoherramientas.listado-herramientas-component')->extends('adminlte::page')->section('content');
    }
    public function herramientas($id)
    {
        $herramienta = Herramientas::find($id);

        // Verifica si $herramienta es null
        if ($herramienta !== null) {
            return $herramienta->Herramienta;
        } else {
            // Manejo del caso en que no se encuentra la herramienta
            return 'Herramienta no encontrada';
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
            $idherr = Prestamos::find($this->val1)->herr;

            $herra = $this->herramientas($idherr);
            $name = $this->factura->getClientOriginalName();
            $salvar = $this->factura->storeAs('public/assets/facturas_herr/', $name);


            $docs = new Facturas_herramienta();
            $docs->idher = $this->val1;
            $docs->codigo = $this->val;
            $docs->nombre = $herra;
            $docs->archivo = $name;
            $docs->fecha = date('Y-m-d');
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
        $this->data = Facturas_herramienta::where('idher', $this->val1)->get();
    }
    public function Store()
    {

        DB::beginTransaction();
        $herramientas = Prestamos::find($this->val1);


        if ($this->cambio == 1) {

            $info = explode(',', $this->resp);

            $responsiva = $info[0];
            $usuario = $info[1];
            if ($this->pza == $herramientas->cantidad) {
                $dato = Prestamos::where('id', $this->val1)->update(
                    [
                        'codigo' => $responsiva,
                        'responsable' => $usuario
                    ]
                );
                DB::commit();
                $this->emit('success', 'Se realizo el cambio');
            }
            if ($this->pza > $herramientas->cantidad) {

                $this->emit('error', 'Error es mayor a lo que existe');
            }
            if ($this->pza < $herramientas->cantidad) {
                $dato = new Prestamos();
                $dato->codigo = $responsiva;
                $dato->responsable = $usuario;
                $dato->cantidad = $this->pza;
                $dato->herr = $herramientas->herr;
                $dato->cantidad = $herramientas->cantidad - $this->pza;
                $dato->fecha = date('Y-m-d');
                $dato->hora = date('h:i:s');
                $dato->stat = $herramientas->stat;
                $dato->marca = $herramientas->marca;
                $dato->modelo = $herramientas->modelo;
                $dato->numser = $herramientas->numser;
                $dato->status = $herramientas->status;
                $dato->foto = $herramientas->foto;

                $dato->save();

                Prestamos::where('id', $this->val1)->update(
                    [
                        'cantidad' => $herramientas->cantidad - $this->pza,
                    ]
                );
                DB::commit();
                $this->emit('success', 'Se realizo el cambio');
            }
        } else {
            $herramienta = Prestamos::find($this->val1);
            $existencia = Herramientas::find($herramienta->herr);
            $total = $herramienta->cantidad + $existencia->Cantidad;
            Herramientas::where('id', $herramienta->herr)->update([
                'Cantidad' => $total
            ]);
            Prestamos::where('codigo', $this->val1)->delete();
            DB::commit();
            $this->emit('success', 'Se realizo el cambio');
        }
    }

    public function Guardar()
    {
        $rule = [
            'cod_barras' => 'required',
            'com' => 'required',
            'pza' => 'required',
        ];

        $message = [
            'cod_barras.required' => '**Este campo es obligatorio.**',
            'com.required' => '**Este campo es obligatorio.**',
            'pza.required' => '**Este campo es obligatorio.**'


        ];
            $datos_herramienta = Prestamos::where('id', $this->val1)->first();
            $marca = $datos_herramienta->marca;
            $nombre_herramienta = $this->herramientas($datos_herramienta->herr);

        $this->validate($rule, $message);
        DB::beginTransaction();

        try {
          


            if ($datos_herramienta->cantidad < $this->pza ){
               $bitacora = new bitacora_herramienta();
                $bitacora->id_her = $datos_herramienta->herr;
                $bitacora->cod_barras = $this->cod_barras;
                $bitacora->codigo = $this->cod;
                $bitacora->fecha = date('Y-m-d');
                $bitacora->hora = date('h:i:s');
                $bitacora->responsable = $datos_herramienta->responsable;
                $bitacora->id_retorno = $this->val1;
                $bitacora->cantidad = $datos_herramienta->cantidad - $this->pza;
                $bitacora->stat = 0;
                $bitacora->save();
                 Prestamos::where('id', $this->val1)->update(['cantidad' => $datos_herramienta->cantidad - $this->pza ]);
            
                     $mantenimiento = new Herramientas_mantenimiento();
                $mantenimiento->id_herramientas = $this->val1;
                $mantenimiento->herramienta = $nombre_herramienta;
                $mantenimiento->codigo = $this->cod;
                $mantenimiento->cod_barras = $this->cod_barras;
                $mantenimiento->marca = $datos_herramienta->marca;
                $mantenimiento->status = 1;
                $mantenimiento->save();

                $comentarios = new Comentarios();
                $comentarios->herr = $datos_herramienta->herr;
                $comentarios->origen = $datos_herramienta->id;
                $comentarios->comentario = $this->com;
                $comentarios->codigo = $this->idx;
                $comentarios->fecha = date('Y-m-d');
                $comentarios->status = 1;
                $comentarios->cantidad = $datos_herramienta->cantidad - $this->pza; 
                $comentarios->save();

                DB::commit();
                $this->emit('success', 'Se mando a mantenimiento');
                }
             
            if($datos_herramienta->cantidad == $this->pza) {
                $bitacora = new bitacora_herramienta();
                $bitacora->id_her = $datos_herramienta->herr;
                $bitacora->cod_barras = $this->cod_barras;
                $bitacora->codigo = $this->cod;
                $bitacora->fecha = date('Y-m-d');
                $bitacora->hora = date('h:i:s');
                $bitacora->responsable = $datos_herramienta->responsable;
                $bitacora->id_retorno = $this->val1;
                $bitacora->cantidad = $datos_herramienta->cantidad - $this->pza;
                $bitacora->stat = 0;
                $bitacora->save();


                $mantenimiento = new Herramientas_mantenimiento();
                $mantenimiento->id_herramientas = $this->val1;
                $mantenimiento->herramienta = $nombre_herramienta;
                $mantenimiento->codigo = $this->cod;
                $mantenimiento->cod_barras = $this->cod_barras;
                $mantenimiento->marca = $datos_herramienta->marca;
                $mantenimiento->status = 1;
                $mantenimiento->save();

                $comentarios = new Comentarios();
                $comentarios->herr = $datos_herramienta->herr;
                $comentarios->origen = $datos_herramienta->id;
                $comentarios->comentario = $this->com;
                $comentarios->codigo = $this->idx;
                $comentarios->cantidad = $datos_herramienta->cantidad; 
                $comentarios->fecha = date('Y-m-d');
                $comentarios->status = 1;
                $comentarios->save();



                Prestamos::where('id', $this->val1)->update(['status' => 2]);
                DB::commit();
                $this->emit('success', 'Se mando a mantenimiento');
            
        }
        if($this->pza > $datos_herramienta->cantidad ) {
                $this->emit('error', 'No existen tantas');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            // Registrar cualquier excepción en los logs
            \Log::error('Error al guardar el origen: ' . $e->getMessage());
            // Emitir un mensaje de error
            $this->emit('error', $e->getMessage());
        }
    }
    public function responsable($id)
    {
        $dato = Responsables::find($id);
        $nombre = '';
        // Verificar si $dato no es null
        if (!is_null($dato) && !is_null($dato->Nombre)) {
            $nombre .= $dato->Nombre;
        }
        if (!is_null($dato) && !is_null($dato->Apellido_P)) {

            $nombre .=  ' ' . $dato->Apellido_P;
        }
        if (!is_null($dato) && !is_null($dato->Apellido_M)) {
            $nombre .=  ' ' . $dato->Apellido_M;
        }
        return $nombre;
    }

    public function resetUI()
    {
        $this->accion = '';
        $this->codigo = '';
        $this->marca = '';
        $this->modelo = '';
        $this->numser = '';
        $this->com = '';
        $this->resp = '';
        $this->val = '';
        $this->val1 = '';
        $this->pza = '';
        $this->cod_barras = '';
    }
    public function resetUII()
    {
        $this->data = [];
        $this->factura = '';
        $this->val = '';
        $this->val1 = '';
        $this->accion = '';
    }
}
