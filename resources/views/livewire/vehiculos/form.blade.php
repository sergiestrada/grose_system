@include('common.modalHead')
@switch($accion)
@case(0)
<div class="row">
    <div class="col-md-12">
@foreach($imagen as $row)

    <img class="img-thumbnail" style="width:15%" src="{{url('vehiculos_foto')}}/{{$row->Doc}}">
  
@endforeach
</div>
 
<div class="table-responsive" id="cont">
    <h3>Documentos</h3>
<table class="table">
    <thead class="bg-dark">
      
        <th>Tipo Documento</th>
      <th>Documento</th>
      <th>Accion</th> 
    </thead>
    <tbody>
        @foreach($documentos as $val)
        <tr>
            <td>@if($val->T_doc == 1) Poliza @endif @if($val->T_doc == 2) Factura @endif @if($val->T_doc == 3) Manual @endif @if($val->T_doc == 4) Fotos @endif @if($val->T_doc == 5) Tarjeta de circulacion @endif</td>
            <td>
                @if($val->T_doc == 1)
                    <a href="{{url('vehiculos_poliza')}}/{{$val->Doc}}" target="_blank"> 
                @endif
                @if($val->T_doc == 2) 
                    <a href="{{url('vehiculos_factura')}}/{{$val->Doc}}" target="_blank"> 
                @endif 
                @if($val->T_doc == 3) 
                    <a href="{{url('vehiculos_manual')}}/{{$val->Doc}}" target="_blank">  
                @endif @if($val->T_doc == 4) 
                    <a href="{{url('vehiculos_foto')}}/{{$val->Doc}}" target="_blank">  
                @endif 
                @if($val->T_doc == 5) 
                    <a href="{{url('vehiculos_tarjeta')}}/{{$val->Doc}}" target="_blank">
                @endif
                
                {{$val->Doc}}
                    </a>
            </td>
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
            <div class="col-md-6">
                <div class="form-group">
                    <label>N° Interno</label>
                    <input type="text" class="form-control" name="numint" wire:model="numint" wire:ignore.lazy>
                    @error('numint')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Nombre</label>
                    <input type="text" class="form-control" name="Nombre"  wire:model="Nombre" required wire:ignore.lazy>
                    @error('Nombre')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Marca</label>
                    <input type="text" class="form-control" name="Marca" wire:model="Marca" wire:ignore.lazy>
                    @error('Marca')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Año </label>
                    <select class="form-control" name="Ano" wire:model="Ano" wire:ignore.lazy>
                        <option value=""></option>

                        @for ($i = 1970; $i <= $a[0]; $i++)
                            <option value="<?= $i ?>"><?= $i ?></option>
                        @endfor
                    </select>
                    @error('Ano')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Placa </label>
                    <input type="text" class="form-control" name="Placa" wire:model="Placa" required wire:ignore.lazy>
                    @error('Placa')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Poliza </label>
                    <input type="text" class="form-control"  wire:model="Poliza" required wire:ignore.lazy>
                    @error('Poliza')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label>No GPS </label>
                    <input type="text" class="form-control"  wire:model="no_gps" required wire:ignore.lazy>
                    @error('no_gps')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Modelo</label>
                    <input type="text" class="form-control" name="Modelo" wire:model="Modelo" wire:ignore.lazy>
                    @error('Modelo')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Tipo </label>
                    <input type="text" class="form-control" name="Tipo" wire:model="Tipo"  wire:ignore.lazy>
                    @error('Tipo')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Color</label>
                    <input type="text" class="form-control" name="Color" wire:model="Color" wire:ignore.lazy>
                    @error('Color')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Afianzadora </label>
                    <input type="text" class="form-control" name="afianzadora" wire:model="afianzadora" required wire:ignore.lazy>
                    @error('afianzadora')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Estatus GPS </label>
                    <input type="text" class="form-control" name="estatus_gsp" wire:model="estatus_gsp" required wire:ignore.lazy>
                    @error('estatus_gsp')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>No Serie </label>
                    <input type="text" class="form-control" name="No_Serie" wire:model="No_Serie" wire:ignore.lazy>
                    @error('No_Serie')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Kilometraje </label>
                    <input type="text" class="form-control" name="Kilometraje" wire:model="Kilometraje" wire:ignore.lazy>
                    @error('Kilometraje')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Tarjeta de circulacion</label>
                    <input type="text" class="form-control" name="tc" wire:model="tc" wire:ignore.lazy>
                    @error('tc')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Vigencia Fianza</label>
                    <input type="date" class="form-control" name="vigencia_fianza" wire:model="vigencia_fianza" wire:ignore.lazy>
                    @error('vigencia_fianza')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label>No Motor</label>
                    <input type="text" class="form-control" name="no_motor" wire:model="no_motor" wire:ignore.lazy>
                    @error('no_motor')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="form-group">
            <label>Comentarios </label>
            <input type="text" class="form-control" name="Comentarios" wire:model="Comentarios" wire:ignore.lazy> 
            @error('Comentarios')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    @break

    @case(2)
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>N° Interno</label>
                <input type="text" class="form-control" name="numint" wire:model="numint" wire:ignore.lazy>
                @error('numint')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Nombre</label>
                <input type="text" class="form-control" name="Nombre"  wire:model="Nombre" required wire:ignore.lazy>
                @error('Nombre')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label>Marca</label>
                <input type="text" class="form-control" name="Marca" wire:model="Marca" wire:ignore.lazy>
                @error('Marca')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label>Año </label>
                <select class="form-control" name="Ano" wire:model="Ano" wire:ignore.lazy>
                    <option value=""></option>

                    @for ($i = 1970; $i <= $a[0]; $i++)
                        <option value="<?= $i ?>"><?= $i ?></option>
                    @endfor
                </select>
                @error('Ano')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label>Placa </label>
                <input type="text" class="form-control" name="Placa" wire:model="Placa" required wire:ignore.lazy>
                @error('Placa')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label>Poliza </label>
                <input type="text" class="form-control"  wire:model="Poliza" required wire:ignore.lazy>
                @error('Poliza')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label>No GPS </label>
                <input type="text" class="form-control"  wire:model="no_gps" required wire:ignore.lazy>
                @error('no_gps')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Modelo</label>
                <input type="text" class="form-control" name="Modelo" wire:model="Modelo" wire:ignore.lazy>
                @error('Modelo')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label>Tipo </label>
                <input type="text" class="form-control" name="Tipo" wire:model="Tipo"  wire:ignore.lazy>
                @error('Tipo')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label>Color</label>
                <input type="text" class="form-control" name="Color" wire:model="Color" wire:ignore.lazy>
                @error('Color')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label>Afianzadora </label>
                <input type="text" class="form-control" name="afianzadora" wire:model="afianzadora" required wire:ignore.lazy>
                @error('afianzadora')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label>Estatus GPS </label>
                <input type="text" class="form-control" name="estatus_gsp" wire:model="estatus_gsp" required wire:ignore.lazy>
                @error('estatus_gsp')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>No Serie </label>
                <input type="text" class="form-control" name="No_Serie" wire:model="No_Serie" wire:ignore.lazy>
                @error('No_Serie')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label>Kilometraje </label>
                <input type="text" class="form-control" name="Kilometraje" wire:model="Kilometraje" wire:ignore.lazy>
                @error('Kilometraje')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label>Tarjeta de circulacion</label>
                <input type="text" class="form-control" name="tc" wire:model="tc" wire:ignore.lazy>
                @error('tc')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label>Vigencia Fianza</label>
                <input type="date" class="form-control" name="vigencia_fianza" wire:model="vigencia_fianza" wire:ignore.lazy>
                @error('vigencia_fianza')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label>No Motor</label>
                <input type="text" class="form-control" name="no_motor" wire:model="no_motor" wire:ignore.lazy>
                @error('no_motor')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>
    <div class="form-group">
        <label>Comentarios </label>
        <input type="text" class="form-control" name="Comentarios" wire:model="Comentarios" wire:ignore.lazy> 
        @error('Comentarios')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    @break

    @case(3)
    <h3>Subir documentos</h3>
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
