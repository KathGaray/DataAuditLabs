Tercer Desafío Práctico | Desarrollo de Aplicaciones Web con Software Interpretados en el Servidor
Universidad Don Bosco

Descripción
Aplicación web para la empresa DataAuditLabs que permite a sus empleados gestionar tareas personales de forma organizada. Incluye registro e inicio de sesión de usuarios, CRUD completo de tareas, cambio de estado sin recarga (AJAX) y una versión del CRUD en Laravel.

Estructura del repositorio
DataAuditLabs/
├── mvc_nativo/         
│   ├── config/
│   ├── controllers/
│   ├── models/
│   ├── views/
│   ├── libs/
│   ├── public/
│   └── .htaccess
├── laravel_tareas/      
│   ├── app/
│   ├── database/
│   ├── resources/
│   └── routes/
├── ajax/                
├── database/
│   └── script.sql
├── screenshots/
│   ├── registro.png
│   ├── login.png
│   ├── tareas.png
│   ├── crear.png
│   └── editar.png
├── README.md
└── .gitignore

Tecnologías utilizadas

PHP 8.x (MVC nativo)
Laravel 10.x
MySQL 8.x
Bootstrap 5
JavaScript (Fetch API / AJAX)
Apache con mod_rewrite (.htaccess)


Requisitos previos

PHP >= 8.1
Composer
MySQL >= 8.0
Apache (XAMPP / Laragon / servidor propio) con mod_rewrite habilitado
Node.js (opcional, para assets de Laravel)


Instalación
1. Clonar el repositorio
bashgit clone https://github.com/usuario/DataAuditLabs.git
cd DataAuditLabs
2. Crear la base de datos

Accede a phpMyAdmin o tu cliente MySQL.
Crea una base de datos llamada dataauditlabs.
Importa el script:

bashmysql -u root -p dataauditlabs < database/script.sql

3. Configurar MVC Nativo (mvc_nativo/)

Abre mvc_nativo/config/database.php y ajusta las credenciales:

phpdefine('DB_HOST', 'localhost');
define('DB_NAME', 'dataauditlabs');
define('DB_USER', 'root');
define('DB_PASS', '');

Coloca la carpeta mvc_nativo/ dentro de la raíz de tu servidor (p. ej. htdocs/ en XAMPP).
Accede desde el navegador:

http://localhost/DataAuditLabs/mvc_nativo/public/

4. Configurar Laravel (laravel_tareas/)
bashcd laravel_tareas
composer install
cp .env.example .env
php artisan key:generate
Edita el archivo .env con las credenciales de tu base de datos:
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=dataauditlabs
DB_USERNAME=root
DB_PASSWORD=
Ejecuta las migraciones:
bashphp artisan migrate
php artisan serve
Accede en:
http://127.0.0.1:8000

Credenciales de prueba
UsuarioContraseñaadmin@test.comAdmin1234usuario@test.comUser1234

También puedes registrar un usuario nuevo desde la vista de registro.


Funcionalidades implementadas

 Registro de usuarios con validación
 Inicio de sesión con password_hash / password_verify
 CRUD de tareas (crear, leer, actualizar, eliminar)
 Visualización solo de tareas propias por usuario
 Cambio de estado de tarea sin recargar (AJAX / Fetch API)
 Versión Laravel del CRUD con Eloquent ORM
 Interfaz responsiva con Bootstrap 5


Declaración de uso de Inteligencia Artificial
El uso de IA se limitó exclusivamente al área visual y de presentación (HTML, CSS, Bootstrap), además de su uso para la explicación de la lógica y estructura del sistema. Toda la lógica de negocio, controladores, modelos, rutas y consultas a base de datos fueron desarrollados por el equipo. 


Firmado por:
Gabriela Vanessa Alberto Escalón 
Katherine Gisella Garay Alvarado
