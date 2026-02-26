# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

Laravel package providing an API client for the Affilbox affiliate marketing platform (https://api.affilbox.cz). Built with Spatie Laravel Package Tools. Supports PHP 8.3+, Laravel 11/12.

## Common Commands

- `composer test` — run Pest tests
- `composer test-coverage` — run tests with coverage
- `composer analyse` — run PHPStan (level 5)
- `composer format` — fix code style with Laravel Pint

## Architecture

- **Namespace**: `JakubOrava\AffilboxClient`
- **Service Provider**: `AffilboxClientServiceProvider` — registers config, views, migration, and artisan command using Spatie's `PackageServiceProvider`
- **Facade**: `AffilboxClient` facade resolves the main `AffilboxClient` class
- **Config**: `config/affilbox-client.php`
- **API Spec**: `API_SPECS.md` contains the full Affilbox API reference (in Czech). Authentication is HTTP Basic Auth (instance number + API key).

## Testing

- Uses **Pest** with **Orchestra Testbench** for Laravel package testing
- Base test case: `tests/TestCase.php` (extends Orchestra's TestCase)
- Architecture tests in `tests/ArchTest.php` enforce no `dd`, `dump`, or `ray` calls
- Test execution order is randomized; strict mode enabled

## Code Quality

- **PHPStan** level 5 via Larastan (`phpstan.neon.dist`)
- **Laravel Pint** for code formatting (default preset)
- CI runs tests across PHP 8.3/8.4 × Laravel 11/12 on Ubuntu and Windows