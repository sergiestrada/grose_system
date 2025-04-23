@section('title', $componentName . ' | ' . $pageTitle)
@section('content_header')

@endsection
<div><br>
    <article class="container-fluid d-print-none" >
    <div class="row">

        <div class="col-md-11">
            <h3>{{ $pageTitle }}</h3>
        </div>
        <div class="col-md-1">
     
            <a href="reportes" class="btn btn-secondary">Folio</a>
        </div>
        <div class="col-md-12">
            <div class="col-md-12">
                <div class="row">
                <div class="col-md-11">
                    <div class="form-group" wire:ignore>
                    <label>Herramienta</label>
                <select class="form-control slct" onchange="filtro(this.value)">
                <option></option>
                 @foreach($responsables as $row)
                 <option value="{{$row->id}}">{{$row->Herramienta}} </option>
                 @endforeach
                </select>
                    </div>
                </div>
                    <div class="col-md-1">
                        <br>
                    <a href="#" class="btn btn-info btn-sm" onclick="window.print();">Imprimir</a>
                   
                </div>
                </div>
        <table class="table tablex">
        	<thead>

                <th>Fecha</th>
                <th>Codigo</th>
                <th>Responsable</th>
                <th>Herramienta</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>N° de serie</th>
                <th>Cantidad</th> 
            </thead>
            <tbody>
                @foreach ($tabla as $key )
                <tr> 
                <td><?= $key->fecha?></td>
                <td><?= $key->codigo?></td>
                <td ><?= $this->responsable($key->responsable)?></td>
                <td>{{ DB::table('herramientas')->where ('id',$key->herr)->first()->Herramienta}}</td>
                <td><?= $key->marca?></td>
                <td><?= $key->modelo?></td>
                <td><?= $key->numser?></td>
                @if($key->marca == '')

                <td><?=  DB::table('prestamos')->where('responsable', $key->responsable)->where('status',0)->where('herr',$key->herr)->sum('cantidad')?></td>
                @else
        
                <td><?=  DB::table('prestamos')->where ('responsable',$key->responsable)->where('status',0)->where('herr',$key->herr)->first()->cantidad ?></td>
                @endif
                </tr>
                @endforeach
                
            </tbody>
        </table>
</div>
    </article>
    <article class="container d-none d-print-block" >
        <div class="row">
    
            <div class="col-md-9">
                <h3>{{ $pageTitle }}</h3>
            </div>
           
          
            <table class="table">
                <thead>
    
                    <th>Fecha</th>
                    <th>Codigo</th>
                    <th>Responsable</th>
                    <th>Herramienta</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>N° de serie</th>
                    <th>Cantidad</th> 
                </thead>
                <tbody>
                    @foreach ($tabla as $key )
                    <tr> 
                    <td><?= $key->fecha?></td>
                    <td><?= $key->codigo?></td>
                    <td ><?= $this->responsable($key->responsable)?></td>
                    <td>{{ DB::table('herramientas')->where ('id',$key->herr)->first()->Herramienta}}</td>
                    <td><?= $key->marca?></td>
                    <td><?= $key->modelo?></td>
                    <td><?= $key->numser?></td>
                    @if($key->marca == '')
    
                    <td><?=  DB::table('prestamos')->where('responsable', $key->responsable)->where('status',0)->where('herr',$key->herr)->sum('cantidad')?></td>
                    @else
            
                    <td><?=  DB::table('prestamos')->where ('responsable',$key->responsable)->where('status',0)->where('herr',$key->herr)->first()->cantidad ?></td>
                    @endif
                    </tr>
                    @endforeach
                    
                </tbody>
            </table>
    </div>
        </article>
</div>
@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        @if($rol == 'herramientas')
            $('.admin').hide();
            $('.medicion').hide();
            $('.mantenimiento').hide();
@endif
    
        @if($rol == 'medicion')
            $('.admin').hide();
            $('.herramientas').hide();
            $('.mantenimiento').hide();

        
        @endif
        @if($rol == 'mantenimiento')
            $('.admin').hide();
            $('.medicion').hide();
            $('.herramientas').hide();

        
        @endif
        $('.tablex').DataTable()
        $('.slct').select2()
    })
    function filtro(id){
        @this.set('filtro',id)
    }
</script>
@stop