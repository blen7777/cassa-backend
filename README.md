# CASSA Agrícola — Backend (Laravel)

API REST para la prueba técnica full-stack agrícola.

## Requisitos

- PHP 8.3+, Composer
- MySQL 8 (u otro motor relacional; ajustar `config/database.php` si se usa otro)

## Puesta en marcha

```bash
composer install
cp .env.example .env   # o crear .env con las variables de abajo
php artisan key:generate
```

Variables de entorno relevantes (`.env`):

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=cassa_agricola
DB_USERNAME=root
DB_PASSWORD=
FRONTEND_URL=http://localhost:5173
```

Crear la base de datos y ejecutar el esquema (las tablas de la prueba **no**
usan migraciones de Laravel, según lo indicado en el enunciado):

```bash
mysql -u root -e "CREATE DATABASE cassa_agricola;"
mysql -u root cassa_agricola < database/schema.sql
```

Levantar el servidor:

```bash
php artisan serve
```

## Esquema de base de datos

`database/schema.sql` contiene el DDL (`CREATE TABLE`, llaves foráneas e
índices) para `responsables`, `haciendas` y `lotes`, construido a partir de
`prueba_tenica_base_de_datos.html`.

## Endpoints principales

| Método | Ruta                                | Descripción                    |
|--------|--------------------------------------|---------------------------------|
| GET    | `/api/dashboard/summary`            | Contadores para el dashboard    |
| GET/POST | `/api/responsables`               | Listar / crear responsables     |
| PUT/DELETE | `/api/responsables/{id}`        | Editar / eliminar responsable   |
| GET/POST | `/api/haciendas`                  | Listar / crear haciendas        |
| PUT/DELETE | `/api/haciendas/{id}`           | Editar / eliminar hacienda      |
| GET/POST | `/api/haciendas/{id}/lotes`       | Listar / crear lotes de una hacienda |
| PUT/DELETE | `/api/haciendas/{id}/lotes/{loteId}` | Editar / eliminar lote     |
