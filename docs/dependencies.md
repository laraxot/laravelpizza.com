# Dependencies (canonical)

This document is generated from `composer.json` + `composer.lock` and is the single source of truth for dependency auditing and chaos recovery.

## Runtime-critical packages

- **laravel/framework** `v12.53.0` - The Laravel Framework.
- **livewire/livewire** `v4.2.0` - A front-end framework for Laravel.
- **livewire/volt** `v1.10.3` - An elegantly crafted functional API for Laravel Livewire.
- **laravel/folio** `v1.1.13` - Page based routing for Laravel.
- **filament/filament** `v5.2.3` - A collection of full-stack components for accelerated Laravel app development.
- **nwidart/laravel-modules** `v12.0.4` - Laravel Module management

## Failure modes (what breaks when infected)

- **View / CMS rendering failures**: usually surface as `View [pub_theme::...] not found` (theme namespace, Folio pages, Blade include chain).
- **Interactive UI failures**: Livewire/Volt not mounting or assets missing; symptoms include no reactivity, JS errors, unstyled UI.
- **Modular autoload failures**: module discovery/autoload breaks -> missing classes, providers, translations.

## Safe diagnostics commands

- `composer validate`
- `php artisan about`
- `php artisan route:list`
- `php artisan view:clear && php artisan config:clear` (after fix)

## Validation vs installed state

This document is generated from `composer.lock`. A validation run against `composer show -f json` found **drift** between `composer.lock` and the installed vendor state.

- **Lock packages**: 228
- **Installed packages (composer show)**: 312
- **Version mismatches**: 67

Examples (lock -> installed):

- `laravel/framework` `v12.53.0` -> `v12.52.0`
- `livewire/livewire` `v4.2.0` -> `v4.1.4`
- `filament/filament` `v5.2.3` -> `v5.2.1`

Impact:

- Docs that assume exact versions from `composer.lock` may not match runtime behavior.
- Chaos/bug-injection failures may be non-reproducible if vendor differs from lock.

Recovery guidance:

- Prefer restoring a consistent state via `composer install` (and commit a correct `composer.lock` if it changed).
- Avoid `composer update` during recovery unless explicitly required and documented.

## Direct requirements (composer.json)

### require
- `php`: `^8.2`
- `filament/filament`: `^5.0`
- `laravel/folio`: `*`
- `laravel/framework`: `^12.0`
- `laravel/passport`: `^13`
- `livewire/livewire`: `^4.0`
- `livewire/volt`: `*`
- `nwidart/laravel-modules`: `^12.0`

### require-dev
- `filament/upgrade`: `^5.0`
- `nunomaduro/phpinsights`: `^2.13`
- `pestphp/pest-plugin-laravel`: `^4.0`

## Full dependency list (from composer.lock)

### Auth / OAuth

- **league/oauth1-client** `v1.11.0` - OAuth 1.0 Client Library
- **league/oauth2-server** `9.3.0` - A lightweight and powerful OAuth 2.0 authorization and resource server library with support for all the core specification grants. This library will allow you to secure your API with OAuth and allow your applications users to approve apps that want to access their data from your API.

### Filament / Admin

- **filament/actions** `v5.2.3` - Easily add beautiful action modals to any Livewire component.
- **filament/filament** `v5.2.3` - A collection of full-stack components for accelerated Laravel app development.
- **filament/forms** `v5.2.3` - Easily add beautiful forms to any Livewire component.
- **filament/infolists** `v5.2.3` - Easily add beautiful read-only infolists to any Livewire component.
- **filament/notifications** `v5.2.3` - Easily add beautiful notifications to any Livewire app.
- **filament/query-builder** `v5.2.3` - A powerful query builder component for Filament.
- **filament/schemas** `v5.2.3` - Easily add beautiful UI to any Livewire component.
- **filament/spatie-laravel-media-library-plugin** `v5.2.3` - Filament support for `spatie/laravel-medialibrary`.
- **filament/support** `v5.2.3` - Core helper methods and foundation code for all Filament packages.
- **filament/tables** `v5.2.3` - Easily add beautiful tables to any Livewire component.
- **filament/widgets** `v5.2.3` - Easily add beautiful dashboard widgets to any Livewire component.
- **saade/filament-fullcalendar** `v4.0.0-beta3` - The Most Popular JavaScript Calendar integrated with Filament 💛

