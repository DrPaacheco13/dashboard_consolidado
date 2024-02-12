<p>Información reporte</p>
<p>Tipo de informe: Por Segmento</p>
<p>Region de datos: {{ $seleccion }}</p>
<p>Fecha y Hora de Exportacion: {{ $date }}</p>
<p>Usuario: {{ Auth::user()->name }}</p>
<p>Centro Comercial: {{ $nombre_mall }}</p>
<br>

<table>
    <tr>
        <th>Fecha</th>
        <th>Segmento</th>
        <th>Entradas</th>
    </tr>
    @foreach ($datos_segmentados as $key => $value)
        @foreach ($value as $k => $v)
            @if (is_numeric($v))
                <tr>
                    <th>
                        {{ $value->date }}
                    </th>
                    <th>
                        {{ GetSegmentoNumero($k) }}:00
                    </th>
                    <td>
                        {{ is_numeric($v) ? $v : '' }}
                    </td>
                </tr>
            @endif
        @endforeach
    @endforeach
</table>
