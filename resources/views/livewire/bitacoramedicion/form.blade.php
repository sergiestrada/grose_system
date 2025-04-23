@include('common.modalHead')
@switch($accion)
@case(0)
<h3>Certificados</h3>

@break  
@case(1)

        <div class="row">
            <div class="col-md-3">
                <label for="">Codigo barras</label>
                <input type="text" name="codigo" wire:model="cod_barras" class="form-control" required wire:ignore.lazy>
                @error('clave')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-md-8">
                <div class="form-group" wire:ignore>
                    <label for="">Herramienta</label>
                    <select name="herramienta" wire:model="herramenta" onchange="obtener_herramienta(this.value)"
                        class="form-control slct" required wire:ignore.lazy>
                        <option value=""></option>

                        @foreach ($medicion as $val)
                            <option value="<?= $val->id ?>"><?= $val->instrumento ?></option>
                        @endforeach
                    </select>
                    @error('herramenta')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="">Marca o Modelo</label>
                    <input type="text" class="form-control" wire:model="marca" name="marca" required wire:ignore.lazy>
                    @error('marca')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="table-responsive" wire:ignore>
                    <table class="table" id="example1">
                        <thead>
                            <th>#</th>
                            <th>Codigo</th>
                            <th>Herramienta</th>
                            <th>Marca</th>
                        </thead>
                        <tbody>
                            @foreach ($herramienta_med as $k)
                                <tr>
                                    <td><?= $k->id ?></td>
                                    <td><?= $k->cod_barras ?></td>
                                    <td>{{\App\Models\Medicion::find($k->herramenta)->instrumento }}
                                    </td>
                                    <td><?= $k->marca ?></td>
                                    
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <script>
            $(".table").DataTable();
              $('.slct').select2({
               dropdownParent: $('#theModal'),
               dropdownAutoWidth: true,
               placeholder: 'Selecciona una opcion',
               width: '100%'
           })
           </script>
    @break

    @case(2)
        <div class="row">
            <div class="col-md-12">
                <label for="">Codigo barras</label>
                <select name="codigo" wire:model="id_her" class="form-control slct">
                    <option value=""></option>

                    @foreach ($herramienta_med as $val)
                        <option value="{{ $val->id }}">{{ $val->cod_barras }} &nbsp;<b>
                                [{{ $this->medicion_herr($val->herramenta) }} ]</b></option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label for="">Fecha</label>
                <input type="date" name="fi" wire:model="fecha" class="form-control">
            </div>
            <div class="col-md-6">
                <label for="">Fecha Proximo Mantenimiento</label>
                <input type="date" name="fp" wire:model="fecha_prox" class="form-control">
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="">Comentario</label>
                    <textarea name="comentario" class="form-control" wire:model="comentario" cols="30" rows="3"></textarea>
                </div>
            </div>
        </div>
    @break
@case(3)
<div class="form-group">
    <label>Documento</label>
    <input type="file" class="form-control" name="factura" wire:model="factura">
    @error('factura')
        <span class="text-danger">{{ $message }}</span>
    @enderror
    <div wire:loading wire:target="factura">Uploading...</div>
    </div>
@break
    @case(7)
        <div class="row">
            <div class="col-md-12">
                <label for="">Codigo barras</label>
                <select name="codigo" wire:model="id_her" class="form-control slct">
                    <option value=""></option>

                    @foreach ($herramienta_med as $val)
                        <option value="{{ $val->id }}">{{ $val->cod_barras }} &nbsp;<b>
                                [{{ $this->medicion_herr($val->herramenta) }} ]</b></option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label for="">Fecha</label>
                <input type="date" name="fi" wire:model="fecha" class="form-control">
            </div>
            <div class="col-md-6">
                <label for="">Fecha Proximo Mantenimiento</label>
                <input type="date" name="fp" wire:model="fecha_prox" class="form-control">
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="">Comentario</label>
                    <textarea name="comentario" class="form-control" wire:model="comentario" cols="30" rows="3"></textarea>
                </div>
            </div>
        </div>
    @break

@endswitch

@include('common.modalFooter')
