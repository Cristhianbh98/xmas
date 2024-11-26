<x-filament-widgets::widget>
    <x-filament::section>
        <span>Suba el archivo para importar los asistentes.</span>
        <form wire:submit.prevent="importCsv" enctype="multipart/form-data">
            <x-filament::input.wrapper style="margin-top:1rem;">
                <x-filament::input
                    type="file"
                    required="required"
                    wire:model="file"
                />
            </x-filament::input.wrapper>
            <x-filament::button 
                color="primary" 
                size="sm" 
                type="submit" 
                style="margin-top:1rem;"
                wire:loading.attr="disabled"
                wire:target="importCsv, file">
                <span wire:loading.remove wire:target="importCsv, file">Importar Datos</span>
                <span wire:loading wire:target="importCsv, file">Cargando...</span>
            </x-filament::button>
        </form>
        @if (session()->has('message'))
            <div class="fi-alert fi-alert-success mt-4">
                {{ session('message') }}
            </div>
        @endif
    </x-filament::section>
</x-filament-widgets::widget>