---
title: About Tenant
description: About Tenant
extends: _layouts.documentation
section: content
---

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

Ciò creerà un nuovo database e eseguirà tutte le migrazioni necessarie per configurare lo schema del database del tenant.

Per passare a un database tenant, puoi utilizzare la funzione di supporto tenant. Ad esempio, per passare al database tenant acme, puoi utilizzare il seguente codice:

```bash
tenant('acme');
```
Da questo punto in poi, tutte le query verranno eseguite sul database tenant acme. Per tornare al database predefinito, puoi utilizzare la funzione di

Il modulo Laravel module_tenant è una libreria per la gestione del multitenant in Laravel. Offre una serie di funzionalità che facilitano la creazione e la gestione di un'applicazione multitenant in Laravel.

Per installare il modulo, puoi utilizzare Composer:

```bash
composer require laraxot/module_tenant
```
Una volta installato, puoi utilizzare il comando Artisan make:tenant per generare i modelli e i migrazioni per il multitenant:

```bash
php artisan make:tenant
```
Questo comando genererà i seguenti file:

app/Models/Tenant.php: il modello del tenant, che rappresenta un singolo tenant nell'applicazione.
app/Models/TenantConnection.php: il modello delle connessioni del tenant, che rappresenta una connessione del database per un tenant specifico.
database/migrations/<timestamp>_create_tenants_table.php: una migrazione per creare la tabella dei tenant nella base dati.
database/migrations/<timestamp>_create_tenant_connections_table.php: una migrazione per creare la tabella delle connessioni del tenant nella base dati.
Puoi quindi utilizzare i modelli per gestire i tenant nell'applicazione. Ad esempio, puoi creare un nuovo tenant come segue:

Copy code
use App\Models\Tenant;

// Crea un nuovo tenant
$tenant = Tenant::create([
    'name' => 'Acme Corp',
    'slug' => 'acme-corp',
    // Altri campi...
]);

// Crea una nuova connessione del database per il tenant
$tenant->connections()->create([
    'database' => 'acme_corp',
    'username' => 'acme_user',
    'password' => 'acme_password',
    // Altri campi...
]);
Il modulo offre anche altre funzionalità come:

Un middleware per gestire automaticamente il routing del tenant basato sull'URL.
Una facade per facilmente accedere al tenant corrente nell'applicazione.
Una classe TenantScope per facilmente applicare il tenant corrente come scopo globale per le query Eloquent.
Per ulteriori informazioni su come utilizzare il modulo, consulta la documentazione ufficiale sul sito web del suo autore o sulla pagina GitHub del progetto.