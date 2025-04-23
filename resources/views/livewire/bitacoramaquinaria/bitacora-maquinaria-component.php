@section('title', $componentName . ' | ' . $pageTitle)
@section('content_header')

@endsection
<article class="container">

    <div class="row">
        <section class="col-md-10"><br>
            <h3>{{ $pageTitle }}</h3>
        </section>
        <section class="col-md-2"><br>
          <button class="btn btn-primary btn-sm" wire:click="accion(1,0)">Agregar</button>
        </section>
        <section class="col-md-12 table-responsive" wire:ignore>
        <table class="table " id="example">
            <thead>
            <tr>
            <th>#</th>      
            <th>Vehiculo </th> 
            <th>Responsable</th> 
            <th>Tipo Servicio</th> 
            <th>Mecanico  </th>
            <th>Proveedor</th>
            <th>HRS actual</th>
            <th>HRS servicio </th>
            <th>Actualizado</th>
            <th>Accion</th>
            </tr>     
            </thead>
            <tbody>
                @foreach ($table as $key)
                <tr>
                    <td><?= $key->num_int?></td>
                    <td><?= $key->Nombre_Vehiculo?></td> 
                    <td>{{ $this->responsable($key->Responsable)}}</td>
                    <td><?= $key->Tipo_Servicio?> </td>
                    <td>{{$this->mecanico($key->Tipo_mecanico,$key->Tipo_mecanico)}}</td> 
                    <td>{{$this->provedor($key->Proveedor)}} </td>
                    <td>{{ $key->Fecha_servicio}}</td>
                    <td>{{ $key->Prox_Fecha_Serv}}</td> 
                    <td>{{$key->updated_at}}</td>
                    <td><div class="btn-group"> <button wire:click="accion(2,{{$key->id}})" class="btn btn-warning btn-sm"><span class="fas fa-edit"></span></button> <button wire:click="accion(8,{{$key->id}})" class="btn btn-success btn-sm"><span class="fa fa-plus"></span></button> <button wire:click="accion(0,{{$key->id}})"  class="btn btn-secondary btn-sm"><span class="fa fa-search"></span></button> <button onclick="eliminar({{$key->id}})" class="btn btn-danger btn-sm"><span class="fa fa-times"></span></button></div> </td> 
                </tr>
                 @endforeach
            </tbody>
        </table>
        </section>  
                 
    </div>
    @include('livewire.bitacoramaquinaria.form')
</article>

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {



        $('.slct').select2({
    dropdownParent: $('#theModal'),
    dropdownAutoWidth: true,
    placeholder: 'Selecciona una opcion',
    width: '100%'
})

$('.table').DataTable({
        stateSave: true, // Guarda el estado del DataTable (paginación, búsqueda, etc.)
      
    });
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

    function editar_monto(id,text){
    @this.call('editar_monto',id,text)
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
    function  eliminar_serv(id){
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


</script>

@stop

    
