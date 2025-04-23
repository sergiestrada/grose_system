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
            <a href="{{url('responsivas_medicion/generar')}}" class="btn btn-secondary btn-sm" >Agregar</a>
            <button class="btn btn-danger btn-sm" wire:click="accion(5,0)">Herramienta dañada</button>
        </div>
        <div class="col-md-12 table-responsive" wire:ignore>
            <table class="table" id="example">
                <thead>
                  <th>Responsable</th>
                  <th>Cargo</th>
                  <th>Fecha Entrega</th>
                  <th>Responsiva</th>
                  <th>Estatus</th>
                  <th>Acciones</th>
                </thead>
                  <tbody>
                    @foreach($table as $ke) 
                    <tr>
                    <td>{{$this->responsable($ke->responsable)}}</td>
                    <td>{{$this->cargo($ke->responsable)}}</td>
                    <td>{{$ke->fecha_e}}</td>
                    <td>{{DB::table('formato')->where('id',$ke->responsiva)->first()->Nombre}}</td>
                    <td><?php  if($ke->status==1){?> Pendiente <?php } if($ke->status==0){ ?> Entregado <?php } if($ke->status==2){?> Dañado <?php } if($ke->status==5){?> Reparacion <?php } if($ke->status== 6){?> Baja <?php }?> </td>
                    <td>
                   
                          <a id="pdf" class="btn btn-danger btn-sm" href="{{ url('responsiva_pdf')}}/<?= $ke->responsiva ?>/<?= $ke->id?>"><span class="fas fa-file-pdf"></span></a>
                        
                          <button  class="btn btn-info btn-sm" wire:click="accion(0,{{$ke->id}})"><span class="fa fa-search"></span></button>
                       <button class="btn btn-secondary btn-sm" wire:click="accion(3,{{$ke->id}})"><span class="fa fa-upload"></span></button>
                          <button wire:click="accion(2,{{$ke->id}})" class="btn btn-warning btn-sm" ><span class="fas fa-edit"></span></button>  <button class="btn btn-danger btn-sm" onclick="eliminar({{$ke->id}})"><span class="fa fa-times"></span></button>
                          @if($ke->status != 0)
                          <button onclick="devolver({{$ke->id}})" class="btn btn-success btn-sm"><span class="fa fa-check"></span></button>
                        @endif
                        </td>
                         
                </tr>
                    @endforeach
                  </tbody>
            </table>
        </div>
    </div>
    @include('livewire.responsivasmedicion.form')
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
    window.livewire.on('show-modal', msg => {
        $('#theModal').modal('show');
    });

    window.livewire.on('success', msg => {
        $('#theModal').modal('hide');
        Swal.fire({
            icon: 'success',
            title: 'Éxito',
            html: msg,
        }).then((result) => {
            if (result.isConfirmed || result.isDismissed) {
                @this.call('resetUI'); // Cambiado de "@this.call('resetUI');" a "Livewire.emit('resetUI');"
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
                @this.call('resetUII'); // Cambiado de "@this.call('resetUI');" a "Livewire.emit('resetUI');"
              
            }
        });
    });

    window.livewire.on('error', msg => {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            html: msg,
        });
    });

    $('#example').DataTable({
        'order': [
            [2, 'desc']
        ]
    });
});

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
            @this.call('delete', id); // Cambiado de "@this.call('delete', id)" a "Livewire.emit('delete', id);"
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

function reparar_equipo(id){
    Swal.fire({
        title: '¿Estás seguro de enviar este equipo a reparar o calibracion?',
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminarlo',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Aquí puedes poner la lógica para el caso "Sí"
            @this.call('reparar_equipo', id); // Cambiado de "@this.call('delete', id)" a "Livewire.emit('delete', id);"
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
function eliminar_img(id) {
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
            @this.call('delete_img', id); // Cambiado de "@this.call('delete', id)" a "Livewire.emit('delete', id);"
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
function devolver(id) {
    Swal.fire({
        title: 'Confirmas que se devolvió el equipo',
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Aquí puedes poner la lógica para el caso "Sí"
            @this.call('devolver', id); // Cambiado de "@this.call('devolver', id)" a "Livewire.emit('devolver', id);"
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