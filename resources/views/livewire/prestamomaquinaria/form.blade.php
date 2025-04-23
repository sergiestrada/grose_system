@include('common.modalHead')
@switch($accion)
@case(1)
<div class="row">
    <section class="col-md-12">
        <div class="form-group" wire:ignore>
            <label>Vehiculo</label>
            <select class="form-control slct" onclick="vehiculo(this.value)" wire:model="herr">
                <option></option>
            @foreach ($maquinaria as $val)
            <option value="<?= $val->id ?>"><?= $val->Nombre_Id ?></option>
        @endforeach
            </select>
            @error('herr')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </section>
    <section class="col-md-6">

           <div class="form-group" wire:ignore>
            <label>Responsable </label>
            <select class="form-control slct" name="responsable" wire:model="responsable" onchange="responsable(this.value)" wire:ignore.lazy>
                <option value=""></option>
                @foreach ($responsables as $val)
                    <option value="<?= $val->id ?>"><?= $val->Nombre ?> <?= $val->Apellido_P ?> <?= $val->Apellido_M ?></option>
                @endforeach
        
            </select>
            @error('responsable')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </section>
    <section class="col-md-6">
       
        <div class="form-group" wire:ignore>
            <label>Portador </label>
            <select class="form-control slct" name="portador" wire:model="portador" onchange="portador(this.value)" wire:ignore.lazy>
                <option value=""></option>
                @foreach ($responsables as $val)
                    <option value="<?= $val->id ?>"><?= $val->Nombre ?> <?= $val->Apellido_P ?> <?= $val->Apellido_M ?></option>
                @endforeach
        
            </select>
            @error('portador')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </section>
      <section class="col-md-12">
        <div class="form-group">
            <label>Comentario</label>
            <textarea class="form-control" wire:model="com" wire.ignore.lazy></textarea>
        </div>
    </section>

</div>





<script>
    $('.slct').select2({
        dropdownParent: $('#theModal'),
        dropdownAutoWidth: true,
        placeholder: 'Selecciona una opcion',
        width: '100%'
    })


   
</script>
@break
@case(2)
<div class="row">
<h3>Editar Maqunaria</h3>
<section class="col-md-12">
<b>{{$this->maquinaria($val)}}</b>
</section>
<section class="col-md-6">

           <div class="form-group" wire:ignore>
            <label>Responsable </label>
            <select class="form-control slct" name="responsable" wire:model="responsable" onchange="responsable(this.value)" wire:ignore.lazy>
                <option value="{{$responsable}}">{{$this->responsable($responsable)}}</option>   
                <option value=""></option>
                @foreach ($responsables as $val)
                    <option value="<?= $val->id ?>"><?= $val->Nombre ?> <?= $val->Apellido_P ?> <?= $val->Apellido_M ?></option>
                @endforeach
        
            </select>
            @error('responsable')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </section>
    <section class="col-md-6">
       
        <div class="form-group" wire:ignore>
            <label>Portador </label>

            <select class="form-control slct" name="portador"  onchange="portador(this.value)" wire:ignore.lazy>
                <option value="{{$portador}}">{{$this->responsable($portador)}}</option>
                <option value=""></option>

                @foreach ($responsables as $val)
                    <option value="<?= $val->id ?>"><?= $val->Nombre ?> <?= $val->Apellido_P ?> <?= $val->Apellido_M ?></option>
                @endforeach
        
            </select>
            @error('portador')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </section>
      <section class="col-md-12">
        <div class="form-group">
            <label>Comentario</label>
            <textarea class="form-control" wire:model="com" >
                {{$com}}
            </textarea>
        </div>
    </section>

</div>


<script>
    $('.slct').select2({
        dropdownParent: $('#theModal'),
        dropdownAutoWidth: true,
        placeholder: 'Selecciona una opcion',
        width: '100%'
    })


   
</script>
@break
@case(3)
<div class="row">
    <section class="col-md-9">
       <h3> Subir documentarios</h3>
    </section>
   
    <section class="col-md-12">
      
        <div class="form-group">
            <label>Documentos</label>
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
            <td><a href="{{url('documentos_maquinaria')}}/{{$row->archivo}}" target="_blank"> {{$row->archivo}}</a></td>
            <td><button class="btn btn-danger btn-sm" onclick="eliminar_archivo({{$row->id}})"><span class="far fa-times-circle"></span></button>
            @endforeach
        </tbody>
    </table>
    </section>
