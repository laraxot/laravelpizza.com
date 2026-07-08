---
title: Proiettore
description: Proiettore
extends: _layouts.documentation
section: content
---

# Proiettore {#proiettore}

per tracciare gli eventi, per avere uno storico di ciò che è successo
spatie/laravel-event-sourcing
gia installato su activity


## Definizione Eventi
Bisogna definire gli eventi (https://spatie.be/docs/laravel-event-sourcing/v7/using-projectors/writing-your-first-projector#content-defining-events)  
Ogni classe evento deve estendere \Spatie\EventSourcing\StoredEvents\ShouldBeStored    
classe astratta indica al nostro pacchetto che l'evento deve essere archiviato

## Classe Projection/Attivazione Evento
https://spatie.be/docs/laravel-event-sourcing/v7/using-projectors/writing-your-first-projector#content-lets-fire-off-some-events  
Per dare il "via/attivare" gli eventi, bisogna farlo tramite una classe che estende Projection (classe estende Eloquent Model)  
che include funzionalità che impediscono di salvare una proiezione che non è basata sul flusso di eventi.  
Il salvataggio senza chiamata writeable() genererà un'eccezione.


## Proiettore  
Un proiettore è una classe che ascolta gli eventi archiviati
Quando sente un evento che gli interessa, può eseguire del lavoro.  
per crearlo https://spatie.be/docs/laravel-event-sourcing/v7/using-projectors/writing-your-first-projector#content-creating-your-first-projector  
classe che ascolta gli eventi archiviati che gli interessano 

ModelloProjection::funzione_con_all_interno_la_chiamata_dell_evento(['name' => 'Luke']);  
che si possono eseguire dentro un controller o componente livewire(?).

Non dimentichiamoci di registrare questo proiettore:  
```php
// in a service provider of your own  
Projectionist::addProjector(NomeDelProiettore::class);
```

se si crea un proiettore in un momento in cui ci sono già verificati degli eventi che potrebbero interessargli, eseguire  
```php
php artisan event-sourcing:replay App\\Projectors\\TransactionCountProjector
```  
Questo comando prenderà tutti gli eventi già memorizzati nella stored_events tabella e li passerà a NomeDelProiettore  

La cosa bella dei proiettori è che puoi scriverli dopo che gli eventi si sono verificati

Per crearli eseguire
```php
php artisan make:projector YourNameProjector
``` 
nella cartella /Projectors

## Registrazione dei proiettori
Per impostazione predefinita, il pacchetto troverà e registrerà automaticamente tutti i proiettori trovati nell'applicazione.

In alternativa, è possibile registrare manualmente i proiettori nella projectorschiave del event-sourcingsfile di configurazione.

Puoi anche aggiungerli al file Projectionist. Questa operazione può essere eseguita ovunque, ma in genere lo faresti in un tuo ServiceProvider.

```php
namespace App\Providers;

use App\Projectors\YourProjector;
use Illuminate\Support\ServiceProvider;
use Spatie\EventSourcing\Facades\Projectionist;

class EventSourcingServiceProvider extends ServiceProvider
{
    public function register()
    {
        // adding a single projector
        Projectionist::addProjector(YourProjector::class);

        // you can also add multiple projectors in one go
        Projectionist::addProjectors([
            AnotherProjector::class,
            YetAnotherProjector::class,
        ]);
    }
}
``` 

## funzione aggregateRootUuid()
https://spatie.be/docs/laravel-event-sourcing/v7/using-projectors/creating-and-configuring-projectors#content-getting-the-uuid-of-an-event  

Nella maggior parte dei casi si desidera avere accesso all'evento attivato. Quando utilizzi gli aggregati, i tuoi eventi probabilmente non conterranno l'uuid associato a quell'evento. Per ottenere l'uuid di un evento è sufficiente chiamare il aggregateRootUuid()metodo sull'oggetto evento.

## Test
https://spatie.be/docs/laravel-event-sourcing/v7/using-projectors/writing-your-first-projector#content-using-factories-in-tests


## Proprietà $handlesEvents 
Registrazione manuale dei metodi di gestione degli eventi
https://spatie.be/docs/laravel-event-sourcing/v7/using-projectors/creating-and-configuring-projectors#content-manually-registering-event-handling-methods