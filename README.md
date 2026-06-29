# Prueba técnica - Catalogo de productos

Solución a la prueba técnica:

- **Parte 1** (Laravel + MySQL): CRUD de marcas y productos con validaciones, carga de imágenes y API REST.
- **Parte 2** (Next.js): catálogo público que consume la API, con búsqueda en tiempo real y modo oscuro.

```
prueba/         # Laravel 12 (PHP 8.2) + MySQL
prueba-next/    # Next.js 16 (TypeScript, CSS Modules)
```

---

## Requisitos

- PHP 8.2+
- Composer
- Node.js 18+
- MySQL (XAMPP o similar)

---

## Cómo ejecutar

### Parte 1 (Laravel) - http://127.0.0.1:8000

Crear la base de datos primero:
```sql
CREATE DATABASE catalogo;
```

```bash
cd prueba
composer install
copy .env.example .env
# completar los datos de MySQL en el .env
php artisan key:generate
php artisan migrate
php artisan storage:link
php artisan serve
```

API disponible en `GET /api/products?q=&page=`

### Parte 2 (Next.js) - http://localhost:3000

```bash
cd prueba-next
npm install
npm run dev
```

El backend tiene que estar corriendo para que el catálogo funcione.

---

## Decisiones de modelo

### Marca
- `name` - nombre de la marca
- `reference` - código único sin espacios (validado con regex en servidor y HTML)

### Producto
- `unit` - solo acepta Unidad, Display o Caja
- `price` - entero sin decimales. El input usa `type="text"` con `inputmode="numeric"` para que el navegador no permita escribir puntos o comas
- `image` - opcional, se convierte a WebP automáticamente con máximo 800px de ancho
- `brand_id` - FK con RESTRICT, no se puede borrar una marca si tiene productos

Las validaciones quedaron en los controladores, no se usaron Form Requests.

---

## Parte 2 - Componentes

- **Navbar** - navegación con toggle de modo oscuro
- **ProductCatalog** - búsqueda con debounce de 300ms y paginación
- **ProductCard** - imagen, nombre, marca, observaciones y precio
- **ThemeToggle** - alterna entre claro y oscuro, guarda preferencia en localStorage

---

## Librerías usadas

| Librería | Uso |
|----------|----------|
| Laravel 12 | backend, CRUD, API |
| Bootstrap 5.3 | estilos del admin |
| Next.js 16 | frontend |
| TypeScript | tipado |
| CSS Modules | estilos del catálogo |
