@section('title', $componentName . ' | ' . $pageTitle)
@section('content_header')

@endsection
<div>
<article class="container-fluid d-none  d-print-block">
    <br>
    <div class="row">

        <div class="col-md-11">
            <h3>{{ $pageTitle }}</h3>
        </div>
        <div class="col-md-1">
        </div>
        <div class="col-md-12">
        <div class="row">
            @foreach ($tabla as  $val)
            <section class="col-md-12">
            <section class="card">
            	<div class="card-header bg-dark">
                	<div class="row">
                        <div class="col-md-10">
                            <h3>{{ $this->responsable($val->reponsable)}}</h3>
                        </div>
                        <div class="col-md-2">
                             @if($val->status == 1) Activo @else Cerrado @endif
                        </div>
                        <div class="col-md-8"><?= $val->fecha?></div>	<div class="col-md-4"><?= $val->codigo?></div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table">
				
				    	<thead>
				  
				    	<th>Herramientas</th>
                        <th>Modelo</th>
                        <th>Marca</th>
                            <th>Numero Serie</th>
							<th>Cantidad</th>
				    	</thead>
				    	<tbody>
						
							@php 
							$datos = \App\Models\Prestamos::where('codigo',$val->codigo)->where('status',0)->get();
                            @endphp

							@foreach ($datos as $key) 
							<tr>
                           
                                <td>
                                    @php
                                        $herramienta = DB::table('herramientas')->where('id', $key->herr)->first();
                                        if ($herramienta !== null) {
                                            echo $herramienta->Herramienta;
                                        }
                                    @endphp
                                </td>
								<td>{{$key->modelo}}</td>
                                <td>{{$key->marca}}</td>
                                <td>{{$key->numser}}</td>
                                @if($key->marca == '')
								<td><?=  DB::table('prestamos')->where('codigo', $val->codigo)->where('status',0)->where('herr',$key->herr)->sum('cantidad')?></td>
								@else
								<td><?=  DB::table('prestamos')->where ('codigo',$val->codigo)->where('status',0)->where('herr',$key->herr)->first()->cantidad ?></td>
								@endif
								
							</tr>
						@endforeach
							 
				  		</tbody>
				    </table>
                </div>

            </section>
            </section>
            @endforeach
        </div>
    </article>
<article class="container d-print-none">
    
    <br>
    <div class="row">

        <div class="col-md-10">
            <h3>{{ $pageTitle }}</h3>
        </div>
        <div class="col-md-2">
            <a href="rep_herramientas" class="btn btn-secondary">Herramientas</a>
        </div>
        <div class="col-md-12">
            <div class="row">
            <div class="col-md-11">
                <div class="form-group" wire:ignore>
                <label>Responsable</label>
            <select class="form-control slct" onchange="filtro(this.value)">
            <option></option>
             @foreach($responsables as $row)
             <option value="{{$row->id}}">{{$row->Nombre}} {{$row->Apellido_P}} {{$row->Apellido_M}}</option>
             @endforeach
            </select>
                </div>
            </div>
                <div class="col-md-1">
                    <br>
                <a href="#" class="btn btn-info btn-sm" onclick="window.print();">Imprimir</a>
               
            </div>
            </div>
        <div class="row">
            @foreach ($tabla as  $val)
            <section class="col-md-12">
            <section class="card">
            	<div class="card-header bg-dark">
                	<div class="row">
                        <div class="col-md-10">
                            <h3>{{$val->Nombre}} {{$val->Apellido_P}} {{$val->Apellido_M}}</h3>
                        </div>
                        <div class="col-md-2">
                             @if($val->status == 1) Activo @else Cerrado @endif
                        </div>
                        <div class="col-md-8"><?= $val->fecha?></div>	<div class="col-md-4"><?= $val->codigo?></div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table tablex">
				
				    	<thead>
				    	
				    	<th>Herramientas</th>	
							<th>Cantidad</th>
				    	</thead>
				    	<tbody>
						
							@php 
							$datos = \App\Models\Prestamos::where('codigo',$val->codigo)->where('status',0)->get();
                            @endphp

							@foreach ($datos as $key) 
							<tr>
                                <td>
                                    @php
                                        $herramienta = DB::table('herramientas')->where('id', $key->herr)->first();
                                        if ($herramienta !== null) {
                                            echo $herramienta->Herramienta;
                                        }
                                    @endphp
                                </td>
								@if($key->marca == '')
								<td><?=  DB::table('prestamos')->where('codigo', $val->codigo)->where('status',0)->where('herr',$key->herr)->sum('cantidad')?></td>
								@else
								<td><?=  DB::table('prestamos')->where ('codigo',$val->codigo)->where('status',0)->where('herr',$key->herr)->first()->cantidad ?></td>
								@endif
								
							</tr>
						@endforeach
							 
				  		</tbody>
				    </table>
                </div>

            </section>
            </section>
            @endforeach
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
			
							
			 