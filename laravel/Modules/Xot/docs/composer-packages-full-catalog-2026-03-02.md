# Composer Packages Full Catalog (2026-03-02)

This document is generated from `composer show --format=json` and represents a full package-by-package study baseline.

- Scope: all installed packages in `laravel/`.
- Total packages studied: **312**.
- Objective: chaos readiness via package-aware triage.

## Critical Triage Set

- `laravel/framework`
- `filament/filament`
- `livewire/livewire`
- `livewire/volt`
- `laravel/folio`
- `nwidart/laravel-modules`
- `mcamara/laravel-localization`
- `spatie/laravel-data`
- `spatie/laravel-queueable-action`
- `spatie/laravel-translatable`
- `laravel/passport`
- `laravel/socialite`
- `calebporzio/sushi`
- `coolsam/panel-modules`

## Full Inventory

| Package | Version | Direct | Category | Chaos Surface | Description |
|---|---:|---:|---|---|---|
| `aaronfrancis/fast-paginate` | `v2.0.0` | `yes` | `supporting-lib` | `shared-runtime` | Fast paginate for Laravel |
| `anourvalar/eloquent-serialize` | `1.3.5` | `no` | `supporting-lib` | `shared-runtime` | Laravel Query Builder (Eloquent) serialization |
| `aws/aws-crt-php` | `v1.2.7` | `no` | `supporting-lib` | `shared-runtime` | AWS Common Runtime for PHP |
| `aws/aws-sdk-php` | `3.369.37` | `yes` | `supporting-lib` | `shared-runtime` | AWS SDK for PHP - Use Amazon Web Services in your PHP project |
| `barryvdh/laravel-debugbar` | `v3.16.5` | `no` | `supporting-lib` | `shared-runtime` | PHP Debugbar integration for Laravel |
| `barryvdh/laravel-ide-helper` | `v3.6.1` | `no` | `supporting-lib` | `shared-runtime` | Laravel IDE Helper, generates correct PHPDocs for all Facade classes, to improve auto-completion. |
| `barryvdh/reflection-docblock` | `v2.4.0` | `no` | `supporting-lib` | `shared-runtime` | (no description) |
| `blade-ui-kit/blade-heroicons` | `2.6.0` | `no` | `supporting-lib` | `shared-runtime` | A package to easily make use of Heroicons in your Laravel Blade views. |
| `blade-ui-kit/blade-icons` | `1.8.1` | `no` | `supporting-lib` | `shared-runtime` | A package to easily make use of icons in your Laravel Blade views. |
| `brianium/paratest` | `v7.19.0` | `no` | `quality-testing` | `shared-runtime` | Parallel testing for PHP |
| `brick/math` | `0.14.8` | `no` | `supporting-lib` | `shared-runtime` | Arbitrary-precision arithmetic library |
| `calebporzio/sushi` | `v2.5.3` | `yes` | `laravel-extensions` | `shared-runtime` | Eloquent's missing "array" driver. |
| `carbonphp/carbon-doctrine-types` | `3.2.0` | `no` | `supporting-lib` | `shared-runtime` | Types to use Carbon in Doctrine |
| `chillerlan/php-qrcode` | `5.0.5` | `no` | `media-docs` | `shared-runtime` | A QR Code generator and reader with a user-friendly API. PHP 7.4+ |
| `chillerlan/php-settings-container` | `3.2.1` | `no` | `supporting-lib` | `shared-runtime` | A container class for immutable settings objects. Not a DI container. |
| `clue/ndjson-react` | `v1.3.0` | `no` | `supporting-lib` | `shared-runtime` | Streaming newline-delimited JSON (NDJSON) parser and encoder for ReactPHP. |
| `cmgmyr/phploc` | `8.0.6` | `no` | `supporting-lib` | `shared-runtime` | A tool for quickly measuring the size of a PHP project. |
| `composer/class-map-generator` | `1.7.1` | `no` | `foundational-lib` | `shared-runtime` | Utilities to scan PHP code and generate class maps. |
| `composer/pcre` | `3.3.2` | `no` | `foundational-lib` | `shared-runtime` | PCRE wrapping library that offers type-safe preg_* replacements. |
| `composer/semver` | `3.4.4` | `no` | `foundational-lib` | `shared-runtime` | Semver library that offers utilities, version constraint parsing and validation. |
| `composer/xdebug-handler` | `3.0.5` | `no` | `foundational-lib` | `shared-runtime` | Restarts a process without Xdebug. |
| `coolsam/panel-modules` | `dev-dev` | `yes` | `laravel-extensions` | `shared-runtime` | Support for nwidart/laravel-modules in filamentphp |
| `danharrin/date-format-converter` | `v0.3.1` | `no` | `supporting-lib` | `shared-runtime` | Convert token-based date formats between standards. |
| `danharrin/livewire-rate-limiting` | `v2.1.0` | `no` | `supporting-lib` | `shared-runtime` | Apply rate limiters to Laravel Livewire actions. |
| `dealerdirect/phpcodesniffer-composer-installer` | `v1.2.0` | `no` | `supporting-lib` | `shared-runtime` | PHP_CodeSniffer Standards Composer Installer Plugin |
| `defuse/php-encryption` | `v2.4.0` | `no` | `security-auth` | `shared-runtime` | Secure PHP Encryption Library |
| `dflydev/dot-access-data` | `v3.0.3` | `no` | `supporting-lib` | `shared-runtime` | Given a deep data structure, access data by dot notation. |
| `doctrine/dbal` | `4.4.1` | `yes` | `foundational-lib` | `shared-runtime` | Powerful PHP database abstraction layer (DBAL) with many features for database schema introspection and management. |
| `doctrine/deprecations` | `1.1.6` | `no` | `foundational-lib` | `shared-runtime` | A small layer on top of trigger_error(E_USER_DEPRECATED) or PSR-3 logging with options to disable all deprecations or selectively for packages. |
| `doctrine/inflector` | `2.1.0` | `no` | `foundational-lib` | `shared-runtime` | PHP Doctrine Inflector is a small library that can perform string manipulations with regard to upper/lowercase and singular/plural forms of words. |
| `doctrine/lexer` | `3.0.1` | `no` | `foundational-lib` | `shared-runtime` | PHP Doctrine Lexer parser library that can be used in Top-Down, Recursive Descent Parsers. |
| `doctrine/sql-formatter` | `1.5.4` | `no` | `foundational-lib` | `shared-runtime` | a PHP SQL highlighting library |
| `dragonmantank/cron-expression` | `v3.6.0` | `no` | `supporting-lib` | `shared-runtime` | CRON for PHP: Calculate the next or previous run date and determine if a CRON expression is due |
| `egulias/email-validator` | `4.0.4` | `no` | `supporting-lib` | `shared-runtime` | A library for validating emails against several RFCs |
| `evenement/evenement` | `v3.0.2` | `no` | `supporting-lib` | `shared-runtime` | Événement is a very simple event dispatching library for PHP |
| `ezyang/htmlpurifier` | `v4.19.0` | `no` | `supporting-lib` | `shared-runtime` | Standards compliant HTML filter written in PHP |
| `facade/ignition-contracts` | `1.0.2` | `no` | `supporting-lib` | `shared-runtime` | Solution contracts for Ignition |
| `fakerphp/faker` | `v1.24.1` | `no` | `supporting-lib` | `shared-runtime` | Faker is a PHP library that generates fake data for you. |
| `fidry/cpu-core-counter` | `1.3.0` | `no` | `supporting-lib` | `shared-runtime` | Tiny utility to get the number of CPU cores. |
| `fidum/laravel-eloquent-morph-to-one` | `2.5.0` | `yes` | `supporting-lib` | `shared-runtime` | Adds MorphToOne relation to Laravel eloquent |
| `filament/actions` | `v5.2.1` | `no` | `framework-platform` | `admin-ui-and-realtime` | Easily add beautiful action modals to any Livewire component. |
| `filament/filament` | `v5.2.1` | `yes` | `framework-platform` | `admin-ui-and-realtime` | A collection of full-stack components for accelerated Laravel app development. |
| `filament/forms` | `v5.2.1` | `no` | `framework-platform` | `admin-ui-and-realtime` | Easily add beautiful forms to any Livewire component. |
| `filament/infolists` | `v5.2.1` | `no` | `framework-platform` | `admin-ui-and-realtime` | Easily add beautiful read-only infolists to any Livewire component. |
| `filament/notifications` | `v5.2.1` | `no` | `framework-platform` | `admin-ui-and-realtime` | Easily add beautiful notifications to any Livewire app. |
| `filament/query-builder` | `v5.2.1` | `no` | `framework-platform` | `admin-ui-and-realtime` | A powerful query builder component for Filament. |
| `filament/schemas` | `v5.2.1` | `no` | `framework-platform` | `admin-ui-and-realtime` | Easily add beautiful UI to any Livewire component. |
| `filament/spatie-laravel-media-library-plugin` | `v5.2.1` | `yes` | `framework-platform` | `admin-ui-and-realtime` | Filament support for `spatie/laravel-medialibrary`. |
| `filament/support` | `v5.2.1` | `no` | `framework-platform` | `admin-ui-and-realtime` | Core helper methods and foundation code for all Filament packages. |
| `filament/tables` | `v5.2.1` | `no` | `framework-platform` | `admin-ui-and-realtime` | Easily add beautiful tables to any Livewire component. |
| `filament/upgrade` | `v5.2.1` | `yes` | `framework-platform` | `admin-ui-and-realtime` | Upgrade Filament v4 code to Filament v5. |
| `filament/widgets` | `v5.2.1` | `no` | `framework-platform` | `admin-ui-and-realtime` | Easily add beautiful dashboard widgets to any Livewire component. |
| `filp/whoops` | `2.18.4` | `no` | `supporting-lib` | `shared-runtime` | php error handling for cool kids |
| `firebase/php-jwt` | `v7.0.2` | `no` | `security-auth` | `auth-and-token-flow` | A simple library to encode and decode JSON Web Tokens (JWT) in PHP. Should conform to the current spec. |
| `flowframe/laravel-trend` | `v0.4.0` | `yes` | `supporting-lib` | `shared-runtime` | Easily generate model trends |
| `friendsofphp/php-cs-fixer` | `v3.94.1` | `no` | `quality-testing` | `shared-runtime` | A tool to automatically fix PHP code style |
| `fruitcake/php-cors` | `v1.4.0` | `no` | `supporting-lib` | `shared-runtime` | Cross-origin resource sharing library for the Symfony HttpFoundation |
| `graham-campbell/result-type` | `v1.1.4` | `no` | `supporting-lib` | `shared-runtime` | An Implementation Of The Result Type |
| `guzzlehttp/guzzle` | `7.10.0` | `yes` | `foundational-lib` | `shared-runtime` | Guzzle is a PHP HTTP client library |
| `guzzlehttp/promises` | `2.3.0` | `no` | `foundational-lib` | `shared-runtime` | Guzzle promises library |
| `guzzlehttp/psr7` | `2.8.0` | `no` | `foundational-lib` | `shared-runtime` | PSR-7 message implementation that also provides common utility methods |
| `guzzlehttp/uri-template` | `v1.0.5` | `no` | `foundational-lib` | `shared-runtime` | A polyfill class for uri_template of PHP |
| `hamcrest/hamcrest-php` | `v2.1.1` | `no` | `supporting-lib` | `shared-runtime` | This is the PHP port of Hamcrest Matchers |
| `iamcal/sql-parser` | `v0.7` | `no` | `supporting-lib` | `shared-runtime` | MySQL schema parser |
| `intervention/gif` | `4.2.4` | `no` | `supporting-lib` | `shared-runtime` | Native PHP GIF Encoder/Decoder |
| `intervention/image` | `3.11.6` | `yes` | `media-docs` | `media-export-pipeline` | PHP Image Processing |
| `irazasyed/telegram-bot-sdk` | `v3.15.0` | `yes` | `supporting-lib` | `shared-runtime` | The Unofficial Telegram Bot API PHP SDK |
| `jaybizzle/crawler-detect` | `v1.3.7` | `no` | `supporting-lib` | `shared-runtime` | CrawlerDetect is a PHP class for detecting bots/crawlers/spiders via the user agent |
| `jean85/pretty-package-versions` | `2.1.1` | `no` | `supporting-lib` | `shared-runtime` | A library to get pretty versions strings of installed dependencies |
| `jenssegers/agent` | `v2.6.4` | `yes` | `supporting-lib` | `shared-runtime` | Desktop/mobile user agent parser with support for Laravel, based on Mobiledetect |
| `kirschbaum-development/eloquent-power-joins` | `4.2.11` | `no` | `supporting-lib` | `shared-runtime` | The Laravel magic applied to joins. |
| `lara-zeus/spatie-translatable` | `2.0.0` | `yes` | `laravel-extensions` | `i18n-and-routing` | Filament support for `spatie/laravel-translatable`. |
| `larastan/larastan` | `v3.9.2` | `no` | `quality-testing` | `quality-gates` | Larastan - Discover bugs in your code without running it. A phpstan/phpstan extension for Laravel |
| `laravel-notification-channels/telegram` | `6.0.0` | `yes` | `supporting-lib` | `shared-runtime` | Telegram Notifications Channel for Laravel |
| `laravel/boost` | `v2.1.7` | `no` | `framework-platform` | `app-core-and-modules` | Laravel Boost accelerates AI-assisted development by providing the essential context and structure that AI needs to generate high-quality, Laravel-specific code. |
| `laravel/folio` | `v1.1.12` | `yes` | `framework-platform` | `app-core-and-modules` | Page based routing for Laravel. |
| `laravel/framework` | `v12.52.0` | `yes` | `framework-platform` | `app-core-and-modules` | The Laravel Framework. |
| `laravel/mcp` | `v0.5.9` | `no` | `framework-platform` | `app-core-and-modules` | Rapidly build MCP servers for your Laravel applications. |
| `laravel/pail` | `v1.2.6` | `no` | `framework-platform` | `app-core-and-modules` | Easily delve into your Laravel application's log files directly from the command line. |
| `laravel/passport` | `v13.4.4` | `yes` | `framework-platform` | `app-core-and-modules` | Laravel Passport provides OAuth2 server support to Laravel. |
| `laravel/pennant` | `v1.19.0` | `yes` | `framework-platform` | `app-core-and-modules` | A simple, lightweight library for managing feature flags. |
| `laravel/pint` | `v1.27.1` | `no` | `framework-platform` | `app-core-and-modules` | An opinionated code formatter for PHP. |
| `laravel/prompts` | `v0.3.13` | `no` | `framework-platform` | `app-core-and-modules` | Add beautiful and user-friendly forms to your command-line applications. |
| `laravel/pulse` | `v1.5.0` | `yes` | `framework-platform` | `app-core-and-modules` | Laravel Pulse is a real-time application performance monitoring tool and dashboard for your Laravel application. |
| `laravel/roster` | `v0.4.0` | `no` | `framework-platform` | `app-core-and-modules` | Detect packages & approaches in use within a Laravel project |
| `laravel/sail` | `v1.53.0` | `no` | `framework-platform` | `app-core-and-modules` | Docker files for running a basic Laravel application. |
| `laravel/serializable-closure` | `v2.0.9` | `no` | `framework-platform` | `app-core-and-modules` | Laravel Serializable Closure provides an easy and secure way to serialize closures in PHP. |
| `laravel/socialite` | `v5.24.2` | `no` | `framework-platform` | `app-core-and-modules` | Laravel wrapper around OAuth 1 & OAuth 2 libraries. |
| `laravel/tinker` | `v2.11.1` | `yes` | `framework-platform` | `app-core-and-modules` | Powerful REPL for the Laravel framework. |
| `lcobucci/clock` | `3.5.0` | `no` | `supporting-lib` | `shared-runtime` | Yet another clock abstraction |
| `lcobucci/jwt` | `5.6.0` | `no` | `security-auth` | `auth-and-token-flow` | A simple library to work with JSON Web Token and JSON Web Signature |
| `league/commonmark` | `2.8.0` | `no` | `foundational-lib` | `shared-runtime` | Highly-extensible PHP Markdown parser which fully supports the CommonMark spec and GitHub-Flavored Markdown (GFM) |
| `league/config` | `v1.2.0` | `no` | `foundational-lib` | `shared-runtime` | Define configuration arrays with strict schemas and access values with dot notation |
| `league/container` | `5.1.0` | `no` | `foundational-lib` | `shared-runtime` | A fast and intuitive dependency injection container. |
| `league/csv` | `9.28.0` | `no` | `foundational-lib` | `shared-runtime` | CSV data manipulation made easy in PHP |
| `league/event` | `3.0.3` | `no` | `foundational-lib` | `shared-runtime` | Event package |
| `league/flysystem` | `3.31.0` | `no` | `foundational-lib` | `shared-runtime` | File storage abstraction for PHP |
| `league/flysystem-local` | `3.31.0` | `no` | `foundational-lib` | `shared-runtime` | Local filesystem adapter for Flysystem. |
| `league/mime-type-detection` | `1.16.0` | `no` | `foundational-lib` | `shared-runtime` | Mime-type detection for Flysystem |
| `league/oauth1-client` | `v1.11.0` | `no` | `security-auth` | `auth-and-token-flow` | OAuth 1.0 Client Library |
| `league/oauth2-server` | `9.3.0` | `no` | `security-auth` | `auth-and-token-flow` | A lightweight and powerful OAuth 2.0 authorization and resource server library with support for all the core specification grants. This library will allow you to secure your API with OAuth and allow your applications users to approve apps that want to access their data from your API. |
| `league/uri` | `7.8.0` | `no` | `foundational-lib` | `shared-runtime` | URI manipulation library |
| `league/uri-components` | `7.8.0` | `no` | `foundational-lib` | `shared-runtime` | URI components manipulation library |
| `league/uri-interfaces` | `7.8.0` | `no` | `foundational-lib` | `shared-runtime` | Common tools for parsing and resolving RFC3987/RFC3986 URI |
| `livewire/flux` | `v2.12.1` | `yes` | `framework-platform` | `admin-ui-and-realtime` | The official UI component library for Livewire. |
| `livewire/livewire` | `v4.1.4` | `yes` | `framework-platform` | `admin-ui-and-realtime` | A front-end framework for Laravel. |
| `livewire/volt` | `v1.10.2` | `yes` | `framework-platform` | `admin-ui-and-realtime` | An elegantly crafted functional API for Laravel Livewire. |
| `maatwebsite/excel` | `3.1.67` | `yes` | `media-docs` | `media-export-pipeline` | Supercharged Excel exports and imports in Laravel |
| `maennchen/zipstream-php` | `3.2.1` | `no` | `supporting-lib` | `shared-runtime` | ZipStream is a library for dynamically streaming dynamic zip files from PHP without writing to the disk at all on the server. |
| `markbaker/complex` | `3.0.2` | `no` | `supporting-lib` | `shared-runtime` | PHP Class for working with complex numbers |
| `markbaker/matrix` | `3.0.1` | `no` | `supporting-lib` | `shared-runtime` | PHP Class for working with matrices |
| `masterminds/html5` | `2.10.0` | `no` | `supporting-lib` | `shared-runtime` | An HTML5 parser and serializer. |
| `mcamara/laravel-localization` | `v2.3.0` | `yes` | `laravel-extensions` | `i18n-and-routing` | Easy localization for Laravel |
| `mobiledetect/mobiledetectlib` | `2.8.45` | `no` | `supporting-lib` | `shared-runtime` | Mobile_Detect is a lightweight PHP class for detecting mobile devices. It uses the User-Agent string combined with specific HTTP headers to detect the mobile environment. |
| `mockery/mockery` | `1.6.12` | `no` | `supporting-lib` | `shared-runtime` | Mockery is a simple yet flexible PHP mock object framework |
| `monolog/monolog` | `3.10.0` | `no` | `supporting-lib` | `shared-runtime` | Sends your logs to files, sockets, inboxes, databases and various web services |
| `mtdowling/jmespath.php` | `2.8.0` | `no` | `supporting-lib` | `shared-runtime` | Declaratively specify how to extract elements from a JSON document |
| `mustache/mustache` | `v2.14.2` | `no` | `supporting-lib` | `shared-runtime` | A Mustache implementation in PHP. |
| `myclabs/deep-copy` | `1.13.4` | `no` | `supporting-lib` | `shared-runtime` | Create deep copies (clones) of your objects |
| `nesbot/carbon` | `3.11.1` | `no` | `supporting-lib` | `shared-runtime` | An API extension for DateTime that supports 281 different languages. |
| `nette/php-generator` | `v4.2.1` | `no` | `supporting-lib` | `shared-runtime` | 🐘 Nette PHP Generator: generates neat PHP code for you. Supports new PHP 8.5 features. |
| `nette/schema` | `v1.3.4` | `no` | `supporting-lib` | `shared-runtime` | 📐 Nette Schema: validating data structures against a given Schema. |
| `nette/utils` | `v4.1.3` | `no` | `supporting-lib` | `shared-runtime` | 🛠  Nette Utils: lightweight utilities for string & array manipulation, image handling, safe JSON encoding/decoding, validation, slug or strong password generating etc. |
| `nikic/php-parser` | `v5.7.0` | `no` | `supporting-lib` | `shared-runtime` | A PHP parser written in PHP |
| `nunomaduro/collision` | `v8.9.1` | `no` | `quality-testing` | `shared-runtime` | Cli error handling for console/command-line PHP applications. |
| `nunomaduro/phpinsights` | `v2.13.3` | `yes` | `quality-testing` | `shared-runtime` | Instant PHP quality checks from your console. |
| `nunomaduro/pokio` | `v0.1.2` | `no` | `quality-testing` | `shared-runtime` | Pokio is a dead simple asynchronous API for PHP that just works |
| `nunomaduro/termwind` | `v2.4.0` | `no` | `quality-testing` | `shared-runtime` | It's like Tailwind CSS, but for the console. |
| `nwidart/laravel-modules` | `v12.0.4` | `yes` | `framework-platform` | `app-core-and-modules` | Laravel Module management |
| `openspout/openspout` | `v4.32.0` | `no` | `supporting-lib` | `shared-runtime` | PHP Library to read and write spreadsheet files (CSV, XLSX and ODS), in a fast and scalable way |
| `orchestra/canvas` | `v10.1.1` | `no` | `supporting-lib` | `shared-runtime` | Code Generators for Laravel Applications and Packages |
| `orchestra/canvas-core` | `v10.1.2` | `no` | `supporting-lib` | `shared-runtime` | Code Generators Builder for Laravel Applications and Packages |
| `orchestra/sidekick` | `v1.2.20` | `no` | `supporting-lib` | `shared-runtime` | Packages Toolkit Utilities and Helpers for Laravel |
| `orchestra/testbench` | `v10.9.0` | `no` | `supporting-lib` | `shared-runtime` | Laravel Testing Helper for Packages Development |
| `orchestra/testbench-core` | `v10.9.0` | `no` | `supporting-lib` | `shared-runtime` | Testing Helper for Laravel Development |
| `orchestra/workbench` | `v10.0.8` | `no` | `supporting-lib` | `shared-runtime` | Workbench Companion for Laravel Packages Development |
| `owenvoke/blade-fontawesome` | `v2.9.1` | `yes` | `supporting-lib` | `shared-runtime` | A package to easily make use of Font Awesome in your Laravel Blade views |
| `paragonie/constant_time_encoding` | `v3.1.3` | `no` | `supporting-lib` | `shared-runtime` | Constant-time Implementations of RFC 4648 Encoding (Base-64, Base-32, Base-16) |
| `paragonie/random_compat` | `v9.99.100` | `no` | `supporting-lib` | `shared-runtime` | PHP 5.x polyfill for random_bytes() and random_int() from PHP 7 |
| `pbmedia/laravel-ffmpeg` | `8.7.1` | `yes` | `media-docs` | `media-export-pipeline` | FFMpeg for Laravel |
| `pestphp/pest` | `v4.4.1` | `no` | `quality-testing` | `quality-gates` | The elegant PHP Testing Framework. |
| `pestphp/pest-plugin` | `v4.0.0` | `no` | `quality-testing` | `quality-gates` | The Pest plugin manager |
| `pestphp/pest-plugin-arch` | `v4.0.0` | `no` | `quality-testing` | `quality-gates` | The Arch plugin for Pest PHP. |
| `pestphp/pest-plugin-laravel` | `v4.0.0` | `yes` | `quality-testing` | `quality-gates` | The Pest Laravel Plugin |
| `pestphp/pest-plugin-mutate` | `v4.0.1` | `no` | `quality-testing` | `quality-gates` | Mutates your code to find untested cases |
| `pestphp/pest-plugin-profanity` | `v4.2.1` | `no` | `quality-testing` | `quality-gates` | The Pest Profanity Plugin |
| `pestphp/pest-plugin-type-coverage` | `v4.0.3` | `no` | `quality-testing` | `quality-gates` | The Type Coverage plugin for Pest PHP. |
| `phar-io/manifest` | `2.0.4` | `no` | `supporting-lib` | `shared-runtime` | Component for reading phar.io manifest information from a PHP Archive (PHAR) |
| `phar-io/version` | `3.2.1` | `no` | `supporting-lib` | `shared-runtime` | Library for handling version information and constraints |
| `php-debugbar/php-debugbar` | `v2.2.6` | `no` | `supporting-lib` | `shared-runtime` | Debug bar in the browser for php application |
| `php-ffmpeg/php-ffmpeg` | `v1.4.0` | `no` | `media-docs` | `media-export-pipeline` | FFMpeg PHP, an Object Oriented library to communicate with AVconv / ffmpeg |
| `php-http/discovery` | `1.20.0` | `no` | `supporting-lib` | `shared-runtime` | Finds and installs PSR-7, PSR-17, PSR-18 and HTTPlug implementations |
| `php-parallel-lint/php-parallel-lint` | `v1.4.0` | `no` | `supporting-lib` | `shared-runtime` | This tool checks the syntax of PHP files about 20x faster than serial check. |
| `phpdocumentor/reflection` | `6.4.4` | `no` | `supporting-lib` | `shared-runtime` | Reflection library to do Static Analysis for PHP Projects |
| `phpdocumentor/reflection-common` | `2.2.0` | `no` | `supporting-lib` | `shared-runtime` | Common reflection classes used by phpdocumentor to reflect the code structure |
| `phpdocumentor/reflection-docblock` | `5.6.6` | `no` | `supporting-lib` | `shared-runtime` | With this component, a library can provide support for annotations via DocBlocks or otherwise retrieve information that is embedded in a DocBlock. |
| `phpdocumentor/type-resolver` | `1.12.0` | `yes` | `supporting-lib` | `shared-runtime` | A PSR-5 based resolver of Class names, Types and Structural Element Names |
| `phpoffice/phpspreadsheet` | `1.30.2` | `no` | `media-docs` | `shared-runtime` | PHPSpreadsheet - Read, Create and Write Spreadsheet documents in PHP - Spreadsheet engine |
| `phpoption/phpoption` | `1.9.5` | `no` | `supporting-lib` | `shared-runtime` | Option Type for PHP |
| `phpseclib/phpseclib` | `3.0.49` | `no` | `supporting-lib` | `shared-runtime` | PHP Secure Communications Library - Pure-PHP implementations of RSA, AES, SSH2, SFTP, X.509 etc. |
| `phpstan/phpdoc-parser` | `2.3.2` | `no` | `quality-testing` | `quality-gates` | PHPDoc parser with support for nullable, intersection and generic types |
| `phpstan/phpstan` | `2.1.39` | `no` | `quality-testing` | `quality-gates` | PHPStan - PHP Static Analysis Tool |
| `phpunit/php-code-coverage` | `12.5.3` | `no` | `quality-testing` | `quality-gates` | Library that provides collection, processing, and rendering functionality for PHP code coverage information. |
| `phpunit/php-file-iterator` | `6.0.1` | `no` | `quality-testing` | `quality-gates` | FilterIterator implementation that filters files based on a list of suffixes. |
| `phpunit/php-invoker` | `6.0.0` | `no` | `quality-testing` | `quality-gates` | Invoke callables with a timeout |
| `phpunit/php-text-template` | `5.0.0` | `no` | `quality-testing` | `quality-gates` | Simple template engine. |
| `phpunit/php-timer` | `8.0.0` | `no` | `quality-testing` | `quality-gates` | Utility class for timing |
| `phpunit/phpunit` | `12.5.12` | `no` | `quality-testing` | `quality-gates` | The PHP Unit Testing framework. |
| `pragmarx/google2fa` | `v9.0.0` | `no` | `security-auth` | `shared-runtime` | A One Time Password Authentication package, compatible with Google Authenticator. |
| `pragmarx/google2fa-qrcode` | `v3.0.0` | `no` | `security-auth` | `shared-runtime` | QR Code package for Google2FA |
| `predis/predis` | `v3.4.0` | `yes` | `supporting-lib` | `shared-runtime` | A flexible and feature-complete Redis/Valkey client for PHP. |
| `psr/cache` | `3.0.0` | `no` | `foundational-lib` | `shared-runtime` | Common interface for caching libraries |
| `psr/clock` | `1.0.0` | `no` | `foundational-lib` | `shared-runtime` | Common interface for reading the clock. |
| `psr/container` | `2.0.2` | `no` | `foundational-lib` | `shared-runtime` | Common Container Interface (PHP FIG PSR-11) |
| `psr/event-dispatcher` | `1.0.0` | `no` | `foundational-lib` | `shared-runtime` | Standard interfaces for event handling. |
| `psr/http-client` | `1.0.3` | `no` | `foundational-lib` | `shared-runtime` | Common interface for HTTP clients |
| `psr/http-factory` | `1.1.0` | `no` | `foundational-lib` | `shared-runtime` | PSR-17: Common interfaces for PSR-7 HTTP message factories |
| `psr/http-message` | `2.0` | `no` | `foundational-lib` | `shared-runtime` | Common interface for HTTP messages |
| `psr/http-server-handler` | `1.0.2` | `no` | `foundational-lib` | `shared-runtime` | Common interface for HTTP server-side request handler |
| `psr/http-server-middleware` | `1.0.2` | `no` | `foundational-lib` | `shared-runtime` | Common interface for HTTP server-side middleware |
| `psr/log` | `3.0.2` | `no` | `foundational-lib` | `shared-runtime` | Common interface for logging libraries |
| `psr/simple-cache` | `3.0.0` | `no` | `foundational-lib` | `shared-runtime` | Common interfaces for simple caching |
| `psy/psysh` | `v0.12.20` | `no` | `supporting-lib` | `shared-runtime` | An interactive shell for modern PHP. |
| `ralouphie/getallheaders` | `3.0.3` | `no` | `supporting-lib` | `shared-runtime` | A polyfill for getallheaders. |
| `ramsey/collection` | `2.1.1` | `no` | `supporting-lib` | `shared-runtime` | A PHP library for representing and manipulating collections. |
| `ramsey/uuid` | `4.9.2` | `no` | `supporting-lib` | `shared-runtime` | A PHP library for generating and working with universally unique identifiers (UUIDs). |
| `react/cache` | `v1.2.0` | `no` | `foundational-lib` | `shared-runtime` | Async, Promise-based cache interface for ReactPHP |
| `react/child-process` | `v0.6.7` | `no` | `foundational-lib` | `shared-runtime` | Event-driven library for executing child processes with ReactPHP. |
| `react/dns` | `v1.14.0` | `no` | `foundational-lib` | `shared-runtime` | Async DNS resolver for ReactPHP |
| `react/event-loop` | `v1.6.0` | `no` | `foundational-lib` | `shared-runtime` | ReactPHP's core reactor event loop that libraries can use for evented I/O. |
| `react/promise` | `v3.3.0` | `no` | `foundational-lib` | `shared-runtime` | A lightweight implementation of CommonJS Promises/A for PHP |
| `react/socket` | `v1.17.0` | `no` | `foundational-lib` | `shared-runtime` | Async, streaming plaintext TCP/IP and secure TLS socket server and client connections for ReactPHP |
| `react/stream` | `v1.4.0` | `no` | `foundational-lib` | `shared-runtime` | Event-driven readable and writable streams for non-blocking I/O in ReactPHP |
| `rector/rector` | `2.3.6` | `no` | `quality-testing` | `shared-runtime` | Instant Upgrade and Automated Refactoring of any PHP code |
| `rinvex/countries` | `v9.1.0` | `yes` | `supporting-lib` | `shared-runtime` | Rinvex Countries is a simple and lightweight package for retrieving country details with flexibility. A whole bunch of data including name, demonym, capital, iso codes, dialling codes, geo data, currencies, flags, emoji, and other attributes for all 250 countries worldwide at your fingertips. |
| `ryangjchandler/blade-capture-directive` | `v1.1.0` | `no` | `supporting-lib` | `shared-runtime` | Create inline partials in your Blade templates with ease. |
| `saade/filament-fullcalendar` | `v4.0.0-beta3` | `yes` | `supporting-lib` | `shared-runtime` | The Most Popular JavaScript Calendar integrated with Filament 💛 |
| `scrivo/highlight.php` | `v9.18.1.10` | `no` | `supporting-lib` | `shared-runtime` | Server side syntax highlighter that supports 185 languages. It's a PHP port of highlight.js |
| `sebastian/cli-parser` | `4.2.0` | `no` | `supporting-lib` | `shared-runtime` | Library for parsing CLI options |
| `sebastian/comparator` | `7.1.4` | `no` | `supporting-lib` | `shared-runtime` | Provides the functionality to compare PHP values for equality |
| `sebastian/complexity` | `5.0.0` | `no` | `supporting-lib` | `shared-runtime` | Library for calculating the complexity of PHP code units |
| `sebastian/diff` | `7.0.0` | `no` | `supporting-lib` | `shared-runtime` | Diff implementation |
| `sebastian/environment` | `8.0.3` | `no` | `supporting-lib` | `shared-runtime` | Provides functionality to handle HHVM/PHP environments |
| `sebastian/exporter` | `7.0.2` | `no` | `supporting-lib` | `shared-runtime` | Provides the functionality to export PHP variables for visualization |
| `sebastian/global-state` | `8.0.2` | `no` | `supporting-lib` | `shared-runtime` | Snapshotting of global state |
| `sebastian/lines-of-code` | `4.0.0` | `no` | `supporting-lib` | `shared-runtime` | Library for counting the lines of code in PHP source code |
| `sebastian/object-enumerator` | `7.0.0` | `no` | `supporting-lib` | `shared-runtime` | Traverses array structures and object graphs to enumerate all referenced objects |
| `sebastian/object-reflector` | `5.0.0` | `no` | `supporting-lib` | `shared-runtime` | Allows reflection of object attributes, including inherited and non-public ones |
| `sebastian/recursion-context` | `7.0.1` | `no` | `supporting-lib` | `shared-runtime` | Provides functionality to recursively process PHP variables |
| `sebastian/type` | `6.0.3` | `no` | `supporting-lib` | `shared-runtime` | Collection of value objects that represent the types of the PHP type system |
| `sebastian/version` | `6.0.0` | `no` | `supporting-lib` | `shared-runtime` | Library that helps with managing the version number of Git-hosted PHP projects |
| `slevomat/coding-standard` | `8.22.1` | `no` | `supporting-lib` | `shared-runtime` | Slevomat Coding Standard for PHP_CodeSniffer complements Consistence Coding Standard by providing sniffs with additional checks. |
| `socialiteproviders/auth0` | `4.2.0` | `yes` | `security-auth` | `auth-and-token-flow` | Auth0 OAuth2 Provider for Laravel Socialite |
| `socialiteproviders/manager` | `v4.8.1` | `no` | `security-auth` | `auth-and-token-flow` | Easily add new or override built-in providers in Laravel Socialite. |
| `spatie/better-types` | `1.0.1` | `no` | `laravel-extensions` | `shared-runtime` | Improved abstraction for dealing with union and named types. |
| `spatie/cpu-load-health-check` | `1.0.5` | `yes` | `laravel-extensions` | `shared-runtime` | A Laravel Health check to monitor CPU load |
| `spatie/eloquent-sortable` | `5.0.0` | `no` | `laravel-extensions` | `shared-runtime` | Sortable behaviour for eloquent models |
| `spatie/enum` | `3.13.0` | `no` | `laravel-extensions` | `shared-runtime` | PHP Enums |
| `spatie/image` | `3.9.1` | `no` | `laravel-extensions` | `media-export-pipeline` | Manipulate images with an expressive API |
| `spatie/image-optimizer` | `1.8.1` | `no` | `laravel-extensions` | `media-export-pipeline` | Easily optimize images using PHP |
| `spatie/invade` | `2.1.0` | `no` | `laravel-extensions` | `shared-runtime` | A PHP function to work with private properties and methods |
| `spatie/laravel-activitylog` | `4.11.0` | `yes` | `laravel-extensions` | `shared-runtime` | A very simple activity logger to monitor the users of your website or application |
| `spatie/laravel-data` | `4.19.1` | `yes` | `laravel-extensions` | `contracts-actions-jobs` | Create unified resources and data transfer objects |
| `spatie/laravel-database-mail-templates` | `3.7.1` | `yes` | `laravel-extensions` | `contracts-actions-jobs` | Render Laravel mailables using a template stored in the database. |
| `spatie/laravel-event-sourcing` | `7.13.0` | `yes` | `laravel-extensions` | `contracts-actions-jobs` | The easiest way to get started with event sourcing in Laravel |
| `spatie/laravel-health` | `1.37.0` | `yes` | `laravel-extensions` | `shared-runtime` | Monitor the health of a Laravel application |
| `spatie/laravel-medialibrary` | `11.20.0` | `no` | `laravel-extensions` | `media-export-pipeline` | Associate files with Eloquent models |
| `spatie/laravel-model-states` | `2.12.1` | `yes` | `laravel-extensions` | `shared-runtime` | State support for Eloquent models |
| `spatie/laravel-model-status` | `1.19.0` | `yes` | `laravel-extensions` | `shared-runtime` | A package to enable assigning statuses to Eloquent Models |
| `spatie/laravel-package-tools` | `1.92.7` | `yes` | `laravel-extensions` | `shared-runtime` | Tools for creating Laravel packages |
| `spatie/laravel-permission` | `7.2.0` | `yes` | `laravel-extensions` | `shared-runtime` | Permission handling for Laravel 12 and up |
| `spatie/laravel-personal-data-export` | `4.3.1` | `yes` | `laravel-extensions` | `shared-runtime` | Create personal data downloads in a Laravel app |
| `spatie/laravel-queueable-action` | `2.16.2` | `yes` | `laravel-extensions` | `contracts-actions-jobs` | Queueable action support in Laravel |
| `spatie/laravel-responsecache` | `7.7.2` | `yes` | `laravel-extensions` | `shared-runtime` | Speed up a Laravel application by caching the entire response |
| `spatie/laravel-schemaless-attributes` | `2.5.2` | `yes` | `laravel-extensions` | `shared-runtime` | Add schemaless attributes to Eloquent models |
| `spatie/laravel-sluggable` | `3.7.5` | `yes` | `laravel-extensions` | `shared-runtime` | Generate slugs when saving Eloquent models |
| `spatie/laravel-tags` | `4.10.2` | `yes` | `laravel-extensions` | `shared-runtime` | Add tags and taggable behaviour to your Laravel app |
| `spatie/laravel-translatable` | `6.12.0` | `no` | `laravel-extensions` | `i18n-and-routing` | A trait to make an Eloquent model hold translations |
| `spatie/php-structure-discoverer` | `2.3.3` | `no` | `laravel-extensions` | `shared-runtime` | Automatically discover structures within your PHP application |
| `spatie/regex` | `3.1.1` | `no` | `laravel-extensions` | `shared-runtime` | A sane interface for php's built in preg_* functions |
| `spatie/shiki-php` | `2.3.3` | `no` | `laravel-extensions` | `shared-runtime` | Highlight code using Shiki in PHP |
| `spatie/temporary-directory` | `2.3.1` | `no` | `laravel-extensions` | `shared-runtime` | Easily create, use and destroy temporary directories |
| `spipu/html2pdf` | `v5.3.3` | `yes` | `media-docs` | `media-export-pipeline` | Html2Pdf is a HTML to PDF converter written in PHP - It uses TCPDF - OFFICIAL PACKAGE |
| `squizlabs/php_codesniffer` | `3.13.5` | `no` | `quality-testing` | `shared-runtime` | PHP_CodeSniffer tokenizes PHP, JavaScript and CSS files and detects violations of a defined set of coding standards. |
| `staabm/side-effects-detector` | `1.0.5` | `no` | `supporting-lib` | `shared-runtime` | A static analysis tool to detect side effects in PHP code |
| `statikbe/laravel-cookie-consent` | `1.11.4` | `yes` | `supporting-lib` | `shared-runtime` | Cookie consent modal for EU |
| `staudenmeir/eloquent-has-many-deep` | `v1.21.2` | `yes` | `laravel-extensions` | `shared-runtime` | Laravel Eloquent HasManyThrough relationships with unlimited levels |
| `staudenmeir/eloquent-has-many-deep-contracts` | `v1.3` | `no` | `laravel-extensions` | `shared-runtime` | Contracts for staudenmeir/eloquent-has-many-deep |
| `staudenmeir/laravel-adjacency-list` | `v1.25.2` | `yes` | `laravel-extensions` | `shared-runtime` | Recursive Laravel Eloquent relationships with CTEs |
| `staudenmeir/laravel-cte` | `v1.12.4` | `no` | `laravel-extensions` | `shared-runtime` | Laravel queries with common table expressions |
| `symfony/cache` | `v7.4.5` | `no` | `foundational-lib` | `shared-runtime` | Provides extended PSR-6, PSR-16 (and tags) implementations |
| `symfony/cache-contracts` | `v3.6.0` | `no` | `foundational-lib` | `shared-runtime` | Generic abstractions related to caching |
| `symfony/clock` | `v7.4.0` | `no` | `foundational-lib` | `shared-runtime` | Decouples applications from the system clock |
| `symfony/console` | `v7.4.4` | `no` | `foundational-lib` | `shared-runtime` | Eases the creation of beautiful and testable command line interfaces |
| `symfony/css-selector` | `v7.4.0` | `no` | `foundational-lib` | `shared-runtime` | Converts CSS selectors to XPath expressions |
| `symfony/deprecation-contracts` | `v3.6.0` | `no` | `foundational-lib` | `shared-runtime` | A generic function and convention to trigger deprecation notices |
| `symfony/dom-crawler` | `v7.4.4` | `yes` | `foundational-lib` | `shared-runtime` | Eases DOM navigation for HTML and XML documents |
| `symfony/error-handler` | `v7.4.4` | `no` | `foundational-lib` | `shared-runtime` | Provides tools to manage errors and ease debugging PHP code |
| `symfony/event-dispatcher` | `v7.4.4` | `no` | `foundational-lib` | `shared-runtime` | Provides tools that allow your application components to communicate with each other by dispatching events and listening to them |
| `symfony/event-dispatcher-contracts` | `v3.6.0` | `no` | `foundational-lib` | `shared-runtime` | Generic abstractions related to dispatching event |
| `symfony/filesystem` | `v7.4.0` | `no` | `foundational-lib` | `shared-runtime` | Provides basic utilities for the filesystem |
| `symfony/finder` | `v7.4.5` | `no` | `foundational-lib` | `shared-runtime` | Finds files and directories via an intuitive fluent interface |
| `symfony/html-sanitizer` | `v7.4.0` | `no` | `foundational-lib` | `shared-runtime` | Provides an object-oriented API to sanitize untrusted HTML input for safe insertion into a document's DOM. |
| `symfony/http-client` | `v7.4.5` | `yes` | `foundational-lib` | `shared-runtime` | Provides powerful methods to fetch HTTP resources synchronously or asynchronously |
| `symfony/http-client-contracts` | `v3.6.0` | `no` | `foundational-lib` | `shared-runtime` | Generic abstractions related to HTTP clients |
| `symfony/http-foundation` | `v7.4.5` | `no` | `foundational-lib` | `shared-runtime` | Defines an object-oriented layer for the HTTP specification |
| `symfony/http-kernel` | `v7.4.5` | `no` | `foundational-lib` | `shared-runtime` | Provides a structured process for converting a Request into a Response |
| `symfony/mailer` | `v7.4.4` | `no` | `foundational-lib` | `shared-runtime` | Helps sending emails |
| `symfony/mime` | `v7.4.5` | `no` | `foundational-lib` | `shared-runtime` | Allows manipulating MIME messages |
| `symfony/options-resolver` | `v7.4.0` | `no` | `foundational-lib` | `shared-runtime` | Provides an improved replacement for the array_replace PHP function |
| `symfony/polyfill-ctype` | `v1.33.0` | `no` | `foundational-lib` | `shared-runtime` | Symfony polyfill for ctype functions |
| `symfony/polyfill-intl-grapheme` | `v1.33.0` | `no` | `foundational-lib` | `shared-runtime` | Symfony polyfill for intl's grapheme_* functions |
| `symfony/polyfill-intl-idn` | `v1.33.0` | `no` | `foundational-lib` | `shared-runtime` | Symfony polyfill for intl's idn_to_ascii and idn_to_utf8 functions |
| `symfony/polyfill-intl-normalizer` | `v1.33.0` | `no` | `foundational-lib` | `shared-runtime` | Symfony polyfill for intl's Normalizer class and related functions |
| `symfony/polyfill-mbstring` | `v1.33.0` | `no` | `foundational-lib` | `shared-runtime` | Symfony polyfill for the Mbstring extension |
| `symfony/polyfill-php80` | `v1.33.0` | `no` | `foundational-lib` | `shared-runtime` | Symfony polyfill backporting some PHP 8.0+ features to lower PHP versions |
| `symfony/polyfill-php81` | `v1.33.0` | `no` | `foundational-lib` | `shared-runtime` | Symfony polyfill backporting some PHP 8.1+ features to lower PHP versions |
| `symfony/polyfill-php82` | `v1.33.0` | `no` | `foundational-lib` | `shared-runtime` | Symfony polyfill backporting some PHP 8.2+ features to lower PHP versions |
| `symfony/polyfill-php83` | `v1.33.0` | `no` | `foundational-lib` | `shared-runtime` | Symfony polyfill backporting some PHP 8.3+ features to lower PHP versions |
| `symfony/polyfill-php84` | `v1.33.0` | `no` | `foundational-lib` | `shared-runtime` | Symfony polyfill backporting some PHP 8.4+ features to lower PHP versions |
| `symfony/polyfill-php85` | `v1.33.0` | `no` | `foundational-lib` | `shared-runtime` | Symfony polyfill backporting some PHP 8.5+ features to lower PHP versions |
| `symfony/polyfill-uuid` | `v1.33.0` | `no` | `foundational-lib` | `shared-runtime` | Symfony polyfill for uuid functions |
| `symfony/postmark-mailer` | `v7.4.4` | `yes` | `foundational-lib` | `shared-runtime` | Symfony Postmark Mailer Bridge |
| `symfony/process` | `v7.4.5` | `no` | `foundational-lib` | `shared-runtime` | Executes commands in sub-processes |
| `symfony/property-access` | `v7.4.4` | `no` | `foundational-lib` | `shared-runtime` | Provides functions to read and write from/to an object or array using a simple string notation |
| `symfony/property-info` | `v7.4.5` | `no` | `foundational-lib` | `shared-runtime` | Extracts information about PHP class' properties using metadata of popular sources |
| `symfony/psr-http-message-bridge` | `v7.4.4` | `no` | `foundational-lib` | `shared-runtime` | PSR HTTP message bridge |
| `symfony/routing` | `v7.4.4` | `no` | `foundational-lib` | `shared-runtime` | Maps an HTTP request to a set of configuration variables |
| `symfony/serializer` | `v7.4.5` | `no` | `foundational-lib` | `shared-runtime` | Handles serializing and deserializing data structures, including object graphs, into array structures or other formats like XML and JSON. |
| `symfony/service-contracts` | `v3.6.1` | `no` | `foundational-lib` | `shared-runtime` | Generic abstractions related to writing services |
| `symfony/stopwatch` | `v7.4.0` | `no` | `foundational-lib` | `shared-runtime` | Provides a way to profile code |
| `symfony/string` | `v7.4.4` | `no` | `foundational-lib` | `shared-runtime` | Provides an object-oriented API to strings and deals with bytes, UTF-8 code points and grapheme clusters in a unified way |
| `symfony/translation` | `v7.4.4` | `no` | `foundational-lib` | `shared-runtime` | Provides tools to internationalize your application |
| `symfony/translation-contracts` | `v3.6.1` | `no` | `foundational-lib` | `shared-runtime` | Generic abstractions related to translation |
| `symfony/type-info` | `v7.4.4` | `no` | `foundational-lib` | `shared-runtime` | Extracts PHP types information. |
| `symfony/uid` | `v7.4.4` | `no` | `foundational-lib` | `shared-runtime` | Provides an object-oriented API to generate and represent UIDs |
| `symfony/var-dumper` | `v7.4.4` | `no` | `foundational-lib` | `shared-runtime` | Provides mechanisms for walking through any arbitrary PHP variable |
| `symfony/var-exporter` | `v7.4.0` | `no` | `foundational-lib` | `shared-runtime` | Allows exporting any serializable PHP data structure to plain PHP code |
| `symfony/yaml` | `v7.4.1` | `no` | `foundational-lib` | `shared-runtime` | Loads and dumps YAML files |
| `ta-tikoma/phpunit-architecture-test` | `0.8.7` | `no` | `supporting-lib` | `shared-runtime` | Methods for testing application architecture |
| `tecnickcom/tcpdf` | `6.10.1` | `no` | `media-docs` | `media-export-pipeline` | TCPDF is a PHP class for generating PDF documents and barcodes. |
| `thecodingmachine/phpstan-safe-rule` | `v1.4.3` | `no` | `supporting-lib` | `shared-runtime` | A PHPStan rule to detect safety issues. Must be used in conjunction with thecodingmachine/safe |
| `thecodingmachine/safe` | `v3.4.0` | `yes` | `supporting-lib` | `shared-runtime` | PHP core functions that throw exceptions instead of returning FALSE on error |
| `theseer/tokenizer` | `2.0.1` | `no` | `supporting-lib` | `shared-runtime` | A small library for converting tokenized PHP source code into XML and potentially other formats |
| `tightenco/parental` | `v1.5.0` | `yes` | `supporting-lib` | `shared-runtime` | A simple eloquent trait that allows relationships to be accessed through child models. |
| `tijsverkoyen/css-to-inline-styles` | `v2.4.0` | `no` | `supporting-lib` | `shared-runtime` | CssToInlineStyles is a class that enables you to convert HTML-pages/files into HTML-pages/files with inline styles. This is very useful when you're sending emails. |
| `tomasvotruba/type-coverage` | `2.1.0` | `no` | `supporting-lib` | `shared-runtime` | Measure type coverage of your project |
| `ueberdosis/tiptap-php` | `2.1.0` | `no` | `supporting-lib` | `shared-runtime` | A PHP package to work with Tiptap output |
| `vlucas/phpdotenv` | `v5.6.3` | `no` | `supporting-lib` | `shared-runtime` | Loads environment variables from `.env` to `getenv()`, `$_ENV` and `$_SERVER` automagically. |
| `voku/portable-ascii` | `2.0.3` | `no` | `supporting-lib` | `shared-runtime` | Portable ASCII library - performance optimized (ascii) string functions for php. |
| `webmozart/assert` | `1.12.1` | `no` | `supporting-lib` | `shared-runtime` | Assertions to validate method input/output with nice error messages. |
| `wikimedia/composer-merge-plugin` | `v2.1.0` | `no` | `media-docs` | `media-export-pipeline` | Composer plugin to merge multiple composer.json files |

## Regeneration

Run from `laravel/`: `composer show --format=json` and regenerate this catalog.
