<script>
    $(document).ready(function() {
        $('#role_id').change(function() {
            let value = (this).value;
            if(value == '3'){
                $('#col_mall').css('display', 'none');
                $('#col_distribucion').css('display', 'block');
            }else{
                $('#col_mall').css('display', 'block');
                $('#col_distribucion').css('display', 'none');
            }
        });
        $('#btn_submit').click(function() {
            $('#formulario').submit();
        });
    });
</script>
