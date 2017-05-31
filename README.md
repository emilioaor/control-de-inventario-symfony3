Control de inventario en Symfony 3
=================================
@author [Emilio Ochoa](http://emilioochoa.com.ve)

Un testing en symfony 3 con una pequeña funcionalidad para control de inventario, reforzando un poco los conocimientos.

### Instalar
1. Descarga o clona el proyecto y posicionate en la raíz.

2. Renombrar el archivo **app/config/parameters.yml.dist** a **parameters.yml** 

3. Configurar el archivo **app/config/parameters.yml** con los datos de conexion a base de datos

 
4. Ejecuta los siguientes comandos en la raiz:

        /* Descargar las dependencias */
        composer update
        
        /* Crear base de datos */
        php bin/console doctrine:schema:update --force



Listo puedes correr el proyecto desde apache o utilizando symfony

Para iniciar con symfony corre el comando:

    php bin/console server:run

Con esto puedes acceder a traves de <http://localhost:8000>
