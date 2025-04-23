<?php

namespace App\Http\Livewire\Home;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class HomeComponent extends Component
{
    public $componentName;
    public $pageTitle;
    public $rol;

    public function mount()
    {
        $this->componentName = 'Inicio';
        $this->pageTitle     = 'Dashboard';
        $this->rol = Auth::user()->rol;
    }
    public function render()
    {
        return view('livewire.home.home-component')->extends('adminlte::page')->section('content');
    }
}
