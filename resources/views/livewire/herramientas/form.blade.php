@include('common.modalHead')
@switch($accion)
    @case(1)
    <div class="row">
        <section class="col-md-12">
        <div class="form-group">
            <label for="">Herramienta</label>
            <input type="text" name="nombre" class="form-control required" required="true" wire:model="Herramienta">
            @error('Herramienta')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        </section>
        <section class="col-md-6">
        <div class="form-group">
            <label for="">Tipo</label>
            <select name="tipo" class="form-control required" required="true" wire:model="tipo">
                <option></option>
                <option value="1">Manual</option>
                <option value="2">Media</option>
                <option value="3">Pesada</option>
            </select>
            @error('tipo')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        </section>
        <section class="col-md-6">
        <div class="form-group">
            <label for="">Cantidad</label>
            <input type="number" name="alias" class="form-control required" required="true" wire:model="Cantidad">
            @error('Cantidad')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        </section>
       
    </div>
    @break

    @case(2)
    <div class="row">
        <section class="col-md-12">
        <div class="form-group">
            <label for="">Herramienta</label>
            <input type="text" name="nombre" class="form-control required" required="true" wire:model="Herramienta">
            @error('Herramienta')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        </section>
        <section class="col-md-6">
        <div class="form-group">
            <label for="">Tipo</label>
            <select name="tipo" class="form-control required" required="true" wire:model="tipo">
                <option></option>
                <option value="1">Manual</option>
                <option value="2">Media</option>
                <option value="3">Pesada</option>
            </select>
            @error('tipo')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        </section>
        <section class="col-md-6">
        <div class="form-group">
            <label for="">Cantidad</label>
            <input type="number" name="alias" class="form-control required" required="true" wire:model="Cantidad">
            @error('Cantidad')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        </section>

    </div>
    @break
    @case(3)
    <div class="row">
        <section class="col-md-9">
           <h3> Subir facturas</h3>
        </section>
        <section class="col-md-2">
            <button class="btn btn-dark btn-sm" wire:click="accion(4,0)">Retroceder</button>
        </section>
        <section class="col-md-12">
            <div class="form-group">
                <label>Numero de factura</label>
                <input type="text" class="form-control"  wire:model="num_fact">
                @error('num_fact')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
              
            </div>
            <div class="form-group">
                <label>Proveedor</label>
                <input type="text" class="form-control"  wire:model="proveedor">
                @error('proveedor')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
              
            </div>
            <div class="form-group">
                <label>Monto</label>
                <input type="number" class="form-control"  wire:model="monto">
                @error('monto')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
              
            </div>
            <div class="form-group">
                <label>Factura</label>
                <input type="file" class="form-control" name="factura" wire:model="factura">
                @error('factura')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
                <div wire:loading wire:target="factura">Uploading...</div>
            </div>
        <table class="table">
            <thead class="bg-dark">
                <th>Archivo</th>
                <th>Monto</th>
                <th>Acciones</th>
            </thead>
            <tbody>
                @foreach($archivos as $row)
                <tr>
                <td><a href="{{url('faturas_requi')}}/{{$row->documento}}" target="_blank"> {{$row->documento}}</a></td>
                <td>{{$row->monto}}</td>
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
        <section class="col-md-10">
         <h3>   Requisicion</h3>
        </section>
        <section class="col-md-1">
            <button class="btn btn-dark" wire:click="accion(5,0)">Generar</button>
        </section>
        <section class="col-md-12">
            <table class="table">
                <thead class="bg-dark">
                    <th>Requisicion</th>
                    <th>Acciones</th>
                </thead>
                <tbody>
                   @php
                       $req1 = App\Models\Requisicion::select('folio')->distinct('folio')->get();
                   @endphp 
                    @foreach($req1 as $row )
             
                   <tr>
                    <td><button class="btn btn-link btn-sm" wire:click="accion(6,'{{$row->folio}}')">{{$row->folio}}</button></td>
                    <td><button class="btn btn-secondary btn-sm"  wire:click="accion(3,'{{$row->folio}}')"><span class="fa fa-upload"></span></button>  <button class="btn btn-danger btn-sm" onclick="eliminar_req('{{$row->folio}}')"><span class="far fa-times-circle"></span></button></td>
                   </tr>
                    @endforeach
                </tbody>
            </table>
        </section>
    </div>
    @break
    @case(5)
    <div class="row">
    <section class="col-md-9">
        <h3>Crear Requisicion</h3>
    </section>
    <section class="col-md-3">
        <button class="btn btn-info btn-sm" wire:click="accion(4,0)">Retornar</button>
        <button class="btn btn-dark btn-sm" wire:click="finalizar_req()">Finalizar</button>
    </section>
    <hr>
    <section class="col-md-8">
        <div class="form-group" wire:ignore >
            <label>Herramienta</label>
        <select class="form-control slct2" onchange="obtener_herramienta(this.value)">
            <option></option>
            @foreach($select as $row)
                <option value="{{$row->id}}">{{$row->Herramienta}}</option>
            @endforeach
        </select>
        @error('herramienta')
        <span class="text-danger">{{ $message }}</span>
    @enderror
        </div>
    </section>
    <section class="col-md-2">
        <div class="form-group">
            <label>Cantidad</label>
        <input class="form-control" type="number" wire:model="cantidad">
        @error('cantidad')
        <span class="text-danger">{{ $message }}</span>
    @enderror
        </div>
    </section>
    <section class="col-md-1"><br>
      <button class="btn btn-success" wire:click="agregar_tmp()">Agregar</button>
    </section>
    <section class="col-md-12"> 
        <table class="table">
            <thead class="bg-dark">
                <th>Herramienta</th>
                <th>Cantidad</th>
                <th>Acciones</th>
            </thead>
            <tbody>
                @foreach($tmp as $row)
                    <tr>
                        <td>{{$this->herr($row->material)}}</td>
                        <td>{{$row->cantidad}}</td>
                        <td><button class="btn btn-danger btn-sm" onclick="eliminar_tmp({{$row->id}})"><span class="far fa-times-circle"></span></button></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </section>
    </div>
    <script>
        $('.slct2').select2();
      </script>
    @break
    @case(6)
      <div class="row">
        <section class="col-md-10">
          <h3>Herramientas de requisicion</h3> 
        </section>
    <section class="col-md-2">
        <button class="btn btn-dark btn-sm" wire:click="accion(4,0)">Retroceder</button>
    </section>
<section class="col-md-12">
    <div class="row">
      
    <section class="col-md-8">
        <h4>{{App\Models\Requisicion::where('folio',$val)->first()->folio}}</h4>
    </section>
    <section class="col-md-3">
        {{App\Models\Requisicion::where('folio',$val)->first()->created_at}}

    </section>
    </div>
    <table class="table">
    <thead class="bg-dark">
        <th>Herramienta</th>
        <th>Cantidad</th>
    </thead>
    <tbody>
        
        @foreach($cont as $row=> $c)
    
            <tr>
                <td>{{$this->herr($c->herramienta)}}</td>
                <td>{{$c->cantidad}}</td>
            </tr>
        @endforeach
    </tbody>
</table>
</section>

      </div>
    @break
@endswitch
@include('common.modalFooter')
