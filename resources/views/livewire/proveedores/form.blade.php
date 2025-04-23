@include('common.modalHead')
@switch($accion)
@case(1)

    <div class="form-group">
        <label>Proveedor</label>
        <input type="text" name="prov" class="form-control" wire:model="Nombre_Proveedor" required>
        @error('Nombre_Proveedor')
        <span class="text-danger">{{ $message }}</span>
    @enderror
     </div>  
        <div class="form-group">
        <label>Contacto</label>
        <input type="text" name="con" wire:model="Nombre_contacto" class="form-control" required>
        @error('Nombre_contacto')
        <span class="text-danger">{{ $message }}</span>
    @enderror    
    </div>
        <div class="form-group">
        <label>Ciudad </label>
        <input type="text" name="cd" wire:model="Ciudad" class="form-control">
        @error('Ciudad')
        <span class="text-danger">{{ $message }}</span>
    @enderror
        </div> 
        <div class="form-group">
        <label>Telefono</label>
        <input type="text" name="tel" class="form-control" wire:model="Telefono" maxlength="10" required>
        @error('Telefono')
        <span class="text-danger">{{ $message }}</span>
    @enderror
        </div>  
        <div class="form-group">
        <label>Tipo</label>
        <input type="text" name="tip" wire:model="Tipo" class="form-control">
        @error('Tipo')
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>
@break
@case(2)
<div class="form-group">
    <label>Proveedor</label>
    <input type="text" name="prov" class="form-control" wire:model="Nombre_Proveedor" required>
    @error('Nombre_Proveedor')
    <span class="text-danger">{{ $message }}</span>
@enderror
 </div>  
    <div class="form-group">
    <label>Contacto</label>
    <input type="text" name="con" wire:model="Nombre_contacto" class="form-control" required>
    @error('Nombre_contacto')
    <span class="text-danger">{{ $message }}</span>
@enderror    
</div>
    <div class="form-group">
    <label>Ciudad </label>
    <input type="text" name="cd" wire:model="Ciudad" class="form-control">
    @error('Ciudad')
    <span class="text-danger">{{ $message }}</span>
@enderror
    </div> 
    <div class="form-group">
    <label>Telefono</label>
    <input type="text" name="tel" class="form-control" wire:model="Telefono" maxlength="10" required>
    @error('Telefono')
    <span class="text-danger">{{ $message }}</span>
@enderror
    </div>  
    <div class="form-group">
    <label>Tipo</label>
    <input type="text" name="tip" wire:model="Tipo" class="form-control">
    @error('Tipo')
    <span class="text-danger">{{ $message }}</span>
@enderror
</div>
@break
@endswitch
@include('common.modalFooter')