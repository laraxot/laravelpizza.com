---
title: "Topic auth"
type: digest
status: active
qmd: "digest ceiling 100 auth"
---

# Topic auth

Sintesi automatica di 3 documenti (chiave `auth`).

## auth

_Fonte: `auth.md`_



## auth

_Fonte: `bmad/auth.md`_



## Versione HEAD

_Fonte: `it/config/auth.md`_

<?php

declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    |
    | This option controls the default authentication "guard" and password
    | reset options for your application. You may change these defaults
    | as required, but they're a perfect start for most applications.
    |
    */

    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    |
    | Next, you may define every authentication guard for your application.
    | Of course, a great default configuration has been defined for you
    | here which uses session storage and the Eloquent user provider.
    |
