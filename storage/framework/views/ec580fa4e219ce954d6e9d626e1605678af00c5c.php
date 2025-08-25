<?php echo $__env->make('common.modalHead', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<style>
    .estatico{
        height: 300px;
        overflow: scroll;  
    }
    </style>
<?php switch($accion):
    case (0): ?>
    <?php break; ?>

    <?php case (1): ?>
        <div class="row">
            <section class="col-md-6">
                <div class="form-group" wire:ignore>
                    <label for="">Responsable</label>
                    <select name="resp" class="form-control slct2" onchange="responsable(this.value)" wire:model="reponsable"
                        wire:ignore.lazy>
                        <option value=""></option>
                        <?php $__currentLoopData = $responsables; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?= $val->id ?>"><?= $val->Nombre ?> <?= $val->Apellido_P ?> <?= $val->Apellido_M ?>
                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <?php $__errorArgs = ['reponsable'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="text-danger"><?php echo e($message); ?></span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

            </section>
            <section class="col-md-6">
                <div class="form-group" wire:ignore>
                    <label for="">Portador</label>
                    <select name="portador" class="form-control slct2" onchange="portador(this.value)" wire:model="Portador"
                        wire:ignore.lazy>
                        <option></option>
                        
                        <?php $__currentLoopData = $portadores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($val->id); ?>"><?php echo e($val->Nombre); ?> <?php echo e($val->Apellido_P); ?>

                                <?php echo e($val->Apellido_M); ?> </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php $__errorArgs = ['Portador'];
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


            </section>
        <?php break; ?>

        <?php case (2): ?>
            <?php echo e($codigo); ?>

            <h3><b><?php echo e($nreponsable); ?></b></h3>
            <div class="form-group">
                <label for="">N° de serie</label>
                <input type="text" class="form-control" name="numser" wire:ignore.lazy wire:model="numser">
                <?php $__errorArgs = ['numser'];
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

            <div class="form-group" wire:ignore>
                <label for="">Herramientas</label>
                <select name="her" class="form-control slct2" onchange="obtener_herramienta(this.value)"  wire:model="herr" wire:ignore.lazy>
                    <option value=""></option>
                    <?php echo $this->hers(); ?>

                  
                </select>
                <?php $__errorArgs = ['herr'];
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
            </section>

                <div class="row">

                    <section class="col-md-6">
                        <div class="form-group">
                            <label for="">Marca</label>
                            <input type="text" class="form-control" name="marca" wire:ignore.lazy wire:model="marca">
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

                    </section>
                    <section class="col-md-6">

                        <div class="form-group">
                            <label for="">Modelo</label>
                            <input type="text" class="form-control" name="modelo" wire:ignore.lazy wire:model="modelo">
                            <?php $__errorArgs = ['modelo'];
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
                    </section>
                </div>
                <div class="form-group">
                    <label for="">Cantidad</label>
                    <input name="cant" type="number" class="form-control" wire:ignore.lazy wire:model="cantidad">
                    <?php $__errorArgs = ['cantidad'];
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
                  
                    <label>Foto</label>
                    <input type="file" class="form-control" name="factura" id="factura" wire:model="factura">
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
                <div class="form-group">
                    <label for="">Comentario</label>
                    <textarea name="com" class="form-control" wire:ignore.lazy wire:model="com">
</textarea>
                </div>
            <?php break; ?>

            <?php case (4): ?>
            
            <h3>Herramientas de mano</h3>
            <div class="prestamos1 table-responsive">
                <div class="estatico">
                <table class="table  order-table"  id="examplex">
                <thead>
                
                    <th>Numero de serie</th>
                    <th>Herramienta</th>
                    <th>Modelo</th>
                    <th>Marca</th>
                    <th>Cantidad</th>
                    <th>Accion</th>
                </thead>
                <tbody >
           
                <?php $__currentLoopData = $her_mano; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                <tr>
                     <td><?= $key->numser?> </td>
    
                    <td><?= $this->herramientas($key->herr)?></td>
                    <td><?= $key->modelo ?></td>
                    <td><?= $key->marca ?></td>
                    
                    <td><?= $key->cantidad ?></td>
                    
                    <td hidden><?= $key->id?></td>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </table>
                </div>
        </div>
            <?php break; ?>
            <?php case (5): ?>
            <h3>Herramienta de mediana</h3>
            <div class="prestamos1 table-responsive">
            <div class="estatico">
                <table class="table  order-table"  id="examplex">
                    <thead>
                  
                        <th>Numero de serie</th>
                        <th>Herramienta</th>
                        <th>Modelo</th>
                        <th>Marca</th>
                        <th>Cantidad</th>
                        <th>Accion</th>
                    </thead>
                    <tbody>
                    <?php echo $this->herramientas_mediana($val); ?>      
                    </tbody>
            </table>
            </div>
            <?php break; ?>
            <?php case (6): ?>
  <div class="bg-danger"> 
	<h3> Herramientas defectuosas	</h3>
  </div>
	<div class="table-responsive estatico">
	<table  class="table">
	<thead>		
		<th>Herramienta</th>
		<th>Comentario</th>
		<th>Accion</th>
	</thead>
	<tbody>	
       <?php echo $herramienta_danada; ?>

    </tbody>	
</table>
    </div>

            <?php break; ?>
        <?php endswitch; ?>
        <script>
            $('.table').DataTable();
            $('.slct2').select2({
                dropdownParent: $('#theModal'),
                dropdownAutoWidth: true,
                placeholder: 'Selecciona una opcion',
                width: '100%'
            })
        </script>
        <?php echo $__env->make('common.modalFooter', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH C:\Users\SERG\Documents\grose_system\resources\views/livewire/prestamosherramientas/form.blade.php ENDPATH**/ ?>