<hr>

</div>

@break
@case(4)
<div class="row">
    
    <section class="col-md-9">
        <h3>Motivo de retorno</h3>
    </section>
    <section class="col-md-3">
    
        <button class="btn btn-dark btn-sm" wire:click="retorno_taller()">Finalizar</button>
    </section>
    <section class="col-md-12">
        <div class="form-group">
            <label>Comentario</label>
            <textarea class="form-control" wire:model="coment"></textarea>
        </div>
    </section>

</div>
@break
@case(5)
<div class="row">
    
    <section class="col-md-9">
        <h3>Motivo de deshechar la maquinaria</h3>
    </section>
    <section class="col-md-3">
        <button class="btn btn-dark btn-sm" wire:click="deshechar()">Finalizar</button>
    </section>
    <section class="col-md-12">
        <div class="form-group">
            <label>Comentario</label>
            <textarea class="form-control" wire:model="coment"></textarea>
        </div>
    </section>

</div>
@break
@case(6)
<div class="row">
    <section class="col-md-10">
<h3>Enviar a reparacion</h3>
</section>
<section class="col-md-1">
    <button class="btn btn-dark btn-sm" wire:click="guardar_danada()">Guardar</button>
</section>
<section class="col-md-12">

<div class="form-group">
    <label>Codigo de barras</label>
    <input class="form-control" wire:model="cod_barras">
    @error('cod_barras')
    <span class="text-danger">{{ $message }}</span>
@enderror
</div>
<div class="form-group">
    <label>Comentarios</label>
    <textarea class="form-control" wire:model="coment"></textarea>
    @error('coment')
    <span class="text-danger">{{ $message }}</span>
@enderror
</div>
<table class="table">
    <thead class="bg-dark">
        <th>Codigo</th>
        <th>Codigo barras</th>
        <th>Comentarios</th>
        <th>Acciones</th>
    </thead>
    <tbody>
    
        @foreach($reparacion as $row)
        <tr>
            <td>{{$row->codigo}}</td>
            <td>{{$row->cod_barras}}</td>
            <td>{{$row->Comentario}}</td>
            <td><button class="btn btn-success btn-sm" wire:click="accion(4,{{$row->id}})"><span class="fa fa-check"></span></button>
                <button class="btn btn-danger btn-sm" wire:click="accion(5,{{$row->id}})"><span class="far fa-times-circle"></span></button>
            </td>

        </tr>
        @endforeach
    </tbody>
</table>
</section>
@break
@case(8)
<div class="row">
    <section class="col-md-12">
        <h3>Agregar maquinaria al prestamo<br> {{$val}}</h3>
        <div class="form-group" wire:ignore>
            <label>Vehiculo</label>
            <select class="form-control slct" onclick="vehiculo(this.value)" wire:model="herr">
                <option></option>
            @foreach ($maquinaria as $val)
            <option value="<?= $val->id ?>"><?= $val->Nombre_Id ?></option>
        @endforeach
            </select>
            @error('herr')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </section>
    
      <section class="col-md-12">
        <div class="form-group">
            <label>Comentario</label>
            <textarea class="form-control" wire:model="com" wire.ignore.lazy></textarea>
        </div>
        <table class="table">
            <thead class="bg-dark">
                <th>Maquinaria</th>
                <th>Accion</th>
            </thead>
            <tbody>
                    @foreach($maquinarias as $row)
                        <tr>
                            <td>{{$this->get_maquinaria($row->herr)}}</td>
                           <td> <button class="btn btn-primary btn-sm"  wire:click="accion(6,{{$row->id}})"><span class="fas fa-tools"></span></button></td>
                        </tr>
                    @endforeach
            </tbody>
        </table>
    </section>






</div>
<script>
    $('.slct').select2({
        dropdownParent: $('#theModal'),
        dropdownAutoWidth: true,
        placeholder: 'Selecciona una opcion',
        width: '100%'
    })


   
</script>
@break
@endswitch
@include('common.modalFooter')