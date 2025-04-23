@include('common.modalHead')
<style>
    .estatico{
        height: 300px;
        overflow: scroll;  
    }
    </style>
@switch($accion)
    @case(0)
    @break

    @case(1)
        <div class="row">
            <section class="col-md-6">
                <div class="form-group" wire:ignore>
                    <label for="">Responsable</label>
                    <select name="resp" class="form-control slct2" onchange="responsable(this.value)" wire:model="reponsable"
                        wire:ignore.lazy>
                        <option value=""></option>
                        @foreach ($responsables as $val)
                            <option value="<?= $val->id ?>"><?= $val->Nombre ?> <?= $val->Apellido_P ?> <?= $val->Apellido_M ?>
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('reponsable')
                    <span class="text-danger">{{ $message }}</span>
                @enderror

            </section>
            <section class="col-md-6">
                <div class="form-group" wire:ignore>
                    <label for="">Portador</label>
                    <select name="portador" class="form-control slct2" onchange="portador(this.value)" wire:model="Portador"
                        wire:ignore.lazy>
                        <option></option>
                        
                        @foreach ($portadores as $val)
                            <option value="{{ $val->id }}">{{ $val->Nombre }} {{ $val->Apellido_P }}
                                {{ $val->Apellido_M }} </option>
                        @endforeach
                    </select>
                    @error('Portador')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror

                </div>


            </section>
        @break

        @case(2)
            {{ $codigo }}
            <h3><b>{{ $nreponsable }}</b></h3>
            <div class="form-group">
                <label for="">N° de serie</label>
                <input type="text" class="form-control" name="numser" wire:ignore.lazy wire:model="numser">
                @error('numser')
                <span class="text-danger">{{ $message }}</span>
            @enderror

            </div>

            <div class="form-group" wire:ignore>
                <label for="">Herramientas</label>
                <select name="her" class="form-control slct2" onchange="obtener_herramienta(this.value)"  wire:model="herr" wire:ignore.lazy>
                    <option value=""></option>
                    {!! $this->hers() !!}
                  
                </select>
                @error('herr')
                <span class="text-danger">{{ $message }}</span>
            @enderror

            </div>    
            </section>

                <div class="row">

                    <section class="col-md-6">
                        <div class="form-group">
                            <label for="">Marca</label>
                            <input type="text" class="form-control" name="marca" wire:ignore.lazy wire:model="marca">
                            @error('marca')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
    
                        </div>

                    </section>
                    <section class="col-md-6">

                        <div class="form-group">
                            <label for="">Modelo</label>
                            <input type="text" class="form-control" name="modelo" wire:ignore.lazy wire:model="modelo">
                            @error('modelo')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
    
                        </div>
                    </section>
                </div>
                <div class="form-group">
                    <label for="">Cantidad</label>
                    <input name="cant" type="number" class="form-control" wire:ignore.lazy wire:model="cantidad">
                    @error('cantidad')
                    <span class="text-danger">{{ $message }}</span>
                @enderror

                </div>
                <div class="form-group">
                  
                    <label>Foto</label>
                    <input type="file" class="form-control" name="factura" id="factura" wire:model="factura">
                    @error('factura')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <div wire:loading wire:target="factura">Uploading...</div>
                </div>
                <div class="form-group">
                    <label for="">Comentario</label>
                    <textarea name="com" class="form-control" wire:ignore.lazy wire:model="com">
</textarea>
                </div>
            @break

            @case(4)
            
            <h3>Herramientas de mano</h3>
            <div class="prestamos1 table-responsive">
                <div class="estatico">
                <table class="table  order-table"  id="examplex">
                <thead>
                
                    <th>Numero de serie</th>
                    <th>Herramienta</th>
                    <th>Modelo</th>
                    <th>Marca</th>
                    <th>Cantidad</th>
                    <th>Accion</th>
                </thead>
                <tbody >
           
                @foreach ($her_mano as $key ) 
                <tr>
                     <td><?= $key->numser?> </td>
    
                    <td><?= $this->herramientas($key->herr)?></td>
                    <td><?= $key->modelo ?></td>
                    <td><?= $key->marca ?></td>
                    
                    <td><?= $key->cantidad ?></td>
                    
                    <td hidden><?= $key->id?></td>
                @endforeach
        </table>
                </div>
        </div>
            @break
            @case(5)
            <h3>Herramienta de mediana</h3>
            <div class="prestamos1 table-responsive">
            <div class="estatico">
                <table class="table  order-table"  id="examplex">
                    <thead>
                  
                        <th>Numero de serie</th>
                        <th>Herramienta</th>
                        <th>Modelo</th>
                        <th>Marca</th>
                        <th>Cantidad</th>
                        <th>Accion</th>
                    </thead>
                    <tbody>
                    {!!$this->herramientas_mediana($val)!!}      
                    </tbody>
            </table>
            </div>
            @break
            @case(6)
  <div class="bg-danger"> 
	<h3> Herramientas defectuosas	</h3>
  </div>
	<div class="table-responsive estatico">
	<table  class="table">
	<thead>		
		<th>Herramienta</th>
		<th>Comentario</th>
		<th>Accion</th>
	</thead>
	<tbody>	
       {!!$herramienta_danada !!}
    </tbody>	
</table>
    </div>

            @break
        @endswitch
        <script>
            $('.table').DataTable();
            $('.slct2').select2({
                dropdownParent: $('#theModal'),
                dropdownAutoWidth: true,
                placeholder: 'Selecciona una opcion',
                width: '100%'
            })
        </script>
        @include('common.modalFooter')
