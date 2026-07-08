---
title: Aggregati
description: Aggregati
extends: _layouts.documentation
section: content
---

# Aggregati {#aggregati}
Facilitano il processo decisionale basato su eventi passati.  
Classe che decide di registrare eventi in base a eventi passati.  

Per crearli eseguire
```php
php artisan make:aggregate YourNameAggregate
``` 
che creerà nella cartella /Aggregates
```php
namespace App\Aggregates;

use Spatie\EventSourcing\AggregateRoots\AggregateRoot;


class YourNameAggregate extends AggregateRoot
{
}
``` 

## Recupero di un aggregato
Un aggregato può essere recuperato con metodo statico in questo modo:
```php
YourNameAggregate::retrieve($uuid)
``` 
oppure
```php
$myAggregate = new YourNameAggregate();
$myAggregate->loadUuid($uuid);
``` 
utile quando si inseriscono radici aggregate in costruttori o classi in cui è supportata l'iniezione del metodo
```php
public function handle(YourNameAggregate $aggregate) {
    $aggregate->load($uuid);
    
    // ...
}
``` 