<?php $__env->startSection('title', $componentName . ' | ' . $pageTitle); ?>
<?php $__env->startSection('content_header'); ?>

<?php $__env->stopSection(); ?>

<article class="container">
    <h3 class="">Responsiva: <?php echo e($this->responsable($prestamo->reponsable)); ?></h3>
    </div>
    <center>
        <img src="<?php echo e(url('img/logo.jpeg')); ?>" style="width:40%">
    </center>
    <div class="row">
        <div class="col-4">
            <b>Codigo:</b> <?php echo e($prestamo->codigo); ?>

        </div>
        <div class="col-4">

        </div>
        <div class="col-4">
            <b>Fecha remision:</b> <?= date('d-m-Y') ?>
        </div>
        <div class="col-md-12"><br>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ACCESORIOS INCLUIDOS</th>
                        <th>C</th>
                        <th>E</th>
                        <th>Comentarios</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $tabla; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($this->herramientas($key->herr)); ?> NS: <b><?= $key->numserie ?></b>
                                MD: <b><?= $key->modelo ?></b></td>
                            <?php if($key->modelo == ''): ?>
                                <td><?php echo e($this->suma($key->herr)); ?> </td>
                                <td><?php echo e($this->suma($key->herr)); ?></td>
                            <?php else: ?>
                                <td><?php echo e($key->cantidad); ?></td>
                                <td><?php echo e($key->cantidad); ?></td>
                            <?php endif; ?>
                            <td><?php echo e($key->com); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
            C: cantidad  E: entrega R: recepci&oacute;n
            <div class="text-center" >
                <i>El cual me comprometo, mantener en buen estado y utilizarlo &uacute;nica y exclusivamente para asuntos relacionados con mi actividad laboral. En caso de su exxtravop. daño &oacute; uso inadecuado total o parcial, me responsabilizo oa pagar el costo de reaparaci&oacute;n o la reposici&oacute;n del equipo. La responsibilidad no es transferible.</i>
            
                </div>
                <div class="row">
                <div class="col-md-6">
                    FECHA DE ENTREGA:
                    </div>
                <div class="col-md-6">
                    <b> <?= date('d - m - Y');?></b>
                </div>
                </div>
                <div class="row">
                    <div class="col-md-6 text-center" >             
                    <b>ENTREGA</b><br>
                    
                        <hr>
                        <b>Firma</b>
    
                <label>Nombre:</label><br>
                    <?php echo e($user); ?><br>
                    <label>Cargo:</label><br>
                        admin
                    </div>
                    
                    <div class="col-md-6" >
                      <center>
                    <b>RECIBE</b><br>
                    <hr>
                        <label>NOMBRE:</label> <br>
                        <?php echo e($this->responsable($prestamo->reponsable)); ?><br>
                        <label>CARGO:</label><br>
                     <?php echo e($this->datos_responsable($prestamo->reponsable)); ?></b>
                      </center>
                    </div>
                    
                    
                    
                    <div class="col-md-12">
                        <label for="">Comentarios</label><br>
                        <textarea name="" id="" cols="30" rows="2" class="form-control"></textarea><br>
                    <center>
                    <div class="btn-group d-print-none">
                    
                    <button class="btn-info btn" onclick="window.print();">Imprimir</button>
                
                    </div>
                    </center>
                    </div>
                </div>
                    
        </div>
    </div>
</article>
<?php /**PATH C:\Users\SERG\Documents\grose_system\resources\views/livewire/impresionprestamo/impresion-presamo-component.blade.php ENDPATH**/ ?>