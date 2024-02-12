<div class="w-full" style="text-align: center">
    <div class="flex flex-wrap justify-between items-center mb-16">
        <input type="hidden" wire:model="selected_id">
        <div class="w-auto pr-3">
            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="nombre">Nombre</label>
            <input wire:model="nombre" type="text" class="appearance-none block w-full bg-gray-200 text-gray-700 border {{ $errors->has('nombre') ? ' border-red-500' : 'border-gray-200' }} rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white">
            @error('nombre')
                <span class="text-red-500 text-xs italic">{{ $message }}</span>
            @enderror
        </div>
        <hr>
        <div class="w-auto inline-block text-right">
            <button wire:click="update()" class="px-3 py-2 bg-orange-200 text-orange-500 hover:bg-orange-500 hover:text-orange-100 rounded">Actualizar contacto</button>
        </div>
    </div>
</div>