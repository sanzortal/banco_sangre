<div>
    <flux:modal name="editar-donante" class="md:w-96">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Editar Donante</flux:heading>
                <flux:text class="mt-2">Rellena los campos con los datos personales del donante.</flux:text>
            </div>

            <flux:input wire:model="name" label="Nombre" placeholder="Nombre del donante" type="text" />
            <flux:input wire:model="email" label="Correo electrónico" placeholder="example@example.com" type="email" />
            <flux:input wire:model="tipo_sangre" label="Tipo de sangre"
                placeholder="A+ / A- / B+ / B- / AB+ / AB- / O+ / O-" type="text" />
            <flux:input wire:model="fecha_nacimiento" label="Fecha de nacimiento" type="date" />
            <flux:input wire:model="telefono" label="Teléfono" placeholder="Teléfono" type="text" />
            <flux:input wire:model="direccion" label="Dirección" placeholder="Dirección" type="text" />

            <div class="flex">
                <flux:spacer />
                <flux:button wire:click="update" type="submit" variant="primary">Guardar cambios</flux:button>
            </div>
        </div>
    </flux:modal>
</div>