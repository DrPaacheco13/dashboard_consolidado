<script>
    $('#table-resumen').DataTable({
        scrollCollapse: true,
        autoWidth: true,
        responsive: true,
        searching: false,
        bLengthChange: false,
        bPaginate: true,
        columnDefs: [{
            targets: "datatable-nosort",
            orderable: false,
        }],
        order: [
            [0, 'desc']
        ],
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "Todos"]
        ],
        "language": {
            "info": "_START_-_END_ de _TOTAL_ Registros",
            search: "Buscar",
            searchPlaceholder: "Ingrese una o más letras",
            paginate: {
                next: '<i class="fa fa-chevron-right"></i>',
                previous: '<i class="fa fa-chevron-left"></i>'
            },
            "sZeroRecords": "No existen registros a mostrar",
            "sInfoEmpty": "Mostrando 0 al 0 de 0 registros",
            "sInfoFiltered": "(filtrado de _MAX_ registros totales)",
            "sLengthMenu": "Mostrar _MENU_ Registros",
        },
    });
</script>
