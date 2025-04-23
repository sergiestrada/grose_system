@include('common.modalHead')
@switch($accion)
@case(0)
<div class="row">
<section class="col-md-9">
    <h3>Herramientas</h3>
</section>
<section class="col-md-3">
<button class="btn btn-dark" onclick="reparar_equipo(1)">Reparar</button>
<button class="btn btn-dark" onclick="reparar_equipo(2)">Calibrar</button>


</section>
</div>
<table class="table">
    <thead>
        <th>Herramienta</th>
        <th>Acciones</th>
    
    </thead>
    <tbody>
  
        @foreach($herramientas as $row)
       <tr>
        <td>{{$this->herramienta($row->herr)}}</td>
      <td><button class="btn btn-danger btn-sm" wire:click="accion(4,{{$row->id}})"><span class="fas fa-tools"></span></button>
    
       </tr>
        @endforeach
    </tbody>
</table>
@break

@case(2)
<div class="form-group">
    <label for="">Empresa/Obra</label>
<input type="text" name="emp1" wire:model="obra" class="form-control">
    </div>
<div class="form-group">
        <label for="">Responsiva</label>
        <input name="buscar1" class="form-control" wire:model="responsiva" readonly disabled>
              
    </div>
    <div class="form-group">
        <label>Quien entrega</label>
        <input type="text" class="form-control" name="entrego1" wire:model="encargado" required>
    </div>
    <div class="form-group">
        <label>Cargo</label>
        <input type="text" class="form-control" name="cargo1" wire:model="cargo_e" required>
    </div>

    <div class="form-group">
    <label for="">Responsable</label>
    <input name="responsable1" wire:model="responsable" class="form-control" disabled required="">
    
    </div>
    

    <div class="form-group">
        <label for="">Comentario</label>
        <textarea name="com1" class="form-control" wire:model="com" cols="30" rows="3"></textarea>
    </div>
@break
@case(3)
<h3>Subir documentos</h3>
<hr>
<div class="form-group">
    <label>Documento</label>
    <input type="file" class="form-control" name="factura" wire:model="factura">
    @error('factura')
        <span class="text-danger">{{ $message }}</span>
    @enderror
    <div wire:loading wire:target="factura">Uploading...</div>
</div>
<table class="table">
<thead class="bg-dark">
    <th>Archivo</th>
    <th>Acciones</th>
</thead>
<tbody>
    @foreach($archivos as $row)
        <tr>
            <td><a target="_blank" href="{{url('conformidades')}}/{{$row->archivo}}">{{$row->archivo}}</td>
            <td><button class="btn btn-danger btn-sm" onclick="eliminar_img({{$row->id}})"><span class="fa fa-times"></span></button>
        </tr>
    @endforeach
</tbody>
</table>
@break
@case(4)
<div class="row">
<section class="col-md-9">
    <h3>Enviar a reparacion</h3>
</section>
<section class="col-md-3">
    <button class="btn btn-info btn-sm" wire:click="accion(0,{{$dato}})">Retroceder</button>
    <button class="btn btn-dark btn-sm" wire:click="enviar_reparacion()">Enviar</button>

</section>
</div>

<hr>
<div class="form-group">
    <label>Comentario</label>
    <textarea class="form-control" wire:model="comentario"></textarea>
</div>
@break
@case(5)
<h3>Medicion dañada</h3>
<table class="table">
    <thead>
        <th>Herramienta</th>
        <th>Comentario</th>
        <th>Estatus</th>
        <th>Accion</th>
    </thead>
    <tbody>
        @foreach($dato as $row)
        <tr>
            <td>{{$this->herramienta($row->herramineta)}}</td>
            <td>{{$row->comentario}}</td>
            @if($row->status == 1)
            <td class="bg-danger">Dañada</td>
            @else
            <td class="bg-success">Reparada</td>
            @endif
            <td>
                @if($row->status == 1)
                <button class="btn btn-success btn-sm" wire:click="reparar({{$row->id}})"><span class="fa fa-check"></span></button>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@break
@endswitch
@include('common.modalFooter')