### Laravel Core

- **laravel/folio** `v1.1.13` - Page based routing for Laravel.
- **laravel/framework** `v12.53.0` - The Laravel Framework.
- **laravel/passport** `v13.5.0` - Laravel Passport provides OAuth2 server support to Laravel.
- **laravel/pennant** `v1.20.0` - A simple, lightweight library for managing feature flags.
- **laravel/prompts** `v0.3.13` - Add beautiful and user-friendly forms to your command-line applications.
- **laravel/pulse** `v1.6.0` - Laravel Pulse is a real-time application performance monitoring tool and dashboard for your Laravel application.
- **laravel/sentinel** `v1.0.1` - 
- **laravel/serializable-closure** `v2.0.10` - Laravel Serializable Closure provides an easy and secure way to serialize closures in PHP.
- **laravel/socialite** `v5.24.3` - Laravel wrapper around OAuth 1 & OAuth 2 libraries.
- **laravel/tinker** `v2.11.1` - Powerful REPL for the Laravel framework.

### Livewire / Volt

- **danharrin/livewire-rate-limiting** `v2.1.0` - Apply rate limiters to Laravel Livewire actions.
- **livewire/flux** `v2.12.2` - The official UI component library for Livewire.
- **livewire/livewire** `v4.2.0` - A front-end framework for Laravel.
- **livewire/volt** `v1.10.3` - An elegantly crafted functional API for Laravel Livewire.

### Modules / Modular Monolith

- **nwidart/laravel-modules** `v12.0.4` - Laravel Module management

### Other

