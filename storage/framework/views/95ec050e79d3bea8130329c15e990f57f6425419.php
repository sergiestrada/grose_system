<?php $__env->startSection('title', $componentName . ' | ' . $pageTitle); ?>
<?php $__env->startSection('content_header'); ?>

<?php $__env->stopSection(); ?>


<article class="container-fluid">
    <br>
    <div class="row">

        <div class="col-md-9">
            <h3><?php echo e($pageTitle); ?></h3>
        </div>
        <div class="col-md-3">
            <a href="<?php echo e(url('responsivas_medicion/generar')); ?>" class="btn btn-secondary btn-sm" >Agregar</a>
            <button class="btn btn-danger btn-sm" wire:click="accion(5,0)">Herramienta dañada</button>
        </div>
        <div class="col-md-12 table-responsive" wire:ignore>
            <table class="table" id="example">
                <thead>
                  <th>Responsable</th>
                  <th>Cargo</th>
                  <th>Fecha Entrega</th>
                  <th>Responsiva</th>
                  <th>Estatus</th>
                  <th>Acciones</th>
                </thead>
                  <tbody>
                    <?php $__currentLoopData = $table; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ke): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                    <tr>
                    <td><?php echo e($this->responsable($ke->responsable)); ?></td>
                    <td><?php echo e($this->cargo($ke->responsable)); ?></td>
                    <td><?php echo e($ke->fecha_e); ?></td>
                    <td><?php echo e(DB::table('formato')->where('id',$ke->responsiva)->first()->Nombre); ?></td>
                    <td><?php  if($ke->status==1){?> Pendiente <?php } if($ke->status==0){ ?> Entregado <?php } if($ke->status==2){?> Dañado <?php } if($ke->status==5){?> Reparacion <?php } if($ke->status== 6){?> Baja <?php }?> </td>
                    <td>
                   
                          <a id="pdf" class="btn btn-danger btn-sm" href="<?php echo e(url('responsiva_pdf')); ?>/<?= $ke->responsiva ?>/<?= $ke->id?>"><span class="fas fa-file-pdf"></span></a>
                        
                          <button  class="btn btn-info btn-sm" wire:click="accion(0,<?php echo e($ke->id); ?>)"><span class="fa fa-search"></span></button>
                       <button class="btn btn-secondary btn-sm" wire:click="accion(3,<?php echo e($ke->id); ?>)"><span class="fa fa-upload"></span></button>
                          <button wire:click="accion(2,<?php echo e($ke->id); ?>)" class="btn btn-warning btn-sm" ><span class="fas fa-edit"></span></button>  <button class="btn btn-danger btn-sm" onclick="eliminar(<?php echo e($ke->id); ?>)"><span class="fa fa-times"></span></button>
                          <?php if($ke->status != 0): ?>
                          <button onclick="devolver(<?php echo e($ke->id); ?>)" class="btn btn-success btn-sm"><span class="fa fa-check"></span></button>
                        <?php endif; ?>
                        </td>
                         
                </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </tbody>
            </table>
        </div>
    </div>
    <?php echo $__env->make('livewire.responsivasmedicion.form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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
    window.livewire.on('show-modal', msg => {
        $('#theModal').modal('show');
    });

    window.livewire.on('success', msg => {
        $('#theModal').modal('hide');
        Swal.fire({
            icon: 'success',
            title: 'Éxito',
            html: msg,
        }).then((result) => {
            if (result.isConfirmed || result.isDismissed) {
                window.livewire.find('<?php echo e($_instance->id); ?>').call('resetUI'); // Cambiado de "window.livewire.find('<?php echo e($_instance->id); ?>').call('resetUI');" a "Livewire.emit('resetUI');"
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
                window.livewire.find('<?php echo e($_instance->id); ?>').call('resetUII'); // Cambiado de "window.livewire.find('<?php echo e($_instance->id); ?>').call('resetUI');" a "Livewire.emit('resetUI');"
              
            }
        });
    });

    window.livewire.on('error', msg => {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            html: msg,
        });
    });

    $('#example').DataTable({
        'order': [
            [2, 'desc']
        ]
    });
});

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
            window.livewire.find('<?php echo e($_instance->id); ?>').call('delete', id); // Cambiado de "window.livewire.find('<?php echo e($_instance->id); ?>').call('delete', id)" a "Livewire.emit('delete', id);"
        } else {
            // Aquí puedes poner la lógica para el caso "No"
            Swal.fire(
                'Cancelado',
                'Se canceló la petición.',
                'error'
            );
        }
    });
}

function reparar_equipo(id){
    Swal.fire({
        title: '¿Estás seguro de enviar este equipo a reparar o calibracion?',
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminarlo',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Aquí puedes poner la lógica para el caso "Sí"
            window.livewire.find('<?php echo e($_instance->id); ?>').call('reparar_equipo', id); // Cambiado de "window.livewire.find('<?php echo e($_instance->id); ?>').call('delete', id)" a "Livewire.emit('delete', id);"
        } else {
            // Aquí puedes poner la lógica para el caso "No"
            Swal.fire(
                'Cancelado',
                'Se canceló la petición.',
                'error'
            );
        }
    });
}
function eliminar_img(id) {
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
            window.livewire.find('<?php echo e($_instance->id); ?>').call('delete_img', id); // Cambiado de "window.livewire.find('<?php echo e($_instance->id); ?>').call('delete', id)" a "Livewire.emit('delete', id);"
        } else {
            // Aquí puedes poner la lógica para el caso "No"
            Swal.fire(
                'Cancelado',
                'Se canceló la petición.',
                'error'
            );
        }
    });
}
function devolver(id) {
    Swal.fire({
        title: 'Confirmas que se devolvió el equipo',
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Aquí puedes poner la lógica para el caso "Sí"
            window.livewire.find('<?php echo e($_instance->id); ?>').call('devolver', id); // Cambiado de "window.livewire.find('<?php echo e($_instance->id); ?>').call('devolver', id)" a "Livewire.emit('devolver', id);"
        } else {
            // Aquí puedes poner la lógica para el caso "No"
            Swal.fire(
                'Cancelado',
                'Se canceló la petición.',
                'error'
            );
        }
    });
}
</script>
<?php $__env->stopSection(); ?><?php /**PATH C:\Users\SERG\Documents\grose_system\resources\views/livewire/responsivasmedicion/responsivas-medicion-component.blade.php ENDPATH**/ ?>