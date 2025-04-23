@include('common.modalHead')
@switch($accion)
    @case(1)
        <div class="form-group">
            <label>Nombre Completo</label>
            <input class="form-control" wire:model="name">
            @error('name')
            <span class="text-danger">{{ $message }}</span>
        @enderror
        </div>
        <div class="form-group">
            <label>Email</label>
            <input class="form-control" wire:model="email" type="email">
            @error('email')
            <span class="text-danger">{{ $message }}</span>
        @enderror
        </div>
        <div class="form-group">
            <label>Rol</label>
            <select class="form-control" wire:model="rol">
                <option></option>
                <option value="admin">Administrador</option>
                <option value="herramientas">Herramientas</option>
                <option value="mantenimiento">Mantenimiento</option>
                <option value="medicion">Medicion</option>
             
               
            </select>
                @error('rol')
                   <span class="text-danger">{{ $message }}</span>
                @enderror
        </div>
        <div class="form-group">
            <label>Contraseña</label>
            <input class="form-control" wire:model="password" type="password">
            @error('password')
            <span class="text-danger">{{ $message }}</span>
        @enderror
        </div>
    @break

    @case(2)
    <div class="form-group">
        <label>Nombre Completo</label>
        <input class="form-control" wire:model="name">
    </div>
    <div class="form-group">
        <label>Email</label>
        <input class="form-control" wire:model="email" type="email">
    </div>
    <div class="form-group">
        <label>Rol</label>
        <select class="form-control" wire:model="rol">
            <option></option>
            <option value="admin">Administrador</option>
        </select>
    </div>
    <div class="form-group">
        <label>Contraseña</label>
        <input class="form-control" wire:model="password" type="password">
    </div>
    @break

    @default
@endswitch

@include('common.modalFooter')
