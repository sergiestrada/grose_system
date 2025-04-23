@section('title', $componentName . ' | ' . $pageTitle)
@section('content_header')

@endsection
<article class="container-fluid">

    <div class="row">
        <section class="col-md-10"><br>
            <h3>{{ $pageTitle }}</h3>
        </section>
        <section class="col-md-2"><br>
            <button class="btn btn-secondary btn-sm" wire:click="accion(1,0)">Codificar</button>   <button class="btn btn-primary btn-sm" wire:click="accion(2,0)">Agregar</button>
        </section>
        <section class="col-md-12" wire:ignore>
            <table class="table">
                <thead class="bg-dark">
                    <th>#</th>
                    <th>Codigo</th>
                    <th>Herramienta</th>
                    <th>Fecha</th>
                    <th>Fecha Prox Mant</th>
                    <th>Acciones</th>
              
                </thead>
                <tbody class="bg-light"> 
                    @foreach ($table as $v)   
                    @php 
                    $hoy = date('Y-m-d');
                   
        $fecha_p = strtotime($v->fecha_prox);
        $hoy_n = strtotime($hoy);
        $codigo = \App\Models\Herramienta_medicion::where('id', $v->id_her)->value('codigo');
        $idher = \App\Models\Herramienta_medicion::where('id', $v->id_her)->value('herramenta');
        $her = \App\Models\Medicion::where('id', $idher)->value('instrumento');
    @endphp
                   
                   <tr>
                    <td>{{ $v->id }}</td>
                  
                    <td>{{ $codigo }}</td>
                    <td>{{ $her }}</td>
                    <td>{{ $v->fecha }}</td>
                    <td @if($fecha_p >= $hoy_n) class="bg-success" @else class="bg-danger" @endif>{{ $v->fecha_prox }}</td>
                          <td>
                            <button wire:click="accion(7,{{$v->id}})" class="btn btn-warning btn-sm"><span class="fas fa-edit"></span></button>
                           </td>
           
                </tr>
                    @endforeach
                          
                </tbody>
            </table>
        </section>
    </div>
    @include('livewire.bitacoramedicion.form')
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


            $('.slct').select2({
        dropdownParent: $('#theModal'),
        dropdownAutoWidth: true,
        placeholder: 'Selecciona una opcion',
        width: '100%'
    })
   
    $('.table').DataTable({
        stateSave: true, // Guarda el estado del DataTable (paginación, búsqueda, etc.)
      
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

  

        function obtener_herramienta(id) {
              @this.set('herramenta',id)
        }
    </script>

@stop
