@include('common.modalHead')
@switch($accion)

@case(1)
        <div class="form-group">
            <div class="row">
                <div class="col-md-4">
                      <div class="form-group">
                     <label>No Empleado </label>
                     <input type="text" name="no_Empleado" wire:model="no_Empleado" class="form-control" >
                     @error('no_Empleado')
                     <span class="text-danger">{{ $message }}</span>
                 @enderror
                     </div>
                 <div class="form-group">
                     <label>Apellido Materno </label>
                     <input type="text" name="apellido_M" wire:model="apellido_M" class="form-control">
                     @error('apellido_M')
                     <span class="text-danger">{{ $message }}</span>
                 @enderror 
                    </div>
                
                     <div class="form-group">
                     <label>Antiguedad</label>
                     <input type="number" name="antiguedad" wire:model="antiguedad" class="form-control" >
                  
                    </div>
                </div>
                <div class="col-md-4">
                      <div class="form-group">
                      <label>Nombre</label>
                      <input type="text" name="nombre" wire:model="nombre" class="form-control" required>
                      @error('nombre')
                      <span class="text-danger">{{ $message }}</span>
                  @enderror
                    </div>
    
                       <div class="form-group">
                     <label>Cargo</label>
                     <input type="text" name="cargo" wire:model="cargo" class="form-control">
                     @error('cargo')
                     <span class="text-danger">{{ $message }}</span>
                 @enderror
                    </div>
                      <div class="form-group">
                     <label>Estado</label>
                     <select name="estado" wire:model="estado" class="form-control">
                     <option value=""></option>
              
                     @foreach($estados as $key) 
                       <option value="{{$key->id}}">{{$key->estado}}</option>
                     @endforeach
                     </select>
                     @error('estado')
                     <span class="text-danger">{{ $message }}</span>
                 @enderror
                     </div>
                </div>
                <div class="col-md-4">
                 <div class="form-group">
                      <label>Apellido Paterno</label>
                      <input type="text" name="apellido_P" wire:model="apellido_P" class="form-control" required="">
                      @error('apellido_P')
                      <span class="text-danger">{{ $message }}</span>
                  @enderror
                      </div>
                      <div class="form-group">
                     <label>Telefono </label>
                     <input type="text" name="numero_contacto" wire:model="numero_contacto" class="form-control" maxlength="10">
                     @error('numero_contacto')
                     <span class="text-danger">{{ $message }}</span>
                 @enderror
                     </div>
                      
                      </div>
        </div>
    @break

    @case(2)
    <div class="form-group">
        <div class="row">
            <div class="col-md-4">
                  <div class="form-group">
                 <label>No Empleado </label>
                 <input type="text" name="no_Empleado" wire:model="no_Empleado" class="form-control" >
                 @error('no_Empleado')
                 <span class="text-danger">{{ $message }}</span>
             @enderror
                 </div>
             <div class="form-group">
                 <label>Apellido Materno </label>
                 <input type="text" name="apellido_M" wire:model="apellido_M" class="form-control">
                 @error('apellido_M')
                 <span class="text-danger">{{ $message }}</span>
             @enderror 
                </div>
            
                 <div class="form-group">
                 <label>Antiguedad</label>
                 <input type="number" name="antiguedad" wire:model="antiguedad" class="form-control" >
              
                </div>
            </div>
            <div class="col-md-4">
                  <div class="form-group">
                  <label>Nombre</label>
                  <input type="text" name="nombre" wire:model="nombre" class="form-control" required>
                  @error('nombre')
                  <span class="text-danger">{{ $message }}</span>
              @enderror
                </div>

                   <div class="form-group">
                 <label>Cargo</label>
                 <input type="text" name="cargo" wire:model="cargo" class="form-control">
                 @error('cargo')
                 <span class="text-danger">{{ $message }}</span>
             @enderror
                </div>
                  <div class="form-group">
                 <label>Estado</label>
                 <select name="estado" wire:model="estado" class="form-control">
                 <option value=""></option>
          
                 @foreach($estados as $key) 
                   <option value="{{$key->id}}">{{$key->estado}}</option>
                 @endforeach
                 </select>
                 @error('estado')
                 <span class="text-danger">{{ $message }}</span>
             @enderror
                 </div>
            </div>
            <div class="col-md-4">
             <div class="form-group">
                  <label>Apellido Paterno</label>
                  <input type="text" name="apellido_P" wire:model="apellido_P" class="form-control" required="">
                  @error('apellido_P')
                  <span class="text-danger">{{ $message }}</span>
              @enderror
                  </div>
                  <div class="form-group">
                 <label>Telefono </label>
                 <input type="text" name="numero_contacto" wire:model="numero_contacto" class="form-control" maxlength="10">
                 @error('numero_contacto')
                 <span class="text-danger">{{ $message }}</span>
             @enderror
                 </div>
                  
                  </div>
    </div>
    @break

    @default
@endswitch

@include('common.modalFooter')