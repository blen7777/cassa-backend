# CASSA Agrícola — Backend (Laravel)

API REST para la prueba técnica full-stack agrícola: gestión de haciendas,
lotes y responsables, más un dashboard de resumen. Repo hermano del
frontend: [`cassa-frontend`](https://github.com/blen7777/cassa-frontend).

> **Spec-driven development:** todo cambio futuro debe partir de lo documentado
> en [`specs/`](./specs/requirements.md) (requerimientos, diseño técnico y
> tareas). Si un cambio no está reflejado ahí, actualizar los specs primero.

## Estructura del proyecto

```
backend/
├── app/
│   ├── Http/Controllers/    # ResponsableController, HaciendaController,
│   │                        # LoteController, DashboardController, HealthController
│   ├── Models/               # Hacienda, Lote, Responsable, User
│   └── Providers/            # AppServiceProvider (rate limiter "api")
├── database/
│   └── schema.sql            # DDL de responsables/haciendas/lotes (sin migraciones)
├── routes/
│   ├── api.php                # Rutas /api/* (REST + anidadas)
│   └── web.php
├── specs/                     # Requerimientos, diseño y tareas (spec-driven dev)
│   ├── requirements.md
│   ├── design.md
│   ├── tasks.md
│   ├── database/schema-spec.html
│   └── requirements/prueba-tecnica-fullstack.pdf
└── config/                    # cors.php, database.php, etc.
```

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
[`specs/database/schema-spec.html`](./specs/database/schema-spec.html).
**No usan migraciones de Laravel** — se crean directamente con ese script.

### `responsables`

| Campo | Tipo | Nulo | Notas |
|---|---|---|---|
| id | INT PK autoincrement | No | |
| nombre | VARCHAR(150) | No | |
| apellido | VARCHAR(150) | Sí | |
| correo | VARCHAR(255) | Sí | |
| telefono | VARCHAR(30) | Sí | |
| estatus | TINYINT(1) | No | Default `1` (Activo). Indexado. |
| created_at / updated_at | TIMESTAMP | Sí | |

### `haciendas`

| Campo | Tipo | Nulo | Notas |
|---|---|---|---|
| id | INT PK autoincrement | No | |
| nombre | VARCHAR(200) | No | |
| ubicacion | VARCHAR(255) | Sí | |
| estatus | TINYINT(1) | No | Default `1` (Activo). Indexado. |
| created_at / updated_at | TIMESTAMP | Sí | |

### `lotes`

| Campo | Tipo | Nulo | Notas |
|---|---|---|---|
| id | INT PK autoincrement | No | |
| hacienda_id | INT FK → haciendas.id | No | Indexado |
| nombre | VARCHAR(200) | No | |
| hectareas | DECIMAL(12,2) | Sí | |
| estatus | TINYINT(1) | No | Default `1` (Activo). Indexado. |
| created_at / updated_at | TIMESTAMP | Sí | |

**Relación:** una hacienda tiene muchos lotes (`haciendas 1—N lotes`).

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
| GET | `/api/dashboard/haciendas-overview` | Detalle por hacienda (lotes/hectáreas) |
| GET | `/api/health` | Verifica conexión a la base de datos |

## Seguridad

- Rate limiting: 60 solicitudes/min por IP en todas las rutas `/api/*`.
- Rutas anidadas de lotes (`/haciendas/{id}/lotes/{loteId}`) validan que el
  lote pertenezca a esa hacienda antes de editar/eliminar (evita IDOR).
- Detalle completo en [`specs/design.md`](./specs/design.md#seguridad-de-la-api).
