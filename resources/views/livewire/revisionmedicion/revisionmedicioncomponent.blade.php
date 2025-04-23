@section('title', $componentName . ' | ' . $pageTitle)
@section('content_header')

@endsection


<article class="container-fluid">
    <br>
    <div class="row">

        <div class="col-md-9">
            <h3>{{ $pageTitle }}</h3>
        </div>
        <div class="col-md-3">

        </div>
        <div class="col-md-12 table-responsive" wire:ignore>
            <table class="table" id="example">
                <thead>

                    <th>Clave</th>
                    <th>Equipo</th>
                    <th>Marca</th>
                    <th>Serie</th>
                    <th>Estatus</th>
                    <th>Tipo</th>
                    <th>Fecha Alta</th>
                    <th>Fecha Finalizacion</th>

                    <th>Accion</th>
                </thead>
                <tbody>
                    @foreach ($table as $row)
                        @php
                            $data = App\Models\formato::find($row->resposiva);
                        @endphp
                        <tr>

                            <td>{{ $data->Nombre }}</td>
                            <td>{{ $data->nom_equi }}</td>
                            <td>{{ $data->marca }}</td>
                            <td>{{ $data->serie }}</td>
                            <td>{{ $row->estatus }}</td>
                            <td>
                                @if ($row->tipo == 1)
                                    Reparacion
                                @else
                                    Calibracion
                                @endif

                            </td>

                            <td>{{ $row->ceated_at }}</td>
                            <td>{{ $row->updated_at }}</td>
                            <td>
                                <button class="btn btn-info btn-sm" wire:click="comentario({{$row->id}})"><i class="fas fa-comment"></i></button>
                                @if($row->estatus ==  'En revision')
                                <button class="btn btn-success btn-sm" onclick="aceptar({{$row->origen}},{{$row->id}})"><i class="fas fa-check"></i></button> 
                               <button class="btn btn-danger btn-sm" onclick="eliminar({{$row->origen}},{{$row->id}})"><i class="fas fa-times"></i></button>
                                @endif
                            </td>                         
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>
    @include('livewire.revisionmedicion.form')
</article>
@section('js')
<script>
     document.addEventListener('DOMContentLoaded', function() {
        window.livewire.on('show-modal', msg => {
        $('#theModal').modal('show');
    });
    window.livewire.on('success', msg => {
        Swal.fire({
            icon: 'success',
            title: 'Éxito',
            html: msg,
        }).then((result) => {
            if (result.isConfirmed || result.isDismissed) {
                @this.call('resetUI'); // Cambiado de "@this.call('resetUI');" a "Livewire.emit('resetUI');"
       
            }
        });
    });
    window.livewire.on('success1', msg => {
        Swal.fire({
            icon: 'success',
            title: 'Éxito',
            html: msg,
        }).then((result) => {
            if (result.isConfirmed || result.isDismissed) {
                location.reload(); // Esto recargará la página
                @this.call('resetUI'); // Cambiado de "@this.call('resetUI');" a "Livewire.emit('resetUI');"
       
            }
        });
    });


    $('#example').DataTable({
        'order': [
            [6, 'desc']
        ]
    });

    window.livewire.on('error', msg => {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            html: msg,
        });
    });

})
function aceptar(id,idx) {
    Swal.fire({
        title: 'Confirmas que reparo el equipo?',
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Aquí puedes poner la lógica para el caso "Sí"
            @this.call('aceptar', id,idx); // Cambiado de "@this.call('devolver', id)" a "Livewire.emit('devolver', id);"
        } else {
            // Aquí puedes poner la lógica para el caso "No"
            Swal.fire(
                'Cancelado',
                'Se canceló la petición.',
                'error'
            );
        }
    });
}
function eliminar(id,idx) {
    Swal.fire({
        title: 'Quieres dar de baja este equipo?',
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Aquí puedes poner la lógica para el caso "Sí"
            @this.call('eliminar', id,idx); // Cambiado de "@this.call('devolver', id)" a "Livewire.emit('devolver', id);"
        } else {
            // Aquí puedes poner la lógica para el caso "No"
            Swal.fire(
                'Cancelado',
                'Se canceló la petición.',
                'error'
            );
        }
    });
}
</script>
@stop