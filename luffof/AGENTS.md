# LuffoF - Laravel 11 Blood Pressure Tracker

## Project Overview
Blood pressure tracking application built with:
- **Backend**: Laravel 11
- **Frontend**: Blade + Bootstrap 5.3 (server-rendered, CDN)
- **Authentication**: Laravel Breeze
- **Database**: SQLite (default), MySQL/PostgreSQL via `.env`
- **Testing**: PHPUnit 11
- **Realtime / SPA**: none (Inertia.js and Vue 3 were removed)

> **Current reality:** The app is **Bare-metal server-rendered Blade**. There is **no SPA layer, no Inertia, no Ziggy, no Tailwind, no Vue components.** Any document or plan still assuming a Vue/Inertia stack is out of date.

## Environment (on this machine)
- **PHP**: 8.3.6 (`php -v`)
- **Node/NPM**: **not installed**
- **Composer**: installed as `composer.phar` (a standalone PHP autoloader)
- **Database**: SQLite3 (migration files present; DB file not present on disk)

## Repo Layout
Base: `/home/developer/pla/luffof/` (Laravel 11 skeleton)
Remote: `git@github.com:gbetanzos/pla.git` — local is 1 commit ahead of `origin/main`

```
/app
  /app/Http/Controllers/
    /Auth/
      AuthenticatedSessionController.php
      ConfirmablePasswordController.php
      EmailVerificationNotificationController.php
      EmailVerificationPromptController.php
      NewPasswordController.php
      PasswordController.php
      PasswordResetLinkController.php
      RegisteredUserController.php
      VerifyEmailController.php
    /Bp/                                   # ← BP CRUD controller lives here (namespaced)
      BpController.php
    ProfileController.php
  /app/Http/Controllers/BpController.php    # ❌ does NOT exist (stale name)
  /app/Models/
    BloodPressure.php                       # ✅ model
    User.php
  /app/Providers/
    AppServiceProvider.php
  /app/View/Components/
    GuestLayout.php                         # ✅ resolves app layout
/public
  /public/build                             # ❌ does not exist (never built)
/resources/views/
  /resources/views/auth/                   # Breeze Blade views (login, register, verify, reset, ...)
  /resources/views/bp/                      # ✅ index/create/show/edit
  /resources/views/layouts/
    app.blade.php                          # authenticated layout
    guest.blade.php                        # guest / auth layout (Bootstrap CDN)
  app.blade.php                            # welcome landing
  dashboard.blade.php
  welcome.blade.php
  profile/edit.blade.php
/routes/
  web.php (BP CRUD)
  auth.php
/database/migrations/2026_04_19_050428_create_blood_pressures_table.php
/database/seeders/BPSampleSeeder.php
/database/factories/UserFactory.php (only; BloodPressureFactory missing)
```

## Authentication Flow
1. User visits `/` → `welcome.blade.php` (pure Blade landing page)
2. Authenticated → `/dashboard` (`auth` + `verified` middleware) → `dashboard.blade.php`
3. Breeze provides: login / register / verify-email / password-reset (Blade views, not Inertia)

## Database Tables (from migrations)
- `users` — authentication
- `blood_pressures` — readings (`systolic`, `diastolic`, `notes`, timestamps); `user_id` FK → `users`
- `sessions`, `password_reset_tokens`, `personal_access_tokens`, `failed_jobs` (Breeze)

## Routes (BP CRUD, all behind `auth`)
| URL | Method | Handler |
| --- | --- | --- |
| `/` | GET | welcome landing |
| `/dashboard` | GET | protected |
| `/bp` | GET | `Bp\bp.index` |
| `/bp/create` | GET | `Bp\bp.create` |
| `/bp` | POST | `Bp\bp.store` |
| `/bp/{bp}` | GET | `Bp\bp.show` |
| `/bp/{bp}/edit` | GET | `Bp\bp.edit` |
| `/bp/{bp}` | PATCH | `Bp\bp.update` |
| `/bp/{bp}` | DELETE | `Bp\bp.destroy` |

## Validation & Behavior
- **BP store/update**: `systolic` 80–250, `diastolic` 60–120, `notes` nullable ≤500
- **Ownership**: `store` / `update` / `destroy` enforce `$request->user() === $bp->user`
- **Status display**: none stored; rows classified by systolic/diastolic thresholds (index/edit forms show them)

## Development Commands
```bash
composer.phar install          # (not: composer install — path is composer.phar here)
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate --force
php artisan db:seed --class=BPSampleSeeder            # ⚠️ seeder has a seeding bug (see below)
php artisan serve                        # (server currently broken: vendor/ missing)
vendor/bin/phpunit                       # ⚠️ vendor/ missing on disk — will fail here
```

## Known Issues & Notes (verified against disk)
- **No `vendor/` on disk** → `php artisan` fully broken until `composer.phar install`.
- **No `node_modules/` / `public/build/`** → asset build never ran; dev server assets not available.
- **No `.env` on disk** → only `.env.example`; `app.config()` needs `key:generate`.
- **`node`/`npm`/`nodejs` not on PATH.**
- **`BpController` naming confusion:** real file is `app/Http/Controllers/Bp/BpController.php`
  (namespaced `App\Http\Controllers\Bp`); the path name `BpController.php` is misleading.
- **Seeder bug:** `BPSampleSeeder` creates users then only loops records for the first slice (`->slice(0, 1)`) — effectively 1 user, not "2 users × 5 readings."
- **No `BloodPressureFactory`** in `database/factories/` (only `UserFactory`). Tests use `User::factory(...)` directly.
- **Very thin test suite:** only `tests/Feature/BloodPressureTest.php` is a real feature test; the rest are default Breeze/example tests.
- **No `routes/api.php`** and no Sanctum API endpoints installed.

## Contact & Context
- Location: `/home/developer/pla/luffof/`
- README: `/home/developer/pla/luffof/README.md`
- This document: `/home/developer/pla/luffof/AGENTS.md`
