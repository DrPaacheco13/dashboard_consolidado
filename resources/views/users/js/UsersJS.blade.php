<script>
    $(document).ready(function() {
        $('#table_users').DataTable({
            scrollCollapse: true,
            autoWidth: true,
            responsive: true,
            searching: false,
            bLengthChange: false,
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
    });

    function EliminarUsuario(usuario_id) {
        let table = $('#table_users').DataTable();
        $('#row_' + usuario_id).addClass('selected_fila');

        if (usuario_id > 0) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: '¿Quieres eliminar este usuario?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    var csrfToken = $('meta[name="csrf-token"]').attr('content');
                    // Usuario hizo clic en "Sí, eliminar"
                    $.ajax({
                        url: '{{ route('users/eliminar') }}',
                        type: "POST",
                        data: {
                            usuario_id: usuario_id,
                            _token: csrfToken,

                        },
                        dataType: 'json',
                        success: function(resp) {
                            console.log(resp);
                            let respuesta = JSON.stringify(resp);
                            let obj = $.parseJSON(respuesta);
                            let tipo = obj['tipo'];
                            let msg = obj['msg'];
                            console.log(tipo);

                            if (tipo == 'success') {
                                // Si se elimina el usuario
                                table.row('.selected_fila').remove().draw(false);
                                toastr["success"](`Usuario Eliminado Correctamente`,
                                    "Mantenedor de Usuario");
                            } else {
                                toastr["error"](`${msg}`, "Error Interno");
                            }
                        },
                        error: function(error) {
                            console.log(JSON.stringify(error));
                        }
                    });
                } else {
                    $('#row_' + usuario_id).removeClass('selected_fila');

                }
            });
        } else {
            toastr["error"](`Ha ocurrido un error al eliminar el Usuario. Recargue e intente nuevamente.`,
                "Error de validación");
            // toastr["error"](`No existe ID de Campo ${id}`, "Error de Validación");
        }
    }
</script>
