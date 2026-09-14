# Blood Pressure Tracker

> **State:** Not installed/cannot run yet in this copy — `vendor/`, `node_modules/`, `.env`, and `public/build` are all absent on disk. This documents the intended application.
>
> **Stack:** Laravel 11 + Blade + Bootstrap 5.3 (CDN). Formerly Vue 3 + Inertia.js (removed in commit `3bcf0c8`) — do not treat this as an SPA project. Do not trust git history or prior sessions that describe it as Vue/Inertia or as "installed".

A Laravel 11 + Blade + Bootstrap web application for tracking and managing blood pressure readings with user authentication.

> **Status:** The frontend was migrated from **Vue 3 + Inertia.js** to a **pure server-rendered Blade + Bootstrap** stack (see git commit `3bcf0c8`). Do not treat this as an SPA project.

## Features

- **User Authentication** - Laravel Breeze (login, register, email verification, password reset)
- **Blood Pressure CRUD** - Full create, read, update, delete functionality with ownership protection
- **Notes System** - Optional contextual notes per reading
- **App-level authorization** - Users can only edit/delete their own blood pressure records
- **Database Seeded** - Optional sample data via `BPSampleSeeder`

## Stack

- **Backend:** Laravel 11
- **Frontend:** Blade + Bootstrap 5.3 (CDN, vendored via `npm` devDependency)
- **Auth:** Laravel Breeze (`app/Http/Controllers/Auth`, `resources/views/auth`)
- **Realtime:** Laravel Sanctum + Inertia removed (no Inertia/Ziggy in current code)
- **Database:** SQLite (default) / MySQL / PostgreSQL via `.env`
- **Testing:** PHPUnit 11
- **Linting:** Laravel Pint (`laravel/pint`)

## System Requirements

- PHP 8.2 to <9.0
- Composer
- Node.js 18+ (for Vite build)

## Quick Setup

```bash
# Clone repository
git clone <repo-url>
cd luffof

# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Create + populate the SQLite database
touch database/database.sqlite
php artisan migrate --force
php artisan db:seed --class=BPSampleSeeder

# Start development server
php artisan serve
```

Open http://localhost:8000

## Development Commands

```bash
# Serve application
php artisan serve

# Start the dev server (Vite is used, not `npm run dev` for a non-SPA app)
# If you need hot-reload asset building: npm run dev

# Run test suite
vendor/bin/phpunit

# Run with coverage
vendor/bin/pause          # pa\laravel/pail
vendor/bin/phpunit --testdox

# Lint / format
composer run lint          # Pint
```

## Ephemeral Environment

The application uses `.env` for configuration. The sensitive environment file should never be committed. It is reproduced from `.env.example` on a fresh composer install and is excluded via `.gitignore`.

## Database Setup

The application uses SQLite by default. For MySQL/MariaDB:

```bash
# Edit .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=

# Run migrations + seed
php artisan migrate --force
php artisan db:seed --class=BPSampleSeeder
```

## Project Structure

```
luffof/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   └── Bp/BpController.php       # BP CRUD controller (namespaced in app/Http/Controllers/Bp/)
│   │   └── Controllers/Auth/             # Breeze controllers
│   │   └── Controllers/ProfileController.php
│   └── Models/
│       └── BloodPressure.php             # BP model with user relationship
├── database/
│   ├── factories/                        # UserFactory only (no BloodPressureFactory yet)
│   ├── migrations/
│   │   └── 2026_04_19_050428_create_blood_pressures_table.php
│   └── seeders/
│       └── BPSampleSeeder.php            # Sample BP data
├── resources/
│   └── views/
│       ├── layouts/
│       │   ├── app.blade.php             # Authenticated layout (navbar)
│       │   └── guest.blade.php           # Guest/auth layout
│       ├── auth/                         # Breeze views
│       ├── bp/
│       │   ├── index.blade.php           # List all BP records
│       │   ├── create.blade.php          # Create form
│       │   ├── show.blade.php            # Single record
│       │   ├── edit.blade.php            # Edit form
│       │   └── bpController referenced by /bp/* routes
│       ├── dashboard.blade.php
│       └── welcome.blade.php
├── routes/
│   ├── web.php
│   └── auth.php
├── tests/
│   ├── Feature/
│   │   └── BloodPressureTest.php         # Only real feature test
│   └── Unit/
│       └── ExampleTest.php
├── composer.json
└── package.json
```

## Routes

| URL | Method | Controller | Description |
| --- | --- | --- | --- |
| `/` | `GET` | closure | Welcome page (landing) |
| `/dashboard` | `GET` | closure | Protected (`auth`.`verified`) |
| `/bp` | `GET` | `BpController@index` | List all BP records |
| `/bp/create` | `GET` | `BpController@create` | Show create form |
| `/bp` | `POST` | `BpController@store` | Store new BP record |
| `/bp/{bp}` | `GET` | `BpController@show` | Show single record |
| `/bp/{bp}/edit` | `GET` | `BpController@edit` | Show edit form |
| `/bp/{bp}` | `PATCH` | `BpController@update` | Update BP record |
| `/bp/{bp}` | `DELETE` | `BpController@destroy` | Delete BP record |
| `/profile` | `GET` | `ProfileController@edit` | Edit profile |
| `/profile` | `PATCH` | `ProfileController@update` | Update profile |
| `/profile` | `DELETE` | `ProfileController@destroy` | Delete account |

## Blood Pressure Classification

No explicit "status" column exists on `blood_pressures`; records are visually classified by thresholds:

| Systolic | Diastolic | Status |
| --- | --- | --- |
| 80–120 | 60–80 | Optimal |
| 80–120 | 81–90 | High Normal |
| 121–139 | 81–89 | Elevated |
| ≥140 | ≥90 | Hypertension |

Validation on the forms: systolic `80–250`, diastolic `60–120`.

## Testing

Run all tests:

```bash
vendor/bin/phpunit
```

Run the blood pressure feature tests specifically:

```bash
vendor/bin/phpunit tests/Feature/BloodPressureTest.php
```

The current suite covers authentication-gated routes and the BP CRUD lifecycle (create, update, delete with ownership checks). Note that this project has historically shipped with a very small set of tests; consider expanding `Feature/` coverage (`ProfileTest`, `AuthenticationTest`, etc.).

## Sample Data

Loads a couple of users with several readings each:

```bash
php artisan db:seed --class=BPSampleSeeder
```

> **Note:** The current seeder has a bug — it seeds BP records for only one of the created users (the loop body only executes on `$users->slice(0, 1)`). See `BPSampleSeeder::run()` and `database/seeders/BPSampleSeeder.php`.

## API

None implemented. A Sanctum token endpoint would be the natural next addition, but no `routes/api.php` exists. Sanctum is not actually installed / `vendor/` is required before this runs.

## Contributing

1. Create feature branch
2. Make changes
3. Test your changes
4. Submit pull request

## License

MIT License

## Notes

- **Blade is the primary delivery mechanism**, not Inertia/Vue.
- Styling is provided by **Bootstrap 5.3** loaded from a CDN in the layout files, not Tailwind.
- Authentication uses Laravel Breeze.
- Run `php artisan migrate --force` before seeding to populate the SQLite database.
