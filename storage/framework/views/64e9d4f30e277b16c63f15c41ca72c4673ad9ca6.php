<?php $__env->startSection('title', $componentName . ' | ' . $pageTitle); ?>
<?php $__env->startSection('content_header'); ?>

<?php $__env->stopSection(); ?>


<article class="container-fluid">
    <br>
    <div class="row">

        <div class="col-md-11">
            <h3><?php echo e($pageTitle); ?></h3>
        </div>
        <div class="col-md-1">
            <button class="btn btn-secondary" wire:click="accion(1,0)">Agregar</button>
        </div>
        <div class="col-md-12 table-responsive" wire:ignore>
            <table class="table">
                <thead class="bg-dark">
                    <th>#</th>
                    <th>Codigo</th>
                    <th>Responsable</th>
                    <th>Portador</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </thead>
                <tbody class="bg-white">
                    <?php $__currentLoopData = $tabla; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        
                        <tr>
                            <td><?php echo e($contador++); ?></td>
                            <td><?php echo e($key->codigo); ?></a> </td>
                            <td><?php echo e($this->responsable($key->reponsable)); ?></td>
                            <td><?php echo e($this->responsable($key->Portador)); ?></td>
                            <td><?= $key->fecha ?></td>
                          
                            
                            <td><button class="btn btn-success btn-sm"  title="Agregar herramienta" wire:click="accion(2,<?php echo e($key->id); ?>)"><span
                                        class="fas fas fa-calendar-plus"></span></button>
                                        <a class="btn btn-info btn-sm"  href="<?php echo e(url('prestamos_herramientas/impresion')); ?>/<?php echo e($key->id); ?>"><span
                                        class="fas fa-file-alt"  title="Imprimir Responsiva"></span></a>
                                        <a href='<?php echo e(url('bouche')); ?>/<?php echo e($key->id); ?>'  title="PDF bouche" class="btn btn-secondary btn-sm"><span
                                        class="fas fa-file-alt"></span></a>
                                        <a href="<?php echo e(url('prestamos_herramienta/listado')); ?>/<?php echo e($key->codigo); ?>"  title="Listado de herramieta mediana" class="btn btn-dark btn-sm"><span
                                        class="fas fa-screwdriver"></span></a>  
                                        <button class="btn btn-danger btn-sm"  title="Eliminar" onclick="eliminar(<?php echo e($key->id); ?>)"><span
                                            class="fa fa-times"></span></button>
                
                                        
                            
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
            
        </div>

    </div>
    <?php echo $__env->make('livewire.prestamosherramientas.form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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


            $('.table').DataTable({
                'order': [
                    [4, 'desc']
                ]
            });
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
                    title: 'Éxito',
                    html: msg,
                }).then((result) => {
                    if (result.isConfirmed || result.isDismissed) {
                        window.livewire.find('<?php echo e($_instance->id); ?>').call('resetUII')
                        $('.slct2').val(null).trigger('change')
                        $('#factura').val('');
                    }
                });
            });
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
           window.livewire.find('<?php echo e($_instance->id); ?>').set('Portador',id)
        }

        function responsable(id) {
            window.livewire.find('<?php echo e($_instance->id); ?>').set('reponsable',id)
        }

        function obtener_herramienta(id) {
              window.livewire.find('<?php echo e($_instance->id); ?>').set('herr',id)
        }
    </script>

<?php $__env->stopSection(); ?>
<?php /**PATH C:\Users\SERG\Documents\grose_system\resources\views/livewire/prestamosherramientas/presamos-herramientas-component.blade.php ENDPATH**/ ?>