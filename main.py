# from flask import Flask, jsonify, request

# app = Flask(__name__)

from flask import Flask, jsonify, request
import mysql.connector
from datetime import datetime, timedelta
import sys

app = Flask(__name__)
# mysql = MySQL()

# Configura la conexión a la base de datos MySQL
# app.config['MYSQL_DATABASE_HOST'] = '64.207.184.16'
# app.config['MYSQL_DATABASE_USER'] = 'dmtech'
# app.config['MYSQL_DATABASE_PASSWORD'] = 'X+3w@9fQ2u6u'
# app.config['MYSQL_DATABASE_DB'] = 'DMTECH_PRUEBADOM'

# mysql.connector.connect(app)
credenciales_por_mall = {
    1: {'host': '186.10.7.214', 'user': 'sanfernando', 'password': 'o0p6HJ7Hp#5LIPK*iA', 'database': 'data_sanfernando'},
    2: {'host': '186.10.7.214', 'user': 'coquimbo', 'password': '#4fJ9jEuqQ1@%t1r6Z', 'database': 'data_coquimbo'},
    3: {'host': '186.10.7.214', 'user': 'trapenses', 'password': 'gCyhw3U038I*IOWxhsS', 'database': 'data_trapenses'},
    4: {'host': '186.10.7.214', 'user': 'panoramico', 'password': '#Dc7&Rvmy$bpx04A6U', 'database': 'data_panoramico'},
    5: {'host': '186.10.7.214', 'user': 'antofagasta', 'password': 'C#3t8JrQW7r3!AGt$5', 'database': 'data_euantofagasta'},
    6: {'host': '186.10.7.214', 'user': 'puntarenas', 'password': '!@9E5P8l25t2OQy*gV', 'database': 'data_eupuntarenas'},
    7: {'host': '186.10.7.214', 'user': 'eulalaguna', 'password': 'l9O"4zrG2Oo7U-vg*I', 'database': 'data_eulalaguna'},
    8: {'host': '186.10.7.214', 'user': 'granavenida', 'password': '9_uB<6]TjP_hWl24d4', 'database': 'data_granavenida'},
    9: {'host': '186.10.7.214', 'user': 'puentealto', 'password': 'ZPS8+x]Lu8D?W>8(7F', 'database': 'data_puentealto'},
}


def conectar_a_base_de_datos(mall_id):
    # credenciales = credenciales_por_mall['mall_id']
    credenciales = credenciales_por_mall[mall_id]

    if not credenciales:
        raise Exception(
            f"No se encontraron credenciales para el mall_id: {mall_id}")
    # credenciales = credenciales_por_mall[mall_id]
    conexion = mysql.connector.connect(
        host=credenciales["host"],
        user=credenciales["user"],
        password=credenciales["password"],
        database=credenciales["database"]
    )
    return conexion


def conectar_a_base_de_datos_local():
    # credenciales = credenciales_por_mall['mall_id']
    # credenciales = credenciales_por_mall[mall_id]

    # if not credenciales:
    #     raise Exception(f"No se encontraron credenciales para el mall_id: {mall_id}")
    # credenciales = credenciales_por_mall[mall_id]
    conexion = mysql.connector.connect(
        host='localhost',
        user='root',
        # user='dev',
        password='',
        # password='86929008',
        database='laraveldb'
    )
    return conexion


def ejecutar_consulta(query, data=None, mall_id=None, local=None, conexion = None):
    
    try:
        if conexion is None:
            if local is not None:
                conexion = conectar_a_base_de_datos_local()
            else:
                conexion = conectar_a_base_de_datos(mall_id)
        
        if conexion:
            try:
                with conexion.cursor(dictionary=True) as cursor:
                    if data is not None:
                        cursor.execute(query, data)
                    else:
                        cursor.execute(query)

                    resultados = cursor.fetchall()
            except Exception as e:
                return str(e)
            return resultados
    except Exception as e:
        return str(e)
    finally:
        if conexion:
            conexion.close()

# @app.route('/api/getAforoHoyR1', methods=['GET'])


def get_aforo_hoy_r1(mall_id):
    query = "SELECT totalenternum as Entradas FROM total_personas_dia WHERE id = 1"
    data = ejecutar_consulta(query, mall_id=mall_id)
    return data if data else []

# @app.route('/api/getAforoHoyR2', methods=['GET'])


def get_aforo_hoy_r2(mall_id):
    query = "SELECT totalenternum as Entradas FROM total_personas_dia WHERE id = 2"
    data = ejecutar_consulta(query, mall_id=mall_id)
    return data if data else []

# @app.route('/api/getAforoHoyR3', methods=['GET'])


def get_aforo_hoy_r3(mall_id):
    query = "SELECT totalenternum as Entradas FROM total_personas_dia WHERE id = 3"
    data = ejecutar_consulta(query, mall_id=mall_id)
    return data if data else []

# @app.route('/api/getAforoHoyR0', methods=['GET'])


def get_aforo_hoy_r0(mall_id):
    query = "SELECT totalenternum as Entradas FROM total_personas_dia WHERE id = 4"
    data = ejecutar_consulta(query, mall_id=mall_id)
    return data if data else []

# @app.route('/api/getAforoAyerR1', methods=['GET'])


def get_aforo_ayer_r1(mall_id):
    query = "SELECT totalenternum FROM personas_dia_ant_r1"
    data = ejecutar_consulta(query, mall_id=mall_id)
    return data if data else []

# @app.route('/api/getPersonasSegmentoAyerR1', methods=['GET'])


def get_personas_segmento_ayer_r1(mall_id):
    query = "SELECT totalenternum as Entradas, aforo, segmento FROM personas_segmento_dia_ant_r1"
    print(query)
    exit
    data = ejecutar_consulta(query, mall_id=mall_id)
    return data if data else []


# @app.route('/api/getPersonasSegmentoHoyR1', methods=['GET'])
def get_personas_segmento_hoy_r1(mall_id):
    query = "SELECT totalenternum as Entrada, aforo as Aforo, segmento FROM personas_segmento_dia_r1"
    data = ejecutar_consulta(query, mall_id=mall_id)
    return data if data else []

# @app.route('/api/getAforoAyerR2', methods=['GET'])


def get_aforo_ayer_r2(mall_id):
    query = "SELECT totalenternum FROM personas_dia_ant_r2"
    data = ejecutar_consulta(query, mall_id=mall_id)
    return data if data else []

# @app.route('/api/getPersonasSegmentoAyerR2', methods=['GET'])


def get_personas_segmento_ayer_r2(mall_id):
    query = "SELECT totalenternum as Entradas, aforo, segmento FROM personas_segmento_dia_ant_r2"
    data = ejecutar_consulta(query, mall_id=mall_id)
    return data if data else []

# @app.route('/api/getPersonasSegmentoHoyR2', methods=['GET'])


def get_personas_segmento_hoy_r2(mall_id):
    query = "SELECT totalenternum as Entrada, aforo as Aforo, segmento FROM personas_segmento_dia_r2"
    data = ejecutar_consulta(query, mall_id=mall_id)
    return data if data else []

# @app.route('/api/getAforoAyerR3', methods=['GET'])


def get_aforo_ayer_r3(mall_id):
    query = "SELECT totalenternum FROM personas_dia_ant_r3"
    data = ejecutar_consulta(query, mall_id=mall_id)
    return data if data else []

# @app.route('/api/getPersonasSegmentoAyerR3', methods=['GET'])


def get_personas_segmento_ayer_r3(mall_id):
    query = "SELECT totalenternum as Entradas, aforo, segmento FROM personas_segmento_dia_ant_r3"
    data = ejecutar_consulta(query, mall_id=mall_id)
    return data if data else []

# @app.route('/api/getPersonasSegmentoHoyR3', methods=['GET'])


def get_personas_segmento_hoy_r3(mall_id):
    query = "SELECT totalenternum as Entrada, aforo as Aforo, segmento FROM personas_segmento_dia_r3"
    data = ejecutar_consulta(query, mall_id=mall_id)
    return data if data else []


# @app.route('/api/getAforoAyerR0', methods=['GET'])
def get_aforo_ayer_r0(mall_id):
    query = "SELECT totalenternum FROM personas_dia_ant_r0"
    data = ejecutar_consulta(query, mall_id=mall_id)
    return data if data else []

# @app.route('/api/getPersonasSegmentoAyerR0', methods=['GET'])


def get_personas_segmento_ayer_r0(mall_id):
    query = "SELECT totalenternum as Entradas, aforo, segmento FROM personas_segmento_dia_ant_r0"
    data = ejecutar_consulta(query, mall_id=mall_id)
    return data if data else []

# @app.route('/api/getPersonasSegmentoHoyR0', methods=['GET'])


def get_personas_segmento_hoy_r0(mall_id):
    query = "SELECT totalenternum as Entrada, aforo as Aforo, segmento FROM personas_segmento_dia_r0"
    data = ejecutar_consulta(query, mall_id=mall_id)
    return data if data else []


def get_personas_segmento_hoy_tendencia(mall_id):
    query = "SELECT totalenter as Entrada, segmento FROM vehiculos_segmento_personas_dia"
    data = ejecutar_consulta(query, mall_id=mall_id)
    return data if data else []


def get_personas_segmento_hoy_vehicle(mall_id):
    query = "SELECT totalenter as Entrada, segmento, totalexit FROM vehiculos_segmento_dia"
    data = ejecutar_consulta(query, mall_id=mall_id)
    return data if data else []

# @app.route('/api/timeActualizacion', methods=['GET'])


def time_actualizacion(mall_id):
    query = "SELECT TIME_FORMAT(timeupdate, '%H:%i') as tiempo FROM dashboard_process WHERE id = 1"
    data = ejecutar_consulta(query, mall_id=mall_id)
    return data if data else []

# @app.route('/api/getEntradasCamaraAyerR1', methods=['GET'])


