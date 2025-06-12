<div>
    <flux:modal name="nuevo-centro" class="md:w-96">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Crear un nuevo Centro</flux:heading>
                <flux:text class="mt-2">Rellena los campos con los datos personales del centro.</flux:text>
            </div>

            <flux:input wire:model="name" label="Nombre" placeholder="Nombre del centro" type="text" />
            <flux:input wire:model="email" label="Correo electrónico" placeholder="example@example.com" type="email" />
            <flux:input wire:model="telefono" label="Teléfono" placeholder="Teléfono" type="text" />
            <flux:input wire:model="direccion" label="Dirección" placeholder="Dirección" type="text" />
            <flux:input wire:model="latitud" label="Latitud" type="number" />
            <flux:input wire:model="longitud" label="Longitud" type="number" />
            <div class="flex">
                <flux:spacer />
                <flux:button wire:click="store" type="submit" variant="primary">Registrar</flux:button>
            </div>
        </div>
    </flux:modal>
</div>