<?php echo $__env->make('common.modalHead', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php switch($accion):
    case (1): ?>
        <h3>Realizar cambios</h3>
        <div class="form-group">
            <label for="">Accion</label>
            <select name="accion" class="form-control" wire:model="cambio">
                <option value=""></option>
                <option value="1">Cambiar de responsable</option>
                <option value="2">Quitar</option>
            </select>
        </div>
        <h3><?php echo e($this->nh); ?></h3>
        <div class="form-group">
            <label for="">Cantidad</label>
            <input type="number" name="pza" <?php if($pza == 1): ?> readonly <?php endif; ?> class="form-control" id="pza" wire:model="pza">
        </div>
        <?php if($cambio == 1): ?>
            <div class="form-group" wire:ignore>
                <label>Responsable</label>
                <select class="form-control slct" onchange="responsable(this.value)">
                    <option></option>
                    <?php $__currentLoopData = $responsables; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($val->codigo); ?>,<?php echo e($val->reponsable); ?>"><?php echo e($val->codigo); ?>

                            [<?php echo e($this->responsable($val->reponsable)); ?>] </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <script>
                    $('.slct').select2();
                </script>
            </div>
        <?php endif; ?>

        <script>
            $('.slct').select2();
        </script>
    <?php break; ?>

    <?php case (2): ?>
        <div class="form-group">

            <label for="">N° de serie</label>
            <input type="text" class="form-control" name="nser" wire:model="numser">
        </div>
        <div class="form-group">
            <label for="">Modelo</label>
            <input type="text" class="form-control" name="mod" wire:model="modelo">
        </div>
        <div class="form-group">
            <label for="">Marca</label>
            <input type="text" class="form-control" name="marca" wire:model="marca">
        </div>
        <div class="form-group">
            <label for="">Comentario</label>
            <input type="text" class="form-control" name="com" wire:model="com">
        </div>
    <?php break; ?>
<?php case (4): ?>
<h3>Reporte de reparacion</h3>
<div class="row">
    	<div class="col-md-5">
    		<table class="table table-bordered">
    		<tr>
             
          <td><b>Fecha de baja</b></td>
          <td><?php echo e($fecha_baja); ?></td>
            
          </td>
        </tr>
        <tr>
    			<td><b>Codigo</b></td>
    			<td><?php echo e($codigo); ?> </td>
    		</tr>
        <tr>
          <td><b>Modelo:</b></td>
         <td><?php echo e($modelo); ?></td>
        </tr>
    		<tr>
    			<td><b>Herramienta</b></td>
    			<td><?php echo e($nh); ?></td>
    		</tr>
    		<tr>
    			<td><b>Comentario</b></td>
    			<td><?php echo e($com); ?></td>
    		</tr>
        <tr> 
          <td><b>Fecha de reparacion</b></td>
          <td>      <?php echo e($fecha_rep); ?>    </td>
        </tr>
    		<tr>
    			<td><b>Comentario de reparacion</b></td>
    			<td><?php echo e($com_rep); ?></td>
    		</tr>
    		</table>
    	</div>
<?php break; ?>
    <?php case (3): ?>
        <h3>Subir factura de servicio</h3>
        <button class="btn btn-link" wire:click="accion(0,<?php echo e($val); ?>)">Regresar</button>
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
        <table class="table ">
            <thead class="thead-dark">
                <th>Fecha</th>
                <th>Archivo</th>


                <th> Accion</th>

            </thead>
            <tbody>
                <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>

                        <td><?php echo e($key->fecha); ?></td>
                        <td><a href="<?php echo e(url('facturas_herramientas')); ?>/<?php echo e($key->archivo); ?>"
                                target="_blank"><?php echo e($key->nombre); ?></a></td>
                        <td> <button type="button" onclick="eliminar_imagen(<?php echo e($key->id); ?>)" class="btn btn-danger"><span
                                    class="fa fa-times"></span></button></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
        <script></script>
    <?php break; ?>
<?php case (7): ?>
<h3>Reporte de reparacion</h3>
<div class="row">
    	<div class="col-md-5">
    		<table class="table table-bordered">
    		<tr>
             
          <td><b>Fecha de baja</b></td>
          <td><?php echo e($fecha_baja); ?></td>
            
          </td>
        </tr>
        <tr>
    			<td><b>Codigo</b></td>
    			<td><?php echo e($codigo); ?> </td>
    		</tr>
        <tr>
          <td><b>Modelo:</b></td>
         <td><?php echo e($modelo); ?></td>
        </tr>
    		<tr>
    			<td><b>Herramienta</b></td>
    			<td><?php echo e($nh); ?></td>
    		</tr>
    		<tr>
    			<td><b>Comentario</b></td>
    			<td><?php echo e($com); ?></td>
    		</tr>
        <tr> 
          <td><b>Fecha de reparacion</b></td>
          <td>      <?php echo e($fecha_rep); ?>    </td>
        </tr>
    		<tr>
    			<td><b>Comentario de reparacion</b></td>
    			<td><?php echo e($com_rep); ?></td>
    		</tr>
    		</table>
    	</div>
    	<div class="col-md-5">
	
			<label for="">Comentario</label>
			<textarea name="comentario" wire:model="comentario" class="form-control" <?php if($com_rep != ''): ?> disable <?php endif; ?> cols="30" rows="2"></textarea><br>
			
        </div>
<?php break; ?>
    <?php case (8): ?>
        <div class="form-group" wire:ignore>
            <label>Codigo</label>
            <input type="text" class="form-control" name="cdx" wire:model="cod" wire:ignore.lazy readonly>
            <?php $__errorArgs = ['cod'];
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
        <label>Codigo de barras</label>
        <div class="form-group">
            <input type="text" class="form-control" name="cbx"  wire:model="cod_barras" wire:ignore.lazy>
            <?php $__errorArgs = ['cod_barras'];
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
        <div class="form-group">
            <label>Comentario</label>
            <textarea class="form-control" name="comentario" cols="20" rows="5" wire:model="com" wire:ignore.lazy></textarea>
            <?php $__errorArgs = ['com'];
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
    <?php break; ?>

<?php endswitch; ?>
<?php echo $__env->make('common.modalFooter', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH C:\Users\SERG\Documents\grose_system\resources\views/livewire/listadoherramientas/form.blade.php ENDPATH**/ ?>