def get_entradas_camara_ayer_r1(mall_id):
    query = "SELECT cameraindexcode as camara, totalenternum as tEntrada, nombre, date FROM entradas_camara_dia_ant_r1 ORDER BY totalenternum DESC"
    data = ejecutar_consulta(query, mall_id=mall_id)
    return data if data else []


# @app.route('/api/getDatosAnualesR1', methods=['GET'])
def get_datos_anuales_r1(mall_id):

    fecha_actual = datetime.now()
    # Calcular la fecha hace 12 meses

    # Consulta SQL
    query = """
        SELECT id, totalentradas as tEntradas,
            CONCAT(mes) as mes
        FROM total_personas_mes_r1
        WHERE year >= %s
    """

    data = ejecutar_consulta(
        query, (fecha_actual.year, ), mall_id)
    return data if data else []
def get_datos_anuales_ant_r1(mall_id):
    fecha_actual = datetime.now()
    # Calcular la fecha de enero del año pasado
    fecha_hace_12_meses = fecha_actual - timedelta(days=365)
    # Modificar la consulta SQL para obtener datos desde enero del año pasado hasta el mes actual del año pasado
    query = """
        SELECT id, totalentradas as tEntradas,
        CASE
            WHEN mes = 'diciembre' THEN 'Diciembre'
            ELSE mes
        END as mes
        FROM total_personas_mes_r1
        WHERE year = %s
    """

    data = ejecutar_consulta(query, (fecha_hace_12_meses.year,), mall_id)
    return data if data else []

# @app.route('/api/getDatosMensualesR1', methods=['GET'])


def get_datos_mensuales_r1(mall_id):
    atributo_especial = 'totalenternum' if mall_id not in [5, 6, 26, 27, 30] else 'totalenter'

    query = "SELECT " + atributo_especial + " as tEntrada, " \
            "DATE_FORMAT(date, '%d-%m') as date " \
            "FROM datos_estadisticos_dia_r1  " \
            "WHERE MONTH(date) = MONTH(CURDATE()) " \
            "AND YEAR(date) = YEAR(CURDATE()) " \
            "ORDER BY date ASC"
    data = ejecutar_consulta(query, mall_id=mall_id)
    return data if data else []

from datetime import datetime, timedelta

def get_datos_mensuales_ant_r1(mall_id):
    atributo_especial = 'totalenternum' if mall_id not in [5, 6, 27, 30] else 'totalenter'
    fecha_actual = datetime.now()

    fecha_hace_12_meses = fecha_actual - timedelta(days=365)
    
    query = """
            SELECT {0} as tEntrada,
            DATE_FORMAT(date, '%d-%m') as date
            FROM datos_estadisticos_dia_r1
            WHERE MONTH(date) = MONTH(CURDATE())
            AND DAY(date) < DAY(CURDATE()) 
            AND YEAR(date) = %s 
            ORDER BY date ASC
            """.format(atributo_especial)
    print("####################################")
    print(query)
    print("####################################")
    data = ejecutar_consulta(query, (fecha_hace_12_meses.year,), mall_id=mall_id)
    return data if data else []


# @app.route('/api/comparativoMesActualR1', methods=['GET'])


def comparativo_mes_actual_r1(mall_id):
    atributo_especial = 'totalenternum' if mall_id not in [
        5, 6, 27, 30] else 'totalenter'
    query = "SELECT " + atributo_especial + " as entrada, " \
            "CASE " \
            "WHEN DAYNAME(date) = 'Monday' THEN 'Lunes' " \
            "WHEN DAYNAME(date) = 'Tuesday' THEN 'Martes' " \
            "WHEN DAYNAME(date) = 'Wednesday' THEN 'Miercoles' " \
            "WHEN DAYNAME(date) = 'Thursday' THEN 'Jueves' " \
            "WHEN DAYNAME(date) = 'Friday' THEN 'Viernes' " \
            "WHEN DAYNAME(date) = 'Saturday' THEN 'Sabado' " \
            "WHEN DAYNAME(date) = 'Sunday' THEN 'Domingo' " \
            "END as dia, DATE_FORMAT(date, '%d/%m/%Y') as date " \
            "FROM datos_estadisticos_dia_r1 " \
            "WHERE MONTH(date) = MONTH(CURDATE()) AND YEAR(date) = YEAR(CURDATE())"
    data = ejecutar_consulta(query, mall_id=mall_id)
    return data if data else []

# @app.route('/api/comparativoMesAnteriorR1', methods=['GET'])


def comparativo_mes_anterior_r1(mall_id):
    atributo_especial = 'totalenternum' if mall_id not in [5, 6, 27, 30] else 'totalenter'

    # Obtener la fecha del mes anterior
    fecha_mes_anterior = datetime.now() - timedelta(days=datetime.now().day)
    
    query = "SELECT " + atributo_especial + " as entrada, " \
            "CASE " \
            "WHEN DAYNAME(date) = 'Monday' THEN 'Lunes' " \
            "WHEN DAYNAME(date) = 'Tuesday' THEN 'Martes' " \
            "WHEN DAYNAME(date) = 'Wednesday' THEN 'Miercoles' " \
            "WHEN DAYNAME(date) = 'Thursday' THEN 'Jueves' " \
            "WHEN DAYNAME(date) = 'Friday' THEN 'Viernes' " \
            "WHEN DAYNAME(date) = 'Saturday' THEN 'Sabado' " \
            "WHEN DAYNAME(date) = 'Sunday' THEN 'Domingo' " \
            "END as dia, DATE_FORMAT(date, '%d/%m/%Y') as date " \
            "FROM datos_estadisticos_dia_r1 " \
            f"WHERE MONTH(date) = {fecha_mes_anterior.month} AND YEAR(date) = {fecha_mes_anterior.year}"
    
    data = ejecutar_consulta(query, mall_id=mall_id)
    return data if data else []

def get_entradas_camara_ayer_r0(mall_id):
    query = "SELECT cameraindexcode as camara, totalenternum as tEntrada, nombre, date FROM entradas_camara_dia_ant_r0 ORDER BY totalenternum DESC"
    data = ejecutar_consulta(query, mall_id=mall_id)
    return data if data else []


def get_datos_anuales_r0(mall_id):

    query = """
        SELECT id, totalentradas as tEntradas,
        CONCAT(mes) as mes
        FROM total_personas_mes_r0
        WHERE year = YEAR(CURDATE())
        """
    data = ejecutar_consulta(
        query, mall_id=mall_id)
    return data if data else []

def get_datos_anuales_ant_r0(mall_id):

    fecha_actual = datetime.now()
    fecha_hace_12_meses = fecha_actual - timedelta(days=365)
    query = """
        SELECT id, totalentradas as tEntrada,
        CASE
            WHEN mes = 'diciembre' THEN 'Diciembre'
            ELSE mes
        END as mes
        FROM total_personas_mes_r0
        WHERE year = %s
        """
    data = ejecutar_consulta(
        query, (fecha_hace_12_meses.year,) ,mall_id=mall_id)
    return data if data else []


def get_datos_mensuales_r0(mall_id):
    atributo_especial = 'totalenternum' if mall_id not in [
        5, 6, 27, 30] else 'totalenter'
    query = """
            SELECT {0} as tEntrada, 
            DATE_FORMAT(date, '%d-%m') as date 
            FROM datos_estadisticos_dia_r0 
            WHERE MONTH(date) = MONTH(CURDATE()) 
            AND YEAR(date) = YEAR(CURDATE()) 
            ORDER BY date ASC
        """.format(atributo_especial)
    
    data = ejecutar_consulta(query, mall_id=mall_id)
    return data if data else []

def get_datos_mensuales_ant_r0(mall_id):
    atributo_especial = 'totalenternum' if mall_id not in [5, 6, 27, 30] else 'totalenter'
    fecha_actual = datetime.now()

    fecha_hace_12_meses = fecha_actual - timedelta(days=365)
    query = """
            SELECT {0} as tEntrada, 
            DATE_FORMAT(date, '%d-%m') as date 
            FROM datos_estadisticos_dia_r0 
            WHERE MONTH(date) = MONTH(CURDATE()) 
            AND DAY(date) < DAY(CURDATE()) 
            AND YEAR(date) = %s
            ORDER BY date ASC
        """.format(atributo_especial)
    
    data = ejecutar_consulta(query, (fecha_hace_12_meses.year,), mall_id=mall_id)
    return data if data else []



def comparativo_mes_actual_r0(mall_id):
    atributo_especial = 'totalenternum' if mall_id not in [
        5, 6, 27, 30] else 'totalenter'

    query = "SELECT " + atributo_especial + " as entrada, " \
            "CASE " \
            "WHEN DAYNAME(date) = 'Monday' THEN 'Lunes' " \
            "WHEN DAYNAME(date) = 'Tuesday' THEN 'Martes' " \
            "WHEN DAYNAME(date) = 'Wednesday' THEN 'Miercoles' " \
            "WHEN DAYNAME(date) = 'Thursday' THEN 'Jueves' " \
            "WHEN DAYNAME(date) = 'Friday' THEN 'Viernes' " \
            "WHEN DAYNAME(date) = 'Saturday' THEN 'Sabado' " \
            "WHEN DAYNAME(date) = 'Sunday' THEN 'Domingo' " \
            "END as dia, DATE_FORMAT(date, '%d/%m/%Y') as date " \
            "FROM datos_estadisticos_dia_r0 " \
            "WHERE MONTH(date) = MONTH(CURDATE()) AND YEAR(date) = YEAR(CURDATE())"
    data = ejecutar_consulta(query, mall_id=mall_id)
    return data if data else []


