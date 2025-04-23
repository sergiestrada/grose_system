@section('title', $componentName . ' | ' . $pageTitle)
@section('content_header')

@endsection

<article class="container-fluid">

    <br>
    <h2> {{ $pageTitle }}</h2>

    <div class="row">
        <div class="col-md-12">
            <h3>Herramientas de mano</h3>
            <div class="prestamos1 table-responsive">
                <div class="estatico" wire:ignore>
                    <table class="table  order-table" id="examplex">
                        <thead>

                            <th>Numero de serie</th>
                            <th>Herramienta</th>
                            <th>Modelo</th>
                            <th>Marca</th>
                            <th>Cantidad</th>
                            <th>Accion</th>
                        </thead>
                        <tbody>

                            @foreach ($her_mano as $key)
                                <tr>
                                    <td><?= $key->numser ?> </td>

                                    <td><?= $this->herramientas($key->herr) ?></td>
                                    <td><?= $key->modelo ?></td>
                                    <td><?= $key->marca ?></td>

                                    <td><?= $key->cantidad ?></td>

                                    <td>
									<div class="btn-group">
									<button class="btn btn-primary btn-sm" wire:click="accion(1,{{$key->id}})" ><span class="fas fa-sync-alt"></span></button>
									<button class="btn btn-warning btn-sm" wire:click="accion(2,{{$key->id}})" ><i class="fas fa-edit"></i>
</button>
									<button class="btn btn-secondary btn-sm" wire:click="accion(3,{{$key->id}})"><span class="fa fa-upload"></span></button>
									<button class="btn btn-danger btn-sm" wire:click="accion(8,{{$key->id}})"><span class="fas fa-tools"></span></button>
									</div>
									</td>
                            @endforeach
                    </table>
                </div>
            </div>
            <h3>Herramienta de mediana</h3>
            <div class="prestamos1 table-responsive">
                <div class="estatico" wire:ignore>
                    <table class="table  order-table" id="examplex">
                        <thead>

                       
                            <th>Herramienta</th>
                           
                            <th>Cantidad</th>
                            <th>Accion</th>
                        </thead>
                        <tbody>
                            @foreach ($herr_mayor as $row)
                 
                            @php 
                            $consulta = DB::table('prestamos')->where('codigo', $val)->where('herr', $row->herr)->where('status',0)->first();
                        @endphp    
                        <tr>
                         

                            <td>
                             
                                {{ $this->herramientas($row->herr) }}
                 
                            </td>
                        
                            <td>
                                @if(!is_null($consulta))
                                    {{ DB::table('prestamos')->where('codigo', $val)->where('herr', $row->herr)->where('status',0)->sum('cantidad') }}
                                @endif
                            </td>
                            <td>
                                @if(!is_null($consulta) && !is_null($consulta->id))
                                <div class="btn-group">
							<button class="btn btn-primary btn-sm" wire:click="accion(1,{{$consulta->id}})" ><span class="fas fa-sync-alt"></span></button>
						
							<button class="btn btn-secondary btn-sm" wire:click="accion(3,{{$consulta->id}})"><span class="fa fa-upload"></span></button>
							<button class="btn btn-danger btn-sm"  wire:click="accion(8,{{$consulta->id}})"><span class="fas fa-tools"></span></button></div>
                           @endif
                            </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="bg-danger">
                <h3> Herramientas defectuosas </h3>
            </div>
            <div class="table-responsive estatico" wire:ignore>
                <table class="table">
                    <thead>
                        <th>Fecha</th>
                        <th>Herramienta</th>
                        <th>Comentario</th>
                        <th>Accion</th>
                    </thead>
                    <tbody>
                        @foreach ($danada as $row)
                        
                            <tr>
                                <td>{{$row->created_at}}</td>
                                <td>{{ $this->herramientas($row->herr) }}</td>
                                <td>{{ $row->comentario }}</td>
                               @if($row->status == 1)
                                <td><button class="btn btn-danger" wire:click="accion(7,{{$row->id}})"><span class="fas fa-sync-alt"></span></button></td>
                                @else
                                <td><button class="btn btn-link"  wire:click="accion(4,{{$row->id}})" > <span class="text-success">Retornado</span></button></td>
                                @endif
                            </tr>
                          
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @include('livewire.listadoherramientas.form')
    
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
            @this.set('Portador', id)
        }

        function responsable(id) {
            @this.set('resp', id)
        
        }

        function obtener_herramienta(id) {
            @this.set('herr', id)
        }
    </script>

@stop
