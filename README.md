# CryptoLog - Backend
Proyecto de servidor para la gestión de usuarios, autenticación, transacciones y seguridad de la aplicación CryptoLog, utilizando Laravel Breeze, Sanctum y MySQL.

## 📄 Descripción
CryptoLog - Backend es el servidor encargado de gestionar los usuarios, autenticación, transacciones y la seguridad de la aplicación CryptoLog. Utiliza Laravel Breeze con Sanctum para proporcionar una autenticación simple y rápidamente escalable. Además, se integra con MySQL para almacenar los datos de forma persistente.

## 📚 Instalación

1. Clona el repositorio:

```bash
git clone https://github.com/DevDesiree/PE11-CryptoLog_BackEnd.git
```

2. Instalación de dependencias:

Asegúrate de tener PHP y Composer instalados en tu sistema.
En la terminal, navega hasta la carpeta del proyecto y ejecuta:

```bash
composer install
```

3. Configuración del entorno:

Crea un archivo .env en la raíz del proyecto y configura las variables de entorno necesarias, como la conexión a la base de datos MySQL.

4. Configuración de la base de datos:

Crea una base de datos MySQL para el proyecto y configura las credenciales en el archivo .env.

5. Ejecuta las migraciones para crear las tablas necesarias en la base de datos:
```bash
php artisan migrate
```

6. Ejecución del servidor:

```bash
php artisan serve
```

Esto iniciará el servidor. Asegúrate de que esté funcionando correctamente antes de usar la aplicación frontend.

## 📕 Rutas
- `/register` (POST): Registro de nuevos usuarios.
- `/login` (POST): Inicio de sesión de usuarios existentes.
- `/json` (GET): Obtener datos en formato JSON.
- `/updateJson` (GET): Actualizar datos JSON en caché.
- `/transactions` (GET): Obtener todas las transacciones.
- `/transactions/{id}` (GET): Obtener una transacción específica por ID.
- `/create-transaction` (POST): Crear una nueva transacción.
- `/update-transaction/{id}` (PUT): Actualizar una transacción existente por ID.
- `/delete-transaction/{id}` (DELETE): Eliminar una transacción existente por ID.
- `/favorite-coins` (GET): Obtener todas las monedas favoritas del usuario.
- `/favorite-coins` (POST): Agregar una nueva moneda favorita para el usuario.
- `/favorite-coins/{id}` (DELETE): Eliminar una moneda favorita del usuario por ID.
- `/profile` (GET): Obtener el perfil del usuario.
- `/update-profile` (POST): Actualizar el perfil del usuario.
- `/historicals` (GET): Obtener el historial del usuario.


## 💻 Tecnologías Utilizadas
Laravel, Breeze y Sanctum
PHP
MySQL

## 👩‍💻 Autora
*Desiree Sánchez*