</div>
      <div class="modal-footer">
     
          @switch($accion)
            @case('0')
                <button type="button" wire:click.prevent="resetUI()" class="btn btn-dark close-btn" data-dismiss="modal">CERRAR</button>
              @break
            @case('1')
                <button type="button" wire:click.prevent="resetUI()" class="btn btn-dark close-btn" data-dismiss="modal">CERRAR</button>
                <button type="button" wire:click.prevent="Store()" wire:loading.attr="disabled" class="btn btn-dark close-modal" >GUARDAR</button>
              @break
            @case('2')
                <button type="button" wire:click.prevent="resetUI()" class="btn btn-dark close-btn" data-dismiss="modal">CERRAR</button>
                <button type="button" wire:click.prevent="Update()" wire:loading.attr="disabled" class="btn btn-dark close-modal" >ACTUALIZAR</button>
              @break
            @case('3')
                <button type="button" wire:click.prevent="resetUI()" class="btn btn-dark close-btn" data-dismiss="modal">CERRAR</button>
                <button type="button" wire:click.prevent="subir_documento()" wire:target="factura" wire:loading.attr="disabled" class="btn btn-dark close-modal" >SUBIR</button>
              @break
              @case('4')
                <button type="button" wire:click.prevent="resetUI()" class="btn btn-dark close-btn" data-dismiss="modal">CERRAR</button>
              @break
              @case('5')
                <button type="button" wire:click.prevent="resetUI()" class="btn btn-dark close-btn" data-dismiss="modal">CERRAR</button>
              @break
              @case('6')
                <button type="button" wire:click.prevent="resetUI()" class="btn btn-dark close-btn" data-dismiss="modal">CERRAR</button>
              @break
              @case('7')
              <button type="button" wire:click.prevent="resetUI()" class="btn btn-dark close-btn" data-dismiss="modal">CERRAR</button>
              <button type="button" wire:click.prevent="GuardarActualizacion()" wire:loading.attr="disabled" class="btn btn-dark close-modal" >ACTUALIZAR</button>
            @break
            @case('8')
            <button type="button" wire:click.prevent="resetUI()" class="btn btn-dark close-btn" data-dismiss="modal">CERRAR</button>
            <button type="button" wire:click.prevent="Guardar()" wire:loading.attr="disabled" class="btn btn-dark close-modal" >GUARDAR</button>
          @break
            @case('transaction')
                <button type="button" wire:click.prevent="resetUI()" class="btn btn-dark close-btn" data-dismiss="modal">CERRAR</button>
                <button type="button" wire:click.prevent="SaveTransaction()" wire:loading.attr="disabled" class="btn btn-dark close-modal" >GUARDAR MOVIMIENTO</button>
              @break
          @endswitch
 
      </div>
    </div>
  </div>
</div>