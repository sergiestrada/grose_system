@section('title', $componentName . ' | ' . $pageTitle)
@section('content_header')

@endsection


<article class="container-fluid">
    @php

        $fecha = date('Y-m-d');
        $a = explode('-', $fecha);

    @endphp
    <br>
    <div class="row">

        <div class="col-md-11">
            <h3>{{ $pageTitle }}</h3>
        </div>
        <div class="col-md-1">
            <button class="btn btn-secondary" wire:click="accion(1,0)">Agregar</button>
        </div>
        <div class="col-md-12 table-responsive" wire:ignore>
            <table class="table">
                <thead class="bg-dark">
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Serie</th>
                    <th>Afianzadora</th>
                    <th>Vigencia fianza</th>
                    <th>No gps</th>
                    <th>Estatus gps</th>
                    <th>No motor</th>
                    <th>Poliza</th>
                    <th>Año </th>
                    <th>Color</th>
                    <th>Placa</th>

                    <th>Acciones</th>
                </thead>
                <tbody class="bg-white">
                    @foreach ($tabla as $key)
                        <tr>
                            <td>{{ $contador++ }}</td>

                            <td>{{ $key->Nombre_Id }}</td>
                            <td>{{ $key->Marca }}</td>
                            <td>{{ $key->Modelo }}</td>
                            <td>{{ $key->No_Serie }}</td>
                            <td>{{ $key->afianzadora }}</td>
                            <td>{{ $key->vigencia_fianza }}</td>
                            <td>{{ $key->no_gps}}</td>
                            <td>{{ $key->estatus_gsp }} </td>
                            <td>{{ $key->no_motor }}</td>
                            <td>{{ $key->Poliza }}</td>
                            <td>{{ $key->Ano }}</td>
                            <td>{{ $key->Color }}</td>
                            <td>{{ $key->Placa }}</td>
                            <td><button class="btn btn-warning btn-sm" wire:click="accion(2,{{ $key->id }})"><span
                                        class="fas fa-edit"></span></button><button
                                    wire:click="accion(0,{{ $key->id }})" class="btn btn-primary btn-sm"><span
                                        class="fa fa-search"></span></button><button
                                    wire:click="accion(3,{{ $key->id }})" class="btn btn-secondary btn-sm"><span
                                        class="fa fa-upload"></span></button><button
                                    onclick="eliminar({{ $key->id }})" class="btn btn-danger btn-sm"><span
                                        class="fa fa-times"></span></button></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
    @include('livewire.vehiculos.form')
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
            $('.table').DataTable();
            window.livewire.on('show-modal', msg => {
                $('#theModal').modal('show')
            })
            window.livewire.on('success', msg => {
                $('#theModal').modal('hide');
                Swal.fire({
                    icon: 'success',
                    title: 'Éxito',
                    html: msg,
                }).then((result) => {
                    if (result.isConfirmed || result.isDismissed) {
                        @this.call('resetUI');
                        location.reload(); // Esto recargará la página
                    }
                });
            });
            window.livewire.on('error', msg => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    html: msg,

                });

            })

        })

        function eliminar(id) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡No podrás revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminarlo',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Aquí puedes poner la lógica para el caso "Sí"
                    @this.call('delete', id)
                } else {
                    // Aquí puedes poner la lógica para el caso "No"
                    Swal.fire(
                        'Cancelado',
                        'Se cancelo la peticion.',
                        'error'
                    );
                }
            });
        }

        function eliminar_imagen(id) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡No podrás revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminarlo',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Aquí puedes poner la lógica para el caso "Sí"
                    @this.call('delete_img', id)
                } else {
                    // Aquí puedes poner la lógica para el caso "No"
                    Swal.fire(
                        'Cancelado',
                        'Se cancelo la peticion.',
                        'error'
                    );
                }
            });
        }
    </script>

@stop
