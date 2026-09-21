# Diseño técnico — Backend

Ver requerimientos completos en [`requirements.md`](./requirements.md).

## Base de datos

- Motor: MySQL 8 (local, vía Laragon). Compatible con cualquier motor relacional.
- Esquema creado directamente por SQL (`database/schema.sql`), **sin** migraciones
  de Laravel, según lo exigido por la especificación.
- Tablas: `responsables`, `haciendas`, `lotes` (FK `lotes.hacienda_id → haciendas.id`).
- Modelos Eloquent (`app/Models/*`) mapean estas tablas vía `$table` explícito.

## API REST

Base: `/api`. Sin autenticación real (HU1 es solo frontend con credenciales estáticas).

| Método | Ruta | Controller | Notas |
|---|---|---|---|
| GET | `/dashboard/summary` | `DashboardController@summary` | Conteos activos de las 3 entidades |
| GET | `/dashboard/haciendas-overview` | `DashboardController@haciendasOverview` | Detalle por hacienda: lotes (activos/total) y hectáreas totales, vía `withCount`/`withSum` |
| GET/POST | `/responsables` | `ResponsableController` | |
| GET/PUT/DELETE | `/responsables/{id}` | `ResponsableController` | |
| GET/POST | `/haciendas` | `HaciendaController` | |
| GET/PUT/DELETE | `/haciendas/{id}` | `HaciendaController` | Delete devuelve 409 si tiene lotes asociados (FK) |
| GET/POST | `/haciendas/{hacienda}/lotes` | `LoteController` | Anidado, filtra por hacienda |
| PUT/DELETE | `/haciendas/{hacienda}/lotes/{lote}` | `LoteController` | |

## CORS

`config/cors.php` permite origen `FRONTEND_URL` (`http://localhost:5173`).
En desarrollo el frontend usa el proxy de Vite (`/api` → `127.0.0.1:8000`), por lo
que CORS no llega a activarse en local; queda configurado para despliegues separados.

## Seguridad de la API

- **Rate limiting**: `throttleApi('api')` en `bootstrap/app.php` + limiter
  `RateLimiter::for('api', ...)` en `AppServiceProvider` — 60 req/min por IP
  en todas las rutas `/api/*`. Headers `X-RateLimit-Limit` / `-Remaining`
  verificados.
- **IDOR en rutas anidadas**: `LoteController@update`/`@destroy` recibían
  `Lote $lote` con binding implícito global, permitiendo editar/eliminar un
  lote de OTRA hacienda pasando su id por una URL con `hacienda_id`
  incorrecto (ej. `PUT /haciendas/2/lotes/1` donde el lote 1 es de la
  hacienda 1). Corregido: el lote ahora se resuelve vía
  `$hacienda->lotes()->findOrFail($loteId)`, forzando que pertenezca a la
  hacienda de la URL o devuelva 404.

## Decisiones

- MySQL en vez de SQL Server: entorno local (Laragon) ya tenía MySQL disponible,
  ahorra tiempo de setup bajo la ventana de 1 hora. Cumple "cualquier motor relacional".
- Validación de eliminación con integridad referencial: se captura `QueryException`
  en `HaciendaController@destroy` y se responde 409 con mensaje claro en vez de un 500 genérico.
