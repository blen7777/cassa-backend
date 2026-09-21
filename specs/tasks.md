# Tareas — Backend

Estado respecto a [`requirements.md`](./requirements.md).

- [x] Esquema SQL (`database/schema.sql`) creado según `database/schema-spec.html`
- [x] Modelos Eloquent: `Hacienda`, `Lote` (con relación `hasMany`), `Responsable`
- [x] `DashboardController@summary` — HU3
- [x] `ResponsableController` CRUD completo — HU4
- [x] `HaciendaController` CRUD completo + manejo 409 en delete con lotes — HU5
- [x] `LoteController` CRUD anidado y filtrado por hacienda — HU6
- [x] Rutas `api.php` (apiResource + nested resource)
- [x] CORS configurado para `FRONTEND_URL`
- [x] Datos semilla para demo (`database/schema.sql` no las incluye; insertadas manualmente en local)
- [x] Verificación end-to-end vía curl (create/update/delete/validaciones/409)

## Pendiente / mejoras futuras

- [ ] Seeder formal (`DatabaseSeeder`) para reproducir datos demo sin SQL manual
- [ ] Tests automatizados (Pest/PHPUnit) de los controllers
- [ ] Paginación en listados si el volumen de datos crece
