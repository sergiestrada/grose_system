@section('title', $componentName . ' | ' . $pageTitle)
@section('content_header')

@endsection


<article class="container-fluid">
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
                    <th>Codigo Barras</th>
                    <th>Codigo Int</th>
                    <th>Herramientas</th>
                    <th>Modelo</th>
                    <th>Clasificacion</th>
                    <th>Acciones</th>
                </thead>
                <tbody class="bg-white">
                    @foreach ($tabla as $key)
                        <tr>
                            <td>{{ $contador++ }}</td>

                            <td>{{ $key->codigob }}</td>
                            <td>{{ $key->codigo }}</td>
                            <td>{{ $key->instrumento }}</td>
                            <td>{{ $key->modelo }}</td>


                            <td>
                                @if ($key->clasificacion != '')
                                    {{ DB::table('categoria_medicion')->select('categoria')->where('id', $key->clasificacion)->get()[0]->categoria }}
                                @endif
                            </td>

                            <td><button class="btn btn-warning btn-sm" wire:click="accion(2,{{ $key->id }})"><span
                                        class="fas fa-edit"></span></button><button
                                    wire:click="accion(0,{{ $key->id }})" class="btn btn-sm btn-primary"><span
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
    @include('livewire.herramientasmedicion.form')
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