def comparativo_mes_anterior_r0(mall_id):
    atributo_especial = 'totalenternum' if mall_id not in [
        5, 6, 27, 30] else 'totalenter'
    fecha_mes_anterior = datetime.now() - timedelta(days=datetime.now().day)

    query = "SELECT " + atributo_especial + " as entrada, " \
            "CASE " \
            "WHEN DAYNAME(date) = 'Monday' THEN 'Lunes' " \
            "WHEN DAYNAME(date) = 'Tuesday' THEN 'Martes' " \
            "WHEN DAYNAME(date) = 'Wednesday' THEN 'Miercoles' " \
            "WHEN DAYNAME(date) = 'Thursday' THEN 'Jueves' " \
            "WHEN DAYNAME(date) = 'Friday' THEN 'Viernes' " \
            "WHEN DAYNAME(date) = 'Saturday' THEN 'Sabado' " \
            "WHEN DAYNAME(date) = 'Sunday' THEN 'Domingo' " \
            "END as dia, DATE_FORMAT(date, '%d/%m/%Y') as date " \
            "FROM datos_estadisticos_dia_r0 " \
            f"WHERE MONTH(date) = {fecha_mes_anterior.month} AND YEAR(date) = {fecha_mes_anterior.year}"
    data = ejecutar_consulta(query, mall_id=mall_id)
    return data if data else []


def get_entradas_camara_ayer_r2(mall_id):
    query = "SELECT cameraindexcode as camara, totalenternum as tEntrada, nombre, date FROM entradas_camara_dia_ant_r2 ORDER BY totalenternum DESC"
    data = ejecutar_consulta(query, mall_id=mall_id)
    return data if data else []
def get_entradas_camara_hoy_r2(mall_id):
    query = "SELECT cameraindexcode as camara, totalenternum as tEntrada, nombre, date FROM entradas_camara_dia_r2 ORDER BY totalenternum DESC"
    data = ejecutar_consulta(query, mall_id=mall_id)
    return data if data else []


def get_datos_anuales_r2(mall_id):
    query = """
        SELECT id, totalentradas as tEntradas,
        CONCAT(mes) as mes
        FROM total_personas_mes_r2
        WHERE year = year(curdate())
        """
    data = ejecutar_consulta(
        query, mall_id=mall_id)
    return data if data else []

def get_datos_anuales_ant_r2(mall_id):
    fecha_actual = datetime.now()
    fecha_hace_12_meses = fecha_actual - timedelta(days=365)
    query = """
        SELECT id, totalentradas as tEntradas,
        CASE
            WHEN mes = 'October' THEN 'Octubre'
            WHEN mes = 'September' THEN 'Septiembre'
            ELSE mes
        END as mes
        FROM total_personas_mes_r2
        WHERE year = %s
        """
    data = ejecutar_consulta(
        query, (fecha_hace_12_meses.year, ), mall_id=mall_id)
    return data if data else []


def get_datos_mensuales_r2(mall_id):
    atributo_especial = 'totalenternum' if mall_id not in [
        5, 6, 27, 30] else 'totalenter'
    query = """
            SELECT {0} as tEntrada, 
            DATE_FORMAT(date, '%d-%m') as date 
            FROM datos_estadisticos_dia_r2 
            WHERE MONTH(date) = MONTH(CURDATE()) 
            AND YEAR(date) = YEAR(CURDATE()) 
            ORDER BY date ASC
            """.format(atributo_especial)
    data = ejecutar_consulta(query, mall_id=mall_id)
    return data if data else []
def get_datos_mensuales_ant_r2(mall_id):
    atributo_especial = 'totalenternum' if mall_id not in [
        5, 6, 27, 30] else 'totalenter'
    fecha_actual = datetime.now()
    fecha_hace_12_meses = fecha_actual - timedelta(days=365)
    query = """
            SELECT {0} as tEntrada, 
            DATE_FORMAT(date, '%d-%m') as date 
            FROM datos_estadisticos_dia_r2 
            WHERE MONTH(date) = MONTH(CURDATE()) 
            AND DAY(date) < DAY(CURDATE()) 
            AND YEAR(date) = %s 
            ORDER BY date ASC
            """.format(atributo_especial)
    
    data = ejecutar_consulta(query, (fecha_hace_12_meses.year, ), mall_id=mall_id)
    return data if data else []


def comparativo_mes_actual_r2(mall_id):
    atributo_especial = 'totalenternum' if mall_id not in [
        5, 6, 27, 30] else 'totalenter'
    query = "SELECT " + atributo_especial + " as entrada, " \
            "CASE " \
            "WHEN DAYNAME(date) = 'Monday' THEN 'Lunes' " \
            "WHEN DAYNAME(date) = 'Tuesday' THEN 'Martes' " \
            "WHEN DAYNAME(date) = 'Wednesday' THEN 'Miercoles' " \
            "WHEN DAYNAME(date) = 'Thursday' THEN 'Jueves' " \
            "WHEN DAYNAME(date) = 'Friday' THEN 'Viernes' " \
            "WHEN DAYNAME(date) = 'Saturday' THEN 'Sabado' " \
            "WHEN DAYNAME(date) = 'Sunday' THEN 'Domingo' " \
            "END as dia, DATE_FORMAT(date, '%d/%m/%Y') as date " \
            "FROM datos_estadisticos_dia_r2 " \
            "WHERE MONTH(date) = MONTH(CURDATE()) AND YEAR(date) = YEAR(CURDATE())"
    data = ejecutar_consulta(query, mall_id=mall_id)
    return data if data else []


def comparativo_mes_anterior_r2(mall_id):
    atributo_especial = 'totalenternum' if mall_id not in [
        5, 6, 27, 30] else 'totalenter'
    fecha_mes_anterior = datetime.now() - timedelta(days=datetime.now().day)
    
    query = "SELECT " + atributo_especial + " as entrada, " \
            "CASE " \
            "WHEN DAYNAME(date) = 'Monday' THEN 'Lunes' " \
            "WHEN DAYNAME(date) = 'Tuesday' THEN 'Martes' " \
            "WHEN DAYNAME(date) = 'Wednesday' THEN 'Miercoles' " \
            "WHEN DAYNAME(date) = 'Thursday' THEN 'Jueves' " \
            "WHEN DAYNAME(date) = 'Friday' THEN 'Viernes' " \
            "WHEN DAYNAME(date) = 'Saturday' THEN 'Sabado' " \
            "WHEN DAYNAME(date) = 'Sunday' THEN 'Domingo' " \
            "END as dia, DATE_FORMAT(date, '%d/%m/%Y') as date " \
            "FROM datos_estadisticos_dia_r2 " \
            f"WHERE MONTH(date) = {fecha_mes_anterior.month} AND YEAR(date) = {fecha_mes_anterior.year}"
    data = ejecutar_consulta(query, mall_id=mall_id)
    return data if data else []


def get_entradas_camara_ayer_r3(mall_id):
    query = "SELECT cameraindexcode as camara, totalenternum as tEntrada, nombre, date FROM entradas_camara_dia_ant_r3 ORDER BY totalenternum DESC"
    data = ejecutar_consulta(query, mall_id=mall_id)
    return data if data else []


def get_datos_anuales_r3(mall_id):

    query = """
        SELECT id, totalentradas as tEntradas,
            CONCAT(mes) as mes
        FROM total_personas_mes_r3
        WHERE year = year(curdate())
    """
    data = ejecutar_consulta(
        query, mall_id=mall_id)
    return data if data else []

def get_datos_anuales_ant_r3(mall_id):

    fecha_actual = datetime.now()
    fecha_hace_12_meses = fecha_actual - timedelta(days=365)
    query = """
        SELECT id, totalentradas as tEntrada,
            CONCAT(mes) as mes
        FROM total_personas_mes_r3
        WHERE year = %s
    """
    data = ejecutar_consulta(
        query, (fecha_hace_12_meses.year,), mall_id=mall_id)
    return data if data else []


def get_datos_mensuales_r3(mall_id):
    atributo_especial = 'totalenternum' if mall_id not in [
        5, 6, 27, 30] else 'totalenter'
    query = """
            SELECT {0} as tEntrada, 
            DATE_FORMAT(date, '%d-%m') as date 
            FROM datos_estadisticos_dia_r3 
            WHERE MONTH(date) = MONTH(CURDATE()) 
            AND YEAR(date) = YEAR(CURDATE()) 
            ORDER BY date ASC
            """.format(atributo_especial)
    data = ejecutar_consulta(query, mall_id=mall_id)
    return data if data else []
def get_datos_mensuales_ant_r3(mall_id):
    atributo_especial = 'totalenternum' if mall_id not in [
        5, 6, 27, 30] else 'totalenter'
    fecha_actual = datetime.now()
    fecha_hace_12_meses = fecha_actual - timedelta(days=365)
    query = """
            SELECT {0} as tEntrada, 
            DATE_FORMAT(date, '%d-%m') as date 
            FROM datos_estadisticos_dia_r3 
            WHERE MONTH(date) = MONTH(CURDATE()) 
            AND DAY(date) < DAY(CURDATE()) 
            AND YEAR(date) = %s
            ORDER BY date ASC
            """.format(atributo_especial)
    data = ejecutar_consulta(query, (fecha_hace_12_meses.year,), mall_id=mall_id)
    return data if data else []


def comparativo_mes_actual_r3(mall_id):
    atributo_especial = 'totalenternum' if mall_id not in [
        5, 6, 27, 30] else 'totalenter'
    query = "SELECT " + atributo_especial + " as entrada, " \
            "CASE " \
            "WHEN DAYNAME(date) = 'Monday' THEN 'Lunes' " \
            "WHEN DAYNAME(date) = 'Tuesday' THEN 'Martes' " \
            "WHEN DAYNAME(date) = 'Wednesday' THEN 'Miercoles' " \
            "WHEN DAYNAME(date) = 'Thursday' THEN 'Jueves' " \
            "WHEN DAYNAME(date) = 'Friday' THEN 'Viernes' " \
            "WHEN DAYNAME(date) = 'Saturday' THEN 'Sabado' " \
            "WHEN DAYNAME(date) = 'Sunday' THEN 'Domingo' " \
            "END as dia, DATE_FORMAT(date, '%d/%m/%Y') as date " \
            "FROM datos_estadisticos_dia_r3 " \
            "WHERE MONTH(date) = MONTH(CURDATE()) AND YEAR(date) = YEAR(CURDATE())"
    data = ejecutar_consulta(query, mall_id=mall_id)
    return data if data else []


