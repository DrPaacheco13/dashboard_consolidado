<script>
    // Variables globales
    let page = 1;
    let nextPage = 1;
    let perPage = 10;
    let texto = '';
    let count = 1;
    let preLoadBool = false;
    let loadedResults = [];

    // Función principal que se ejecuta al cargar el documento
    $(document).ready(function() {
        // Asociar el evento 'keydown' a los campos de entrada para la tecla 'Enter'
        $('#patente, #fecha_inicial, #fecha_final').on('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                $('#btn_buscar').click();
            }
        });

        // Cargar datos al inicio
        loadData();
        // preloadNextPages();
    });
    // Función para cargar la siguiente página en segundo plano
    function preloadNextPages() {
        const url = '{{ route('buscar-patente') }}';
        const fechaInicial = $('#fecha_inicial').val();
        const fechaFinal = $('#fecha_final').val();
        texto = $('#patente').val();
        nextPage = (nextPage + 1);
        if (!loadedResults[nextPage]) {
            const nextDataPost = {
                texto,
                page: nextPage,
                fecha_inicial: fechaInicial,
                fecha_final: fechaFinal,
                perPage
            };
            console.log('inicio carga page: ' + nextPage);
            preLoadBool = true;
            loadNewData(url, nextDataPost, true); // El tercer parámetro indica que es una carga en segundo plano
            console.log('fin carga page: ' + nextPage);
        }
    }

    // Función para manejar la carga de datos
    function loadData() {
        $('#preload-spinner').css('display', 'block');
        const csrfToken = $('meta[name="csrf-token"]').attr('content');
        texto = $('#patente').val();
        const fechaInicial = $('#fecha_inicial').val();
        const fechaFinal = $('#fecha_final').val();
        const url = '{{ route('buscar-patente') }}';
        const data_post = {
            texto,
            page,
            fecha_inicial: fechaInicial,
            fecha_final: fechaFinal,
            perPage
        };
        console.log('load data page: ' + page);
        console.log(page);
        console.log(loadedResults);
        if (loadedResults[page]) {
            console.log('-----DATA PRE CARGADA PARA PAGE-----');
            preLoadBool = true;
            loadCachedData();
        } else {
            console.log('-----CARGAR DATA PARA PAGE-----');
            preLoadBool = false;
            loadNewData(url, data_post);
        }
        // Cargar siguiente página en segundo plano
        // preloadNextPages();
    }

    // Función para cargar datos precargados
    function loadCachedData() {
        console.log('load precargada');
        const startIndex = (page - 1) * perPage;
        count = startIndex + 1; // Establecer el contador correctamente
        updateTableData(loadedResults[page]);
        updatePaginationButtons(10);
        $('#preload-spinner').css('display', 'none');
    }

    // Función para cargar nuevos datos
    function loadNewData(url, data_post, backgroundLoad = false) {
        // console.log('load nueva carga');
        GetDataAjax(url, 'post', data_post)
            .then(function(data) {
                // console.log('data');
                count = (page - 1) * perPage + 1;
                if (preLoadBool == true) {
                    loadedResults[nextPage] = data.data;
                } else {
                    console.log(data);
                    console.log(page);
                    loadedResults[page] = data.data;
                }
                if (!backgroundLoad) {
                    updateTableData(loadedResults[page]);
                    updatePaginationButtons(data.data.result.length);
                    $(this).prop('disabled', false);
                }
                if (data.data.result.length == 10 && data_post.page < 10) {
                    preloadNextPages()
                }


                // updatePaginationButtons(data.data.result.length);
            })
            .catch(function(error) {
                console.log(error);
            })
            .always(function() {
                $('#preload-spinner').css('display', 'none');
            });
    }

    // Función para actualizar los botones de paginación
    function updatePaginationButtons(resultLength) {
        const paginationButtons = $('#pagination-buttons');
        paginationButtons.empty();

        if (page > 1) {
            paginationButtons.append('<button class="btn btn-primary" id="prevPage">Anterior</button>');
        }

        paginationButtons.append(`<span class="current-page pr-3 pl-3 pt-2">Página ${page}</span>`);

        if (resultLength >= perPage) {
            paginationButtons.append('<button class="btn btn-primary" id="nextPage">Siguiente</button>');
        }

        $('#prevPage').on('click', function() {
            if (page > 1) {
                page--;
                loadData();
            }
        });

        $('#nextPage').on('click', function() {
            page++;
            $(this).prop('disabled', true);
            // this.attr('disabled');
            loadData();
        });
    }

    // Función para actualizar los datos de la tabla
    function updateTableData(data) {
        // console.log('----INICIO CARGA DE TBODY----');
        const tbody = $('#tbody');
        const fechaInicialInput = $('#fecha_inicial');
        const fechaFinalInput = $('#fecha_final');

        fechaInicialInput.val(ordenarFechaHumano(data.fecha_inicial));
        fechaFinalInput.val(ordenarFechaHumano(data.fecha_final));

        const startIndex = (page - 1) * perPage;



        tbody.html('');
        console.log('----LIMPIEZA TBODY----');

        data.result.forEach(function(item, index) {
            const rowIndex = startIndex + index;
            const row = createOrUpdateRow(rowIndex, item);
            count++;
            tbody.append(row);
        });
        console.log('----CARGA TBODY----');
    }

    // Función para crear o actualizar una fila de la tabla
    function createOrUpdateRow(rowIndex, item) {
        const rowHtml = `
        <tr class="text-center">
            <td>${count}</td>
            <td>${item.patente}</td>
            <td>${item.color}</td>
            <td>${item.tipo}</td>
            <td>${item.date}</td>
            <td>${item.time}</td>
        </tr>
    `;

        return rowHtml;
    }

    // ...

    // Cargar datos al hacer clic en el botón de búsqueda
    $(document).ready(function() {
        $('#btn_buscar').click(function() {
            page = 1;
            count = 1;
            nextPage = 1;
            loadedResults = [];
            loadData();
        });
    });
</script>
