@section('title', $componentName . ' | ' . $pageTitle)
@section('content_header')

@endsection
<article class="container-fluid">

    <div class="row">
        <section class="col-md-10"><br>
            <h3>{{ $pageTitle }}</h3>
        </section>
       
        <section class="col-md-12">
       <table class="table">
            <thead class="bg-dark">
                <th>Fecha</th>
                <th>Codigo</th>
                <th>Codigo de barras</th>
                <th>Herramienta</th>
                <th>Comentario</th>
                <th>Comentario de reparacion</th>
                <th>Fecha de reparacion</th>
                <th>Estatus</th>
            </thead>
            <tbody class="">
            @foreach($table as $row)
            <tr>
                <td>{{$row->created_at}}</td>
                <td>{{$row->codigo}}</td>
                <td>{{$row->cod_barras}}</td>
                <td>{{$this->herramientas($row->id_her)}}</td>
                <td>{{$row->comentario}}</td>
                <td>{{$row->com_rep}}</td>
                <td>{{$row->rep_fecha}}</td>
                <td> @if($row->stat == 0) PENDIENTE...@endif  @if($row->stat == 1) <span class="text-success">RESUELTO</span> @endif @if($row->stat == 3)DESHECHADA..@endif</td>
            </tr>
            
            @endforeach
            </tbody>
    </table>
       
        </section>
    </div>
</article>
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
})
   
</script>

@stop