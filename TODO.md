# TODO

## Pending
- [ ] Add BP **dashboard chart + stat-pill** feature (`/dashboard`): range dropdown → line chart + stat pills
  - **Range dropdown**: **Weekly / Monthly** (`GET range=`, default `monthly`). Switching re-fetches and re-plots.
  - **Library**: **Chart.js 4 via CDN** (`chart.umd.min.js`, global `Chart`) — no npm/build. Only the authenticated layout loads it; guest/auth pages unaffected.
  - **Chart**: **single line series** = `max` value per reading across the selected period (tooltip shows value/date). No npm build.
  - **Pills**: **Bootstrap pills** (`max`, `min`, `avg`) per metric — one stat card *per metric* (total 2 stat cards × 3 pills), values computed from all readings charted in the selected range.
  - Monthly: all readings in the current month (`created_at` month == now); x = month day (`d M`); series label `m M`.
  - Weekly: all readings inside the current week (Monday–Sunday, ISO week of `now`); x = week number (`Wn`); series label `W*.`
  - Empty period: chart hidden (`data: null`); stat pills still render `0`; empty-state card shown (links to bp.create).
  - Auth stays `auth` + `verified`. `$bpCount` scoped to the logged-in user (`->where('user_id',$user->id)->count()`). No DB migration.
  - Route: `Route::get('/dashboard', [DashboardController::class,'index'])->name('dashboard');`
  - View: dashboard header (range dropdown + title); 2 stat cards (one per metric × max/min/avg pills); `<canvas id="bp-chart">`.

## Done
- [x] Remove register from templates (Option A)
  - `resources/views/auth/register.blade.php` → renders empty page (blank @section shell)
  - `resources/views/auth/login.blade.php` → removed "Don't have an account? Register" link
  - `resources/views/welcome.blade.php` → removed "Register" button (Login button kept)
  - `resources/views/layouts/app.blade.php` → removed "Register" navbar nav-item
  - Left untouched: register route (`routes/auth.php`), `RegisteredUserController.php`, and unused `$canRegister` in `routes/web.php`
  - Note: `/register` still 200s with a blank page
