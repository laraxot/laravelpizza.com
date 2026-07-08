---
title: Il file xra.php
description: Il file xra.php
extends: _layouts.documentation
section: content
---

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
    'home' => 'template.homepage',
    // ...
];
```
esso indicherà che per la home del frontend verrà utilizzata la pagina blade laravel\Themes\pub_theme\Resources\views\home\template\homepage.blade.php.

Se non specificata, per la homepage del frontend verrà utilizzata la blade laravel\Themes\pub_theme\Resources\views\home\01.blade.php.

### Parametro adm_home {#parametro-adm_home}

Come il parametro 'home', anche il parametro **'adm_home'** indica la blade che verrà utilizzata per la homepage dell'amministrazione.

Di default viene utilizzata **laravel\Themes\adm_theme\Resources\views\admin\dashboard\01.blade.php**, blade importante perchè mette a disposizione l'utilizzo di blade personalizzate per ogni modulo utilizzato.

**nome_modulo::admin.dashboard.item** è la blade che dovrà essere creata per ogni modulo.
