<?php $__env->startSection('title', $componentName . ' | ' . $pageTitle); ?>
<?php $__env->startSection('content_header'); ?>

<?php $__env->stopSection(); ?>
<article class="container-fluid">

    <div class="row">
        <section class="col-md-10"><br>
            <h3><?php echo e($pageTitle); ?></h3>
        </section>
        <section class="col-md-2"><br>
            <button class="btn btn-secondary btn-sm" wire:click="accion(1,0)">Codificar</button>   <button class="btn btn-primary btn-sm" wire:click="accion(2,0)">Agregar</button>
        </section>
        <section class="col-md-12" wire:ignore>
            <table class="table">
                <thead class="bg-dark">
                    <th>#</th>
                    <th>Codigo</th>
                    <th>Herramienta</th>
                    <th>Fecha</th>
                    <th>Fecha Prox Mant</th>
                    <th>Acciones</th>
              
                </thead>
                <tbody class="bg-light"> 
                    <?php $__currentLoopData = $table; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>   
                    <?php 
                    $hoy = date('Y-m-d');
                   
        $fecha_p = strtotime($v->fecha_prox);
        $hoy_n = strtotime($hoy);
        $codigo = \App\Models\Herramienta_medicion::where('id', $v->id_her)->value('codigo');
        $idher = \App\Models\Herramienta_medicion::where('id', $v->id_her)->value('herramenta');
        $her = \App\Models\Medicion::where('id', $idher)->value('instrumento');
    ?>
                   
                   <tr>
                    <td><?php echo e($v->id); ?></td>
                  
                    <td><?php echo e($codigo); ?></td>
                    <td><?php echo e($her); ?></td>
                    <td><?php echo e($v->fecha); ?></td>
                    <td <?php if($fecha_p >= $hoy_n): ?> class="bg-success" <?php else: ?> class="bg-danger" <?php endif; ?>><?php echo e($v->fecha_prox); ?></td>
                          <td>
                            <button wire:click="accion(7,<?php echo e($v->id); ?>)" class="btn btn-warning btn-sm"><span class="fas fa-edit"></span></button>
                           </td>
           
                </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                          
                </tbody>
            </table>
        </section>
    </div>
    <?php echo $__env->make('livewire.bitacoramedicion.form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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


            $('.slct').select2({
        dropdownParent: $('#theModal'),
        dropdownAutoWidth: true,
        placeholder: 'Selecciona una opcion',
        width: '100%'
    })
   
    $('.table').DataTable({
        stateSave: true, // Guarda el estado del DataTable (paginación, búsqueda, etc.)
      
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

  

        function obtener_herramienta(id) {
              window.livewire.find('<?php echo e($_instance->id); ?>').set('herramenta',id)
        }
    </script>

<?php $__env->stopSection(); ?>
<?php /**PATH C:\Users\SERG\Documents\grose_system\resources\views/livewire/bitacoramedicion/bitacora-medicion-component.blade.php ENDPATH**/ ?>