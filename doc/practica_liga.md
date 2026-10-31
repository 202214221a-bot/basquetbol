# Documentación técnica: Gestión de Liga de Básquetbol

## 1. Arquitectura general

La aplicación está desarrollada con **PHP 8.2** y **Laravel 12**, usa **MySQL** como base de datos (`basquetbol`) y se versionó con **Git**, con el repositorio en **GitHub**. Sigue el patrón **MVC** de Laravel:

- **Rutas** (`routes/web.php`): asocian cada dirección con un método de controlador. Se dividen en dos grupos con *middleware*: `guest` (registro e ingreso) y `auth` (todo lo demás).
- **Controladores** (`app/Http/Controllers`): validan los datos y coordinan modelos y vistas.
- **Modelos Eloquent** (`app/Models`): representan las tablas y sus relaciones.
- **Vistas Blade** (`resources/views`): todas extienden `plantillas/principal.blade.php`, que contiene el menú y los mensajes de aviso. El menú marca la sección actual con `request()->routeIs()`.
- **Migraciones** (`database/migrations`): definen las tablas como código versionado.
- **Estilos** (`public/css/estilos.css`): un solo archivo con los colores en variables CSS.

## 2. Clases implementadas

| Tipo | Clases |
|---|---|
| Modelos | `User`, `Equipo`, `Jugador`, `Partido` |
| Controladores | `AutenticacionController`, `EquipoController`, `JugadorController`, `PartidoController`, `EstadisticaController` |

Relaciones: un `Equipo` tiene muchos `Jugador` (`hasMany`); un `Jugador` pertenece a un `Equipo` (`belongsTo`); un `Partido` pertenece a dos equipos, el local y el visitante, mediante `equipo_local_id` y `equipo_visitante_id`.

## 3. Funcionalidades principales

- **Autenticación:** registro con validación, inicio y cierre de sesión con `Auth`.
- **Equipos:** crear, listar, editar y eliminar, con nombre único.
- **Jugadores:** gestión por equipo, con dorsal único dentro del equipo.
- **Partidos:** programación y registro de resultados.
- **Estadísticas:** tabla de posiciones, resumen de la liga y últimos resultados.
- **Inicio:** totales, líder actual y próximos partidos (`EstadisticaController::inicio`).

Todos los módulos siguen el mismo flujo: la ruta llama al controlador, este valida con `$request->validate()`, el modelo guarda o consulta, y se devuelve una vista o una redirección con un mensaje. Los formularios incluyen `@csrf` y Blade escapa lo que se imprime con `{{ }}`, lo que protege contra CSRF y XSS.

## 4. Fragmentos relevantes

**Dorsal único por equipo** (`JugadorController`). La regla `unique` se limita al equipo y se ignora al jugador que se edita:

```php
Rule::unique('jugadores', 'dorsal')
    ->where('equipo_id', $equipo->id)
    ->ignore($jugador?->id)
```

**Sin empates** (`PartidoController`). Laravel no trae una regla para esto, por eso se lanza una excepción de validación manual:

```php
if ((int) $datos['puntos_local'] === (int) $datos['puntos_visitante']) {
    throw ValidationException::withMessages([
        'puntos_local' => 'En básquetbol no hay empates.',
    ]);
}
```

**Tabla de posiciones** (`Partido::tablaPosiciones`). Se recorren los partidos finalizados de cada equipo, se acumulan victorias y puntos, y se ordena por puntos de liga y diferencia:

```php
->sort(function ($a, $b) {
    return [$b->puntos_liga, $b->diferencia] <=> [$a->puntos_liga, $a->diferencia];
})
```

## 5. Problemas encontrados y soluciones

1. **Tablas en SQLite.** Laravel viene configurado con SQLite y las primeras migraciones no aparecían en MySQL. Se cambió `DB_CONNECTION=mysql` en `.env` y `.env.example` y se limpió la caché con `php artisan config:clear`.
2. **Nombres en español.** Laravel pluraliza en inglés y de `Jugador` deduciría `jugadors`. Se definió `$table = 'jugadores'` en el modelo y la migración se creó con ese nombre.
3. **Doble cifrado de contraseña.** `User` ya tiene el cast `hashed`; usar además `Hash::make` cifraría dos veces y el ingreso fallaría. Se deja que el modelo la cifre.
4. **Editar sin chocar consigo mismo.** Las reglas `unique` de nombre y dorsal rechazaban el propio registro; se resolvió con `->ignore()`.
5. **Ruta de ingreso.** Laravel envía a quien no inició sesión a la ruta llamada `login`; por eso esa ruta conserva ese nombre aunque las demás estén en español.
6. **Dos relaciones al mismo modelo.** `Partido` apunta dos veces a `Equipo`; se declararon dos `belongsTo` con su clave foránea y se usó `with()` para evitar consultas repetidas.

## 6. Decisiones técnicas y justificación

- **Laravel:** ofrece validación, protección CSRF, ORM y autenticación ya probados.
- **Migraciones:** el esquema queda en el historial de Git y se reproduce con `php artisan migrate`.
- **`cascadeOnDelete`:** al eliminar un equipo se borran sus jugadores y partidos, evitando datos huérfanos.
- **Posiciones calculadas, no guardadas:** nunca quedan desactualizadas al editar o eliminar partidos.
- **Un formulario para crear y editar:** `$modelo->exists` decide el título y la dirección, y evita duplicar vistas.
- **Nombres y direcciones en español:** salvo lo que Laravel exige (`User`, `email`, `password`, `index`, `store`, `login`). Las direcciones `/crear` y `/editar` se configuraron con `Route::resourceVerbs`.
- **Ramas por módulo y pull requests:** cada módulo se desarrolló en una rama `feature/` y se unió a `main` con un pull request.

## 7. Ejecución

1. `composer install`
2. Copiar `.env.example` a `.env` y ejecutar `php artisan key:generate`
3. Crear la base `basquetbol` en MySQL.
4. `php artisan migrate`
5. `php artisan serve` y abrir `http://127.0.0.1:8000`