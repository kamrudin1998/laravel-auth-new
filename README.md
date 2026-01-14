# Laravel Auth New

A small Laravel application that demonstrates authentication and a Todo list with comments.

## Overview

This project is a Laravel app containing a simple Todo system with user authentication, public/private todos, progress states, and comments. It includes standard controllers, models, migrations, seeders, Blade views, and Pest tests.

## Requirements

- PHP 8.x
- Composer
- Node.js & npm (for front-end assets)
- MySQL / MariaDB (or another supported DB)
- XAMPP (optional; this repo was used with XAMPP on Windows)

## Quick setup

1. Install PHP dependencies:

```bash
composer install
```

2. Install JS dependencies and build assets (dev):

```bash
npm install
npm run dev
```

3. Copy `.env` and generate an app key:

```bash
cp .env.example .env
php artisan key:generate
```

4. Configure database settings in `.env` (DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD).

5. Run migrations and seeders:

```bash
php artisan migrate
php artisan db:seed
```

6. Run the app (built-in server):

```bash
php artisan serve
```

Or use your local webserver (XAMPP) and point to the `public` directory.

## Tests

Run tests with Pest (installed in vendor):

```bash
./vendor/bin/pest
```

Or with PHPUnit:

```bash
./vendor/bin/phpunit
```

## Database

Migrations are located in `database/migrations`. Important tables:

- `users` — default Laravel users table
- `todos` — todos with `title`, `description`, `progress`, `status`, and `user_id`
- `comments` — comments attached to todos

Seeders are in `database/seeders` (e.g., `UsersTableSeeder`).

## Models

- `App\Models\User` — typical Laravel user model
- `App\Models\Todo` — todo model; likely has relations `comments()` and `user()`
- `App\Models\Comment` — comment model; likely has `user()` and `todo()` relations

## Controllers and Routes

Main controller for Todo functionality: `App\Http\Controllers\TodoController`.

Key methods in `TodoController`:

- `index(Request $request)` — lists todos (private for owner, or public). Supports `search` query and pagination.
- `create()` — shows the add-todo form.
- `store(Request $request)` — validates and creates a new todo.
- `show($id)` — shows a single todo and its comments (only if allowed by policy/public status).
- `edit($id)` — shows edit form for the user's todo.
- `update(Request $request, $id)` — validates and updates the user's todo.
- `destroy($id)` — deletes a user's todo.
- `storeComment(Request $request, $id)` — validates and stores a comment for a public todo.

Route names used in controllers (examples): `todo.index`, `todo.show`.

To find the actual routes, open `routes/web.php` and `routes/auth.php`.

File: [app/Http/Controllers/TodoController.php](app/Http/Controllers/TodoController.php)

## Views

Blade templates live in `resources/views` and include views under `todo/` for list, add, edit, and view pages.

## Common commands

- Install PHP deps: `composer install`
- Install JS deps: `npm install`
- Build assets (dev): `npm run dev`
- Run migrations: `php artisan migrate`
- Run seeders: `php artisan db:seed`
- Serve app: `php artisan serve`
- Lint a PHP file: `php -l path/to/file.php`
- Run tests: `./vendor/bin/pest` or `./vendor/bin/phpunit`

## Troubleshooting

- Ensure `.env` DB credentials match your local DB and the DB exists.
- If migrations fail, run `php artisan migrate:fresh --seed` to recreate schema (CAUTION: destroys data).
- For permission issues on storage, run `php artisan storage:link` and ensure webserver user has write permission.

## Contributing

Open an issue or send a PR. Keep changes focused and add tests for new behavior.

---

If you'd like, I can also generate an API-style route list, document specific Blade views, or add examples of requests/responses for each `TodoController` action.
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

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

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
