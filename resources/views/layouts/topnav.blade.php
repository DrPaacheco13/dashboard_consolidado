@if (empty($no_top))
    <div class="row">
        <div class="col-1"></div>
        <div class="col-10">
            <div class="callout callout-info mt-3">
                <h2 class="mb-0" style="text-align: center;">
                    {{ isset($seccion_flujo) ? strUpper($seccion_flujo) : 'FLUJO DE CLIENTES' }}
                    {{ !empty($nombre_mall) ? ' - '. strUpper($nombre_mall) : '' }}{{ !empty($acceso_mall) ? ' - '. strUpper($acceso_mall) : '' }}
                </h2>
                <h5 style="text-align: center;">
                    {{-- {{ !empty($yesterday_text) ? $yesterday_text : '' }} --}}
                </h5>
            </div>

        </div>
    </div>
    <hr>
@else
    <br>
    <br>
@endif
