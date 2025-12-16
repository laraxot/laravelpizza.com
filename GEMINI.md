# GEMINI.md

## Project Overview

This is a Laravel project that aims to provide a "meetup" theme for Laravel meetups. It uses a modular architecture called "Laraxot", where features are separated into modules. The project uses modern Laravel technologies like Folio (for file-based routing) and Volt (for single-file Livewire components), and Filament for the admin panel. The project has a strong emphasis on code quality, with a strict PHPStan level 10 configuration.

## Building and Running

### Setup

To set up the project for the first time, run the following command from the `laravel` directory:

```bash
composer run setup
```

This will:
- Install Composer dependencies
- Create a `.env` file
- Generate an application key
- Run database migrations
- Install NPM dependencies
- Build frontend assets

### Development

To start the development environment, run the following command from the `laravel` directory:

```bash
composer run dev
```

This will start:
- The Laravel development server on `http://127.0.0.1:8000`
- A queue listener
- A log watcher
- The Vite development server for frontend assets

### Testing

To run the tests, run the following command from the `laravel` directory:

```bash
composer run test
```

## Development Conventions

- **Architecture**: The project follows the "Laraxot" architecture, which is a modular architecture for Laravel. Each feature should be in its own module.
- **Frontend**: The frontend is built with Folio and Volt. All public-facing pages should be built with these technologies.
- **Code Quality**: The project enforces a strict PHPStan level 10 configuration. All code must pass PHPStan analysis before being committed.
- **Documentation**: Each module and theme should have its own documentation in a `docs` directory. All documentation should be written in Markdown.
