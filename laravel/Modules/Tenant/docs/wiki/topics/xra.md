---
title: "Topic xra"
type: digest
status: active
qmd: "digest ceiling 100 xra"
---

# Topic xra

Sintesi automatica di 3 documenti (chiave `xra`).

## Versione HEAD

_Fonte: `it/config/xra.md`_

<?php

declare(strict_types=1);

return [
    'adm_home' => '01',
    'enable_ads' => '1',
    'main_module' => 'Ptv',
    'primary_lang' => 'it',
    'pub_theme' => 'One',
    'search_action' => 'it/search',
    'show_trans_key' => false,
    'disable_admin_dynamic_route' => true,
    'disable_frontend_dynamic_route' => true,
    'register_adm_theme' => false,
    'register_pub_theme' => false,
    'forcessl' => false,
];

## Collegamenti tra versioni di xra.md
* [xra.md](../../../xot/docs/install/xra.md)
* [xra.md](../../../tenant/docs/it/xra.md)
* [xra.md](../../../tenant/docs/it/config/xra.md)

---

## Il file xra.php {#il-file-xra}

_Fonte: `it/xra.md`_

# Il file xra.php {#il-file-xra}

Il file xra è uno dei file fondamentali. Ogni configurazione ne deve avere uno.

Esempio:

```php
return [
    'adm_theme' => 'AdminLTE',
    'main_module' => 'Blog',
    'primary_lang' => 'it',
    'pub_theme' => 'DirectoryBs5',
];
```
il parametro **main_module** determina quale sia il modulo principale che il progetto utilizza.

Il parametro **adm_theme** determina quale tra i temi installati nella base, nella cartella laravel/Themes, viene utilizzata per il backand/amministrazione.

Il parametro **pub_theme** determina quale tra i temi installati nella base, viene utilizzata per il frontend.

Il parametro **primary_lang** determina la lingua di default utilizzata nel progetto.

### Parametro home {#parametro-home}

Un altro parametro che si può inserire nel file xra.php è **'home'**:

```php
return [
    // ...

## xra

_Fonte: `xra.md`_
