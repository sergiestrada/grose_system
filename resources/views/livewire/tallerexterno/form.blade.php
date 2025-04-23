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
               
              
      
            <div class="form-group"><label>Telefono </label>
                <input type="text" name="tel" maxlength="10" class="form-control" wire:model="Telefono">
                @error('Telefono')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label>Ciudad </label>
                <input type="text" name="cd" class="form-control" wire:model="Ciudad">
                @error('Ciudad')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label>Nombre Taller</label>
                <input type="text" name="ntal" class="form-control" wire:model="Nombre_Taller">
                @error('Nombre_Taller')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
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
       
      

    <div class="form-group"><label>Telefono </label>
        <input type="text" name="tel" maxlength="10" class="form-control" wire:model="Telefono">
        @error('Telefono')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="form-group">
        <label>Ciudad </label>
        <input type="text" name="cd" class="form-control" wire:model="Ciudad">
        @error('Ciudad')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="form-group">
        <label>Nombre Taller</label>
        <input type="text" name="ntal" class="form-control" wire:model="Nombre_Taller">
        @error('Nombre_Taller')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
</div>

    @break

@endswitch
@include('common.modalFooter')
