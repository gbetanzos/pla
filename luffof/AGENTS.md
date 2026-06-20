# LuffoF - Laravel 11 Blood Pressure Tracker

## Project Overview
Blood pressure tracking application built with:
- **Backend**: Laravel 11 with Inertia.js 2.0 + Vue 3
- **Frontend**: Vue 3 + Vite + TailwindCSS
- **Database**: SQLite (SQLite3)
- **Authentication**: Laravel Breeze
- **Deployment**: Kubernetes-ready

## Environment
- **PHP**: 8.3 (system default)
- **Node.js**: 20.20.2
- **npm**: 10.8.2
- **Database**: SQLite3

## Installation History - What Has Been Done

### 1. Composer Setup
```bash
curl -sS https://getcomposer.org/installer -o composer.phar
php /usr/bin/composer.phar install
php artisan key:generate
```

### 2. Database Setup
```bash
touch database/database.sqlite
php artisan migrate:fresh --force
php artisan db:seed --class=BPSampleSeeder
```

### 3. Node.js Setup
```bash
sudo apt-get install -y nodejs
# Upgrades to v20.20.2 - satisfies Vite requirements
```

### 4. NPM Setup
```bash
npm install
# Added 170 packages
npm audit
# No vulnerabilities
```

### 5. Frontend Build
```bash
npm run build
# Successfully built 22 asset files
# Output: public/build/
```

### 6. Server Start
```bash
php artisan serve --host=0.0.0.0 --port=8000
# Server running at http://0.0.0.0:8000
```

## Architecture

### File Structure
```
/app
  Blog (API for blog feature)
/app/Http/Controllers/
  Auth/
    AuthenticatedController.php
    RegisterController.php
  BP/ (Blood Pressure controllers)
  Blog/
    BlogController.php
  BPController.php
  BlogController.php
  ProfileController.php
  RecordController.php
/app/Models/
  Blog.php
  Record.php
  User.php
/app/Providers/
  AppServiceProvider.php
/public
  build/ (Vite output)
/views
  auth/ (Laravel Breeze views)
  bp/
blog/ (static blog file)

```

### Key Views

#### Inertia Vue Pages (`resources/js/Pages/`)
- `Index.vue` - Dashboard
- `Dashboard.vue` 
- `Profile/Edit.vue` - Edit profile
- `GuestLayout.vue` - Inertia guest layout (auth pages)
- `Welcome.vue` - Welcome

#### Laravel Blade Views (`resources/views/`)
- `auth/*` - Login, register, forgot password (Inertia-powered)
- `bp/*` - Blood pressure records pages
- `blog/*` - Blog pages
- **Note**: Uses `<x-guest-layout>` component for layout

### Authentication Flow
1. User visits `/` → `Index.vue` (dashboard)
2. Not logged in → Redirects to login via Inertia
3. Login page at `/` (Inertia: `Login.vue`)
4. Breeze provides: login, register, forgot password, verify email

### Database Tables (from SQLite)
- `users` - Authentication
- `records` - Blood pressure records
- `blogs` - Blog posts (seeded data)
- `password_resets`
- `sessions`
- `personal_access_tokens`

### Environment Variables (`.env`)
```env
APP_NAME=LuffoF
APP_ENV=local
APP_KEY=<generated>
APP_DEBUG=true
APP_URL=http://laruff.local:8000

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
BROADCAST_LOG_CHANNEL=stack

DB_CONNECTION=sqlite

BROADCAST_CONNECTION=log

SESSION_DRIVER=database
SESSION_LIFETIME=120

CACHE_STORE=database

MAIL_MAILER=log
```

## Known Issues & Solutions

### Issue 1: npm engine warnings
- **Symptom**: `npm warn EBADENGINE` about Node.js version
- **Root cause**: Vite requires Node.js 20.19+ or 22.12+
- **Solution**: Upgraded to Node.js 20.20.2 via NodeSource repo
- **Status**: ✅ Resolved

### Issue 2: npm install failures after upgrade
- **Symptom**: `rolldown native binding not found`
- **Root cause**: Optional dependencies bug in npm
- **Solution**: Delete `node_modules` and `package-lock.json`, reinstall
- **Status**: ✅ Resolved

### Issue 3: Blade component error
- **Symptom**: "Unable to locate a class or view for component [guest-layout]"
- **Root cause**: Blade views use `<x-guest-layout>` but no PHP component exists
- **Solutions**:
  1. Create `app/View/Components/GuestLayout.php`
  2. OR remove `<x-guest-layout>` from blade files
- **Status**: ⚠️ Pending decision

## File Locations Cheat Sheet

| File/View | Purpose | Component/Template |
|-----------|---------|-------------------|
| `resources/js/Pages/Index.vue` | Dashboard | Inertia Vue |
| `resources/js/Pages/GuestLayout.vue` | Guest layout | Inertia Vue |
| `resources/views/bp/index.blade.php` | BP index | `<x-guest-layout>` |
| `resources/views/bp/create.blade.php` | Create record | `<x-guest-layout>` |
| `auth/login.blade.php` | Login form | Inertia |
| `auth/register.blade.php` | Register form | Inertia |

## URLs
- Application: http://localhost:8000
- Login: http://localhost:8000/login
- Register: http://localhost:8000/register
- Forgot Password: http://localhost:8000/password/reset

## Development Commands Cheat Sheet

| Command | Purpose |
|---------|---------|
| `composer install` | Install PHP deps |
| `php artisan migrate:fresh --force` | Reset DB |
| `php artisan db:seed` | Seed demo data |
| `npm install` | Install Node deps |
| `npm run dev` | Dev mode (hot reload) |
| `npm run build` | Production build |
| `npm run preview` | Preview production build |
| `php artisan serve` | Start server |

## Next Steps / Pending Tasks

1. **Decide on GuestLayout component**:
   - Create PHP Laravel View Component class
   - OR Remove `<x-guest-layout>` from blade files
   - Use `layouts/guest.blade.ext` instead

2. **Test application flow**:
   - Visit http://localhost:8000
   - Login via Inertia power
   - Test BP recording functionality

3. **Consider adding**:
   - API routes for mobile app
   - Additional BP analytics
   - User settings/notifications

## Contact & Context
- Location: `/home/developer/pla/luffof/`
- README: `/home/developer/pla/luffof/README.md`
- This document: `/home/developer/pla/luffof/AGENTS.md`

---
*Generated after initial setup - Pick up from here with fresh knowledge!*

