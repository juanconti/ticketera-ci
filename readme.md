# Ticketera de Soporte Técnico

### Descripción

Es un sistema de registro de **tickets de soporte técnico**. Los tickets pueden generarse individualmente y autoconclusivos o dejarse como pendientes para eventualmente continuarse y formar parte de una cadena. 

La aplicación cuenta con un sistema para generar usuarios, a los que se deben designar a un sector. En la entidad de sector, es donde se administran los permisos de los usuarios. Es decir, depende de la función que valla a cumplir el usuario es al sector al que se le asigna. Los permisos que tenga cada sector van a ser designados por el usuario administrador(Admin), creado ya por defecto en la aplicación.

El usuario administrador es quien genera los sectores y asigna los permisos. Los permisos por el momento solo habilitan a crear, editar o deshabilitar usuarios o abonados('USUARIOS_ABM' y 'ABONADOS_ABM'). El Admin también tiene acceso a las bitácoras de los tickets y puede visualizar por los diferentes cambios que pasó un ticket.

Cada ticket tiene que estar asignado a un Abonado, que debe crearse previamente y es la entidad que representa a los clientes de la empresa.

### Configuración de la aplicación

 Debe configurarse la dirección root que tendrá el proyecto en el archivo de configuración de Codeigniter *./application/config/config.php* e indicarse en el índice 'base_url' en la variable config, remplazando 'localhost'.

```
$config['base_url'] = *Indicar url root aquí*;
```

Luego debe configurarse la codeigniter para que se comunique con su base de datos. Esto debe hacerse en el archivo *./application/config/database.php* y remplazar los datos pertinentes con los de su base de datos.

Por último, debe crear la base de datos necesaria para correr la aplicación. Esto lo puede realizar tomando el archivo *db_ticketera.sql* que contiene querys para recrear la base de datos inicial. Creará una base de datos llamada 'ticketera' en su base de datos que contendrá todas las tablas necesarias y generará el usuario Admin con el que podrdrá comenzar a crear el resto de los usuarios. El username del mismo es '*admin*' y la contraseña '*contraseña*'.

### Construido Utilizando

* PHP 5.6
* mySql(MariaDB) - Base de datos
* [Codeigniter 3.1](https://codeigniter.com) - Framework de php
* [jQuery](https://jquery.com) - Librería de javaScript
* [Boostrap 4.0](http://getbootstrap.com) - Librería de Frontend
* [Font Awesome](https://fontawesome.com) - Librería de iconos
