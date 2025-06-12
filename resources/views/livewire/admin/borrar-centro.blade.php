<div>
    <flux:modal name="borrar-centro" class="min-w-[22rem]">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">¿Quieres realmente borrarlo?</flux:heading>

                <flux:text class="mt-2">
                    <p>Estás a punto de borrar este centro.</p>
                    <p>Esta acción es irreversible.</p>
                </flux:text>
            </div>

            <div class="flex gap-2">
                <flux:spacer />

                <flux:modal.close>
                    <flux:button variant="ghost">Cancelar</flux:button>
                </flux:modal.close>

                <flux:button wire:click="destroy" type="submit" variant="danger">Borrar centro</flux:button>
            </div>
        </div>
    </flux:modal>
</div>