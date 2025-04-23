<?php

namespace App\Http\Livewire\Formato;

use Livewire\Component;
use App\Models\Formato;
use Illuminate\Support\Facades\Auth;
use DB;
class FormatoComponent extends Component
{
    public $componentName;
    public $pageTitle;
    public $tabla   = [];
    public $contador = 1;
    public $Nombre,$nom_equi, $clave, $modelo, $marca, $serie; 
    public $val;
    public $accion;
    public $rol;

    public function mount()
    {
        $this->componentName = 'Configuracion';
        $this->pageTitle     = 'Formatos de medicion';
        $this->rol = Auth::user()->rol;
    }

    public function accion($opc, $val)
    {
        $this->accion = $opc;
        $this->val = $val;
        switch ($opc) {
          
            case 1:
                $this->crear();
                break;
            case 2:
                $this->editar();
                break;
           
        }
    }

    public function crear()
    {
        $this->emit('show-modal');
    }

  public function editar()
    {
        $datos = Formato::find($this->val);
        $this->Nombre = $datos->Nombre;
        $this->nom_equi = $datos->nom_equi;
        $this->clave = $datos->clave;
        $this->modelo = $datos->modelo;
        $this->marca = $datos->marca;
        $this->serie = $datos->serie;
        $this->emit('show-modal');
    }
    public function render()
    {
        $this->tabla = Formato::all();
        return view('livewire.formato.formato-component', ['tabla', $this->tabla])->extends('adminlte::page')->section('content');

    }
    public function Store()
    {
        $rule = [
            'Nombre' => 'required',
            'nom_equi' => 'required',
            'clave' => 'required',
            'modelo' => 'required',
            'marca' => 'required',
            'serie'        => 'required',
          
        ];

        $message = [

            'Nombre.required'   =>   '**Este campo es obligatorio.**',
            'nom_equi.required'      =>   '**Este campo es obligatorio.**',
            'clave.required'    =>   '**Este campo es obligatorio.**',
            'modelo.required'   =>   '**Este campo es obligatorio.**',
            'marca.required'     =>   '**Este campo es obligatorio.**',
            'serie.required'    =>   '**Este campo es obligatorio.**',
         
        ];

        $this->validate($rule, $message);

        DB::beginTransaction();

        try {
            $datos = new Formato();
            $datos->Nombre  = $this->Nombre;
            $datos->nom_equi    = $this->nom_equi;
            $datos->clave       = $this->clave;
            $datos->modelo      = $this->modelo;
            $datos->marca       = $this->marca;
            $datos->serie       = $this->serie;
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
    public function Update()
    {
        $rule = [
            'Nombre' => 'required',
            'nom_equi' => 'required',
            'clave' => 'required',
            'modelo' => 'required',
            'marca' => 'required',
            'serie'        => 'required',
        ];

        $message = [
            'Nombre.required'   =>   '**Este campo es obligatorio.**',
            'nom_equi.required'      =>   '**Este campo es obligatorio.**',
            'clave.required'    =>   '**Este campo es obligatorio.**',
            'modelo.required'   =>   '**Este campo es obligatorio.**',
            'marca.required'     =>   '**Este campo es obligatorio.**',
            'serie.required'    =>   '**Este campo es obligatorio.**',
        ];

        $this->validate($rule, $message);

        DB::beginTransaction();

        try {
            Formato::where('id', $this->val)->update([
                'Nombre'  => $this->Nombre,
                'nom_equi'     => $this->nom_equi,
                'clave'       => $this->clave,
                'modelo'      => $this->modelo,
                'marca'    => $this->marca,
                'serie'         => $this->serie,
               
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

    public function delete($id){
            Formato::where('id',$id)->delete();
            $this->emit('success', 'Se elimino el dato');  
    }
    public function resetUI()
    {
       $this->Nombre = '';
       $this->nom_equi = '';
       $this->clave = ''; 
       $this->modelo = ''; 
       $this->marca = ''; 
       $this->serie = ''; 
       $this->val = '';
       $this->accion = '';
    
    }
}