def comparativo_mes_anterior_r3(mall_id):
    atributo_especial = 'totalenternum' if mall_id not in [
        5, 6, 27, 30] else 'totalenter'
    
    fecha_mes_anterior = datetime.now() - timedelta(days=datetime.now().day)

    query = "SELECT " + atributo_especial + " as entrada, " \
            "CASE " \
            "WHEN DAYNAME(date) = 'Monday' THEN 'Lunes' " \
            "WHEN DAYNAME(date) = 'Tuesday' THEN 'Martes' " \
            "WHEN DAYNAME(date) = 'Wednesday' THEN 'Miercoles' " \
            "WHEN DAYNAME(date) = 'Thursday' THEN 'Jueves' " \
            "WHEN DAYNAME(date) = 'Friday' THEN 'Viernes' " \
            "WHEN DAYNAME(date) = 'Saturday' THEN 'Sabado' " \
            "WHEN DAYNAME(date) = 'Sunday' THEN 'Domingo' " \
            "END as dia, DATE_FORMAT(date, '%d/%m/%Y') as date " \
            "FROM datos_estadisticos_dia_r3 " \
            f"WHERE MONTH(date) = {fecha_mes_anterior.month} AND YEAR(date) = {fecha_mes_anterior.year}"
    data = ejecutar_consulta(query, mall_id=mall_id)
    return data if data else []


def get_aforo_hoy_tendencia(mall_id):
    query = "SELECT totalenter as Entradas FROM vehiculos_personas_dia WHERE id = 1"
    data = ejecutar_consulta(query, mall_id=mall_id)
    return data if data else []


def get_aforo_hoy_vehicle(mall_id):
    query = "SELECT totalexit, totalenter, TIME_FORMAT(estadia, '%H:%i:%s') AS estadia FROM vehiculos_total_dia"
    data = ejecutar_consulta(query, mall_id=mall_id)
    return data if data else []


def get_aforo_hoy_grafico_tendencia(mall_id):
    query = "SELECT totalenter as Entrada, segmento FROM vehiculos_segmento_personas_dia"
    data = ejecutar_consulta(query, mall_id=mall_id)
    return data if data else []


def get_aforo_ayer_tendencia(mall_id):
    query = "SELECT totalenter FROM vehiculos_personas_dia_ant WHERE id = 1"
    data = ejecutar_consulta(query, mall_id=mall_id)
    return data if data else []


def get_aforo_ayer_grafico_tendencia(mall_id):
    query = "SELECT totalenter as Entrada, segmento FROM vehiculos_segmento_personas_dia_ant"
    data = ejecutar_consulta(query, mall_id=mall_id)
    return data if data else []

# FUNCIONES DE GET DATOS VEHICULOS


def get_aforo_hoy_grafico_vehiculos(mall_id):
    query = "SELECT totalenter as Entrada, segmento FROM vehiculos_segmento_dia"
    data = ejecutar_consulta(query, mall_id=mall_id)
    return data if data else []


def get_aforo_ayer_vehiculos(mall_id):
    query = "SELECT totalenter FROM vehiculos_detalle_mes order by id desc limit 1"
    data = ejecutar_consulta(query, mall_id=mall_id)
    return data if data else []


def get_aforo_ayer_grafico_vehiculos(mall_id):
    query = "SELECT totalenter as Entrada, segmento FROM vehiculos_segmento_dia_ant"
    data = ejecutar_consulta(query, mall_id=mall_id)
    return data if data else []


def get_camara_sector_anterior_vehiculos(mall_id):
    query = "SELECT cameraindexcode, nombre, totalenternum as tEntrada FROM vehiculos_entradas_camara_dia_ant"
    data = ejecutar_consulta(query, mall_id=mall_id)
    return data if data else []


def get_datos_mensuales_vehiculos(mall_id):
    query = "SELECT totalenter as tEntrada, date_format(date, '%d-%m') as date FROM vehiculos_detalle_mes\
            where date_format(date, '%m-%y') like date_format(curdate(), '%m-%y')\
            order by date asc"
    data = ejecutar_consulta(query, mall_id=mall_id)
    return data if data else []


def get_datos_anuales_vehiculos(mall_id):
    query = "SELECT totalenter as tEntrada, month as mes, year FROM vehiculos_total_mes where year = year(curdate()) and totalenter > 0"
    data = ejecutar_consulta(query, mall_id=mall_id)
    return data if data else []


def get_salidas_vehiculos(mall_id, select=''):
    try:
        query = 'SELECT totalenter, TIME_FORMAT(time, "%H:%i") as tiempo, TIME_FORMAT(estadia, "%H:%i:%s") AS estadia '
        if select:
            query += ', ' + select
        query += ' FROM vehiculos_total_dia'
        data = ejecutar_consulta(query, mall_id=mall_id)
        return data if data else []
    except Exception as e:
        # Captura y maneja cualquier excepción ocurrida
        print(f"Error en get_salidas_vehiculos: {str(e)}")
        return {}



def get_rango_etario_hoy(mall_id):
    try:
        query = "SELECT pr.id, pr.hombres, pr.mujeres, pr.1 as nino, pr.2 as adolescente, pr.3 as joven, "\
                "pr.4 as adulto, pr.5 as anciano, TIME_FORMAT(pr.time, '%H:%i') AS time  " \
                "FROM personas_rf_dia pr"
        data = ejecutar_consulta(query, mall_id=mall_id)
        return data if data else []
    except Exception as e:
        # Captura y maneja cualquier excepción ocurrida
        print(f"Error en get_rango_etario_hoy: {str(e)}")
        return {}


def get_rango_etario_ayer(mall_id):
    try:
        query = "SELECT pr.id, pr.hombres, pr.mujeres, pr.1 as nino, pr.2 as adolescente, pr.3 as joven, " \
                "pr.4 as adulto, pr.5 as anciano "\
                "FROM personas_rf_dia_ant pr"
        data = ejecutar_consulta(query, mall_id=mall_id)
        return data if data else []
    except Exception as e:
        # Captura y maneja cualquier excepción ocurrida
        print(f"Error en get_rango_etario_ayer: {str(e)}")
        return {}


def get_pdf_grafico_x_dia_r0(mall_id, fecha_inicial, fecha_final):
    try:
        atributo_especial = 'totalenternum' if mall_id not in [
            5, 6, 27, 30] else 'totalenter'
        query = f"SELECT MAX({atributo_especial}) AS Entradas, "\
                f"DATE_FORMAT(date, '%m-%d') AS date " \
                f"FROM datos_estadisticos_dia_r0 " \
                f"WHERE date BETWEEN '{fecha_inicial}' AND '{fecha_final}' "\
                f"GROUP BY date"
        data = ejecutar_consulta(query, mall_id=mall_id)
        return data if data else []
    except Exception as e:
        print(f"Error en datos_estadisticos_dia_r0: {str(e)}")
        return {}


def get_pdf_datos_r0(mall_id, fecha_inicial, fecha_final):
    try:
        atributo_especial = 'totalenternum' if mall_id not in [
            5, 6, 27, 30] else 'totalenter'
        atributo_especial2 = 'totalexitnum' if mall_id not in [
            5, 6, 27, 30] else 'totalexit'
        query = f"select sum({atributo_especial}) as tEntrada, "\
                f"sum({atributo_especial2}) as tSalida " \
                f"from datos_estadisticos_dia_r0 " \
                f"where date between '{fecha_inicial}' AND '{fecha_final}'"
        # "group by date"
        data = ejecutar_consulta(query, mall_id=mall_id)
        return data if data else []
    except Exception as e:
        print(f"Error en datos_estadisticos_dia_r0: {str(e)}")
        return {}


def get_pdf_segmentos_entrada_r0(mall_id, fecha_inicial, fecha_final):
    try:
        # atributo_especial = 'T0.totalenternum' if mall_id not in [5, 6, 27, 30] else 'T0.totalenter'
        # atributo_especial2 = 'T0.totalexitnum' if mall_id not in [5, 6, 27, 30] else 'T0.totalexit'
        query = f"select sum(T0.08) as sum_08, "\
                f"sum(T0.09) as sum_09, " \
                f"sum(T0.10) as sum_10, " \
                f"sum(T0.11) as sum_11, " \
                f"sum(T0.12) as sum_12, " \
                f"sum(T0.13) as sum_13, " \
                f"sum(T0.14) as sum_14, " \
                f"sum(T0.15) as sum_15, " \
                f"sum(T0.16) as sum_16, " \
                f"sum(T0.17) as sum_17, " \
                f"sum(T0.18) as sum_18, " \
                f"sum(T0.19) as sum_19, " \
                f"sum(T0.20) as sum_20, " \
                f"sum(T0.21) as sum_21, " \
                f"sum(T0.22) as sum_22, " \
                f"sum(T0.23) as sum_23, " \
                f"Tipo " \
                f"from datos_seg_historicos_r0 as T0 "\
                f"where Tipo = 'Total Entradas' "\
                f"and date between '{fecha_inicial}' AND '{fecha_final}'"
        # "group by date"
        data = ejecutar_consulta(query, mall_id=mall_id)
        return data if data else []
    except Exception as e:
        print(f"Error en datos_seg_historicos_r0: {str(e)}")
        return {}


