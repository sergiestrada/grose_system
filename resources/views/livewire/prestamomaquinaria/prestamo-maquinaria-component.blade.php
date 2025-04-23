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

                    <th>Codigo</th>
                    <th>Responsable</th>
                    <th>Fecha</th>
                    <th>Estatus</th>
                    <th>Acciones</th>
                </thead>
                <tbody class="bg-white">
                    @foreach ($tabla as $row)
                        <tr>
                            <td>{{ $row->codigo }}</td>
                            <td>{{  $this->responsable($row->responsables) }}</td>
                            <td>{{ $row->fechas }}</td>
                            <td>
                                @if ($row->stats == 1)
                                    Activo
                                    @endif 
                                    @if ($row->stats == 2)
                                        Finalizado
                                    @endif
                                    @if ($row->stats == 3)
                                        Dañada
                                    @endif
                                    @if ($row->stats == 4)
                                    Desehechada
                                @endif
                            </td>
                            <td>
                                @if($row->stats != 2 && $row->stats != 4)
                                <button class="btn btn-warning btn-sm" wire:click="accion(2,{{$row->ids}})"><span class="fas fa-edit"></span></button>
                                <button class="btn btn-dark btn-sm" wire:click="accion(8,'{{$row->codigo}}')"><span class="fas fas fa-calendar-plus"></span></button>
                                <a class="btn btn-info btn-sm"  href="{{url('prestamos_maquinaria/bouche')}}/{{$row->codigo}}" ><span class="fas fa-file-alt"></span></a>
                                @endif
                                <button class="btn btn-dark btn-sm"  wire:click="accion(3,{{$row->ids}})"><span class="fa fa-upload"></span></button>
                                @if($row->stats != 2 && $row->stats != 4)
                              
                              
                                <button class="btn btn-danger btn-sm" onclick="eliminar({{$row->ids}})"><span class="far fa-times-circle"></span></button>
                                <button class="btn btn-success btn-sm" onclick="retorno({{$row->ids}})"><span class="fa fa-check"></span></button>
                                @endif
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @include('livewire.prestamomaquinaria.form')
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
            window.livewire.on('success1', msg => {
                Swal.fire({
                    icon: 'success',
                    title: 'Éxito',
                    html: msg,
                }).then((result) => {
                    if (result.isConfirmed || result.isDismissed) {
                        @this.call('resetUII');
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
function retorno(id){
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
                    @this.call('retorno', id)
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
        function eliminar_archivo(id){
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
        function vehiculo(id) {
            @this.set('herr', id)
        }

        function responsable(id) {
            @this.set('responsable', id)
        }

        function portador(id) {
            @this.set('portador', id)
        }
    </script>
@stop
