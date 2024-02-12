<div class="">
    <div class="flex flex-wrap justify-between items-center mb-16" style="text-align: center">
        <div class="w-auto pr-3">
            <label class="font-bold" for="nombre">Nombre</label>
            <input class="appearance-none block  bg-gray-200 border text-gray-700 {{ $errors->has('nombre') ? ' border-red-500' : 'border-gray-200' }} rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white" id="nombre" wire:model="nombre" type="text" placeholder="Nombre completo...">
            @error('nombre')
                <span class="text-red-500 text-xs italic">{{ $message }}</span>
            @enderror
        </div>
        <div class="w-auto pl-3 text-right">
            <div class="pt-5">
                <button wire:click="store()" class="px-3 py-2 bg-purple-200 text-purple-500 hover:bg-purple-500 hover:text-purple-100 rounded">Agregar mall</button>
            </div>
        </div>
    </div>
</div>