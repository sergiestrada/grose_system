@section('title', $componentName . ' | ' . $pageTitle)
@section('content_header')

@endsection


<article class="container-fluid">
    <br>
    <div class="row">

        <div class="col-md-12">
            <h3>{{ $pageTitle }}</h3>
        
        </div>
        <div class="col-md-6">	
            <div class="form-group">
            <label for="">Empresa/Obra</label>
        <input type="text" name="emp" class="form-control" wire:model="obra" wire:ignore.lazy>
        @error('obra')
                <span class="text-danger">{{ $message }}</span>
            @enderror
            </div>
            <div class="form-group">
                <label>Quien entrega</label>
                <input type="text" class="form-control" name="entrego" required wire:model="encargado" wire:ignore.lazy> 
                @error('encargado')
                <span class="text-danger">{{ $message }}</span>
            @enderror
            </div>
            <div class="form-group">
                <label>Cargo</label>
                <input type="text" class="form-control" name="cargo" required wire:model="cargo" wire:ignore.lazy>
                @error('cargo')
                <span class="text-danger">{{ $message }}</span>
            @enderror
            </div>
            </div>
             <div class="col-md-6" wire:ignore>	
        <div class="form-group">
                <label for="">Responsiva</label>
                <select name="buscar"  onchange="cargarcheck(this.value)" class="form-control slc2" wire:model="responsiva" required>
                        <option value=""></option>
                
                    @foreach ($formatos as $key ) 
                        <option value="<?= $key->id?>"><?= $key->Nombre?></option>
                    @endforeach
                    </select>
                    @error('responsiva')
                <span class="text-danger">{{ $message }}</span>
            @enderror
            </div>
            
            <div class="form-group">
            <label for="">Responsable</label>
            <select name="responsable" class="form-control slc2" wire:ignore.lazy required="" onchange="responsable(this.value)" wire:model="responsable">
                <option value=""></option>
            @foreach ($responsables as $val) 
            <option value="<?= $val->id?>"><?= $val->Nombre?> <?= $val->Apellido_P?> <?= $val->Apellido_M?></option>
            @endforeach
            </select>
            @error('responsable')
                <span class="text-danger">{{ $message }}</span>
            @enderror
            </div>
            </div>
            </div>
            
    
            <div class="form-group">
                <label for="">Comentario</label>
                <textarea name="com" class="form-control" cols="30" rows="3" wire:model="com"></textarea>
            </div>
            <button onclick="guardar()" class="btn btn-success" >Guardar</button> 

            @if($datos != Null)
           
            <h4>Herramientas a prestarx</h4>
            <table class="table">
                <thead>
                    <th>Descripción</th>
                    <th>Cantidad</th>
                    <th>Check</th>
                </thead>
                <tbody class="herramientas">
                    @foreach($datos as $key => $val)
                    <tr>
                        <td>{{$val->Descripcion}}</td>
                        <td><input id="cantidad_{{$key}}" value="{{$val->Cantidad}}" ></td>
                        <td><input type="checkbox" class="form-control" id="herramientas_{{$key}}" checked value="{{$val->id}}"></td>
                           </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
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
        $('.slc2').select2({
    dropdownParent: $('#theModal'),
    dropdownAutoWidth: true,
    placeholder: 'Selecciona una opcion',
    width: '100%'
})
window.livewire.on('success', msg => {
                $('#theModal').modal('hide')
                Swal.fire({
                    icon: 'success',
                    title: 'Exito',
                    html: msg,

                });
                @this.call('resetUI')
            })

            window.livewire.on('error', msg => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    html: msg,

                });

            })

        })
       function cargarcheck(id){
        @this.set('responsiva',id)
       }
       function responsable(id){
        @this.set('responsable',id)
       }
       function guardar() {
    var herramientas = [];
    var cantidades = [];
    
    // Iterar sobre los checkboxes marcados
    $('[id*="herramientas_"]:checked').each(function(index, checkbox) {
        var herramientaId = checkbox.id;
        var cantidad = $('[id="cantidad_' + herramientaId.split('_')[1] + '"]').val();
        
        // Obtener el valor del checkbox (o cualquier otro dato relevante)
        var herramienta = checkbox.value;
        
        // Agregar la herramienta y la cantidad a sus respectivos arreglos
        herramientas.push(herramienta);
        cantidades.push(cantidad);
    });

    @this.set('herr',herramientas)
    @this.set('cantidad',cantidades)

    @this.call('guardar')
    // Si deseas pasar estos arreglos a algún otro lugar, puedes hacerlo aquí
}
    </script>

@stop
