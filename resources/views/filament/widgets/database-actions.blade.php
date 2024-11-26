<x-filament-widgets::widget>
    <x-filament::section>
        <span>Escribe <strong>ELIMINAR</strong> para limpiar la base de datos.</span>
        <form wire:submit.prevent="clearDatabase">
            @csrf
            <x-filament::input.wrapper style="margin-top:1rem;">
                <x-filament::input
                    type="text"
                    placeholder="ELIMINAR..."
                    required="required"
                    wire:model="name"
                />
            </x-filament::input.wrapper>
            <x-filament::button 
                color="danger" 
                size="sm" 
                type="submit" 
                style="margin-top:1rem;"
                wire:loading.attr="disabled"
                wire:target="clearDatabase">
                <span wire:loading.remove wire:target="clearDatabase">Limpiar</span>
                <span wire:loading wire:target="clearDatabase">Limpiando...</span>
            </x-filament::button>
        </form>
        @if (session()->has('message'))
            <div class="fi-alert fi-alert-success mt-4">
                {{ session('message') }}
            </div>
        @endif
    </x-filament::section>
</x-filament-widgets::widget>
