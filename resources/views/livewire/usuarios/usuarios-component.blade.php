@section('title', $componentName . ' | ' . $pageTitle)
@section('content_header')

@endsection



<article class="container-fluid">
    <style>
        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        /* Hide default HTML checkbox */
        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        /* The slider */
        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked+.slider {
            background-color: #2196F3;
        }

        input:focus+.slider {
            box-shadow: 0 0 1px #2196F3;
        }

        input:checked+.slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }

        #precios {
            height: 500px;
            overflow: scroll;
        }
    </style>
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
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Activar</th>
                    <th>Acciones</th>

                </thead>
                <tbody class="bg-white">
                    @foreach ($users as $row)
                        <tr>
                            <td>{{ $contador++ }}</td>
                            <td>{{ $row->name }}</td>
                            <td>{{ $row->email }}</td>
                            <td>{{ $row->rol }}</td>
                            <td>
                                <label class="switch">
                                    <input type="checkbox" @if ($row->activo == 1) checked @endif
                                        wire:click="bloquear({{ $row->id }})">
                                    <span class="slider round"></span>
                                </label>
                            </td>
                            <td><button class="btn btn-warning" wire:click="accion(2,{{ $row->id }})">E</button>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @include('livewire.usuarios.form')
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
    </script>

@stop
