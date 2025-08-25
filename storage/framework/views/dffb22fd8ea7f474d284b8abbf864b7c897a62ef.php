
<?php $__env->startSection('title',$componentName.' | '.$pageTitle); ?>
<?php $__env->startSection('content_header'); ?>
    
<?php $__env->stopSection(); ?>
<br>
<article class="container-fluid">
    <h3><?php echo e($pageTitle); ?></h3>

   
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
    })
       
    </script>

<?php $__env->stopSection(); ?><?php /**PATH C:\Users\SERG\Documents\grose_system\resources\views/livewire/home/home-component.blade.php ENDPATH**/ ?>