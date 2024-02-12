<p>Información reporte</p>
<p>Tipo de informe: Por dia</p>
<p>Region de datos: {{ $nombre_acceso }}</p>
<p>Fecha y Hora de Exportacion: {{ $date }}</p>
<p>Usuario: {{ Auth::user()->name }}</p>
<p>Centro Comercial: {{ !empty($namemall) ? $namemall : 'Mall Vivo ' }}</p>
<br>
<table>
    <tr>
        <th>Fecha</th>
        <th>Ubicacion</th>
        <th>Entradas</th>
    </tr>
    @foreach ($datos_segmentados as $item)
        <tr>
            <th>
                {{ $item->date }}
            </th>
            <th>
                {{ !empty($namemall) ? $namemall : '' }}
            </th>
            <td>
                {{ $item->totalenternum }}
            </td>
        </tr>
    @endforeach
</table>
