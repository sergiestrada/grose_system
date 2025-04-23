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
                <th>Clasificacion</th>
                <th>Acciones</th>
            </thead>
            <tbody class="bg-white">
                @foreach($tabla as $row)
                <tr>
                    <td>{{$contador++}}</td>
                    <td>{{$row->categoria}}</td>
                    <td><button wire:click="accion(2,{{$row->id}})" class="btn btn-warning btn-sm"><span class="fas fa-edit"></span></button> <button onclick="eliminar({{$row->id}})" class="btn btn-danger btn-sm"><span class="fa fa-times"></span></button></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>
    </div>
    @include('livewire.medicion.form')
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
        function eliminar(id){
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
              @this.call('delete',id)
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
