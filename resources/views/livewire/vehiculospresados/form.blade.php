@include('common.modalHead')

@switch($accion)
    @case(0)
    <div class="row">
        <div class="col-md-12">
            <h1>Documentos</h1>
    @foreach($imagen as $row)
    
        <img class="img-thumbnail" style="width:15%" src="{{url('vehiculos_pesado_foto')}}/{{$row->Doc}}">
      
    @endforeach
    </div>

    <div class="table-responsive" id="cont">
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
                        <a href="{{url('vehiculos_poliza')}}/{{$val->Doc}}"> 
                    @endif
                    @if($val->T_doc == 2) 
                        <a href="{{url('vehiculos_factura')}}/{{$val->Doc}}"> 
                    @endif 
                    @if($val->T_doc == 3) 
                        <a href="{{url('vehiculos_manual')}}/{{$val->Doc}}">  
                    @endif @if($val->T_doc == 4) 
                        <a href="{{url('vehiculos_foto')}}/{{$val->Doc}}">  
                    @endif 
                    @if($val->T_doc == 5) 
                        <a href="{{url('vehiculos_tarjeta')}}/{{$val->Doc}}">
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
                    <label>N° interno </label>
                    <input type="text" name="numint" wire:model="numint" class="form-control" value="" wire:ignore.lazy>
                    @error('numint')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Marca </label>
                    <input type="text" name="marca" wire:model="Marca" class="form-control" required wire:ignore.lazy>
                    @error('Marca')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Modelo </label>
                    <input type="text" name="modelo" wire:model="Modelo" class="form-control" wire:ignore.lazy>
                    @error('Modelo')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>No Serie</label>
                    <input type="text" name="numser" wire:model="No_Serie" class="form-control" required wire:ignore.lazy>
                    @error('No_Serie')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Año </label>
                    <input type="text" wire:model="Ano" name="ano" class="form-control" list="a">
                    <datalist id="a">
                        @for ($i = 1970; $i <= $a[0]; $i++)
                        <option value="<?= $i ?>"><?= $i ?></option>
                    @endfor
                    </datalist>
                    @error('Ano')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
                </div>
            </div>


        </div>



        <div class="form-group">
            <label>Poliza </label>
            <input type="text" name="poliza" wire:model="Poliza" class="form-control" required wire:ignore.lazy>
            @error('Poliza')
            <span class="text-danger">{{ $message }}</span>
        @enderror
        </div>
        <div class="form-group">
            <label>Tipo </label>
            <input type="text" name="tipo" wire:model="Tipo" class="form-control" wire:ignore.lazy>
            @error('Tipo')
            <span class="text-danger">{{ $message }}</span>
        @enderror
        </div>
        <div class="form-group">
            <label>Comentarios </label>
            <input type="text" name="comentarios" wire:model="Comentarios" class="form-control" wire:ignore.lazy>
            @error('Comentarios')
            <span class="text-danger">{{ $message }}</span>
        @enderror
        </div>
    @break

    @case(2)
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>N° interno </label>
                <input type="text" name="numint" wire:model="numint" class="form-control" value="" wire:ignore.lazy>
                @error('numint')
                <span class="text-danger">{{ $message }}</span>
            @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Marca </label>
                <input type="text" name="marca" wire:model="Marca" class="form-control" required wire:ignore.lazy>
                @error('Marca')
                <span class="text-danger">{{ $message }}</span>
            @enderror
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label>Modelo </label>
                <input type="text" name="modelo" wire:model="Modelo" class="form-control" wire:ignore.lazy>
                @error('Modelo')
                <span class="text-danger">{{ $message }}</span>
            @enderror
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>No Serie</label>
                <input type="text" name="numser" wire:model="No_Serie" class="form-control" required wire:ignore.lazy>
                @error('No_Serie')
                <span class="text-danger">{{ $message }}</span>
            @enderror
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Año </label>
                <input type="text" wire:model="Ano" name="ano" class="form-control" list="a">
                <datalist id="a">
                    @for ($i = 1970; $i <= $a[0]; $i++)
                    <option value="<?= $i ?>"><?= $i ?></option>
                @endfor
                </datalist>
                @error('Ano')
                <span class="text-danger">{{ $message }}</span>
            @enderror
            </div>
        </div>


    </div>



    <div class="form-group">
        <label>Poliza </label>
        <input type="text" name="poliza" wire:model="Poliza" class="form-control" required wire:ignore.lazy>
        @error('Poliza')
        <span class="text-danger">{{ $message }}</span>
    @enderror
    </div>
    <div class="form-group">
        <label>Tipo </label>
        <input type="text" name="tipo" wire:model="Tipo" class="form-control" wire:ignore.lazy>
        @error('Tipo')
        <span class="text-danger">{{ $message }}</span>
    @enderror
    </div>
    <div class="form-group">
        <label>Comentarios </label>
        <input type="text" name="comentarios" wire:model="Comentarios" class="form-control" wire:ignore.lazy>
        @error('Comentarios')
        <span class="text-danger">{{ $message }}</span>
    @enderror
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
