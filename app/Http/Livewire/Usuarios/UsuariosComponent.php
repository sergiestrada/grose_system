<?php

namespace App\Http\Livewire\Usuarios;

use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use DB;

class UsuariosComponent extends Component
{
    public $componentName;
    public $pageTitle;
    public $users = [];
    public $contador = 1;
    public $accion;
    public $dato;
    public $name;
    public $email;
    public $rol;
    public $password;

    public function mount()
    {
        $this->componentName = 'Configuracion';
        $this->pageTitle     = 'Usuarios';
        $this->users         = User::all(); 

    }

    public function accion($opc,$val)
    {
        $this->accion = $opc;
        $this->dato   = $val;

        switch($opc){
            case 1: 
                $this->crear();
                break;
            case 2: 
                $this->editar();
                break;
            
        }

    }
    public function editar()
    {
        $user = User::find($this->dato);
        $this->name     =   $user->name;
        $this->email    =   $user->email;
        $this->rol      =   $user->rol;

        $this->emit('show-modal');
    }
    public function crear(){
     
        $this->emit('show-modal');
    }
    public function render()
    {
        return view('livewire.usuarios.usuarios-component')->extends('adminlte::page')->section('content');
    }
    public function Store()
    {
        $rule = [
            'name'   => 'required|string',
            'email'   => 'required|string',
            'password'    => 'required|min:8',
            'rol'  => 'required',
            
        ];

        $message = [
            'name.required'     =>   '**Este campo es obligatorio.**',
            'email.required'    =>   '**Este campo es obligatorio.**',
            'password.required' =>   '**Este campo es obligatorio.**',
            'rol.required'      =>   '**Este campo es obligatorio.**',
           
        ];
        $this->validate($rule, $message);

        DB::beginTransaction();
        try {
            $user = new User();
            $user->name    = $this->name;
            $user->email   = $this->email;
            $user->rol     = $this->rol;
            $user->activo  = 1;
            $user->password = Hash::make($this->password);
        $user->save();
        DB::commit();
        $this->emit('success','Agregaste un usuario');
        }catch (\Exception $e) {
            DB::rollBack();
          // Registrar cualquier excepción en los logs
          \Log::error('Error al guardar el origen: ' . $e->getMessage());
          // Emitir un mensaje de error
          $this->emit('error', 'Ocurrió un error al guardar el usuario.');
      }
    }
    public function Update(){
        User::where('id',$this->dato)->Update([
            'name'    => $this->name,
            'email'   => $this->email,
            'rol'     => $this->rol,
            'password' => Hash::make($this->password)
        ]);
        $this->emit('success','Se actualizo el usuario');
    }
    public function bloquear($id)
    {
        $estatus = User::find($id);
        if($estatus->activo == 1){
            User::where('id',$id)->update(['activo' => 0]);
            $this->emit('success','Haz desactivado este usuario');
        }else{
            User::where('id',$id)->update(['activo' => 1]);
            $this->emit('success','Activaste este usuario');
        }
        
    }

    public function resetUI(){
        $this->accion   = '';
        $this->dato     = '';
        $this->name     = '';
        $this->email    = '';
        $this->rol      = '';
        $this->password = '';
    }
    
}
