@include('common.modalHead')
@switch($accion)
@case(0)
<div class="row">
    
  
<h3>Manuales</h3>
<div class="table-responsive" id="cont">
    
<table class="table">
    <thead class="bg-dark">
      

      <th>Archivo</th>
      <th>Accion</th> 
    </thead>
    <tbody>
        @foreach($documentos as $val)
        <tr>
        <td><a href="{{url('manuales')}}/{{$val->manual}}" >{{$val->manual}}</a> </td>
            <td><button type="button" onclick="eliminar_imagen({{$val->id}})" class="btn btn-danger  btn-sm"><span class="fa fa-times"> </span></button></td>
          </tr>
        @endforeach
    </tbody>
</table>
</div>
</div>

@break  
    @case(1)
    <div class="row">
        <div class="col-md-12">
          <div class="form-group">    
        <label for="">Codigo de barra</label>
        <input type="text" class="form-control" name="codigob" wire:model="codigob">
        @error('codigo')
        <span class="text-danger">{{ $message }}</span>
    @enderror
      </div>
        </div>
             <div class="col-md-5">
         <div class="form-group">		
             <label for="">Codigo interno</label>
             <input type="text" class="form-control" name="codigo" required="" wire:model="codigo">
             @error('codigo')
             <span class="text-danger">{{ $message }}</span>
         @enderror
         </div>
             </div>
             <div class="col-md-7">
                 <div class="form-group">
             <label for="">Instrumento</label>
             <input type="text" class="form-control" name="instrumento" required="" wire:model="instrumento">
             @error('instrumento')
             <span class="text-danger">{{ $message }}</span>
         @enderror
         </div>
             </div>
         </div>
      <div class="form-group">
        <label for="">Clasificacion</label>
        <select class="form-control" name="clasificacion" wire:model="clasificacion">
          <option value=""></option>
         
        @foreach ($categorias as  $val)     
        <option value="<?= $val->id?>"><?= $val->categoria ?></option>
        @endforeach
        </select>
        @error('clasificacion')
        <span class="text-danger">{{ $message }}</span>
    @enderror
      </div>
         <div class="form-group">
             <label for="">Marca o Modelo</label>
             <input type="text" name="modelo" class="form-control" required="" wire:model="modelo">
             @error('modelo')
             <span class="text-danger">{{ $message }}</span>
         @enderror
         </div>
         <div class="form-group">
             <label for="">Descripcion</label>
             <textarea class="form-control" name="desc" required="" wire:model="descripcion"></textarea>
             @error('descripcion')
             <span class="text-danger">{{ $message }}</span>
         @enderror
         </div>
    @break

    @case(2)
    <div class="row">
        <div class="col-md-12">
          <div class="form-group">    
        <label for="">Codigo de barra</label>
        <input type="text" class="form-control" name="codigob" wire:model="codigob">
        @error('codigo')
        <span class="text-danger">{{ $message }}</span>
    @enderror
      </div>
        </div>
             <div class="col-md-5">
         <div class="form-group">		
             <label for="">Codigo interno</label>
             <input type="text" class="form-control" name="codigo" required="" wire:model="codigo">
             @error('codigo')
             <span class="text-danger">{{ $message }}</span>
         @enderror
         </div>
             </div>
             <div class="col-md-7">
                 <div class="form-group">
             <label for="">Instrumento</label>
             <input type="text" class="form-control" name="instrumento" required="" wire:model="instrumento">
             @error('instrumento')
             <span class="text-danger">{{ $message }}</span>
         @enderror
         </div>
             </div>
         </div>
      <div class="form-group">
        <label for="">Clasificacion</label>
        <select class="form-control" name="clasificacion" wire:model="clasificacion">
          <option value=""></option>
         
        @foreach ($categorias as  $val)     
        <option value="<?= $val->id?>"><?= $val->categoria ?></option>
        @endforeach
        </select>
        @error('clasificacion')
        <span class="text-danger">{{ $message }}</span>
    @enderror
      </div>
         <div class="form-group">
             <label for="">Marca o Modelo</label>
             <input type="text" name="modelo" class="form-control" required="" wire:model="modelo">
             @error('modelo')
             <span class="text-danger">{{ $message }}</span>
         @enderror
         </div>
         <div class="form-group">
             <label for="">Descripcion</label>
             <textarea class="form-control" name="desc" required="" wire:model="descripcion"></textarea>
             @error('descripcion')
             <span class="text-danger">{{ $message }}</span>
         @enderror
         </div>
    @break

    @case(3)
   
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