def get_pdf_grafico_x_camara_r0(mall_id, fecha_inicial, fecha_final):
    try:
        # Utilizando f-strings para mejorar la legibilidad y formateo de la consulta
        query = f"SELECT nc.nombre AS nombre, SUM(enternum) AS Entradas "\
                f"FROM detalle_camara_r0 AS dcr1 "\
                f"JOIN {'nombre_camaras' if mall_id != 4 else 'entradas_camara_dia_ant_r1'} AS nc ON dcr1.cameraindexcode = {'nc.camaraindexcode' if mall_id != 4 else 'nc.cameraindexcode'} "\
                f"WHERE dcr1.date BETWEEN '{fecha_inicial}' AND '{fecha_final}' "\
                F"GROUP BY nc.nombre "
        # f"WHERE Tipo = 'Total Entradas' "\
        # Eliminando el comentario de "group by date" ya que no está siendo utilizado
        data = ejecutar_consulta(query, mall_id=mall_id)
        return data if data else []
    except Exception as e:
        # Corrigiendo el mensaje de error para reflejar el nombre correcto de la función
        print(f"Error en detalle_camara_r0: {str(e)}")
        return {}


def get_pdf_grafico_x_dia_r1(mall_id, fecha_inicial, fecha_final):
    try:
        atributo_especial = 'totalenternum' if mall_id not in [
            5, 6, 27, 30] else 'totalenter'
        query = f"SELECT MAX({atributo_especial}) AS Entradas, "\
                f"DATE_FORMAT(date, '%m-%d') AS date " \
                f"FROM datos_estadisticos_dia_r1 " \
                f"WHERE date BETWEEN '{fecha_inicial}' AND '{fecha_final}' "\
                f"GROUP BY date"
        data = ejecutar_consulta(query, mall_id=mall_id)
        return data if data else []
    except Exception as e:
        print(f"Error en get_pdf_grafico_x_dia_r1: {str(e)}")
        return {}


def get_pdf_datos_r1(mall_id, fecha_inicial, fecha_final):
    try:
        atributo_especial = 'totalenternum' if mall_id not in [
            5, 6, 27, 30] else 'totalenter'
        atributo_especial2 = 'totalexitnum' if mall_id not in [
            5, 6, 27, 30] else 'totalexit'
        query = f"select sum({atributo_especial}) as tEntrada, "\
                f"sum({atributo_especial2}) as tSalida " \
                f"from datos_estadisticos_dia_r1 " \
                f"where date between '{fecha_inicial}' AND '{fecha_final}'"
        # "group by date"
        data = ejecutar_consulta(query, mall_id=mall_id)
        return data if data else []
    except Exception as e:
        print(f"Error en get_rango_etario_hoy: {str(e)}")
        return {}


def get_pdf_segmentos_entrada_r1(mall_id, fecha_inicial, fecha_final):
    try:
        # atributo_especial = 'T0.totalenternum' if mall_id not in [5, 6, 27, 30] else 'T0.totalenter'
        # atributo_especial2 = 'T0.totalexitnum' if mall_id not in [5, 6, 27, 30] else 'T0.totalexit'
        query = f"select sum(T0.08) as sum_08, "\
                f"sum(T0.09) as sum_09, " \
                f"sum(T0.10) as sum_10, " \
                f"sum(T0.11) as sum_11, " \
                f"sum(T0.12) as sum_12, " \
                f"sum(T0.13) as sum_13, " \
                f"sum(T0.14) as sum_14, " \
                f"sum(T0.15) as sum_15, " \
                f"sum(T0.16) as sum_16, " \
                f"sum(T0.17) as sum_17, " \
                f"sum(T0.18) as sum_18, " \
                f"sum(T0.19) as sum_19, " \
                f"sum(T0.20) as sum_20, " \
                f"sum(T0.21) as sum_21, " \
                f"sum(T0.22) as sum_22, " \
                f"sum(T0.23) as sum_23, " \
                f"Tipo " \
                f"from datos_seg_historicos_r1 as T0 "\
                f"where Tipo = 'Total Entradas' "\
                f"and date between '{fecha_inicial}' AND '{fecha_final}'"
        # "group by date"
        data = ejecutar_consulta(query, mall_id=mall_id)
        return data if data else []
    except Exception as e:
        print(f"Error en get_rango_etario_hoy: {str(e)}")
        return {}
    
def get_excel_segmentos_entrada_r1(mall_id, fecha_inicial, fecha_final):
    try:
        # atributo_especial = 'T0.totalenternum' if mall_id not in [5, 6, 27, 30] else 'T0.totalenter'
        # atributo_especial2 = 'T0.totalexitnum' if mall_id not in [5, 6, 27, 30] else 'T0.totalexit'
        query = f"select DATE_FORMAT(T0.date, '%d/%m/%Y') as date, sum(T0.08) as sum_08, "\
                f"sum(T0.09) as sum_09, " \
                f"sum(T0.10) as sum_10, " \
                f"sum(T0.11) as sum_11, " \
                f"sum(T0.12) as sum_12, " \
                f"sum(T0.13) as sum_13, " \
                f"sum(T0.14) as sum_14, " \
                f"sum(T0.15) as sum_15, " \
                f"sum(T0.16) as sum_16, " \
                f"sum(T0.17) as sum_17, " \
                f"sum(T0.18) as sum_18, " \
                f"sum(T0.19) as sum_19, " \
                f"sum(T0.20) as sum_20, " \
                f"sum(T0.21) as sum_21, " \
                f"sum(T0.22) as sum_22, " \
                f"sum(T0.23) as sum_23, " \
                f"Tipo " \
                f"from datos_seg_historicos_r1 as T0 "\
                f"where Tipo = 'Total Entradas' "\
                f"and date between '{fecha_inicial}' AND '{fecha_final}' "\
                f"GROUP BY T0.Tipo, T0.date"                  
        # "group by date"
        data = ejecutar_consulta(query, mall_id=mall_id)
        return data if data else []
    except Exception as e:
        print(f"Error en get_excel_segmentos_entrada_r1: {str(e)}")
        return {}
def get_excel_segmentos_entrada_r2(mall_id, fecha_inicial, fecha_final):
    try:
        # atributo_especial = 'T0.totalenternum' if mall_id not in [5, 6, 27, 30] else 'T0.totalenter'
        # atributo_especial2 = 'T0.totalexitnum' if mall_id not in [5, 6, 27, 30] else 'T0.totalexit'
        query = f"select DATE_FORMAT(date, '%d/%m/%Y') as date, sum(T0.08) as sum_08, "\
                f"sum(T0.09) as sum_09, " \
                f"sum(T0.10) as sum_10, " \
                f"sum(T0.11) as sum_11, " \
                f"sum(T0.12) as sum_12, " \
                f"sum(T0.13) as sum_13, " \
                f"sum(T0.14) as sum_14, " \
                f"sum(T0.15) as sum_15, " \
                f"sum(T0.16) as sum_16, " \
                f"sum(T0.17) as sum_17, " \
                f"sum(T0.18) as sum_18, " \
                f"sum(T0.19) as sum_19, " \
                f"sum(T0.20) as sum_20, " \
                f"sum(T0.21) as sum_21, " \
                f"sum(T0.22) as sum_22, " \
                f"sum(T0.23) as sum_23, " \
                f"Tipo " \
                f"from datos_seg_historicos_r2 as T0 "\
                f"where Tipo = 'Total Entradas' "\
                f"and date between '{fecha_inicial}' AND '{fecha_final}' "\
                f"GROUP BY T0.Tipo, T0.date"        # "group by date"
        data = ejecutar_consulta(query, mall_id=mall_id)
        return data if data else []
    except Exception as e:
        print(f"Error en get_excel_segmentos_entrada_r2: {str(e)}")
        return {}
    
def get_excel_segmentos_entrada_r3(mall_id, fecha_inicial, fecha_final):
    try:
        # atributo_especial = 'T0.totalenternum' if mall_id not in [5, 6, 27, 30] else 'T0.totalenter'
        # atributo_especial2 = 'T0.totalexitnum' if mall_id not in [5, 6, 27, 30] else 'T0.totalexit'
        query = f"select DATE_FORMAT(date, '%d/%m/%Y') as date, sum(T0.08) as sum_08, "\
                f"sum(T0.09) as sum_09, " \
                f"sum(T0.10) as sum_10, " \
                f"sum(T0.11) as sum_11, " \
                f"sum(T0.12) as sum_12, " \
                f"sum(T0.13) as sum_13, " \
                f"sum(T0.14) as sum_14, " \
                f"sum(T0.15) as sum_15, " \
                f"sum(T0.16) as sum_16, " \
                f"sum(T0.17) as sum_17, " \
                f"sum(T0.18) as sum_18, " \
                f"sum(T0.19) as sum_19, " \
                f"sum(T0.20) as sum_20, " \
                f"sum(T0.21) as sum_21, " \
                f"sum(T0.22) as sum_22, " \
                f"sum(T0.23) as sum_23, " \
                f"Tipo " \
                f"from datos_seg_historicos_r3 as T0 "\
                f"where Tipo = 'Total Entradas' "\
                f"and date between '{fecha_inicial}' AND '{fecha_final}' "\
                f"GROUP BY T0.Tipo, T0.date"
        # "group by date"
        data = ejecutar_consulta(query, mall_id=mall_id)
        return data if data else []
    except Exception as e:
        print(f"Error en get_excel_segmentos_entrada_r3: {str(e)}")
        return {}



def get_pdf_grafico_x_camara_r1(mall_id, fecha_inicial, fecha_final):
    try:
        # Utilizando f-strings para mejorar la legibilidad y formateo de la consulta
        query = f"SELECT nc.nombre AS nombre, SUM(enternum) AS Entradas "\
                f"FROM detalle_camara_r1 AS dcr1 "\
                f"JOIN {'nombre_camaras' if mall_id != 4 else 'entradas_camara_dia_ant_r1'} AS nc ON dcr1.cameraindexcode = {'nc.camaraindexcode' if mall_id != 4 else 'nc.cameraindexcode'} "\
                f"WHERE dcr1.date BETWEEN '{fecha_inicial}' AND '{fecha_final}' "\
                F"GROUP BY nc.nombre "
        # f"WHERE Tipo = 'Total Entradas' "\
        # Eliminando el comentario de "group by date" ya que no está siendo utilizado
        data = ejecutar_consulta(query, mall_id=mall_id)
        return data if data else []
    except Exception as e:
        # Corrigiendo el mensaje de error para reflejar el nombre correcto de la función
        print(f"Error en get_pdf_grafico_x_camara_r1: {str(e)}")
        return {}


