# Copilot Instructions for AI Agents

## Project Overview
This is a Laravel-based web application for project management, using standard Laravel conventions for structure, routing, and data access. The codebase is organized according to Laravel's MVC pattern, with custom models for `Project`, `Student`, and `User`.

## Key Architecture & Patterns
- **MVC Structure:**
  - Controllers: `app/Http/Controllers/`
  - Models: `app/Models/`
  - Views: `resources/views/`
- **Routing:**
  - Web routes are defined in `routes/web.php`.
- **Database:**
  - Migrations: `database/migrations/`
  - Seeders: `database/seeders/`
  - SQLite database: `database/database.sqlite`
- **Frontend:**
  - Assets: `resources/css/`, `resources/js/`
  - Vite is used for asset bundling (`vite.config.js`).

## Developer Workflows
- **Run the application:**
  - Use Laravel's built-in server: `php artisan serve`
- **Database migrations:**
  - Run: `php artisan migrate`
- **Seeding data:**
  - Run: `php artisan db:seed`
- **Testing:**
  - Run: `vendor\bin\phpunit` or `php artisan test`
- **Asset build:**
  - Use Vite: `npm run dev` (for development)

## Project-Specific Conventions
- **Models:**
  - Custom models for `Project`, `Student`, and `User` are in `app/Models/`.
- **Pivot Table:**
  - Many-to-many relationship between projects and students via `project_student` table.
- **Seeders:**
  - Custom seeders for projects and students in `database/seeders/`.
- **Configuration:**
  - App and environment config in `config/` and `.env`.

## Integration Points
- **External dependencies:**
  - Managed via Composer (`composer.json`) for PHP and NPM (`package.json`) for JS.
- **Service Providers:**
  - Registered in `app/Providers/` and `config/app.php`.

## Examples
- To add a new model, place it in `app/Models/` and create a migration in `database/migrations/`.
- To add a new route, edit `routes/web.php` and point to a controller in `app/Http/Controllers/`.

## References
- [Laravel Documentation](https://laravel.com/docs)
- Key files: `artisan`, `composer.json`, `vite.config.js`, `phpunit.xml`, `routes/web.php`, `app/Models/Project.php`, `database/migrations/2025_09_24_151625_create_projects_table.php`

---
If any conventions or workflows are unclear, please ask for clarification or check the referenced files for examples.
