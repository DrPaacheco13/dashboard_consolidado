<div>
    <thead>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.css">

        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js"></script>
    </thead>
    @if ($updateMode)
        @include('livewire.update')
    @else
        @include('livewire.create')
    @endif

    <div class="card" style="overflow: scroll; height:250px;">
        <table id="myTable" class="table-auto w-full display" style="text-align: center">
            <thead>
                <tr class="bg-gray-200">
                    <th class="px-4 py-2">#</th>
                    <th class="px-4 py-2">Nombre</th>
                    <th class="px-4 py-2">Email</th>
                    <th class="px-4 py-2">Mall Asignado</th>
                    <th class="px-4 py-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $item)
                    <tr class="text-center">
                        <td class="border px-4 py-2">
                            {{ $loop->iteration }}
                        </td>
                        <td class="border px-4 py-2">{{ $item->name }}</td>
                        <td class="border px-4 py-2">{{ $item->email }}</td>
                        <td class="border px-4 py-2">{{ $item->nombre }}</td>
                        <td class="border px-4 py-2">
                            <button wire:click="edit({{ $item->id }})"
                                class="px-2 py-1 bg-blue-200 text-blue-500 hover:bg-blue-500 hover:text-white rounded">Editar</button>
                            <button wire:click="destroy({{ $item->id }})"
                                class="px-2 py-1 bg-red-200 text-red-500 hover:bg-red-500 hover:text-white rounded">Borrar</button>
                        </td>
                    </tr>
                @empty
                    <tr class="text-center">
                        <td colspan="4" class="py-3 italic">No hay información</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <hr style="margin-top: 10px; margin-bottom: 10px;">

    <div class="card">
        <table class="table-auto w-full" style="text-align: center;">
            <thead>
                <tr class="bg-gray-200">
                    <th class="px-4 py-2">#</th>
                    <th class="px-4 py-2">Nombre Mall</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($mall as $item)
                    <tr class="text-center">
                        <td class="border px-4 py-2">
                            {{ $item->id }}
                        </td>
                        <td class="border px-4 py-2">{{ $item->nombre }}</td>
                    </tr>
                @empty
                    <tr class="text-center">
                        <td colspan="4" class="py-3 italic">No hay información</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();
        });
    </script>

&nbsp;
</div>
