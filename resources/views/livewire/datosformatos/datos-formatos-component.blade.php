@section('title', $componentName . ' | ' . $pageTitle)
@section('content_header')

@endsection
<article class="container-fluid">

    <div class="row">
        <div class="col-md-12"><br>
            <h3>{{ $pageTitle }}</h3>
        </div>

        <section class="col-md-6">
            <div class="form-group" wire:ignore.lazy>
                <label for="">Herramientas</label>
                <select class="form-control" id="slct" name="desc" onchange="obtener_valor(this.value)">
                    <option value=""></option>

                    @foreach ($categorias as $k)
                        <option value="{{ $k->id }}">{{ $k->categoria }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Cantidad</label>
                <input class="form-control" type="number" name="cnt" wire:model="Cantidad">
            </div>
            <button class="btn btn-success btn-block" wire:loading.attr="disabled" wire:click="Save()">Guardar</button>
            <br>
            <div wire:ignore>
                <table class="table">
                    <thead class="bg-dark text-white">
                        <tr>

                            <td>Descripcion</td>
                            <td>Cantidad</td>
                            <td>Acciones</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($descripciones as $key)
                            <tr>
                                <td><?= $key->Descripcion ?></td>
                                <td><?= $key->Cantidad ?></td>
                                <td><button type="button" onclick="eliminar({{ $key->id }})"
                                        class="btn btn-danger btn-sm"><span class="fa fa-times"></span></button></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
        <section class="col-md-6">
            <div clas="form-group">
                <label>Imagen</label>
                <input type="file" class="form-control" name="factura" wire:model="factura"><br>
                <button class="btn btn-success btn-block" wire:target="factura" wire:loading.attr="disabled"
                    wire:click="Subir()">Subir</button>
            </div>
            <table class="table" id="example2">
                <tbody>
                    @foreach ($imagenes as $val)
                        <tr>
                            <td><img src="{{ url('/images') }}/{{ $val->Dir }}" style="width: 50%;height: 80px">
                            </td>
                            <td>
                                <div class="btn-group">
                                    <button onclick="eliminar_imagen({{ $val->id }})" type="button"
                                        class="btn btn-danger btn-sm"><span class="fa fa-times"></span></a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </section>
    </div>
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
            $('#slct').select2();

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

        function obtener_valor(id) {
            @this.set('tipo', id) // Corregido @this.set('tipo',id) a Livewire.emit('set', 'tipo', id);
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
                    @this.call('delete', id); // Corregido @this.call('delete',id) a Livewire.emit('delete', id);
                } else {
                    Swal.fire(
                        'Cancelado',
                        'Se canceló la petición.',
                        'error'
                    );
                }
            })
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
                    @this.call('delete_img',
                    id); // Corregido @this.call('delete_img',id) a Livewire.emit('delete_img', id);
                } else {
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
