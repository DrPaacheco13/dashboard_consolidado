<script>
    let mall_id;
    $(document).ready(function() {
        $('#table_malls').DataTable({
            scrollCollapse: true,
            autoWidth: true,
            responsive: false,
            searching: true,
            bLengthChange: true,
            bPaginate: true,
            bInfo: true,
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
        $('.btn_deleted').click(function() {
            mall_id = $(this).attr('id'); // Corregido: $(this).attr('id')
            let nombre_mall = $('#nombre_mall_' + mall_id).val();
            console.log(nombre_mall);
            $('#modal-eliminar').modal('show');
            $('#nombre_mall_eliminar').html(nombre_mall);
        });

    });

    function EliminarMall() {
        let url = '{{ route('malls/eliminar') }}'
        let data = {
            mall_id: mall_id
        };
        let rsp = GetDataAjax(url, 'post', data)
            .then(function(data) {
                console.log(data);
                SweetAlert(data.tipo, data.title, data.msg);
                $('#row_' + mall_id).remove();
                $('#modal-eliminar').modal('hide');
            })
            .catch(function(error) {
                console.log(error);
            });
    }
</script>