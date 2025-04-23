@section('title', $componentName . ' | ' . $pageTitle)
@section('content_header')

@endsection

    <article class="container-fluid">

        <div class="row">
            <section class="col-md-11"><br>
                <h3>{{ $pageTitle }}</h3>
            </section>
            <section class="col-md-1"><br>
                <button class="btn btn-primary btn-sm" wire:click="accion(1,0)">Agregar</button>
            </section>
            <section class="col-md-12 table-respnsive" wire:ignore>
            
                <table class="table" id="example">
                    <thead class="bg-dark">
                        <tr>
                            <th>#</th>
                            <th>Responsable</th>
                            <th>Vehiculo</th>
                            <th>Tipo Servicio</th>
                            <th>Mecanico</th>
                            <th>Proveedor</th>
                            <th>Horometro</th>
                            <th>Revision</th>
                            <th>Fecha de actualizacion</th>
                            <th>Estatus </th>

                            <th>Accion</th>

                        </tr>

                    </thead>
                    <tbody class="bg-light">
                        @foreach ($table as $key)
                            <tr>
                                <td>{{ $key->num_int }}</td>
                                <td>{{ $this->responsable($key->Responsable) }}</td>
                                <td>{{ $key->Nombre_Vehiculo }}</td>
                                <td>{{ $key->Tipo_Servicio }}</td>
                                <td> {{ $this->mecanico($key->Tipo_mecanico, $key->Tipo_mecanico) }}</td>
                                <td>{{ $this->provedor($key->Proveedor) }} </td>
                                <td><?= $key->horometro ?></td>
                                <td><?= $key->Fecha_servicio ?></td>
                                <td>{{ $key->updated_at }}</td>
                                <td
                                    class="@if ($key->horometro >= $key->Fecha_servicio && $key->horometro <= $key->Prox_fecha_serv) bg-warning @endif @if ($key->horometro >= $key->Fecha_servicio && $key->horometro >= $key->Prox_fecha_serv) bg-danger @endif @if ($key->horometro <= $key->Prox_fecha_serv && $key->horometro <= $key->Fecha_servicio) bg-success @endif">
                                    {{ $key->Prox_fecha_serv }}
                                </td>

                                <td>
                                    <div class="btn-group"> <button wire:click="accion(2,{{ $key->id }})"
                                            class="btn btn-warning btn-sm"><span class="fas fa-edit"></span></button>
                                        <button wire:click="accion(8,{{ $key->id }})"
                                            class="btn btn-success btn-sm"><span class="fa fa-plus"></span></button>
                                        <button wire:click="accion(0,{{ $key->id }})"
                                            class="btn btn-secondary btn-sm"><span class="fa fa-search"></span></button>
                                        <button onclick="eliminar({{ $key->id }})"
                                            class="btn btn-danger btn-sm"><span class="fa fa-times"></span></button>
                                    </div>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-center">
                    {{ $table->links('vendor.pagination.bootstrap-4') }} <!-- Enlaces de paginación centrados -->
                </div>
            </section>
            @include('livewire.bitacoravehiculospesados.form')
    </article>

    @section('js')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                $('.table').DataTable({
        stateSave: true, // Guarda el estado del DataTable (paginación, búsqueda, etc.)
      
    });
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


                $('.slct').select2({
                    dropdownParent: $('#theModal'),
                    dropdownAutoWidth: true,
                    placeholder: 'Selecciona una opcion',
                    width: '100%'
                })

             
                $("#facturas").DataTable();

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
                window.livewire.on('success1', msg => {

                    Swal.fire({
                        icon: 'success',
                        title: 'Exito',
                        html: msg,

                    });
                    @this.call('resetUII')
                })
                window.livewire.on('error', msg => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        html: msg,

                    });

                })

            })

            function editar_monto(id, text) {
                @this.call('editar_monto', id, text)
            }

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
                        location.reload(); // Esto recargará la página
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
                        location.reload(); // Esto recargará la página
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

            function eliminar_serv(id) {
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
                        @this.call('eliminar_ser', id)
                        location.reload(); // Esto recargará la página
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

            function responsable(id) {
                @this.set('Responsable', id)
            }

            function obtener_herramienta(id) {
                @this.set('herramenta', id)
            }
        </script>

    @stop
