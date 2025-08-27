<?php $__env->startSection('title', $componentName . ' | ' . $pageTitle); ?>
<?php $__env->startSection('content_header'); ?>

<?php $__env->stopSection(); ?>

<article class="container-fluid">

    <br>
    <h2> <?php echo e($pageTitle); ?></h2>

    <div class="row">
        <div class="col-md-12">
            <h3>Herramientas de mano</h3>
            <div class="prestamos1 table-responsive">
                <div class="estatico" wire:ignore>
                    <table class="table  order-table" id="examplex">
                        <thead>

                            <th>Numero de serie</th>
                            <th>Herramienta</th>
                            <th>Modelo</th>
                            <th>Marca</th>
                            <th>Cantidad</th>
                            <th>Accion</th>
                        </thead>
                        <tbody>

                            <?php $__currentLoopData = $her_mano; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?= $key->numser ?> </td>

                                    <td><?= $this->herramientas($key->herr) ?></td>
                                    <td><?= $key->modelo ?></td>
                                    <td><?= $key->marca ?></td>

                                    <td><?= $key->cantidad ?></td>

                                    <td>
									<div class="btn-group">
									<button class="btn btn-primary btn-sm" wire:click="accion(1,<?php echo e($key->id); ?>)" ><span class="fas fa-sync-alt"></span></button>
									<button class="btn btn-warning btn-sm" wire:click="accion(2,<?php echo e($key->id); ?>)" ><i class="fas fa-edit"></i>
</button>
									<button class="btn btn-secondary btn-sm" wire:click="accion(3,<?php echo e($key->id); ?>)"><span class="fa fa-upload"></span></button>
									<button class="btn btn-danger btn-sm" wire:click="accion(8,<?php echo e($key->id); ?>)"><span class="fas fa-tools"></span></button>
									</div>
									</td>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </table>
                </div>
            </div>
            <h3>Herramienta de mediana</h3>
            <div class="prestamos1 table-responsive">
                <div class="estatico" wire:ignore>
                    <table class="table  order-table" id="examplex">
                        <thead>

                       
                            <th>Herramienta</th>
                           
                            <th>Cantidad</th>
                            <th>Accion</th>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $herr_mayor; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                 
                            <?php 
                            $consulta = DB::table('prestamos')->where('codigo', $val)->where('herr', $row->herr)->where('status',0)->first();
                        ?>    
                        <tr>
                         

                            <td>
                             
                                <?php echo e($this->herramientas($row->herr)); ?>

                 
                            </td>
                        
                            <td>
                                <?php if(!is_null($consulta)): ?>
                                    <?php echo e(DB::table('prestamos')->where('codigo', $val)->where('herr', $row->herr)->where('status',0)->sum('cantidad')); ?>

                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if(!is_null($consulta) && !is_null($consulta->id)): ?>
                                <div class="btn-group">
							<button class="btn btn-primary btn-sm" wire:click="accion(1,<?php echo e($consulta->id); ?>)" ><span class="fas fa-sync-alt"></span></button>
						
							<button class="btn btn-secondary btn-sm" wire:click="accion(3,<?php echo e($consulta->id); ?>)"><span class="fa fa-upload"></span></button>
							<button class="btn btn-danger btn-sm"  wire:click="accion(8,<?php echo e($consulta->id); ?>)"><span class="fas fa-tools"></span></button></div>
                           <?php endif; ?>
                            </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="bg-danger">
                <h3> Herramientas defectuosas </h3>
            </div>
            <div class="table-responsive estatico" wire:ignore>
                <table class="table">
                    <thead>
                        <th>Fecha</th>
                        <th>Herramienta</th>
                        <th>Cantidad</th>
                        <th>Comentario</th>
                        <th>Accion</th>
                    </thead>
                    <tbody>
              
                        <?php $__currentLoopData = $danada; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        
                            <tr>
                                <td><?php echo e($row->created_at); ?></td>
                                <td><?php echo e($this->herramientas($row->herr)); ?></td>
                                <td><?php echo e($row->cantidad); ?></td>
                                <td><?php echo e($row->comentario); ?></td>
                               <?php if($row->status == 1): ?>
                                <td><button class="btn btn-danger" wire:click="accion(7,<?php echo e($row->id); ?>)"><span class="fas fa-sync-alt"></span></button></td>
                                <?php else: ?>
                                <td><button class="btn btn-link"  wire:click="accion(4,<?php echo e($row->id); ?>)" > <span class="text-success">Retornado</span></button></td>
                                <?php endif; ?>
                            </tr>
                          
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php echo $__env->make('livewire.listadoherramientas.form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    
</article>
<?php $__env->startSection('js'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            <?php if($rol == 'herramientas'): ?>
            $('.admin').hide();
            $('.medicion').hide();
            $('.mantenimiento').hide();
<?php endif; ?>
    
        <?php if($rol == 'medicion'): ?>
            $('.admin').hide();
            $('.herramientas').hide();
            $('.mantenimiento').hide();

        
        <?php endif; ?>
        <?php if($rol == 'mantenimiento'): ?>
            $('.admin').hide();
            $('.medicion').hide();
            $('.herramientas').hide();

        
        <?php endif; ?>
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
                        window.livewire.find('<?php echo e($_instance->id); ?>').call('resetUI');
                        location.reload(); // Esto recargará la página
                    }
                });
            });
            window.livewire.on('success1', msg => {
          
          Swal.fire({
              icon: 'success',
              title: 'Exito',
              html: msg,

          });
          window.livewire.find('<?php echo e($_instance->id); ?>').call('resetUII')
      })
            window.livewire.on('error', msg => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    html: msg,

                });

            })

        })


        function eliminar(id) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡No podrás revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminarlo',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Aquí puedes poner la lógica para el caso "Sí"
                    window.livewire.find('<?php echo e($_instance->id); ?>').call('delete', id)
                } else {
                    // Aquí puedes poner la lógica para el caso "No"
                    Swal.fire(
                        'Cancelado',
                        'Se cancelo la peticion.',
                        'error'
                    );
                }
            });
        }

        function eliminar_imagen(id) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡No podrás revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminarlo',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Aquí puedes poner la lógica para el caso "Sí"
                    window.livewire.find('<?php echo e($_instance->id); ?>').call('delete_img', id)
                } else {
                    // Aquí puedes poner la lógica para el caso "No"
                    Swal.fire(
                        'Cancelado',
                        'Se cancelo la peticion.',
                        'error'
                    );
                }
            });
        }

        function portador(id) {
            window.livewire.find('<?php echo e($_instance->id); ?>').set('Portador', id)
        }

        function responsable(id) {
            window.livewire.find('<?php echo e($_instance->id); ?>').set('resp', id)
        
        }

        function obtener_herramienta(id) {
            window.livewire.find('<?php echo e($_instance->id); ?>').set('herr', id)
        }
    </script>

<?php $__env->stopSection(); ?>
<?php /**PATH C:\Users\SERG\Documents\grose_system\resources\views/livewire/listadoherramientas/listado-herramientas-component.blade.php ENDPATH**/ ?>