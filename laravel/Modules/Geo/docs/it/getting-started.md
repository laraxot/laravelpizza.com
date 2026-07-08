---
title: Modulo Tenant
description: Modulo Tenant
extends: _layouts.documentation
section: content
---

# Modulo Tenant {#modulo-tenant}

Questo modulo è dedicato alla gestione delle configurazioni dei vari domini utilizzati nella base.

Il modulo "module_tenant" è un pacchetto per Laravel che fornisce funzionalità per la gestione del multitenant in un'applicazione Laravel. Il multitenant consiste nella possibilità di gestire più tenant, ossia più clienti o utenti, all'interno di un'unica applicazione.

Per utilizzare il modulo, è necessario installarlo tramite Composer con il comando composer require laraxot/module_tenant. Una volta installato, il modulo può essere utilizzato nell'applicazione Laravel tramite il seguente codice:

Copy code
use Laraxot\ModuleTenant\Facades\ModuleTenant;
Il modulo include diverse funzionalità per la gestione del multitenant, come ad esempio il metodo addTenant() per aggiungere un nuovo tenant all'applicazione, o il metodo setCurrentTenant() per impostare il tenant corrente su cui verranno eseguite le operazioni.

Per utilizzare il modulo, è necessario prima configurare l'applicazione per supportare il multitenant. La configurazione può essere eseguita tramite il comando Artisan php artisan tenant:install, che creerà le tabelle del database necessarie per gestire i tenant e aggiungerà le route e i controller per la gestione dei tenant all'applicazione.
