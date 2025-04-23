@include('common.modalHead')

@switch($accion)

    @case(0)
    <div class="row">
        <section class="col-md-10">
        <h3>Servicios</h3>
        </section>
        <section class="col-md-2">
        <a class="btn btn-dark btn-sm" href="{{url('bitacora_vehiculos_pesados/reporte')}}/{{$val}}/2/{{$vhl}}">Reporte</a>
        </section>
    </div>
        <div class="table-responsive">
            <table class="table" id="tabla_historico">
                <thead>
                    <th>Fecha actualizacion</th>
                    <th>Servicio</th>
                    <th>Proveedor</th>
                    <th>Mecanico</th>
                    <th>Tipo mecanico</th>
                    <th>Act</th>
                    <th>Prox.S</th>
                    <th>Comentario</th>
                    <th>Accion</th>
                </thead>
                <tbody>
                    @foreach ($historial as $his)
                        <tr>
                            <td><?= $his->fecha ?></td>
                            <td><?= $his->servicio ?></td>
                            <td>{{ DB::table('proveedor')->where('id', $his->proveedor)->first()->Nombre_Proveedor }}</td>
                            <td>
                                @if ($his->t_mecanico == 1)
                                    @php
                                        $nombe = DB::table('mecanico_interno')
                                            ->where('id', $his->mecanico)
                                            ->first();
                                    @endphp
                                    {{ $nombe->Nombre }} {{ $nombe->Apellido_P }} {{ $nombe->Apellido_M }}
                                @else
                                    @php
                                        $nombe = DB::table('mecanico_extreno')
                                            ->where('id', $his->mecanico)
                                            ->first();
                                    @endphp
                                    {{ $nombe->Nombre }} {{ $nombe->Apellido_P }} {{ $nombe->Apellido_M }}
                                @endif
                            </td>

                            <td>
                                @if ($his->t_mecanico == 1)
                                    Interno
                                @else
                                    Externo
                                @endif
                            </td>

                            <td> {{ $his->km_anterior }}</td>

                            <td> <?= $his->km_actual ?></td>
                            <td><?= $his->comentario ?></td>
                            <td><button class="btn btn-info btn-sm" wire:click="subaccion(3,{{ $his->id }})"> <span
                                        class="fa fa-upload"></span> </button>  <button id="eliminar"
                                    class="btn btn-danger btn-sm" onclick="eliminar_serv({{ $his->id}})"><span class="fa fa-times"></span></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <script>
            $('.table').DataTable();
        </script>
    @break

    @case(1)
    <div class="row">
    <section class="col-md-6">
        <div class="form-group">

            <label for="">Numero Interno</label>
            <input type="text" class="form-control" name="num" wire:model="num_int" wire:ignore.lazy>
            @error('Tipo_Servicio')
            <span class="text-danger">{{ $message }}</span>
        @enderror
        </div>
    </section>
    <section class="col-md-6">

        <div class="form-group">
            <label>Vehiculo</label>
            <input type="text" class="form-control" name="veh" wire:model="Nombre_Vehiculo" wire:ignore.lazy>
            @error('Nombre_Vehiculo')
            <span class="text-danger">{{ $message }}</span>
        @enderror
        </div>
    </section>
    <section class="col-md-9">
        <div class="form-group" wire:ignore>
            <label>Responsable</label>
            <select class="form-control slct" name="res" wire:model="Responsable" onchange="responsable(this.value)" wire:ignore.lazy>
                <option value=""></option>
             
      @foreach ($responsable as $vals) 
                <option value="<?= $vals->id ?>">
                    <?= $vals->Nombre . ' ' . $vals->Apellido_P . ' ' . $vals->Apellido_M ?> </option>
            @endforeach
            </select>
            @error('Responsable')
            <span class="text-danger">{{ $message }}</span>
        @enderror
        </div>
    </section>
    <section class="col-md-3">
        <div class="form-group">
            <label>Horometro</label>
            <input type="number" class="form-control" name="hmtro" wire:model="horometro" wire:ignore.lazy>
        </div>
        @error('horometro')
        <span class="text-danger">{{ $message }}</span>
    @enderror
    </section>
    <section class="col-md-4">
        <div class="form-group">
            <label>Ultimo Servicio</label>
            <input type="number" class="form-control" name="serv" wire:model="Fecha_servicio" wire:ignore.lazy>
            @error('Fecha_servicio')
            <span class="text-danger">{{ $message }}</span>
        @enderror
        </div>


        <div class="form-group">
            <label>Tipo Mecanico</label>
            <select class="form-control"  wire:model="Tipo_mecanico" name="mec" wire:ignore.lazy>
                <option value=""></option>
                <option value="1">Interno</option>
                <option value="2">Externo</option>
            </select>
            @error('Tipo_mecanico')
            <span class="text-danger">{{ $message }}</span>
        @enderror
        </div>

    </section>
    <section class="col-md-4">
        <div class="form-group">
            <label>Prox serv</label>
            <input type="number" class="form-control" name="prox" wire:model="Prox_fecha_serv" wire:ignore.lazy>
            @error('Prox_fecha_serv')
            <span class="text-danger">{{ $message }}</span>
        @enderror
        </div>

        <div class="form-group wire:ignore">
            <label>Proveedor</label>
            <select class="form-control" name="prov" wire:model="Proveedor" wire:ignore.lazy>
                <option value=""></option>
              
