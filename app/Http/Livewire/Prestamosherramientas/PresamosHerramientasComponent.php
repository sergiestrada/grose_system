<?php

namespace App\Http\Livewire\Prestamosherramientas;

use Livewire\Component;


use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;
use App\Models\Historial_responsivas;
use App\Models\Responsables;
use App\Models\Herramientas;
use App\Models\Prestamos;
use App\Models\Comentarios;
use DB;




class PresamosHerramientasComponent extends Component
{
    use WithFileUploads;

    public $componentName;
    public $pageTitle;
    public $tabla   = [];
    public $responsables = [];
    public $portadores = [];
    public $her_mano = [];
    public $herr_mayor = [];
    public $danada = [];
    public $herramienta_danada;
    public $contador = 1;
    public $val;

    public $nreponsable, $nPortador;
    public $reponsable, $Portador, $herr, $cantidad, $codigo, $numser, $modelo, $com, $marca;
    public $tipo_doc;
    public $factura;
    public $accion;
    public $rol;

    public $herramientas = [];

 
    public function mount()
    {
        $this->componentName = 'Herramientas';
        $this->pageTitle     = 'Prestamos';
        $this->herramientas = Herramientas::all();
        $this->responsables = Responsables::all();
        $this->portadores = Responsables::all();
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
            case 4:
                $this->herramienta_manor();
                break;
             case 5:
                $this->herramienta_pesado();
              break;
            case 6:
                $this->danada();
            break;
        }
    }

    public function crear()
    {
        $this->emit('show-modal');
    }

    public function editar()
    {
        $dato = Historial_responsivas::find($this->val);
        $this->codigo = $dato->codigo;
        $this->reponsable = $dato->reponsable;
        $this->Portador   = $dato->Portador;
        $this->nreponsable =  $this->responsable($dato->reponsable);
        $this->emit('show-modal');
    }
    public function herramienta_manor(){

        $this->her_mano  = Prestamos::where('codigo',$this->val)
                                        ->where('marca','!=','')
                                        ->where('status',0)
                                        ->get();

        $this->emit('show-modal');
    }
    public function herramienta_pesado(){
        $this->herr_mayor = Prestamos::select('herr')
                                ->where('codigo', $this->val)
                                ->where('status', 0)
                                ->where('marca', '')
                                ->where('modelo', '')
                                ->distinct()
                                ->get();
                              
             $this->emit('show-modal');
    }
    public function portadors(){
        $datos = '';
        foreach ($this->portadores as $val){
                   $datos .='<option value="'.$val->id.'">'.$val->Nombre.' '.$val->Apellido_P.' '.$val->Apellido_M.'</option>';
        }
        return $datos;

    }
    public function danada(){
        $this->danada = Comentarios::where('codigo',$this->val)->get();
        foreach($this->danada as $row){
            $this->herramienta_danada .= '<tr><td>'.$this->herramientas($row->herr).'</td><td>'.$row->com.'</td></tr>';
        }
       $this->emit('show-modal');
    }


    public function responsable($id)
    {
        $dato = '';
        $nombre = '';
     if($id != null){
        $dato = Responsables::find($id);
        $nombre = $dato->Nombre.' '.$dato->Apellido_P.' '.$dato->Apellido_M;
     }else{
        $nombre = '';
     }   
    return $nombre;
    }
   
    public function render()
    {
        $this->tabla = Historial_responsivas::all();
        return view('livewire.prestamosherramientas.presamos-herramientas-component')->extends('adminlte::page')->section('content');
    }

    public function Store()
    {
        $rule = [
            'reponsable' => 'required',
            'Portador' => 'required',
                     
        ];

        $message = [
            'reponsable.required'   =>   '**Este campo es obligatorio.**',
            'Portador.required'   =>   '**Este campo es obligatorio.**',
          
        ];

        $this->validate($rule, $message);

        DB::beginTransaction();

        try {
            $d = 'P-'.date('dmYhis');
            $datos = new Historial_responsivas();
            $datos->reponsable  = $this->reponsable;
            $datos->Portador     = $this->Portador;
            $datos->codigo       = $d;
            $datos->status       = 1;
            $datos->estatus      = 0;
            $datos->fecha        = date('Y-m-d');
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
   
    public function herramientas($id){
        $herramienta = Herramientas::find($id);
        return $herramienta->Herramienta;
    }
    
    public function herramientas_mediana($id){
      $dato = '';
      foreach($this->herr_mayor as $h){
   
        $dato .= '<tr>
                    <td>'.Prestamos::where('codigo',$this->val)->where('herr',$h->herr)->first()->numser .'</td>
                    <td>'.$this->herramientas($h->herr).'</td><td>'.Prestamos::where('codigo',$this->val)->where('herr',$h->herr)->first()->modelo .'</td>
                    <td>'.Prestamos::where('codigo',$this->val)->where('herr',$h->herr)->first()->marca .'</td>
                    <td>'.Prestamos::where('codigo',$this->val)->where('herr',$h->herr)->sum('cantidad') .'</td>
                </tr>';
      }
    

     return $dato;
    }
public function hers(){
   $data = '';
   $herramientas = Herramientas::where('cantidad','>','0')->get();
    foreach ($herramientas as $v){
  $data .= '<option value="'.$v->id.'">'.$v->Herramienta.'('.$v->Cantidad.') </option>';
    }
    echo $data;
}
    public function Update()
    {
    $rule = [
        
            'herr' => 'required',
            'cantidad' => 'required',
          
        ];

        $message = [
           
            'herr.required'   =>   '**Este campo es obligatorio.**',
            'cantidad.required'   =>   '**Este campo es obligatorio.**',
       
        ];

        $this->validate($rule, $message);
        $existencia = Herramientas::find($this->herr);
      
        DB::beginTransaction();
if($this->cantidad > $existencia->cantidad){
        try {
            if($this->factura != ''){
            $name = $this->factura->getClientOriginalName();
            $salvar = $this->factura->storeAs('public/assets/imagenes_herramienta/', $name);
            }else{
                $name = '';
            }
         
            $datos = new Prestamos();
            $datos->responsable  = $this->reponsable;
            $datos->portador    = $this->Portador;
            $datos->herr        = $this->herr;
            $datos->cantidad    = $this->cantidad;
            $datos->codigo      = $this->codigo;
            $datos->numser      = $this->numser;
            $datos->modelo      = $this->modelo;
            $datos->marca       = $this->marca;
            $datos->com      = $this->com;
            $datos->foto      = $name;

            $datos->stat      = 1;
            $datos->status      = 0;
            $datos->hora        = date('h:i:s');
            $datos->fecha        = date('Y-m-d');
         $datos->save();

            $total = $existencia->Cantidad - $this->cantidad;
            Herramientas::where('id',$this->herr)->update([
                    'cantidad'=>$total
            ]);
            DB::commit();
            $this->emit('success1', 'Se agrego el dato');
        } catch (\Exception $e) {
            DB::rollBack();
            // Registrar cualquier excepción en los logs
            \Log::error('Error al guardar el origen: ' . $e->getMessage());
            // Emitir un mensaje de error
            $this->emit('error', 'Ocurrió un error al guardar el dato.' . $e->getMessage());
        }
    }else{
        $this->emit('error', 'No tienes existencias.');
    }
    }
    public function delete($id){
        Historial_responsivas::where('id',$id)->delete();
        $this->emit('success', 'Se elimino dato');
    }

    
    public function resetUI()
    {
        $this->her_mano = [];
        $this->herr_mayor = [];
        $this->danada = [];
        $this->herramienta_danada ='';
        $this->val = '';
        $this->nreponsable = ''; 
        $this->nPortador = '';
        $this->reponsable = '';
        $this->Portador = '';
        $this->herr = '';
        $this->cantidad = '';
        $this->codigo = ''; 
        $this->factura;
        $this->numser = '';
        $this->modelo = ''; 
        $this->com = '';
        $this->marca = '';
        $this->accion = '';
    }
    public function resetUII(){
        $this->herr = '';
        $this->cantidad = '';
      
        $this->factura = NULL;
        $this->numser = '';
        $this->modelo = ''; 
        $this->com = '';
        $this->herramientas = Herramientas::all();
        $this->marca = '';
    }

}
