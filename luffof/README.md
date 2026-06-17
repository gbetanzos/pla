# Blood Pressure Tracker

A Laravel 11 + Inertia.js application for tracking and managing blood pressure readings with user authentication.

## Features

- **User Authentication** - Laravel Breeze with Vue.js
- **Blood Pressure CRUD** - Full create, read, update, delete functionality
- **Health Status Indicators** - Visual status (Normal/Elevated/High) based on systolic/diastolic ranges
- **Notes System** - Add contextual notes to each reading
- **Database Seeded** - Sample data for testing

## Stack

- **Backend**: Laravel 11.31
- **Frontend**: Vue 3.4 + Inertia.js 2.0
- **Styling**: Tailwind CSS 3.2
- **Database**: SQLite (production-ready)
- **Testing**: PHPUnit 11.0

## System Requirements

- PHP 8.2.0 to <9.0
- Composer
- Node.js 18+

## Quick Setup

```bash
# Install PHP 8.2 (if not installed)
# Ubuntu/Debian:
sudo apt install php8.2 php8.2-cli php8.2-mysql php8.2-pdo php8.2-sqlite3 php8.2-xml php8.2-curl php8.2-mbstring php8.2-zip

# Clone repository
git clone <repo-url>
cd luffof

# Install dependencies
composer install
npm install

# Setup environment
php artisan env

# Create SQLite database
touch database/database.sqlite

# Run migrations
php artisan migrate --force

# Seed sample data
php artisan db:seed --class=BPSampleSeeder

# Start development server
php artisan serve

# Open in browser
# http://localhost:8000/bp
```

## Development Commands

```bash
# Serve application
php artisan serve

# Hot reload with Vite
npm run dev

# Run dev server with console
npm run dev

# Lint and type check
composer run lint
npm run lint

# Unit tests
vendor/bin/phpunit

# Run with coverage
vendor/bin/phpunit --coverage

# View application logs
tail -f storage/logs/laravel.log
```

## Database Setup

The application uses SQLite by default. For MySQL/MariaDB:

```bash
# Edit .env
# Change DB_CONNECTION=mysql
# Set DB_HOST, DB_DATABASE, DB_USERNAME, DB_PASSWORD

# Run migrations
php artisan migrate

# Seed data
php artisan db:seed
```

## Project Structure

```
luffof/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   └── BpController.php          # BP CRUD controller
│   │   └── Contracts/
│   │       └── BloodPressure.php          # BP status contract
│   └── Models/
│       └── BloodPressure.php              # BP model with user relationship
├── database/
│   ├── factories/
│   │   └── BloodPressureFactory.php       # BP factory for testing
│   ├── migrations/
│   │   └── 2026_04_19_050428_..._table.php
│   └── seeders/
│       └── BPSampleSeeder.php             # Sample BP data
├── resources/
│   ├── js/
│   │   └── Pages/
│   │       └── Bp/
│   │           ├── Index.vue              # List all BP records
│   │           └── Edit.vue               # Create/Edit form
│   └── views/
│       └── bp/
│           ├── index.blade.php            # Blade index view
│           ├── create.blade.php           # Blade create view
│           ├── show.blade.php             # Blade show view
│           └── edit.blade.php             # Blade edit view
├── routes/
│   └── web.php                            # BP CRUD routes (/bp/*)
├── tests/
│   └── Feature/
│       └── BloodPressureTest.php          # Feature tests
├── composer.json
├── package.json
└── README.md
```

## Routes

| URL | Method | Controller | Description |
|-----|--------|------------|-------------|
| `/bp` | GET | `BpController@index` | List all BP records |
| `/bp/create` | GET | `BpController@create` | Show create form |
| `/bp` | POST | `BpController@store` | Store new BP record |
| `/bp/{id}` | GET | `BpController@show` | Show single record |
| `/bp/{id}/edit` | GET | `BpController@edit` | Show edit form |
| `/bp/{id}` | PUT | `BpController@update` | Update BP record |
| `/bp/{id}` | DELETE | `BpController@destroy` | Delete BP record |

## Health Status Ranges

| Systolic | Diastolic | Status | Color |
|----------|-----------|--------|-------|
| ≤120 | ≤80 | Normal | Green |
| ≤130 | ≤80 | Elevated | Yellow |
| >130 or >80 | - | High | Red |

## Unit Tests

Run all tests:
```bash
vendor/bin/phpunit
```

Run with coverage:
```bash
vendor/bin/phpunit --coverage
```

Run specific test file:
```bash
vendor/bin/phpunit tests/Feature/BloodPressureTest.php
```

With Laravel Pail (composer plugin):
```bash
composer run test
```

### Test Coverage

The test suite includes:
- ✅ Authentication requirements
- ✅ Create/Store with validation
- ✅ Update functionality
- ✅ Delete with ownership protection  
- ✅ View rendering with status indicators
- ✅ Error handling and redirects

## Sample Data

Run this seeder to get sample blood pressure readings:

```bash
php artisan db:seed --class=BPSampleSeeder
```

Creates:
- 2 users with 5 BP readings each
- Mix of systolic/diastolic values
- Sample notes for each reading

## API (Optional)

The application can expose an API using Laravel Sanctum. Currently:
- Sanctum is configured but routes not yet defined
- Authentication token management ready
- Add API routes in `routes/api.php` when needed

## Contributing

1. Create feature branch
2. Make changes
3. Test your changes
4. Submit pull request

## License

MIT License

## Notes

- Blade views are the primary delivery mechanism (production-ready)
- Vue components exist for potential SPA features
- Application uses Laravel Breeze for authentication
- No database seeding - run `php artisan db:seed` to load sample data
