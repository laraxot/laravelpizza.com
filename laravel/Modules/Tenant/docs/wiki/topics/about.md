---
title: "Topic about"
type: digest
status: active
qmd: "digest ceiling 100 about"
---

# Topic about

Sintesi automatica di 3 documenti (chiave `about`).

## about

_Fonte: `about.md`_



## about

_Fonte: `bmad/about.md`_



## module_tenant

_Fonte: `it/about.md`_

# module_tenant

Il pacchetto Laravel module_tenant è un pacchetto che consente agli sviluppatori di configurare facilmente il multitenant nei loro applicazioni Laravel.

Per installare il pacchetto, puoi utilizzare Composer eseguendo il seguente comando:
```bash
composer require laraxot/module_tenant
```

Una volta installato il pacchetto, puoi registrare il provider di servizi nel file config/app.php aggiungendo la seguente riga all'array providers:

```bash
Laraxot\ModuleTenant\TenantServiceProvider::class,
```

Per pubblicare il file di configurazione del pacchetto, puoi eseguire il seguente comando:

```bash
php artisan vendor:publish --provider="Laraxot\ModuleTenant\TenantServiceProvider"
```

Ciò creerà un file config/module_tenant.php dove è possibile personalizzare le impostazioni del pacchetto.

Per creare un tenant, puoi utilizzare il comando Artisan laraxot:tenant. Ad esempio, per creare un tenant con il nome acme, puoi eseguire il seguente comando:

```bash
php artisan laraxot:tenant acme
```
