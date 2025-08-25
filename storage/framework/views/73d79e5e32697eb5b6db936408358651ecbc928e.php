<?php echo $__env->make('common.modalHead', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php switch($accion):
case (0): ?>
<div class="row">
<section class="col-md-9">
    <h3>Herramientas</h3>
</section>
<section class="col-md-3">
<button class="btn btn-dark" onclick="reparar_equipo(1)">Reparar</button>
<button class="btn btn-dark" onclick="reparar_equipo(2)">Calibrar</button>


</section>
</div>
<table class="table">
    <thead>
        <th>Herramienta</th>
        <th>Acciones</th>
    
    </thead>
    <tbody>
  
        <?php $__currentLoopData = $herramientas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
       <tr>
        <td><?php echo e($this->herramienta($row->herr)); ?></td>
      <td><button class="btn btn-danger btn-sm" wire:click="accion(4,<?php echo e($row->id); ?>)"><span class="fas fa-tools"></span></button>
    
       </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>
<?php break; ?>

<?php case (2): ?>
<div class="form-group">
    <label for="">Empresa/Obra</label>
<input type="text" name="emp1" wire:model="obra" class="form-control">
    </div>
<div class="form-group">
        <label for="">Responsiva</label>
        <input name="buscar1" class="form-control" wire:model="responsiva" readonly disabled>
              
    </div>
    <div class="form-group">
        <label>Quien entrega</label>
        <input type="text" class="form-control" name="entrego1" wire:model="encargado" required>
    </div>
    <div class="form-group">
        <label>Cargo</label>
        <input type="text" class="form-control" name="cargo1" wire:model="cargo_e" required>
    </div>

    <div class="form-group">
    <label for="">Responsable</label>
    <input name="responsable1" wire:model="responsable" class="form-control" disabled required="">
    
    </div>
    

    <div class="form-group">
        <label for="">Comentario</label>
        <textarea name="com1" class="form-control" wire:model="com" cols="30" rows="3"></textarea>
    </div>
<?php break; ?>
<?php case (3): ?>
<h3>Subir documentos</h3>
<hr>
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
<table class="table">
<thead class="bg-dark">
    <th>Archivo</th>
    <th>Acciones</th>
</thead>
<tbody>
    <?php $__currentLoopData = $archivos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td><a target="_blank" href="<?php echo e(url('conformidades')); ?>/<?php echo e($row->archivo); ?>"><?php echo e($row->archivo); ?></td>
            <td><button class="btn btn-danger btn-sm" onclick="eliminar_img(<?php echo e($row->id); ?>)"><span class="fa fa-times"></span></button>
        </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</tbody>
</table>
<?php break; ?>
<?php case (4): ?>
<div class="row">
<section class="col-md-9">
    <h3>Enviar a reparacion</h3>
</section>
<section class="col-md-3">
    <button class="btn btn-info btn-sm" wire:click="accion(0,<?php echo e($dato); ?>)">Retroceder</button>
    <button class="btn btn-dark btn-sm" wire:click="enviar_reparacion()">Enviar</button>

</section>
</div>

<hr>
<div class="form-group">
    <label>Comentario</label>
    <textarea class="form-control" wire:model="comentario"></textarea>
</div>
<?php break; ?>
<?php case (5): ?>
<h3>Medicion dañada</h3>
<table class="table">
    <thead>
        <th>Herramienta</th>
        <th>Comentario</th>
        <th>Estatus</th>
        <th>Accion</th>
    </thead>
    <tbody>
        <?php $__currentLoopData = $dato; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td><?php echo e($this->herramienta($row->herramineta)); ?></td>
            <td><?php echo e($row->comentario); ?></td>
            <?php if($row->status == 1): ?>
            <td class="bg-danger">Dañada</td>
            <?php else: ?>
            <td class="bg-success">Reparada</td>
            <?php endif; ?>
            <td>
                <?php if($row->status == 1): ?>
                <button class="btn btn-success btn-sm" wire:click="reparar(<?php echo e($row->id); ?>)"><span class="fa fa-check"></span></button>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>
<?php break; ?>
<?php endswitch; ?>
<?php echo $__env->make('common.modalFooter', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\SERG\Documents\grose_system\resources\views/livewire/responsivasmedicion/form.blade.php ENDPATH**/ ?>