def get_pdf_grafico_x_dia_r2(mall_id, fecha_inicial, fecha_final):
    try:
        atributo_especial = 'totalenternum' if mall_id not in [
            5, 6, 27, 30] else 'totalenter'
        query = f"SELECT MAX({atributo_especial}) AS Entradas, "\
                f"DATE_FORMAT(date, '%m-%d') AS date " \
                f"FROM datos_estadisticos_dia_r2 " \
                f"WHERE date BETWEEN '{fecha_inicial}' AND '{fecha_final}' "\
                f"GROUP BY date"
        data = ejecutar_consulta(query, mall_id=mall_id)
        return data if data else []
    except Exception as e:
        print(f"Error en datos_estadisticos_dia_r2: {str(e)}")
        return {}


def get_pdf_datos_r2(mall_id, fecha_inicial, fecha_final):
    try:
        atributo_especial = 'totalenternum' if mall_id not in [
            5, 6, 27, 30] else 'totalenter'
        atributo_especial2 = 'totalexitnum' if mall_id not in [
            5, 6, 27, 30] else 'totalexit'
        query = f"select sum({atributo_especial}) as tEntrada, "\
                f"sum({atributo_especial2}) as tSalida " \
                f"from datos_estadisticos_dia_r2 " \
                f"where date between '{fecha_inicial}' AND '{fecha_final}'"
        # "group by date"
        data = ejecutar_consulta(query, mall_id=mall_id)
        return data if data else []
    except Exception as e:
        print(f"Error en datos_estadisticos_dia_r2: {str(e)}")
        return {}


def get_pdf_segmentos_entrada_r2(mall_id, fecha_inicial, fecha_final):
    try:
        # atributo_especial = 'T0.totalenternum' if mall_id not in [5, 6, 27, 30] else 'T0.totalenter'
        # atributo_especial2 = 'T0.totalexitnum' if mall_id not in [5, 6, 27, 30] else 'T0.totalexit'
        query = f"select sum(T0.08) as sum_08, "\
                f"sum(T0.09) as sum_09, " \
                f"sum(T0.10) as sum_10, " \
                f"sum(T0.11) as sum_11, " \
                f"sum(T0.12) as sum_12, " \
                f"sum(T0.13) as sum_13, " \
                f"sum(T0.14) as sum_14, " \
                f"sum(T0.15) as sum_15, " \
                f"sum(T0.16) as sum_16, " \
                f"sum(T0.17) as sum_17, " \
                f"sum(T0.18) as sum_18, " \
                f"sum(T0.19) as sum_19, " \
                f"sum(T0.20) as sum_20, " \
                f"sum(T0.21) as sum_21, " \
                f"sum(T0.22) as sum_22, " \
                f"sum(T0.23) as sum_23, " \
                f"Tipo " \
                f"from datos_seg_historicos_r2 as T0 "\
                f"where Tipo = 'Total Entradas' "\
                f"and date between '{fecha_inicial}' AND '{fecha_final}'"
        # "group by date"
        data = ejecutar_consulta(query, mall_id=mall_id)
        return data if data else []
    except Exception as e:
        print(f"Error en datos_seg_historicos_r2: {str(e)}")
        return {}


def get_pdf_grafico_x_camara_r2(mall_id, fecha_inicial, fecha_final):
    try:
        # Utilizando f-strings para mejorar la legibilidad y formateo de la consulta
        query = f"SELECT nc.nombre AS nombre, SUM(enternum) AS Entradas "\
                f"FROM detalle_camara_r2 AS dcr1 "\
                f"JOIN nombre_camaras AS nc ON dcr1.cameraindexcode = nc.camaraindexcode "\
                f"WHERE dcr1.date BETWEEN '{fecha_inicial}' AND '{fecha_final}' "\
                F"GROUP BY nc.nombre "
        # f"WHERE Tipo = 'Total Entradas' "\
        # Eliminando el comentario de "group by date" ya que no está siendo utilizado
        data = ejecutar_consulta(query, mall_id=mall_id)
        return data if data else []
    except Exception as e:
        # Corrigiendo el mensaje de error para reflejar el nombre correcto de la función
        print(f"Error en detalle_camara_r2: {str(e)}")
        return {}


def get_pdf_grafico_x_dia_r3(mall_id, fecha_inicial, fecha_final):
    try:
        atributo_especial = 'totalenternum' if mall_id not in [
            5, 6, 27, 30] else 'totalenter'
        query = f"SELECT MAX({atributo_especial}) AS Entradas, "\
                f"DATE_FORMAT(date, '%m-%d') AS date " \
                f"FROM datos_estadisticos_dia_r3 " \
                f"WHERE date BETWEEN '{fecha_inicial}' AND '{fecha_final}' "\
                f"GROUP BY date"
        data = ejecutar_consulta(query, mall_id=mall_id)
        return data if data else []
    except Exception as e:
        print(f"Error en get_pdf_grafico_x_dia_r3: {str(e)}")
        return {}


def get_pdf_datos_r3(mall_id, fecha_inicial, fecha_final):
    try:
        atributo_especial = 'totalenternum' if mall_id not in [
            5, 6, 27, 30] else 'totalenter'
        atributo_especial2 = 'totalexitnum' if mall_id not in [
            5, 6, 27, 30] else 'totalexit'
        query = f"select sum({atributo_especial}) as tEntrada, "\
                f"sum({atributo_especial2}) as tSalida " \
                f"from datos_estadisticos_dia_r3 " \
                f"where date between '{fecha_inicial}' AND '{fecha_final}'"
        # "group by date"
        data = ejecutar_consulta(query, mall_id=mall_id)
        return data if data else []
    except Exception as e:
        print(f"Error en datos_estadisticos_dia_r3: {str(e)}")
        return {}


def get_pdf_segmentos_entrada_r3(mall_id, fecha_inicial, fecha_final):
    try:
        # atributo_especial = 'T0.totalenternum' if mall_id not in [5, 6, 27, 30] else 'T0.totalenter'
        # atributo_especial2 = 'T0.totalexitnum' if mall_id not in [5, 6, 27, 30] else 'T0.totalexit'
        query = f"select sum(T0.08) as sum_08, "\
                f"sum(T0.09) as sum_09, " \
                f"sum(T0.10) as sum_10, " \
                f"sum(T0.11) as sum_11, " \
                f"sum(T0.12) as sum_12, " \
                f"sum(T0.13) as sum_13, " \
                f"sum(T0.14) as sum_14, " \
                f"sum(T0.15) as sum_15, " \
                f"sum(T0.16) as sum_16, " \
                f"sum(T0.17) as sum_17, " \
                f"sum(T0.18) as sum_18, " \
                f"sum(T0.19) as sum_19, " \
                f"sum(T0.20) as sum_20, " \
                f"sum(T0.21) as sum_21, " \
                f"sum(T0.22) as sum_22, " \
                f"sum(T0.23) as sum_23, " \
                f"Tipo " \
                f"from datos_seg_historicos_r3 as T0 "\
                f"where Tipo = 'Total Entradas' "\
                f"and date between '{fecha_inicial}' AND '{fecha_final}'"
        # "group by date"
        data = ejecutar_consulta(query, mall_id=mall_id)
        return data if data else []
    except Exception as e:
        print(f"Error en datos_seg_historicos_r3: {str(e)}")
        return {}


def get_pdf_grafico_x_camara_r3(mall_id, fecha_inicial, fecha_final):
    try:
        # Utilizando f-strings para mejorar la legibilidad y formateo de la consulta
        query = f"SELECT nc.nombre AS nombre, SUM(enternum) AS Entradas "\
                f"FROM detalle_camara_r3 AS dcr1 "\
                f"JOIN {'nombre_camaras' if mall_id != 4 else 'entradas_camara_dia_ant_r1'} AS nc ON dcr1.cameraindexcode = {'nc.camaraindexcode' if mall_id != 4 else 'nc.cameraindexcode'} "\
                f"WHERE dcr1.date BETWEEN '{fecha_inicial}' AND '{fecha_final}' "\
                F"GROUP BY nc.nombre "
        # f"WHERE Tipo = 'Total Entradas' "\
        # Eliminando el comentario de "group by date" ya que no está siendo utilizado
        data = ejecutar_consulta(query, mall_id=mall_id)
        return data if data else []
    except Exception as e:
        # Corrigiendo el mensaje de error para reflejar el nombre correcto de la función
        print(f"Error en detalle_camara_r3: {str(e)}")
        return {}


def get_malls_x_distribucion(distribucion_id):
    try:
        query = f"SELECT m.* "\
                f"FROM malls m "\
                f"WHERE m.distribucion_id = {distribucion_id} and m.estado=1 and m.deleted=0"
        data = ejecutar_consulta(query, local=True)
        return data if data else []
    except Exception as e:
        print(f"Error en obtencion de malls: {str(e)}")
        return str(e)


def get_administracion_gerente(distribucion_id):
    try:
        print("malls")
        malls = get_malls_x_distribucion(distribucion_id)
        datos_malls = {}
        for mall in malls:
            datos_push = {'mall': mall}
            
            for acceso_tipo in ['r0', 'r1', 'r2', 'r3', 'vehicle', 'tendencia']:
                acceso_actual = f"get_aforo_hoy_{acceso_tipo}"
                acceso_segmentado = f"get_personas_segmento_hoy_{acceso_tipo}"

                if mall[f'acceso_{acceso_tipo}']:
                    aforo_actual = globals()[acceso_actual](mall['id'])
                    aforo_segmentado = globals()[acceso_segmentado](mall['id'])

                    if aforo_actual:
                        datos_push[f'aforo_actual_{acceso_tipo}'] = aforo_actual
                    if aforo_segmentado:
                        datos_push[f'aforo_segmentado_{acceso_tipo}'] = aforo_segmentado

            datos_malls[mall['id']] = datos_push

        return datos_malls if datos_malls else {}
    except Exception as e:
        print(f"Error en obtención de malls: {str(e)}")
        return str(e)
    
