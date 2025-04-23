<?php

namespace App\Http\Livewire\Responsivasmedicion;

use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;

use App\Models\Responsivas_medicion;
use App\Models\MedicionReparacion;
use App\Models\Responsables;
use App\Models\Prestamos_medicion;
use App\Models\Desc_form_med;
use App\Models\Categoria_medicion;
use App\Models\Mediciondanada;


use App\Models\Archivos;
use App\Models\Descripcion_medicion;
use App\Models\Formato;
use App\Models\Herramienta_medicion;
use DB;
 
class ResponsivasMedicionComponent extends Component
{
    use WithFileUploads;
    public $componentName;
    public $pageTitle;
    public $table = [];
    public $archivos = [];
    public $responsiva, $obra, $encargado, $cargo_e, $responsable, $cargo, $fecha_r, $fecha_e, $status, $com;
    public $herramientas = [];
    public $comentario;
    public $rol;
    public $factura;
    public $dato;
    public $val;
    public $accion;

    public function mount(){
        $this->componentName = 'Responsivas';
        $this->pageTitle = 'Medicion'; 
        $this->table    = Responsivas_medicion::all();
        
        $this->rol = Auth::user()->rol;  
           
    }
    public function accion($opc, $val)
    {
        $this->accion = $opc;
        $this->val = $val;
        switch ($opc) {
            case 0:
                if($this->val != null){
                $this->herramientas = Prestamos_medicion::where('id_resp',$this->val)->get();
                }
                $this->emit('show-modal');
            break;
            case 1:
                $this->emit('show-modal');
                break;
            case 2:
                $this->editar();
                break;
            case 3:
                $this->archivos = Archivos::where('id_reponsiva',$this->val)->get();
                $this->emit('show-modal');
               
                break;
            case 4:
                $this->dato  =  Prestamos_medicion::where('id',$this->val)->first()->id_resp;
                $this->emit('show-modal');
                break;
                case 5:
                $this->dato = Mediciondanada::all();
                    $this->emit('show-modal');
                    break;
        }
    }
    public function render()
    {
        return view('livewire.responsivasmedicion.responsivas-medicion-component')->extends('adminlte::page')->section('content');
    }

    public function reparar_equipo($id){
        $data = Responsivas_medicion::find($this->val);
        $responsivas = Formato::find($data->responsiva);
        if($id == 1){
            $tipo = 1;
        }else{
            $tipo = 2;

        }
        MedicionReparacion::create([
            'resposiva' => $responsivas->id,
            'origen' => $this->val,
            'estatus'=> 'En revision',
            'tipo' => $tipo,
        ]);
        Responsivas_medicion::where('id',$this->val)->update([
            'status' => 5
        ]);
        $this->emit('success', 'Se envio a reparacion');

    }
    public function editar(){

        $data = Responsivas_medicion::find($this->val);
        $responsivas = Formato::find($data->responsiva);
        $this->responsiva = $responsivas->Nombre;
        $this->obra = $data->obra;
        $this->encargado = $data->encargado;
        $this->cargo_e = $data->cargo;
        $respo = Responsables::find($data->responsable);
        $this->responsable = $respo->Nombre.' '.$respo->Apellido_P.' '.$respo->Apellido_M;
        $this->com = $data->com;
        $this->emit('show-modal');
    }
    public function delete_img($id){
        $dato = Archivos::find($id);
        Storage::delete('public/assets/conformidades/'.$dato->archivo);
        Archivos::where('id', $id)->delete();
        $this->emit('success1', 'Se elimino la foto');
    }
    public function Update(){
        Responsivas_medicion::where('id',$this->val)->update([
           
            'obra' => $this->obra,
            'encargado' => $this->encargado,
            'cargo_e' => $this->cargo,
            'com' => $this->com
        ]);

    }

    public function herramienta($id){
        $info ='';
        $data = '';
        if($id != null){
        $datos = Descripcion_medicion::find($id);
        $info = $datos->tipo;
        $data = Categoria_medicion::find($info);
        
        }
        return $data->categoria;
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
    public function devolver($id){
      Responsivas_medicion::where('id',$id)->update([
                'status' => 0
       ]);
       $this->emit('success', 'Se recibio el equipo');

    }
    public function cargo($id)
    {
        $dato = '';
        $nombre = '';
        if ($id != null) {
            $dato = Responsables::find($id);
            $nombre = $dato->Cargo;
        } else {
            $nombre = '';
        }

        return $nombre;
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
           $salvar = $this->factura->storeAs('public/assets/conformidades/',$name);
                
    
           $docs = new Archivos();
           $docs->archivo = $name;
           $docs->id_reponsiva = $this->val;
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
public function enviar_reparacion(){

    $rule = [
        'comentario' => 'required',
   
    ];

    $message = [
        'comentario.required' => '**Este campo es obligatorio.**',

    ];
    $this->validate($rule, $message);
    DB::beginTransaction();

    try {
        $data = Prestamos_medicion::find($this->val);
        $d =  Responsivas_medicion::find($data->id_resp);
    $datos =  new Mediciondanada();
    $datos->herramineta = $data->herr;
    $datos->id_resp = $d->id;
    $datos->status = 1;
    $datos->comentario      = $this->comentario;
     $datos->save();

    
      DB::commit();
      $this->emit('success', 'Exito se envio herramienta dañada');
  } catch (\Exception $e) {
      DB::rollBack();
      // Registrar cualquier excepción en los logs
      \Log::error('Error al guardar el origen: ' . $e->getMessage());
      // Emitir un mensaje de error
      $this->emit('error', 'Ocurrió un error al subir el archivo.' . $e->getMessage());
  }
}
 public function reparar($id){

    Mediciondanada::where('id',$id)->update([
        'status' => 0
    ]);
    $this->emit('success', 'Se cambio el estatus');
}
  public function resetUI(){
    $this->responsiva = ''; 
    $this->obra = '';
    $this->encargado = '';
    $this->cargo_e = '';
    $this->responsable = '';
    $this->cargo = '';
    $this->fecha_r = '';
    $this->fecha_e = ''; 
    $this->status = ''; 
    $this->com = '';
    $this->herramientas = [];
    $this->val = '';
    $this->accion = '';

   } 
  public function resetUII(){
    $this->archivos = Archivos::where('id_reponsiva',$this->val)->get();
    $this->factura = '';
   }
}
