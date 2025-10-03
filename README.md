<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Routes & Permissions (quick reference)

- `GET /projects` (public index)
- `projects` resource (other actions protected by `auth`) — policy `ProjectPolicy` controls create/update/delete/assign
	- `ProjectPolicy::create()` => only admins (`is_admin = true`) can create projects
	- `update/delete/assign/unassign` => only admins
	- `view` => admins, assigned students, or authenticated users (configured in `app/Policies/ProjectPolicy.php`)

- `GET /students` (public index)
- other `students` actions (`show`, `create`, `store`, `edit`, etc.) are protected by `auth`.
	- `students.show` additionally restricts viewing detailed student page to the student-owner (`user.student_id`) or admin (see `app/Http/Controllers/StudentController::show`).

## Demo users (for manual testing)

You can seed demo users with:

```bash
php artisan db:seed
```

Credentials included by the seeder:

- Admin: `admin@example.com` / `SuperSecret123!`
- Demo user: `demo@example.com` / `password`

The `DatabaseSeeder` calls `DemoUserSeeder` which creates both users.

## Laravel Dusk (UI tests)

To add and run browser tests using Laravel Dusk on your machine:

1. Install the package:

```powershell
composer require --dev laravel/dusk
```

2. Install the Dusk scaffolding:

```powershell
php artisan dusk:install
```

3. (Optional) Ensure Chromedriver is compatible with your Chrome:

```powershell
php artisan dusk:chrome-driver
```

4. Run Dusk tests (headless optional):

```powershell
php artisan dusk
# or headless
php artisan dusk -- --headless
```

Notes:
- Running Dusk requires Chrome/Chromium on the machine and the appropriate Chromedriver. On Windows you may need to allow the tool to download executables.
- I added a sample `tests/Browser/ProjectsTest.php` and a `tests/DuskTestCase.php` base class to this repo; after you install Dusk locally run `php artisan dusk:install` to wire everything.