@foreach ($provedor as $key) 
                <option value="<?= $key->id ?>"><?= $key->Nombre_Proveedor ?></option>
                @endforeach
                </select>
                @error('Proveedor')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </section>
    <section class="col-md-4">
        <div class="form-group">
            <label>Tipo de  Servicio</label>
            <input type="text" class="form-control" name="ser"  wire:model="Tipo_Servicio" wire:ignore.lazy>
       
            @error('Tipo_Servicio')
            <span class="text-danger">{{ $message }}</span>
        @enderror
     </div>
        <div class="form-group">
                <label>Mecanico</label>
                <div id="tin" >
           @if($Tipo_mecanico == 1)
                <div id="in" >
                    <select class="form-control" name="mec1" wire:model="Mecanico" wire:ignore.lazy>
                        <option value=""></option>
                @foreach ($mec_i as $val)
                        <option value="<?= $val->id ?>">
                            <?= $val->Nombre . ' ' . $val->Apellido_P . ' ' . $val->Apellido_M ?></option>
                       @endforeach
                    </select>
                    @error('Mecanico')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
                </div>
                @endif
                @if($Tipo_mecanico == 2)
                <div id="for">
                    <select class="form-control slc2" name="mec2" wire:model="Mecanico" wire:ignore.lazy>
                        <option value=""></option>
                         @foreach ($mec_e as $v) 
                        <option value="<?= $v->id ?>"><?= $v->Nombre . ' ' . $v->Apellido_P . ' ' . $v->Apellido_M ?>
                        </option>
                        @endforeach
                    </select>
                    @error('Mecanico')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
                </div>
                @endif
            </div>
        </div>
    </section>
    </div>
       
     
            <script>
                $('.slct').select2({
                    dropdownParent: $('#theModal'),
                    dropdownAutoWidth: true,
                    placeholder: 'Selecciona una opcion',
                    width: '100%'
                })

                function change(sel) {
                    if (sel.value == 1) {
                        $("#in").show();
                        $("#for").hide();

                    }
                    if (sel.value == 2) {


                        $("#in").hide();
                        $("#for").show();

                    }
                    if (sel.value == '') {
                        $("#in").hide();
                        $("#for").hide();
                    }
                }

            </script>
        @break

        @case(2)
        <div class="row">
            <section class="col-md-6">
                <div class="form-group">
        
                    <label for="">Numero Interno</label>
                    <input type="text" class="form-control" name="num" wire:model="num_int" wire:ignore.lazy>
                    @error('Tipo_Servicio')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
                </div>
            </section>
            <section class="col-md-6">
        
                <div class="form-group">
                    <label>Vehiculo</label>
                    <input type="text" class="form-control" name="veh" wire:model="Nombre_Vehiculo" wire:ignore.lazy>
                    @error('Nombre_Vehiculo')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
                </div>
            </section>
            <section class="col-md-9">
                <div class="form-group" wire:ignore>
                    <label>Responsable</label>
                    <select class="form-control slct" name="res" wire:model="Responsable" wire:ignore.lazy>
                        <option value=""></option>
                     
              @foreach ($responsable as $vals) 
                        <option value="<?= $vals->id ?>">
                            <?= $vals->Nombre . ' ' . $vals->Apellido_P . ' ' . $vals->Apellido_M ?> </option>
                    @endforeach
                    </select>
                    @error('Responsable')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
                </div>
            </section>
            <section class="col-md-3">
                <div class="form-group">
                    <label>Horometro</label>
                    <input type="number" class="form-control" name="hmtro" wire:model="horometro" wire:ignore.lazy>
                </div>
                @error('horometro')
                <span class="text-danger">{{ $message }}</span>
            @enderror
            </section>
       
         
         
            </div>
               
             
                    <script>
                        $('.slct').select2({
                            dropdownParent: $('#theModal'),
                            dropdownAutoWidth: true,
                            placeholder: 'Selecciona una opcion',
                            width: '100%'
                        })
        
                        function change(sel) {
                            if (sel.value == 1) {
                                $("#in").show();
                                $("#for").hide();
        
                            }
                            if (sel.value == 2) {
        
        
                                $("#in").hide();
                                $("#for").show();
        
                            }
                            if (sel.value == '') {
                                $("#in").hide();
                                $("#for").hide();
                            }
                        }
        
                        function responsable(id) {
                            @this.set('Responsable', id)
                        }
                    </script>
        @break

        @case(3)
            <h3>Subir factura de servicio</h3>
            <button class="btn btn-link" wire:click="accion(0,{{ $val }})">Regresar</button>
            <div class="form-group">
                <label>Monto</label>
                <input class="form-control" type="number" wire:model="monto">
                <label>Documento</label>
                <input type="file" class="form-control" name="factura" wire:model="factura">
                @error('factura')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
                <div wire:loading wire:target="factura">Uploading...</div>
            </div>
            <table class="table ">
                <thead class="thead-dark">
                    <th>Fecha</th>
                    <th>Archivo</th>
                    <th>Valor</th>

                    <th> Accion</th>

                </thead>
                <tbody>
                    @php   $data = \App\Models\Factura::where('tfactura',$subval)->get(); @endphp

                    @foreach ($data as $key)
                        <tr>

                            <td>{{ $key->fecha }}</td>
                            <td><a href="{{ url('vehiculos_factura') }}/{{ $key->Archivo }}"
                                    target="_blank">{{ $key->Archivo }}</a></td>
                            <td><input type="number" id="nmp{{ $key->id }}"
                                    onkeyup="editar_monto({{ $key->id }},this.value)" value="{{ $key->monto }}"></td>

                            <td> <button type="button" onclick="eliminar_imagen({{ $key->id }})"
                                    class="btn btn-danger"><span class="fa fa-times"></span></button></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <script></script>
        @break

        @case(8)
        <div class="row">
           
            <section class="col-md-4">
                <div class="form-group">
                    <label>Ultimo Servicio</label>
                    <input type="number" class="form-control" name="serv" wire:model="Fecha_servicio" >
                    @error('Fecha_servicio')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
                </div>
        
        
                <div class="form-group">
                    <label>Tipo Mecanico</label>
                    <select class="form-control"  wire:model="Tipo_mecanico" name="mec" wire:ignore.lazy>
                        <option value=""></option>
                        <option value="1">Interno</option>
                        <option value="2">Externo</option>
                    </select>
                    @error('Tipo_mecanico')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
                </div>
        
            </section>
            <section class="col-md-4">
                <div class="form-group">
                    <label>Prox serv</label>
                    <input type="number" class="form-control" name="prox" wire:model="Prox_fecha_serv" wire:ignore.lazy>
                    @error('Prox_fecha_serv')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
                </div>
        
                <div class="form-group wire:ignore">
                    <label>Proveedor</label>
                    <select class="form-control" name="prov" wire:model="Proveedor" wire:ignore.lazy>
                        <option value=""></option>
                      
        @foreach ($provedor as $key) 
                        <option value="<?= $key->id ?>"><?= $key->Nombre_Proveedor ?></option>
                        @endforeach
                        </select>
                        @error('Proveedor')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </section>
            <section class="col-md-4">
                <div class="form-group">
                    <label>Tipo de  Servicio</label>
                    <input type="text" class="form-control" name="ser"  wire:model="Tipo_Servicio" wire:ignore.lazy>
               
                    @error('Tipo_Servicio')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
             </div>
                <div class="form-group">
                        <label>Mecanico</label>
                        <div id="tin" >
                   @if($Tipo_mecanico == 1)
                        <div id="in" >
                            <select class="form-control" name="mec1" wire:model="Mecanico" wire:ignore.lazy>
                                <option value=""></option>
                        @foreach ($mec_i as $val)
                                <option value="<?= $val->id ?>">
                                    <?= $val->Nombre . ' ' . $val->Apellido_P . ' ' . $val->Apellido_M ?></option>
                               @endforeach
                            </select>
                            @error('Mecanico')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        </div>
                        @endif
                        @if($Tipo_mecanico == 2)
                        <div id="for">
                            <select class="form-control slc2" name="mec2" wire:model="Mecanico" wire:ignore.lazy>
                                <option value=""></option>
                                 @foreach ($mec_e as $v) 
                                <option value="<?= $v->id ?>"><?= $v->Nombre . ' ' . $v->Apellido_P . ' ' . $v->Apellido_M ?>
                                </option>
                                @endforeach
                            </select>
                            @error('Mecanico')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        </div>
                        @endif
                    </div>
                </div>
            </section>
            <section class="col-md-12">
                <div class="form-group">
                    <label>Comentarios</label>
                    <textarea class="form-control" wire:model="comentario"></textarea>
                </div>
            </section>
            </div>
               
             
                    <script>
                        $('.slct').select2({
                            dropdownParent: $('#theModal'),
                            dropdownAutoWidth: true,
                            placeholder: 'Selecciona una opcion',
                            width: '100%'
                        })
        
                        function change(sel) {
                            if (sel.value == 1) {
                                $("#in").show();
                                $("#for").hide();
        
                            }
                            if (sel.value == 2) {
        
        
                                $("#in").hide();
                                $("#for").show();
        
                            }
                            if (sel.value == '') {
                                $("#in").hide();
                                $("#for").hide();
                            }
                        }
        
                        function responsable(id) {
                            @this.set('Responsable', id)
                        }
                    </script>
        @break


   

@endswitch

@include('common.modalFooter')
