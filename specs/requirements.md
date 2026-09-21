# Requerimientos — Prueba Técnica Full-Stack Agrícola (CASSA)

Fuente original: [`requirements/prueba-tecnica-fullstack.pdf`](./requirements/prueba-tecnica-fullstack.pdf).
Esquema de base de datos: [`database/schema-spec.html`](./database/schema-spec.html).

Stack: Laravel (backend) + React (frontend). Repos separados (frontend / backend).

## HU1 — Autenticación y Protección de Accesos (Login) — Frontend (15 pts)

**Como** usuario del sistema, **quiero** iniciar sesión con credenciales predefinidas,
**para** acceder de forma segura a las rutas protegidas.

- Pantalla de login visualmente atractiva.
- Credenciales estáticas: usuario `devcassa` / contraseña `cassa123`.
- No requiere conexión a BD ni JWT real.
- Todas las rutas internas protegidas; sin sesión activa → redirigir a `/login`.

Evaluado: route guards, manejo de estado global, limpieza de estado en logout.

## HU2 — Estructura Base y Navegación — Frontend (10 pts)

**Como** usuario autenticado, **quiero** un menú lateral, **para** moverme entre módulos.

- Layout principal que envuelve las vistas protegidas.
- Sidebar con: Dashboard, Haciendas, Responsables.
- Botón visible de cierre de sesión.

Evaluado: estructuración de componentes compartidos, uso de React Router.

## HU3 — Dashboard Principal (Resumen) — Frontend + Backend (15 pts)

**Como** administrador agrícola, **quiero** un resumen de entidades activas, **para**
tener panorama rápido al iniciar sesión.

- Pantalla por defecto tras login.
- 3 cards: Haciendas activas, Lotes activos, Responsables activos.
- Datos reales desde la base de datos.

Evaluado: diseño de tarjetas, integración con endpoints GET de agregación.

## HU4 — Gestión de Responsables (CRUD) — Frontend + Backend (15 pts)

- Listado de responsables.
- Crear, editar, eliminar.
- Campo `estatus` (Activo/Inactivo).

Evaluado: diseño de BD + API REST, formularios y validaciones, refresco de UI tras cada operación.

## HU5 — Gestión de Haciendas y Navegación a Lotes — Frontend + Backend (15 pts)

- Listado de haciendas con estatus.
- Crear, editar, eliminar.
- Clic en una hacienda → navega a `/haciendas/:id/lotes` pasando el contexto.

Evaluado: diseño de API/modelo relacional, navegación dinámica con parámetros en URL.

## HU6 — Gestión de Lotes por Hacienda (CRUD) — Frontend + Backend (10 pts)

- Listado de lotes filtrado únicamente por la hacienda seleccionada.
- Crear, editar, eliminar lotes vinculados a esa hacienda.

Evaluado: llaves foráneas y consultas filtradas en backend, manejo de contexto/estado en frontend.

## Consideraciones transversales (20 pts)

| Criterio | Detalle | Pts |
|---|---|---|
| Prevención de errores | Modal de confirmación antes de eliminar (Haciendas, Lotes, Responsables) | 5 |
| Diseño moderno (UI) | Sistema de diseño coherente; TailwindCSS o librería de componentes | 5 |
| Buena UX | Loading states, toasts de éxito/error, manejo de estados vacíos | 5 |
| Buenas prácticas | Código limpio, componentes modulares, nomenclatura consistente, variables de entorno | 5 |

## Restricciones del entregable

- Las tablas de negocio (`responsables`, `haciendas`, `lotes`) **no** se crean con
  migraciones de Laravel — se asumen ya existentes, creadas vía script `.sql`
  (ver [`database/schema-spec.html`](./database/schema-spec.html) para el DDL exacto).
- Motor recomendado: SQL Server; se permite cualquier motor relacional (este proyecto usa MySQL).
- Ventana de tiempo: 1 hora desde el inicio; se evalúa el último commit antes del corte.
