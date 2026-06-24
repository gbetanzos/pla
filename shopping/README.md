<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Shopping List App - Grocery Dashboard

A full-featured Laravel web application for managing grocery shopping lists and product catalogs. Features user authentication, product catalog with search/filter, shopping lists with priorities, and interactive item management.

### Features

- **Product Catalog**: Browse, search, filter by priority/category, add/edit/delete products
- **Shopping Lists**: Create multiple lists with titles, descriptions, and due dates
- **Item Management**: Add items from catalog, toggle completion with checkboxes, mark lists complete
- **Priorities**: Visual color-coding (High/Medium/Low) for items and lists
- **User Accounts**: Individual lists per user, personal product library
- **Responsive UI**: Single-page Bootstrap-styled interface with inline styles

### Tech Stack

- **Laravel**: 11.54.0
- **PHP**: 8.3+
- **Database**: SQLite (with support for MySQL/PostgreSQL)
- **Composer**: PHP dependency management
- **Vue.js**: For checkbox toggle logic

### Getting Started

#### Prerequisites

- PHP 8.3+
- Composer
- Docker (optional)

#### Installation

```bash
cd /shopping

# Install dependencies
composer install

# Setup .env (first run)
cp .env.example .env
php artisan key:generate

# Create database file and run migrations
php artisan migrate:fresh --seed --path=database/database.sqlite

# Start the server
php artisan serve --host=0.0.0.0 --port=8000
```

#### Docker Setup

```bash
# Build and run with Docker Compose
docker-compose up --build

# View logs
docker-compose logs -f app
```

**Docker Compose Setup:**

```yaml
version: '3.8'

services:
  app:
    build:
      context: .
      dockerfile: Dockerfile
    container_name: shopping-app
    ports:
      - "8000:8000"
    volumes:
      - .:/var/www/shopping
    environment:
      - APP_ENV=local
      - APP_DEBUG=true
      - DB_CONNECTION=sqlite
    networks:
      - shopping-net

networks:
  shopping-net:
    driver: bridge
```

**Dockerfile Setup:**

```dockerfile
FROM php:8.3-cli

RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip && \
    pecl install zip pdo_sqlite && \
    docker-php-ext-enable zip pdo_sqlite && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer

WORKDIR /var/www/shopping
COPY . .
RUN composer install --no-dev --optimize-autoloader

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
```

### Usage

1. **Visit**: http://localhost:8000
2. **Products**: Browse `/products` to view catalog
3. **Create List**: Visit `/shopping-list/create`
4. **Add Items**: On a list, click items from product catalog
5. **Manage**: Toggle items, mark complete, delete with confirmation
6. **Priority**: Use visual cues (red/yellow/green) for urgency

### Project Structure

```
shopping/
├── app/
│   ├── Http/Controllers/
│   │   ├── ProductController.php
│   │   └── ShoppingListController.php
│   ├── Models/
│   │   ├── User.php
│   │   ├── Product.php
│   │   └── ShoppingList.php
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   └── views/
│       ├── layouts/
│       └── {shop,products,services}/
├── routes/
│   └── web.php
├── Dockerfile
├── docker-compose.yml
└── AGENTS.md
```

### API Endpoints

| Route | Method | Description |
|-------|--------|-------------|
| `/` | GET | Home - Paginated list of all shopping lists |
| `/products` | GET | Product catalog with search/filter |
| `/product/{id}` | GET | Product detail |
| `/product/{id}/edit` | GET | Edit product form |
| `/shopping-list` | GET | List all shopping lists |
| `/shopping-list/create` | GET | Create new list |
| `/shopping-list/{id}` | GET | View list with items |
| `/shopping-list/{id}/toggle` | POST | Toggle item checkbox |
| `/shopping-list/{id}/mark-complete` | POST | Mark list complete |

### Database Schema

**Products Table:**
```sql
CREATE TABLE products (
    id INTEGER PRIMARY KEY,
    name TEXT NOT NULL,
    brand TEXT,
    notes TEXT,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

**Shopping Lists Table:**
```sql
CREATE TABLE shopping_lists (
    id INTEGER PRIMARY KEY,
    user_id INTEGER,
    title TEXT NOT NULL,
    description TEXT,
    priority ENUM('high','medium','low'),
    due_date DATE,
    items TEXT,  -- JSON: [{"product_id":1, "checked":false}]
    is_completed BOOLEAN,
    completed_at TIMESTAMP,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);
```

### License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

### Key Files

- `routes/web.php` - All CRUD routes
- `app/Http/Controllers/ProductController.php` - Product management
- `app/Http/Controllers/ShoppingListController.php` - List management
- `resources/views/*/` - Blade templates
- `AGENTS.md` - Development progress log
