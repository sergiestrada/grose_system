@section('title', $componentName . ' | ' . $pageTitle)
@section('content_header')

@endsection
<div><br>
    <article class="container-fluid">
    <div class="row">
        <div class="col-md-9">
            <h3>{{ $pageTitle }}</h3>
        </div>
        <div class="col-md-3">
            <a href="rep_emp" class="btn btn-secondary">Empleados</a>
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
                    <a href="#" class="btn btn-info">Imprimir</a>
                   
                </div>
                </div>
        <table class="table tablex">
        	<thead>
                <th>Fecha</th>
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
                    <td>{{ DB::table('herramientas')->where ('id',$key->herr)->first()->Herramienta}}</td>
                    <td><?= $key->marca?></td>
                    <td><?= $key->modelo?></td>
                    <td><?= $key->numser?></td>
                    <td><?=  $key->cantidad ?></td>
                
                </tr>
                    @endforeach
            </tbody>
    </div>
</div>
    </div>  </article>