@include('common.modalHead')
@switch($accion)
    @case(1)
        <div class="form-group">
            <label>Clasificacion</label>
            <input wire:model="categoria" class="form-control">
            @error('categoria')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    @break

    @case(2)
        <div class="form-group">
            <label>Clasificacion</label>
            <input wire:model="categoria" class="form-control">
            @error('categoria')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    @break

    @default
@endswitch

@include('common.modalFooter')
