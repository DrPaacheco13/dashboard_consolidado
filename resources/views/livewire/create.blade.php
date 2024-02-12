<div class="">
    <div class="flex flex-wrap justify-between items-center mb-16" style="text-align: center;">
        <div class="w-auto pr-3">
            <label class="font-bold" for="name">Nombre</label>
            <input class="appearance-none block  bg-gray-200 border text-gray-700 {{ $errors->has('name') ? ' border-red-500' : 'border-gray-200' }} rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white" id="name" wire:model="name" type="text" placeholder="Nombre completo...">
            @error('name')
                <span class="text-red-500 text-xs italic">{{ $message }}</span>
            @enderror
        </div>
        <div class="w-auto px-3">
            <label class="font-bold mb-2" for="email">Email</label>
            <input class="appearance-none block  bg-gray-200 text-gray-700 border {{ $errors->has('name') ? ' border-red-500' : 'border-gray-200' }} rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="email" wire:model="email" type="text" placeholder="Correo electrónico...">
            @error('email')
                <span class="text-red-500 text-xs italic py-1">{{ $message }}</span>
            @enderror
        </div>
        <div class="w-auto px-3">
            <label class="font-bold mb-2" for="id_mall">Id Mall</label>
            <input class="appearance-none block  bg-gray-200 text-gray-700 border {{ $errors->has('name') ? ' border-red-500' : 'border-gray-200' }} rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="id_mall" wire:model="id_mall" type="text" placeholder="Id del Centro Comercial...">
            @error('id_mall')
                <span class="text-red-500 text-xs italic py-1">{{ $message }}</span>
            @enderror
        </div>
        <div class="w-auto px-3">
            <label class="font-bold mb-2" for="password">Contraseña</label>
            <input class="appearance-none block  bg-gray-200 text-gray-700 border {{ $errors->has('name') ? ' border-red-500' : 'border-gray-200' }} rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="password" wire:model="password" type="password" placeholder="Contraseña...">
            @error('password')
                <span class="text-red-500 text-xs italic py-1">{{ $message }}</span>
            @enderror
        </div>
        <div class="w-auto pl-3 text-right">
            <div class="pt-5">
                <button wire:click="store()" class="px-3 py-2 bg-purple-200 text-purple-500 hover:bg-purple-500 hover:text-purple-100 rounded">Agregar usuario</button>
            </div>
        </div>
    </div>
</div>