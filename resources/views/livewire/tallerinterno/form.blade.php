@include('common.modalHead')
@switch($accion)
    @case(1)
    <div class="form-group">
        <label>Nombre del encargado:</label>
        <div class="row">
            <section class="col-md-4">
                <input type="text" name="nombre" class="form-control" placeholder="Nombre" wire:model="Nombre">
                @error('Nombre')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </section>
            <section class="col-md-4">
                <input type="text" name="app" class="form-control" placeholder="Apellido Paterno" wire:model="Apellido_P">
                @error('Apellido_P')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </section>
            <section class="col-md-4">
                <input type="text" name="apm" class="form-control" placeholder="Apellido Materno"
                wire:model="Apellido_M">
            @error('Apellido_M')
                <span class="text-danger">{{ $message }}</span>
            @enderror
            </section>
    
</div>
       
        <div class="form-group">
            <label>Telefono</label>
            <input type="text" class="form-control" maxlength="10" name="tel" wire:model="Telefono">
            @error('Telefono')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label>Obra</label>
            <input type="text" class="form-control" name="obra" wire:model="Obra">
            @error('Obra')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>


@break

@case(2)
<div class="form-group">
    <label>Nombre del encargado:</label>
    <div class="row">
        <section class="col-md-4">
            <input type="text" name="nombre" class="form-control" placeholder="Nombre" wire:model="Nombre">
            @error('Nombre')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </section>
        <section class="col-md-4">
            <input type="text" name="app" class="form-control" placeholder="Apellido Paterno" wire:model="Apellido_P">
            @error('Apellido_P')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </section>
        <section class="col-md-4">
            <input type="text" name="apm" class="form-control" placeholder="Apellido Materno"
            wire:model="Apellido_M">
        @error('Apellido_M')
            <span class="text-danger">{{ $message }}</span>
        @enderror
        </section>

</div>
    <div class="form-group">
        <label>Telefono</label>
        <input type="text" class="form-control" maxlength="10" name="tel" wire:model="Telefono">
        @error('Telefono')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="form-group">
        <label>Obra</label>
        <input type="text" class="form-control" name="obra" wire:model="Obra">
        @error('Obra')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>


@break
@endswitch
@include('common.modalFooter')