def get_resumen_malls(distribucion_id):
    try:
        datos_malls = {}
        malls = get_malls_x_distribucion(distribucion_id)
        for mall in malls:
            datos_push = {'mall': mall}
            
            # print(mall)
            if mall['acceso_vehicle']:
                # print(mall['id'])
                data_vehiculos = get_salidas_vehiculos(mall_id=mall['id'])
                print(data_vehiculos)
                if data_vehiculos is not None:
                    datos_push['aforo_actual_vehiculos'] = data_vehiculos[0]["totalenter"]

            datos_push['aforo_actual_personas'] = 0 
            for acceso_tipo in ['r0', 'r1', 'r2', 'r3']:
                acceso_actual = f"get_aforo_hoy_{acceso_tipo}"
                if mall[f'acceso_{acceso_tipo}']:
                    aforo_actual = globals()[acceso_actual](mall['id'])
                    if aforo_actual:
                        datos_push['aforo_actual_personas'] += aforo_actual[0]["Entradas"]
            rango_etario = get_rango_etario_hoy(mall["id"])
            if rango_etario is not None:
                total_hombres = 0
                total_mujeres = 0
                for rango in rango_etario:
                    total_hombres += rango["hombres"] 
                    total_mujeres += rango["mujeres"] 
                porcentaje_hombres = total_hombres / len(rango_etario)
                porcentaje_mujeres = total_mujeres / len(rango_etario)
                datos_push['total_hombres'] = porcentaje_hombres
                datos_push['total_mujeres'] = porcentaje_mujeres
            datos_malls[mall['id']] = datos_push
            # print('##############################')
            # print(datos_push)
            # print('##############################')
        
        return datos_malls
    except Exception as e:
        return str(e)

def get_camaras(data_post):
    try:
        # Establecer la conexión a la base de datos MySQL
        conexion = mysql.connector.connect(
            user=data_post['username'],
            password=data_post['password'],
            host=data_post['host'],
            port=data_post['port'],
            database=data_post['database']
        )
        
        # Verificar si la conexión fue exitosa
        if conexion.is_connected():
            print("Conexión exitosa a la base de datos MySQL")

            # nombre_camaras = ejecutar_consulta('SELECT * FROM nombre_camaras;', conexion=conexion)
            conexion.close()  # Cerrar la conexión
            return True
        else:
            print("Error: No se pudo conectar a la base de datos MySQL")
            return False
            
    except mysql.connector.Error as e:
        print(f"Error en obtención de cámaras: {str(e)}")
        return False
    
def get_aforo_region(region, mall_id):
    try:
        aforo_tipo_acceso = None
        
        # Mapeo de regiones a tipos de acceso
        if region.lower() == 'region0':
            aforo_tipo_acceso = 'r0'
        elif region.lower() == 'region1':
            aforo_tipo_acceso = 'r1'
        elif region.lower() == 'region2':
            aforo_tipo_acceso = 'r2'
        elif region.lower() == 'region3':
            aforo_tipo_acceso = 'r3'
        elif region.lower() == 'vehicle':
            aforo_tipo_acceso = 'vehicle'
        elif region.lower() == 'tendencia':
            aforo_tipo_acceso = 'tendencia'
        
        if aforo_tipo_acceso:
            # Llama a la función para obtener el aforo actual y segmentado
            aforo_actual = globals()[f"get_aforo_hoy_{aforo_tipo_acceso}"](mall_id)
            aforo_segmentado = globals()[f"get_personas_segmento_hoy_{aforo_tipo_acceso}"](mall_id)

            datos_aforo = {}

            if aforo_actual:
                datos_aforo[f'aforo_actual'] = aforo_actual
            if aforo_segmentado:
                datos_aforo[f'aforo_segmentado'] = aforo_segmentado

            return datos_aforo
        
        return f"No se encontró el tipo de acceso para la región {region}."
    
    except Exception as e:
        return str(e)


# def get_datos_patenetes():
#     try:
#         return 
#     except Exception as e:
#         return str(e)
        
def get_region1_data(mall_id):

    results = {
        'aforo_hoy_r1': get_aforo_hoy_r1(mall_id),
        'aforo_ayer_r1': get_aforo_ayer_r1(mall_id),
        'personas_segmento_ayer_r1': get_personas_segmento_ayer_r1(mall_id),
        'personas_segmento_hoy_r1': get_personas_segmento_hoy_r1(mall_id),
        'time_actualizacion': time_actualizacion(mall_id),
        'entradas_camara_ayer_r1': get_entradas_camara_ayer_r1(mall_id),
        'datos_anuales_r1': get_datos_anuales_r1(mall_id),
        'datos_anuales_ant_r1': get_datos_anuales_ant_r1(mall_id),
        'datos_mensuales_r1': get_datos_mensuales_r1(mall_id),
        'datos_mensuales_ant_r1': get_datos_mensuales_ant_r1(mall_id),
        'comparativo_mes_actual_r1': comparativo_mes_actual_r1(mall_id),
        'comparativo_mes_anterior_r1': comparativo_mes_anterior_r1(mall_id)
    }

    return results


def get_region0_data(mall_id):
    results = {
        'aforo_hoy_r0': get_aforo_hoy_r0(mall_id),
        'aforo_ayer_r0': get_aforo_ayer_r0(mall_id),
        'personas_segmento_ayer_r0': get_personas_segmento_ayer_r0(mall_id),
        'personas_segmento_hoy_r0': get_personas_segmento_hoy_r0(mall_id),
        'time_actualizacion': time_actualizacion(mall_id),
        'entradas_camara_ayer_r0': get_entradas_camara_ayer_r0(mall_id),
        'datos_anuales_r0': get_datos_anuales_r0(mall_id),
        'datos_anuales_ant_r0': get_datos_anuales_ant_r0(mall_id),
        'datos_mensuales_r0': get_datos_mensuales_r0(mall_id),
        'datos_mensuales_ant_r0': get_datos_mensuales_ant_r0(mall_id),
        'comparativo_mes_actual_r0': comparativo_mes_actual_r0(mall_id),
        'comparativo_mes_anterior_r0': comparativo_mes_anterior_r0(mall_id),
    }

    return results


def get_region2_data(mall_id):
    results = {
        'aforo_hoy_r2': get_aforo_hoy_r2(mall_id),
        'aforo_ayer_r2': get_aforo_ayer_r2(mall_id),
        'personas_segmento_ayer_r2': get_personas_segmento_ayer_r2(mall_id),
        'personas_segmento_hoy_r2': get_personas_segmento_hoy_r2(mall_id),
        'time_actualizacion': time_actualizacion(mall_id),
        'entradas_camara_ayer_r2': get_entradas_camara_ayer_r2(mall_id),
        'entradas_camara_hoy_r2': get_entradas_camara_hoy_r2(mall_id),
        'datos_anuales_r2': get_datos_anuales_r2(mall_id),
        'datos_anuales_ant_r2': get_datos_anuales_ant_r2(mall_id),
        'datos_mensuales_r2': get_datos_mensuales_r2(mall_id),
        'datos_mensuales_ant_r2': get_datos_mensuales_ant_r2(mall_id),
        'comparativo_mes_actual_r2': comparativo_mes_actual_r2(mall_id),
        'comparativo_mes_anterior_r2': comparativo_mes_anterior_r2(mall_id)
    }

    return results


def get_region3_data(mall_id):
    results = {
        'aforo_hoy_r3': get_aforo_hoy_r3(mall_id),
        'aforo_ayer_r3': get_aforo_ayer_r3(mall_id),
        'personas_segmento_ayer_r3': get_personas_segmento_ayer_r3(mall_id),
        'personas_segmento_hoy_r3': get_personas_segmento_hoy_r3(mall_id),
        'time_actualizacion': time_actualizacion(mall_id),
        'entradas_camara_ayer_r3': get_entradas_camara_ayer_r3(mall_id),
        'datos_anuales_r3': get_datos_anuales_r3(mall_id),
        'datos_anuales_ant_r3': get_datos_anuales_ant_r3(mall_id),
        'datos_mensuales_r3': get_datos_mensuales_r3(mall_id),
        'datos_mensuales_ant_r3': get_datos_mensuales_ant_r3(mall_id),
        'comparativo_mes_actual_r3': comparativo_mes_actual_r3(mall_id),
        'comparativo_mes_anterior_r3': comparativo_mes_anterior_r3(mall_id),
    }

    return results


def get_tendencia_data(mall_id):
    results = {
        'aforo_hoy': get_aforo_hoy_tendencia(mall_id),
        'aforo_hoy_grafico': get_aforo_hoy_grafico_tendencia(mall_id),
        'aforo_ayer': get_aforo_ayer_tendencia(mall_id),
        'aforo_ayer_grafico': get_aforo_ayer_grafico_tendencia(mall_id),
        'time_actualizacion': time_actualizacion(mall_id),
    }

    return results


def get_vehiculos_data(mall_id):
    results = {
        # 'aforo_hoy': get_aforo_hoy_tendencia(mall_id),
        'aforo_hoy_grafico': get_aforo_hoy_grafico_vehiculos(mall_id),
        'aforo_ayer': get_aforo_ayer_vehiculos(mall_id),
        'aforo_ayer_grafico': get_aforo_ayer_grafico_vehiculos(mall_id),
        'camara_sector_anterior': get_camara_sector_anterior_vehiculos(mall_id),
        'datos_anuales': get_datos_anuales_vehiculos(mall_id),
        'datos_mensuales': get_datos_mensuales_vehiculos(mall_id),
        'time_actualizacion': time_actualizacion(mall_id),
    }
    return results


def get_salidas_vehiculos_data(mall_id, select):
    results = {
        'salidas_vehiculos': get_salidas_vehiculos(mall_id, select),
    }
    return results


