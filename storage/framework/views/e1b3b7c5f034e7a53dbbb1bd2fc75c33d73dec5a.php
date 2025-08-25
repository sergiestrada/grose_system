<?php echo $__env->make('common.modalHead', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php switch($accion):
case (0): ?>
<h3>Certificados</h3>

<?php break; ?>  
<?php case (1): ?>

        <div class="row">
            <div class="col-md-3">
                <label for="">Codigo barras</label>
                <input type="text" name="codigo" wire:model="cod_barras" class="form-control" required wire:ignore.lazy>
                <?php $__errorArgs = ['clave'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="text-danger"><?php echo e($message); ?></span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="col-md-8">
                <div class="form-group" wire:ignore>
                    <label for="">Herramienta</label>
                    <select name="herramienta" wire:model="herramenta" onchange="obtener_herramienta(this.value)"
                        class="form-control slct" required wire:ignore.lazy>
                        <option value=""></option>

                        <?php $__currentLoopData = $medicion; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?= $val->id ?>"><?= $val->instrumento ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php $__errorArgs = ['herramenta'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span class="text-danger"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="">Marca o Modelo</label>
                    <input type="text" class="form-control" wire:model="marca" name="marca" required wire:ignore.lazy>
                    <?php $__errorArgs = ['marca'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span class="text-danger"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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
                            <?php $__currentLoopData = $herramienta_med; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?= $k->id ?></td>
                                    <td><?= $k->cod_barras ?></td>
                                    <td><?php echo e(\App\Models\Medicion::find($k->herramenta)->instrumento); ?>

                                    </td>
                                    <td><?= $k->marca ?></td>
                                    
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
    <?php break; ?>

    <?php case (2): ?>
        <div class="row">
            <div class="col-md-12">
                <label for="">Codigo barras</label>
                <select name="codigo" wire:model="id_her" class="form-control slct">
                    <option value=""></option>

                    <?php $__currentLoopData = $herramienta_med; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($val->id); ?>"><?php echo e($val->cod_barras); ?> &nbsp;<b>
                                [<?php echo e($this->medicion_herr($val->herramenta)); ?> ]</b></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
    <?php break; ?>
<?php case (3): ?>
<div class="form-group">
    <label>Documento</label>
    <input type="file" class="form-control" name="factura" wire:model="factura">
    <?php $__errorArgs = ['factura'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <span class="text-danger"><?php echo e($message); ?></span>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    <div wire:loading wire:target="factura">Uploading...</div>
    </div>
<?php break; ?>
    <?php case (7): ?>
        <div class="row">
            <div class="col-md-12">
                <label for="">Codigo barras</label>
                <select name="codigo" wire:model="id_her" class="form-control slct">
                    <option value=""></option>

                    <?php $__currentLoopData = $herramienta_med; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($val->id); ?>"><?php echo e($val->cod_barras); ?> &nbsp;<b>
                                [<?php echo e($this->medicion_herr($val->herramenta)); ?> ]</b></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
    <?php break; ?>

<?php endswitch; ?>

<?php echo $__env->make('common.modalFooter', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH C:\Users\SERG\Documents\grose_system\resources\views/livewire/bitacoramedicion/form.blade.php ENDPATH**/ ?>