@include('common.modalHead')
@switch($accion)
    @case(1)
        <h3>Realizar cambios</h3>
        <div class="form-group">
            <label for="">Accion</label>
            <select name="accion" class="form-control" wire:model="cambio">
                <option value=""></option>
                <option value="1">Cambiar de responsable</option>
                <option value="2">Quitar</option>
            </select>
        </div>
        <h3>{{ $this->nh }}</h3>
        <div class="form-group">
            <label for="">Cantidad</label>
            <input type="number" name="pza" @if($pza == 1) readonly @endif class="form-control" id="pza" wire:model="pza">
        </div>
        @if ($cambio == 1)
            <div class="form-group" wire:ignore>
                <label>Responsable</label>
                <select class="form-control slct" onchange="responsable(this.value)">
                    <option></option>
                    @foreach ($responsables as $val)
                        <option value="{{ $val->codigo }},{{ $val->reponsable }}">{{ $val->codigo }}
                            [{{ $this->responsable($val->reponsable) }}] </option>
                    @endforeach
                </select>
                <script>
                    $('.slct').select2();
                </script>
            </div>
        @endif

        <script>
            $('.slct').select2();
        </script>
    @break

    @case(2)
        <div class="form-group">

            <label for="">N° de serie</label>
            <input type="text" class="form-control" name="nser" wire:model="numser">
        </div>
        <div class="form-group">
            <label for="">Modelo</label>
            <input type="text" class="form-control" name="mod" wire:model="modelo">
        </div>
        <div class="form-group">
            <label for="">Marca</label>
            <input type="text" class="form-control" name="marca" wire:model="marca">
        </div>
        <div class="form-group">
            <label for="">Comentario</label>
            <input type="text" class="form-control" name="com" wire:model="com">
        </div>
    @break
@case(4)
<h3>Reporte de reparacion</h3>
<div class="row">
    	<div class="col-md-5">
    		<table class="table table-bordered">
    		<tr>
             
          <td><b>Fecha de baja</b></td>
          <td>{{$fecha_baja}}</td>
            
          </td>
        </tr>
        <tr>
    			<td><b>Codigo</b></td>
    			<td>{{$codigo}} </td>
    		</tr>
        <tr>
          <td><b>Modelo:</b></td>
         <td>{{$modelo}}</td>
        </tr>
    		<tr>
    			<td><b>Herramienta</b></td>
    			<td>{{$nh}}</td>
    		</tr>
    		<tr>
    			<td><b>Comentario</b></td>
    			<td>{{$com}}</td>
    		</tr>
        <tr> 
          <td><b>Fecha de reparacion</b></td>
          <td>      {{$fecha_rep}}    </td>
        </tr>
    		<tr>
    			<td><b>Comentario de reparacion</b></td>
    			<td>{{$com_rep}}</td>
    		</tr>
    		</table>
    	</div>
@break
    @case(3)
        <h3>Subir factura de servicio</h3>
        <button class="btn btn-link" wire:click="accion(0,{{ $val }})">Regresar</button>
        <div class="form-group">

            <label>Documento</label>
            <input type="file" class="form-control" name="factura" wire:model="factura">
            @error('factura')
                <span class="text-danger">{{ $message }}</span>
            @enderror
            <div wire:loading wire:target="factura">Uploading...</div>
        </div>
        <table class="table ">
            <thead class="thead-dark">
                <th>Fecha</th>
                <th>Archivo</th>


                <th> Accion</th>

            </thead>
            <tbody>
                @foreach ($data as $key)
                    <tr>

                        <td>{{ $key->fecha }}</td>
                        <td><a href="{{ url('facturas_herramientas') }}/{{ $key->archivo }}"
                                target="_blank">{{ $key->nombre }}</a></td>
                        <td> <button type="button" onclick="eliminar_imagen({{ $key->id }})" class="btn btn-danger"><span
                                    class="fa fa-times"></span></button></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <script></script>
    @break
@case(7)
<h3>Reporte de reparacion</h3>
<div class="row">
    	<div class="col-md-5">
    		<table class="table table-bordered">
    		<tr>
             
          <td><b>Fecha de baja</b></td>
          <td>{{$fecha_baja}}</td>
            
          </td>
        </tr>
        <tr>
    			<td><b>Codigo</b></td>
    			<td>{{$codigo}} </td>
    		</tr>
        <tr>
          <td><b>Modelo:</b></td>
         <td>{{$modelo}}</td>
        </tr>
    		<tr>
    			<td><b>Herramienta</b></td>
    			<td>{{$nh}}</td>
    		</tr>
    		<td><b>Cantidad</b></td>
            <td>{{$cantidad1}}</td>
            <tr>
    			<td><b>Comentario</b></td>
    			<td>{{$com}}</td>
    		</tr>
        <tr> 
          <td><b>Fecha de reparacion</b></td>
          <td>      {{$fecha_rep}}    </td>
        </tr>
    		<tr>
    			<td><b>Comentario de reparacion</b></td>
    			<td>{{$com_rep}}</td>
    		</tr>
    		</table>
    	</div>
    	<div class="col-md-5">
	
			<label for="">Comentario</label>
			<textarea name="comentario" wire:model="comentario" class="form-control" @if($com_rep != '') disable @endif cols="30" rows="2"></textarea><br>
			
        </div>
@break
    @case(8)
        <div class="form-group" wire:ignore>
            <label>Codigo</label>
            <input type="text" class="form-control" name="cdx" wire:model="cod" wire:ignore.lazy readonly>
            @error('cod')
            <span class="text-danger">{{ $message }}</span>
        @enderror
        </div>
        <label>Codigo de barras</label>
        <div class="form-group">
            <input type="text" class="form-control" name="cbx"  wire:model="cod_barras" wire:ignore.lazy>
            @error('cod_barras')
            <span class="text-danger">{{ $message }}</span>
        @enderror
        </div>
         <label>Cantidad a enviar</label>
        <div class="form-group">
            <input type="text" class="form-control" wire:model="pza" wire:ignore.lazy>
            @error('pza')
            <span class="text-danger">{{ $message }}</span>
        @enderror
        </div>
        <div class="form-group">
            <label>Comentario</label>
            <textarea class="form-control" name="comentario" cols="20" rows="5" wire:model="com" wire:ignore.lazy></textarea>
            @error('com')
            <span class="text-danger">{{ $message }}</span>
        @enderror
        </div>
    @break

@endswitch
@include('common.modalFooter')