- **aaronfrancis/fast-paginate** `v2.0.0` - Fast paginate for Laravel
- **anourvalar/eloquent-serialize** `1.3.5` - Laravel Query Builder (Eloquent) serialization
- **aws/aws-crt-php** `v1.2.7` - AWS Common Runtime for PHP
- **aws/aws-sdk-php** `3.371.1` - AWS SDK for PHP - Use Amazon Web Services in your PHP project
- **blade-ui-kit/blade-heroicons** `2.6.0` - A package to easily make use of Heroicons in your Laravel Blade views.
- **blade-ui-kit/blade-icons** `1.9.0` - A package to easily make use of icons in your Laravel Blade views.
- **brick/math** `0.14.8` - Arbitrary-precision arithmetic library
- **calebporzio/sushi** `v2.5.4` - Eloquent's missing "array" driver.
- **carbonphp/carbon-doctrine-types** `3.2.0` - Types to use Carbon in Doctrine
- **chillerlan/php-qrcode** `5.0.5` - A QR Code generator and reader with a user-friendly API. PHP 7.4+
- **chillerlan/php-settings-container** `3.2.1` - A container class for immutable settings objects. Not a DI container.
- **composer/pcre** `3.3.2` - PCRE wrapping library that offers type-safe preg_* replacements.
- **composer/semver** `3.4.4` - Semver library that offers utilities, version constraint parsing and validation.
- **coolsam/panel-modules** `dev-dev` - Support for nwidart/laravel-modules in filamentphp
- **danharrin/date-format-converter** `v0.3.1` - Convert token-based date formats between standards.
- **defuse/php-encryption** `v2.4.0` - Secure PHP Encryption Library
- **dflydev/dot-access-data** `v3.0.3` - Given a deep data structure, access data by dot notation.
- **doctrine/dbal** `4.4.1` - Powerful PHP database abstraction layer (DBAL) with many features for database schema introspection and management.
- **doctrine/deprecations** `1.1.6` - A small layer on top of trigger_error(E_USER_DEPRECATED) or PSR-3 logging with options to disable all deprecations or selectively for packages.
- **doctrine/inflector** `2.1.0` - PHP Doctrine Inflector is a small library that can perform string manipulations with regard to upper/lowercase and singular/plural forms of words.
- **doctrine/lexer** `3.0.1` - PHP Doctrine Lexer parser library that can be used in Top-Down, Recursive Descent Parsers.
- **doctrine/sql-formatter** `1.5.4` - a PHP SQL highlighting library
- **dragonmantank/cron-expression** `v3.6.0` - CRON for PHP: Calculate the next or previous run date and determine if a CRON expression is due
- **egulias/email-validator** `4.0.4` - A library for validating emails against several RFCs
- **evenement/evenement** `v3.0.2` - Événement is a very simple event dispatching library for PHP
- **ezyang/htmlpurifier** `v4.19.0` - Standards compliant HTML filter written in PHP
- **facade/ignition-contracts** `1.0.2` - Solution contracts for Ignition
- **fidum/laravel-eloquent-morph-to-one** `2.5.0` - Adds MorphToOne relation to Laravel eloquent
- **firebase/php-jwt** `v7.0.3` - A simple library to encode and decode JSON Web Tokens (JWT) in PHP. Should conform to the current spec.
- **flowframe/laravel-trend** `v0.4.0` - Easily generate model trends
- **fruitcake/php-cors** `v1.4.0` - Cross-origin resource sharing library for the Symfony HttpFoundation
- **graham-campbell/result-type** `v1.1.4` - An Implementation Of The Result Type
- **guzzlehttp/guzzle** `7.10.0` - Guzzle is a PHP HTTP client library
- **guzzlehttp/promises** `2.3.0` - Guzzle promises library
- **guzzlehttp/psr7** `2.8.0` - PSR-7 message implementation that also provides common utility methods
- **guzzlehttp/uri-template** `v1.0.5` - A polyfill class for uri_template of PHP
- **intervention/gif** `4.2.4` - Native PHP GIF Encoder/Decoder
- **intervention/image** `3.11.7` - PHP Image Processing
- **irazasyed/telegram-bot-sdk** `v3.15.0` - The Unofficial Telegram Bot API PHP SDK
- **jaybizzle/crawler-detect** `v1.3.7` - CrawlerDetect is a PHP class for detecting bots/crawlers/spiders via the user agent
- **jenssegers/agent** `v2.6.4` - Desktop/mobile user agent parser with support for Laravel, based on Mobiledetect
- **kirschbaum-development/eloquent-power-joins** `4.2.11` - The Laravel magic applied to joins.
- **lara-zeus/spatie-translatable** `2.0.0` - Filament support for `spatie/laravel-translatable`.
- **laravel-notification-channels/telegram** `6.0.0` - Telegram Notifications Channel for Laravel
- **lcobucci/clock** `3.5.0` - Yet another clock abstraction
- **lcobucci/jwt** `5.6.0` - A simple library to work with JSON Web Token and JSON Web Signature
- **league/commonmark** `2.8.0` - Highly-extensible PHP Markdown parser which fully supports the CommonMark spec and GitHub-Flavored Markdown (GFM)
- **league/config** `v1.2.0` - Define configuration arrays with strict schemas and access values with dot notation
- **league/csv** `9.28.0` - CSV data manipulation made easy in PHP
- **league/event** `3.0.3` - Event package
- **league/flysystem** `3.32.0` - File storage abstraction for PHP
- **league/flysystem-local** `3.31.0` - Local filesystem adapter for Flysystem.
- **league/mime-type-detection** `1.16.0` - Mime-type detection for Flysystem
- **league/uri** `7.8.0` - URI manipulation library
- **league/uri-components** `7.8.0` - URI components manipulation library
- **league/uri-interfaces** `7.8.0` - Common tools for parsing and resolving RFC3987/RFC3986 URI
- **maatwebsite/excel** `3.1.67` - Supercharged Excel exports and imports in Laravel
- **maennchen/zipstream-php** `3.2.1` - ZipStream is a library for dynamically streaming dynamic zip files from PHP without writing to the disk at all on the server.
- **markbaker/complex** `3.0.2` - PHP Class for working with complex numbers
- **markbaker/matrix** `3.0.1` - PHP Class for working with matrices
- **masterminds/html5** `2.10.0` - An HTML5 parser and serializer.
- **mcamara/laravel-localization** `v2.3.0` - Easy localization for Laravel
- **mobiledetect/mobiledetectlib** `2.8.45` - Mobile_Detect is a lightweight PHP class for detecting mobile devices. It uses the User-Agent string combined with specific HTTP headers to detect the mobile environment.
- **monolog/monolog** `3.10.0` - Sends your logs to files, sockets, inboxes, databases and various web services
- **mtdowling/jmespath.php** `2.8.0` - Declaratively specify how to extract elements from a JSON document
- **mustache/mustache** `v2.14.2` - A Mustache implementation in PHP.
- **nesbot/carbon** `3.11.1` - An API extension for DateTime that supports 281 different languages.
- **nette/php-generator** `v4.2.2` - 🐘 Nette PHP Generator: generates neat PHP code for you. Supports new PHP 8.5 features.
- **nette/schema** `v1.3.5` - 📐 Nette Schema: validating data structures against a given Schema.
- **nette/utils** `v4.1.3` - 🛠  Nette Utils: lightweight utilities for string & array manipulation, image handling, safe JSON encoding/decoding, validation, slug or strong password generating etc.
- **nikic/php-parser** `v5.7.0` - A PHP parser written in PHP
- **nunomaduro/termwind** `v2.4.0` - It's like Tailwind CSS, but for the console.
- **openspout/openspout** `v4.32.0` - PHP Library to read and write spreadsheet files (CSV, XLSX and ODS), in a fast and scalable way
- **owenvoke/blade-fontawesome** `v2.9.1` - A package to easily make use of Font Awesome in your Laravel Blade views
- **paragonie/constant_time_encoding** `v3.1.3` - Constant-time Implementations of RFC 4648 Encoding (Base-64, Base-32, Base-16)
- **paragonie/random_compat** `v9.99.100` - PHP 5.x polyfill for random_bytes() and random_int() from PHP 7
- **pbmedia/laravel-ffmpeg** `8.9.0` - FFMpeg for Laravel
- **php-ffmpeg/php-ffmpeg** `v1.4.0` - FFMpeg PHP, an Object Oriented library to communicate with AVconv / ffmpeg
- **php-http/discovery** `1.20.0` - Finds and installs PSR-7, PSR-17, PSR-18 and HTTPlug implementations
- **phpdocumentor/reflection** `6.4.4` - Reflection library to do Static Analysis for PHP Projects
- **phpdocumentor/reflection-common** `2.2.0` - Common reflection classes used by phpdocumentor to reflect the code structure
- **phpdocumentor/reflection-docblock** `5.6.6` - With this component, a library can provide support for annotations via DocBlocks or otherwise retrieve information that is embedded in a DocBlock.
- **phpdocumentor/type-resolver** `1.12.0` - A PSR-5 based resolver of Class names, Types and Structural Element Names
- **phpoffice/phpspreadsheet** `1.30.2` - PHPSpreadsheet - Read, Create and Write Spreadsheet documents in PHP - Spreadsheet engine
- **phpoption/phpoption** `1.9.5` - Option Type for PHP
- **phpseclib/phpseclib** `3.0.49` - PHP Secure Communications Library - Pure-PHP implementations of RSA, AES, SSH2, SFTP, X.509 etc.
- **pragmarx/google2fa** `v9.0.0` - A One Time Password Authentication package, compatible with Google Authenticator.
- **pragmarx/google2fa-qrcode** `v3.0.0` - QR Code package for Google2FA
- **predis/predis** `v3.4.1` - A flexible and feature-complete Redis/Valkey client for PHP.
- **psr/cache** `3.0.0` - Common interface for caching libraries
- **psr/clock** `1.0.0` - Common interface for reading the clock.
- **psr/container** `2.0.2` - Common Container Interface (PHP FIG PSR-11)
- **psr/event-dispatcher** `1.0.0` - Standard interfaces for event handling.
- **psr/http-client** `1.0.3` - Common interface for HTTP clients
- **psr/http-factory** `1.1.0` - PSR-17: Common interfaces for PSR-7 HTTP message factories
- **psr/http-message** `2.0` - Common interface for HTTP messages
- **psr/http-server-handler** `1.0.2` - Common interface for HTTP server-side request handler
- **psr/http-server-middleware** `1.0.2` - Common interface for HTTP server-side middleware
- **psr/log** `3.0.2` - Common interface for logging libraries
- **psr/simple-cache** `3.0.0` - Common interfaces for simple caching
- **psy/psysh** `v0.12.20` - An interactive shell for modern PHP.
- **ralouphie/getallheaders** `3.0.3` - A polyfill for getallheaders.
- **ramsey/collection** `2.1.1` - A PHP library for representing and manipulating collections.
- **ramsey/uuid** `4.9.2` - A PHP library for generating and working with universally unique identifiers (UUIDs).
- **rinvex/countries** `v9.1.0` - Rinvex Countries is a simple and lightweight package for retrieving country details with flexibility. A whole bunch of data including name, demonym, capital, iso codes, dialling codes, geo data, currencies, flags, emoji, and other attributes for all 250 countries worldwide at your fingertips.
- **ryangjchandler/blade-capture-directive** `v1.1.0` - Create inline partials in your Blade templates with ease.
- **scrivo/highlight.php** `v9.18.1.10` - Server side syntax highlighter that supports 185 languages. It's a PHP port of highlight.js
- **socialiteproviders/auth0** `4.2.0` - Auth0 OAuth2 Provider for Laravel Socialite
- **socialiteproviders/manager** `v4.8.1` - Easily add new or override built-in providers in Laravel Socialite.
- **spatie/better-types** `1.1.0` - Improved abstraction for dealing with union and named types.
- **spatie/cpu-load-health-check** `1.0.5` - A Laravel Health check to monitor CPU load
- **spatie/eloquent-sortable** `5.0.1` - Sortable behaviour for eloquent models
- **spatie/enum** `3.13.0` - PHP Enums
- **spatie/image** `3.9.1` - Manipulate images with an expressive API
- **spatie/image-optimizer** `1.8.1` - Easily optimize images using PHP
- **spatie/invade** `2.1.0` - A PHP function to work with private properties and methods
- **spatie/laravel-activitylog** `4.12.1` - A very simple activity logger to monitor the users of your website or application
- **spatie/laravel-data** `4.20.0` - Create unified resources and data transfer objects
- **spatie/laravel-database-mail-templates** `3.7.2` - Render Laravel mailables using a template stored in the database.
- **spatie/laravel-event-sourcing** `7.15.0` - The easiest way to get started with event sourcing in Laravel
- **spatie/laravel-health** `1.38.0` - Monitor the health of a Laravel application
- **spatie/laravel-medialibrary** `11.21.0` - Associate files with Eloquent models
- **spatie/laravel-model-states** `2.12.1` - State support for Eloquent models
- **spatie/laravel-model-status** `1.20.0` - A package to enable assigning statuses to Eloquent Models
- **spatie/laravel-package-tools** `1.93.0` - Tools for creating Laravel packages
- **spatie/laravel-permission** `7.2.2` - Permission handling for Laravel 12 and up
- **spatie/laravel-personal-data-export** `4.3.2` - Create personal data downloads in a Laravel app
- **spatie/laravel-queueable-action** `2.17.0` - Queueable action support in Laravel
- **spatie/laravel-responsecache** `7.7.2` - Speed up a Laravel application by caching the entire response
- **spatie/laravel-schemaless-attributes** `2.6.0` - Add schemaless attributes to Eloquent models
- **spatie/laravel-sluggable** `3.8.0` - Generate slugs when saving Eloquent models
- **spatie/laravel-tags** `4.11.0` - Add tags and taggable behaviour to your Laravel app
- **spatie/laravel-translatable** `6.13.0` - A trait to make an Eloquent model hold translations
- **spatie/php-attribute-reader** `1.1.0` - A clean API for working with PHP attributes
- **spatie/php-structure-discoverer** `2.4.0` - Automatically discover structures within your PHP application
- **spatie/regex** `3.1.1` - A sane interface for php's built in preg_* functions
- **spatie/shiki-php** `2.3.3` - Highlight code using Shiki in PHP
- **spatie/temporary-directory** `2.3.1` - Easily create, use and destroy temporary directories
- **spipu/html2pdf** `v5.3.3` - Html2Pdf is a HTML to PDF converter written in PHP - It uses TCPDF - OFFICIAL PACKAGE
- **statikbe/laravel-cookie-consent** `1.11.4` - Cookie consent modal for EU
- **staudenmeir/eloquent-has-many-deep** `v1.21.2` - Laravel Eloquent HasManyThrough relationships with unlimited levels
- **staudenmeir/eloquent-has-many-deep-contracts** `v1.3` - Contracts for staudenmeir/eloquent-has-many-deep
- **staudenmeir/laravel-adjacency-list** `v1.25.2` - Recursive Laravel Eloquent relationships with CTEs
- **staudenmeir/laravel-cte** `v1.12.4` - Laravel queries with common table expressions
- **symfony/cache** `v7.4.6` - Provides extended PSR-6, PSR-16 (and tags) implementations
- **symfony/cache-contracts** `v3.6.0` - Generic abstractions related to caching
- **symfony/clock** `v7.4.0` - Decouples applications from the system clock
- **symfony/console** `v7.4.6` - Eases the creation of beautiful and testable command line interfaces
- **symfony/css-selector** `v7.4.6` - Converts CSS selectors to XPath expressions
- **symfony/deprecation-contracts** `v3.6.0` - A generic function and convention to trigger deprecation notices
- **symfony/dom-crawler** `v7.4.6` - Eases DOM navigation for HTML and XML documents
- **symfony/error-handler** `v7.4.4` - Provides tools to manage errors and ease debugging PHP code
- **symfony/event-dispatcher** `v7.4.4` - Provides tools that allow your application components to communicate with each other by dispatching events and listening to them
- **symfony/event-dispatcher-contracts** `v3.6.0` - Generic abstractions related to dispatching event
- **symfony/filesystem** `v7.4.6` - Provides basic utilities for the filesystem
- **symfony/finder** `v7.4.6` - Finds files and directories via an intuitive fluent interface
- **symfony/html-sanitizer** `v7.4.0` - Provides an object-oriented API to sanitize untrusted HTML input for safe insertion into a document's DOM.
- **symfony/http-client** `v7.4.6` - Provides powerful methods to fetch HTTP resources synchronously or asynchronously
- **symfony/http-client-contracts** `v3.6.0` - Generic abstractions related to HTTP clients
- **symfony/http-foundation** `v7.4.6` - Defines an object-oriented layer for the HTTP specification
- **symfony/http-kernel** `v7.4.6` - Provides a structured process for converting a Request into a Response
- **symfony/mailer** `v7.4.6` - Helps sending emails
- **symfony/mime** `v7.4.6` - Allows manipulating MIME messages
- **symfony/polyfill-ctype** `v1.33.0` - Symfony polyfill for ctype functions
- **symfony/polyfill-intl-grapheme** `v1.33.0` - Symfony polyfill for intl's grapheme_* functions
- **symfony/polyfill-intl-idn** `v1.33.0` - Symfony polyfill for intl's idn_to_ascii and idn_to_utf8 functions
- **symfony/polyfill-intl-normalizer** `v1.33.0` - Symfony polyfill for intl's Normalizer class and related functions
- **symfony/polyfill-mbstring** `v1.33.0` - Symfony polyfill for the Mbstring extension
- **symfony/polyfill-php80** `v1.33.0` - Symfony polyfill backporting some PHP 8.0+ features to lower PHP versions
- **symfony/polyfill-php82** `v1.33.0` - Symfony polyfill backporting some PHP 8.2+ features to lower PHP versions
- **symfony/polyfill-php83** `v1.33.0` - Symfony polyfill backporting some PHP 8.3+ features to lower PHP versions
- **symfony/polyfill-php84** `v1.33.0` - Symfony polyfill backporting some PHP 8.4+ features to lower PHP versions
- **symfony/polyfill-php85** `v1.33.0` - Symfony polyfill backporting some PHP 8.5+ features to lower PHP versions
- **symfony/polyfill-uuid** `v1.33.0` - Symfony polyfill for uuid functions
- **symfony/postmark-mailer** `v7.4.4` - Symfony Postmark Mailer Bridge
- **symfony/process** `v7.4.5` - Executes commands in sub-processes
- **symfony/property-access** `v7.4.4` - Provides functions to read and write from/to an object or array using a simple string notation
- **symfony/property-info** `v7.4.6` - Extracts information about PHP class' properties using metadata of popular sources
- **symfony/psr-http-message-bridge** `v7.4.4` - PSR HTTP message bridge
- **symfony/routing** `v7.4.6` - Maps an HTTP request to a set of configuration variables
- **symfony/serializer** `v7.4.6` - Handles serializing and deserializing data structures, including object graphs, into array structures or other formats like XML and JSON.
- **symfony/service-contracts** `v3.6.1` - Generic abstractions related to writing services
- **symfony/string** `v7.4.6` - Provides an object-oriented API to strings and deals with bytes, UTF-8 code points and grapheme clusters in a unified way
- **symfony/translation** `v7.4.6` - Provides tools to internationalize your application
- **symfony/translation-contracts** `v3.6.1` - Generic abstractions related to translation
- **symfony/type-info** `v7.4.6` - Extracts PHP types information.
- **symfony/uid** `v7.4.4` - Provides an object-oriented API to generate and represent UIDs
- **symfony/var-dumper** `v7.4.6` - Provides mechanisms for walking through any arbitrary PHP variable
- **symfony/var-exporter** `v7.4.0` - Allows exporting any serializable PHP data structure to plain PHP code
- **tecnickcom/tcpdf** `6.10.1` - TCPDF is a PHP class for generating PDF documents and barcodes.
- **thecodingmachine/safe** `v3.4.0` - PHP core functions that throw exceptions instead of returning FALSE on error
- **tightenco/parental** `v1.5.0` - A simple eloquent trait that allows relationships to be accessed through child models.
- **tijsverkoyen/css-to-inline-styles** `v2.4.0` - CssToInlineStyles is a class that enables you to convert HTML-pages/files into HTML-pages/files with inline styles. This is very useful when you're sending emails.
- **ueberdosis/tiptap-php** `2.1.0` - A PHP package to work with Tiptap output
- **vlucas/phpdotenv** `v5.6.3` - Loads environment variables from `.env` to `getenv()`, `$_ENV` and `$_SERVER` automagically.
- **voku/portable-ascii** `2.0.3` - Portable ASCII library - performance optimized (ascii) string functions for php.
- **webmozart/assert** `1.12.1` - Assertions to validate method input/output with nice error messages.
- **wikimedia/composer-merge-plugin** `v2.1.0` - Composer plugin to merge multiple composer.json files

### Testing / QA

- **phpstan/phpdoc-parser** `2.3.2` - PHPDoc parser with support for nullable, intersection and generic types
