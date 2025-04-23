@section('title', $componentName . ' | ' . $pageTitle)
@section('content_header')

@endsection
<article class="container-fluid">

    <div class="row">
        <section class="col-md-9"><br>
            <h3>{{ $pageTitle }}</h3>
        </section>
        <section class="col-md-3"><br>
      <button class="btn btn-primary btn-sm" wire:click="accion(1,0)">Agregar</button>
      <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#staticBackdrop">Reporte de costos</button>
        </section>
        <section class="col-md-12" > 
     
            <div class="table-responsive" wire:ignore>
            <table class="table" id="example">
                <thead class="bg-dark">
                   <th>#</th>
                    <th>Placa </th>
                    <th>Vehiculo </th> 
                    <th>Km/Hrm</th> 
                    <th>Responsable</th> 
                    <th>Tipo Servicio</th> 
                    <th>Mecanico  </th>
                    <th>Proveedor</th>
                    <th>Estatus </th>
    
                    <th>Medida</th>
                    <th  class="sorting_desc">Fecha</th>
                    <th class="d-print-none">Accion</th>
           
                </thead>
                <tbody class="bg-light">
                    @foreach ($tabla as $key) 
                        <tr>
                            <td>{{ $key->num_int }}</td>
                            <td>{{ $key->Placa }}</td>
                            <td>{{ $key->Nombre_Vehiculo }}</td> 
                            <td>{{ $key->Kilometraje }}</td>
                            <td>{{ $this->responsable($key->Responsable) }}</td>
                            <td>{{ $key->Tipo_Servicio }}</td>
                            <td>{{$this->mecanico($key->Tipo_mecanico,$key->Mecanico)}}</td>
                            <td>{{$this->provedor($key->Proveedor)}} </td>
                            <td class="
                            @if($key->Kilometraje >= $key->Prox_Fecha_Serv && $key->Kilometraje > $key->revision)
                                bg-danger
                            @elseif($key->Kilometraje < $key->Prox_Fecha_Serv && $key->Kilometraje < $key->revision)
                                bg-success
                            @elseif($key->Kilometraje < $key->Prox_Fecha_Serv && $key->Kilometraje >= $key->revision)
                                bg-warning
                            @endif
                        ">{{ $key->Prox_Fecha_Serv}}
                        </td> 
                      
                            <td><?= $key->medida?></td>
                            <td>{{$key->updated_at}}</td>
                            <td><div class="btn-group"><button wire:click="accion(2,{{$key->id}})" class="btn btn-warning btn-sm"><span class="fas fa-edit"></span></button> <button wire:click="accion(8,{{$key->id}})" class="btn btn-success btn-sm"><span class="fa fa-plus"></span></button> <button wire:click="accion(0,{{$key->id}})"  class="btn btn-secondary btn-sm"><span class="fa fa-search"></span></button> <button onclick="eliminar({{$key->id}})" class="btn btn-danger btn-sm"><span class="fa fa-times"></span></button></div></td> 
                        </tr> 
                    @endforeach
                </tbody>
            </table>
        
            </div>
    
    <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <h3>Reporte de Costos</h3>
                <table class="table" id="facturas">
                    <thead>
                    
                    <th>Codigo</th>
                    <th>Monto</th>
                    </thead>
                    <tbody> 
                   @php 
                $costoss =  DB::select('select distinct Vh_ligado  from factura ');  
                   @endphp
                        @foreach($costoss as $row)
                        <tr>
                            <td>{{$row->Vh_ligado}}</td>
                            <td>{{$this->costox($row->Vh_ligado)}}
                        </tr>
                        @endforeach
                    </tbody>
                    </table>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
      @include('livewire.bitacoravehiculos.form')
        </section>
      
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
    