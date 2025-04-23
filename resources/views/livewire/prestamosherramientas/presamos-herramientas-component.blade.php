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
                    <th>Codigo</th>
                    <th>Responsable</th>
                    <th>Portador</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </thead>
                <tbody class="bg-white">
                    @foreach ($tabla as $key)
        
                        <tr>
                            <td>{{ $contador++ }}</td>
                            <td>{{ $key->codigo }}</a> </td>
                            <td>{{ $this->responsable($key->reponsable) }}</td>
                            <td>{{ $this->responsable($key->Portador) }}</td>
                            <td><?= $key->fecha ?></td>
                          
                            
                            <td><button class="btn btn-success btn-sm"  title="Agregar herramienta" wire:click="accion(2,{{ $key->id }})"><span
                                        class="fas fas fa-calendar-plus"></span></button>
                                        <a class="btn btn-info btn-sm"  href="{{url('prestamos_herramientas/impresion')}}/{{ $key->id }}"><span
                                        class="fas fa-file-alt"  title="Imprimir Responsiva"></span></a>
                                        <a href='{{url('bouche')}}/{{$key->id}}'  title="PDF bouche" class="btn btn-secondary btn-sm"><span
                                        class="fas fa-file-alt"></span></a>
                                        <a href="{{ url('prestamos_herramienta/listado')}}/{{ $key->codigo }}"  title="Listado de herramieta mediana" class="btn btn-dark btn-sm"><span
                                        class="fas fa-screwdriver"></span></a>  
                                        <button class="btn btn-danger btn-sm"  title="Eliminar" onclick="eliminar({{$key->id }})"><span
                                            class="fa fa-times"></span></button>
                
                                        
                            
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            
        </div>

    </div>
    @include('livewire.prestamosherramientas.form')
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


            $('.table').DataTable({
                'order': [
                    [4, 'desc']
                ]
            });
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
                    title: 'Éxito',
                    html: msg,
                }).then((result) => {
                    if (result.isConfirmed || result.isDismissed) {
                        @this.call('resetUII')
                        $('.slct2').val(null).trigger('change')
                        $('#factura').val('');
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

        function portador(id) {
           @this.set('Portador',id)
        }

        function responsable(id) {
            @this.set('reponsable',id)
        }

        function obtener_herramienta(id) {
              @this.set('herr',id)
        }
    </script>

@stop