def get_rango_etario_hoy_data(mall_id):
    results = {
        'rango_etario_hoy': get_rango_etario_hoy(mall_id),
    }
    return results


def get_rango_etario_ayer_data(mall_id):
    results = {
        'rango_etario_ayer': get_rango_etario_ayer(mall_id),
    }
    return results


def get_pdf_r0_data(mall_id, fecha_inicial, fecha_final):
    results = {
        'pdf_grafico_x_dia_r0': get_pdf_grafico_x_dia_r0(mall_id, fecha_inicial, fecha_final),
        'pdf_datos_r0': get_pdf_datos_r0(mall_id, fecha_inicial, fecha_final),
        'pdf_segmentos_entrada_r0': get_pdf_segmentos_entrada_r0(mall_id, fecha_inicial, fecha_final),
        'pdf_grafico_x_camara_r0': get_pdf_grafico_x_camara_r0(mall_id, fecha_inicial, fecha_final),
    }
    return results


def get_pdf_r1_data(mall_id, fecha_inicial, fecha_final):
    results = {
        'pdf_grafico_x_dia_r1': get_pdf_grafico_x_dia_r1(mall_id, fecha_inicial, fecha_final),
        'pdf_datos_r1': get_pdf_datos_r1(mall_id, fecha_inicial, fecha_final),
        'pdf_segmentos_entrada_r1': get_pdf_segmentos_entrada_r1(mall_id, fecha_inicial, fecha_final),
        'pdf_grafico_x_camara_r1': get_pdf_grafico_x_camara_r1(mall_id, fecha_inicial, fecha_final),
    }
    return results


def get_pdf_r2_data(mall_id, fecha_inicial, fecha_final):
    results = {
        'pdf_grafico_x_dia_r2': get_pdf_grafico_x_dia_r2(mall_id, fecha_inicial, fecha_final),
        'pdf_datos_r2': get_pdf_datos_r2(mall_id, fecha_inicial, fecha_final),
        'pdf_segmentos_entrada_r2': get_pdf_segmentos_entrada_r2(mall_id, fecha_inicial, fecha_final),
        'pdf_grafico_x_camara_r2': get_pdf_grafico_x_camara_r2(mall_id, fecha_inicial, fecha_final),
    }
    return results


def get_pdf_r3_data(mall_id, fecha_inicial, fecha_final):
    results = {
        'pdf_grafico_x_dia_r3': get_pdf_grafico_x_dia_r3(mall_id, fecha_inicial, fecha_final),
        'pdf_datos_r3': get_pdf_datos_r3(mall_id, fecha_inicial, fecha_final),
        'pdf_segmentos_entrada_r3': get_pdf_segmentos_entrada_r3(mall_id, fecha_inicial, fecha_final),
        'pdf_grafico_x_camara_r3': get_pdf_grafico_x_camara_r3(mall_id, fecha_inicial, fecha_final),
    }
    return results


def get_datos_administacion_gerente(distribucion_id):
    results = {
        'malls': get_administracion_gerente(distribucion_id),
        # 'malls2': distribucion_id,
    }
    return results

def get_nombre_camaras(data_post):
    results = {
        'camaras': get_camaras(data_post)
    }
    return results

def get_aforo_data(region, mall_id):
    results = {
        'data': get_aforo_region(region=region, mall_id=mall_id)
    }
    return results
def get_datos_segmentados_excel(data_post, mall_id):
    try:
        seleccion = data_post[0]
        fecha_inicial = data_post[1]
        fecha_final = data_post[2]
        atributo_especial = 'totalenternum' if mall_id not in [5, 6, 26, 27, 30] else 'totalenter'
        datos_segmentados = []
        if seleccion == '1':
            datos_segmentados = get_excel_segmentos_entrada_r1(mall_id, fecha_inicial, fecha_final)
        elif seleccion == '2':
            datos_segmentados = get_excel_segmentos_entrada_r2(mall_id, fecha_inicial, fecha_final)
        elif seleccion == '3':
            datos_segmentados = get_excel_segmentos_entrada_r3(mall_id, fecha_inicial, fecha_final)

        
        results = {
            'data': datos_segmentados
        }
        return results
    except Exception as e:
        print(f"Error en obtencion de malls: {str(e)}")
        return str(e)

def get_datos_dia_excel(data_post, mall_id):
    try:
        seleccion = data_post[0]
        fecha_inicial = data_post[1]
        fecha_final = data_post[2]
        atributo_especial = 'totalenternum' if mall_id not in [5, 6, 26, 27, 30] else 'totalenter'
        tabla = ''
        if seleccion == '1':
            tabla = 'datos_estadisticos_dia_r1'
        elif seleccion == '2':
            tabla = 'datos_estadisticos_dia_r2'
        elif seleccion == '3':
            tabla = 'datos_estadisticos_dia_r3'
        # query = "SELECT {}, date FROM {} WHERE date BETWEEN %s AND %s".format(atributo_especial, tabla)
        query = f"SELECT {atributo_especial}, DATE_FORMAT(date, '%d/%m/%Y') as date "\
                f"FROM {tabla} "\
                f"WHERE date between '{fecha_inicial}' and '{fecha_final}'"
        data = ejecutar_consulta(query, mall_id=mall_id)
        
        results = {'data': data}
        return results
    except Exception as e:
        print(f"Error en obtencion de malls: {str(e)}")
        return str(e)

@app.route('/api/get-datos-segmentados-excel/<int:mall_id>', methods=['POST'])
def obtener_datos_segementados_excel(mall_id):
    try:
        data_post = request.json
        print(data_post)
        response = jsonify(get_datos_segmentados_excel(data_post, mall_id))
        return response
    except Exception as e:
        print(f"Error en obtencion de datos: {str(e)}")
        return str(e)
@app.route('/api/get-datos-dia-excel/<int:mall_id>', methods=['POST'])
def obtener_datos_dia_excel(mall_id):
    try:
        data_post = request.json
        print(data_post)
        response = jsonify(get_datos_dia_excel(data_post, mall_id))
        return response
    except Exception as e:
        print(f"Error en obtencion de datos: {str(e)}")
        return str(e)

@app.route('/api/get-aforo/<string:region>/<int:mall_id>', methods=['GET'])
def get_aforo(region, mall_id):
    response = jsonify(get_aforo_data(region, mall_id))
    return response

@app.route('/api/region1/<int:mall_id>', methods=['GET'])
def region1(mall_id):
    response = jsonify(get_region1_data(mall_id))
    return response


@app.route('/api/region0/<int:mall_id>', methods=['GET'])
def region0(mall_id):
    response = jsonify(get_region0_data(mall_id))
    return response


@app.route('/api/region2/<int:mall_id>', methods=['GET'])
def region2(mall_id):
    response = jsonify(get_region2_data(mall_id))
    return response


@app.route('/api/region3/<int:mall_id>', methods=['GET'])
def region3(mall_id):
    response = jsonify(get_region3_data(mall_id))
    return response


@app.route('/api/tendencia/<int:mall_id>', methods=['GET'])
def tendencia(mall_id):
    response = jsonify(get_tendencia_data(mall_id))
    return response


@app.route('/api/vehiculos/<int:mall_id>', methods=['GET'])
def vehiculos(mall_id):
    response = jsonify(get_vehiculos_data(mall_id))
    return response


@app.route('/api/salidas-vehiculos/<int:mall_id>/<string:select>', methods=['GET'])
def salidas_vehiculos(mall_id, select):
    response = jsonify(get_salidas_vehiculos_data(mall_id, select))
    return response


@app.route('/api/rango-etario-hoy/<int:mall_id>', methods=['GET'])
def rango_etario_hoy(mall_id):
    response = jsonify(get_rango_etario_hoy_data(mall_id))
    return response


@app.route('/api/rango-etario-ayer/<int:mall_id>', methods=['GET'])
def rango_etario_ayer(mall_id):
    response = jsonify(get_rango_etario_ayer_data(mall_id))
    return response


@app.route('/api/pdf-r0/<int:mall_id>/<string:fecha_inicial>/<string:fecha_final>', methods=['GET'])
def pdf_r0(mall_id, fecha_inicial, fecha_final):
    response = jsonify(get_pdf_r0_data(mall_id, fecha_inicial, fecha_final))
    return response


@app.route('/api/pdf-r1/<int:mall_id>/<string:fecha_inicial>/<string:fecha_final>', methods=['GET'])
def pdf_r1(mall_id, fecha_inicial, fecha_final):
    response = jsonify(get_pdf_r1_data(mall_id, fecha_inicial, fecha_final))
    return response


@app.route('/api/pdf-r2/<int:mall_id>/<string:fecha_inicial>/<string:fecha_final>', methods=['GET'])
def pdf_r2(mall_id, fecha_inicial, fecha_final):
    response = jsonify(get_pdf_r2_data(mall_id, fecha_inicial, fecha_final))
    return response


@app.route('/api/pdf-r3/<int:mall_id>/<string:fecha_inicial>/<string:fecha_final>', methods=['GET'])
def pdf_r3(mall_id, fecha_inicial, fecha_final):
    response = jsonify(get_pdf_r3_data(mall_id, fecha_inicial, fecha_final))
    return response


@app.route('/api/administracion-gerente/<int:distribucion_id>', methods=['GET'])
def administracion_gerente(distribucion_id):
    # print("kasjdksa")
    response = jsonify(get_datos_administacion_gerente(distribucion_id))
    return response
@app.route('/api/resumen-malls/<int:distribucion_id>', methods=['GET'])
def resumen_malls(distribucion_id):
    response = jsonify(get_resumen_malls(distribucion_id))
    return response


@app.route('/api/obtener-nombre-camaras', methods=['POST'])
def obtener_nombre_camaras():
    data_post = request.json
    response = jsonify(get_nombre_camaras(data_post))
    return response

if __name__ == "__main__":
    app.run(host='0.0.0.0', port=5000, debug=True)
