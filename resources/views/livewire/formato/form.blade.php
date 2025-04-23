@include('common.modalHead')
@switch($accion)
    @case(1)
    <div class="row">
        <section class="col-md-6">
            <div class="form-group">
                <label for="">NOMBRE</label>
                <input type="text" name="nombre_res" class="form-control" wire:model="Nombre">
                @error('Nombre')
                <span class="text-danger">{{ $message }}</span>
            @enderror
            </div>

            <div class="form-group">
                <label for=""> CLAVE</label>
                <input type="text" name="clave" class="form-control" wire:model="clave">
                @error('clave')
                <span class="text-danger">{{ $message }}</span>
            @enderror
            </div>

            <div class="form-group">
                <label for="">MODELO</label>
                <input type="text" name="modelo" class="form-control" wire:model="modelo">
                @error('modelo')
                <span class="text-danger">{{ $message }}</span>
            @enderror
            </div>
        </section>
        <section class="col-md-6">
            <div class="form-group">
                <label for=""> NOMBRE DEL EQUIPO</label>
                <input type="text" name="nombre_e" class="form-control" wire:model="nom_equi">
                @error('nom_equi')
                <span class="text-danger">{{ $message }}</span>
            @enderror
            </div>

            <div class="form-group">
                <label for=""> MARCA</label>
                <input type="text" name="marca" class="form-control" wire:model="marca">
                @error('marca')
                <span class="text-danger">{{ $message }}</span>
            @enderror
            </div>
            <div class="form-group">
                <label for="">SERIE</label>
                <input type="text" name="serie" class="form-control" wire:model="serie">
                @error('numint')
                <span class="text-danger">{{ $message }}</span>
            @enderror
            </div>

        </section>
    </div>        
    
    @break

    @case(2)
      <div class="row">
        <section class="col-md-6">
            <div class="form-group">
                <label for="">NOMBRE</label>
                <input type="text" name="nombre_res" class="form-control" wire:model="Nombre">
                @error('Nombre')
                <span class="text-danger">{{ $message }}</span>
            @enderror
            </div>

            <div class="form-group">
                <label for=""> CLAVE</label>
                <input type="text" name="clave" class="form-control" wire:model="clave">
                @error('clave')
                <span class="text-danger">{{ $message }}</span>
            @enderror
            </div>

            <div class="form-group">
                <label for="">MODELO</label>
                <input type="text" name="modelo" class="form-control" wire:model="modelo">
                @error('modelo')
                <span class="text-danger">{{ $message }}</span>
            @enderror
            </div>
        </section>
        <section class="col-md-6">
            <div class="form-group">
                <label for=""> NOMBRE DEL EQUIPO</label>
                <input type="text" name="nombre_e" class="form-control" wire:model="nom_equi">
                @error('nom_equi')
                <span class="text-danger">{{ $message }}</span>
            @enderror
            </div>

            <div class="form-group">
                <label for=""> MARCA</label>
                <input type="text" name="marca" class="form-control" wire:model="marca">
                @error('marca')
                <span class="text-danger">{{ $message }}</span>
            @enderror
            </div>
            <div class="form-group">
                <label for="">SERIE</label>
                <input type="text" name="serie" class="form-control" wire:model="serie">
                @error('numint')
                <span class="text-danger">{{ $message }}</span>
            @enderror
            </div>

        </section>
    </div>
    @break

    @case(3)
        <div class="form-group">
            <label> Tipo de documento</label>
            <select name="tipo" class="form-control" wire:model="tipo_doc">
                <option value="1">Poliza</option>
                <option value="2">Factura</option>
                <option value="3">Manual</option>
                <option value="4">Fotos</option>
                <option value="5">Tarjeta de circulacion</option>
            </select>
        </div>
        <div class="form-group">
            <label>Documento</label>
            <input type="file" class="form-control" name="factura" wire:model="factura">
            @error('factura')
                <span class="text-danger">{{ $message }}</span>
            @enderror
            <div wire:loading wire:target="factura">Uploading...</div>
        </div>
    @break

@endswitch
@include('common.modalFooter')
