</div>
      <div class="modal-footer">
     
          <?php switch($accion):
            case ('0'): ?>
                <button type="button" wire:click.prevent="resetUI()" class="btn btn-dark close-btn" data-dismiss="modal">CERRAR</button>
              <?php break; ?>
            <?php case ('1'): ?>
                <button type="button" wire:click.prevent="resetUI()" class="btn btn-dark close-btn" data-dismiss="modal">CERRAR</button>
                <button type="button" wire:click.prevent="Store()" wire:loading.attr="disabled" class="btn btn-dark close-modal" >GUARDAR</button>
              <?php break; ?>
            <?php case ('2'): ?>
                <button type="button" wire:click.prevent="resetUI()" class="btn btn-dark close-btn" data-dismiss="modal">CERRAR</button>
                <button type="button" wire:click.prevent="Update()" wire:loading.attr="disabled" class="btn btn-dark close-modal" >ACTUALIZAR</button>
              <?php break; ?>
            <?php case ('3'): ?>
                <button type="button" wire:click.prevent="resetUI()" class="btn btn-dark close-btn" data-dismiss="modal">CERRAR</button>
                <button type="button" wire:click.prevent="subir_documento()" wire:target="factura" wire:loading.attr="disabled" class="btn btn-dark close-modal" >SUBIR</button>
              <?php break; ?>
              <?php case ('4'): ?>
                <button type="button" wire:click.prevent="resetUI()" class="btn btn-dark close-btn" data-dismiss="modal">CERRAR</button>
              <?php break; ?>
              <?php case ('5'): ?>
                <button type="button" wire:click.prevent="resetUI()" class="btn btn-dark close-btn" data-dismiss="modal">CERRAR</button>
              <?php break; ?>
              <?php case ('6'): ?>
                <button type="button" wire:click.prevent="resetUI()" class="btn btn-dark close-btn" data-dismiss="modal">CERRAR</button>
              <?php break; ?>
              <?php case ('7'): ?>
              <button type="button" wire:click.prevent="resetUI()" class="btn btn-dark close-btn" data-dismiss="modal">CERRAR</button>
              <button type="button" wire:click.prevent="GuardarActualizacion()" wire:loading.attr="disabled" class="btn btn-dark close-modal" >ACTUALIZAR</button>
            <?php break; ?>
            <?php case ('8'): ?>
            <button type="button" wire:click.prevent="resetUI()" class="btn btn-dark close-btn" data-dismiss="modal">CERRAR</button>
            <button type="button" wire:click.prevent="Guardar()" wire:loading.attr="disabled" class="btn btn-dark close-modal" >GUARDAR</button>
          <?php break; ?>
            <?php case ('transaction'): ?>
                <button type="button" wire:click.prevent="resetUI()" class="btn btn-dark close-btn" data-dismiss="modal">CERRAR</button>
                <button type="button" wire:click.prevent="SaveTransaction()" wire:loading.attr="disabled" class="btn btn-dark close-modal" >GUARDAR MOVIMIENTO</button>
              <?php break; ?>
          <?php endswitch; ?>
 
      </div>
    </div>
  </div>
</div><?php /**PATH C:\Users\SERG\Documents\grose_system\resources\views/common/modalFooter.blade.php ENDPATH**/ ?>