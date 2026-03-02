# Gestione delle Route con Laravel Folio in il progetto

## Indice
1. [Introduzione](#introduzione)
2. [Named Routes in Laravel Folio](#named-routes-in-laravel-folio)
3. [Vantaggi dell'Uso di Named Routes](#vantaggi-delluso-di-named-routes)
4. [Implementazione in il progetto](#implementazione-in-<nome progetto>)
5. [Esempi Pratici](#esempi-pratici)
6. [Errori Comuni e Best Practices](#errori-comuni-e-best-practices)

## Introduzione

Questo documento descrive come vengono gestite le route in il progetto utilizzando Laravel Folio, con particolare attenzione all'uso delle named routes e alla funzione `route()` per generare URL.

## Named Routes in Laravel Folio

Laravel Folio permette di assegnare nomi alle route direttamente nei file Blade utilizzando la funzione `name()`. Questo è un esempio di come viene definita una named route in un file Folio:

```php
<?php
use function Laravel\Folio\{middleware, name};

middleware(['guest']);
name('register');

// Resto del codice...
?>
```

Questa dichiarazione assegna il nome 'register' alla route corrispondente al file in cui è definita, permettendo di riferirsi ad essa tramite questo nome in qualsiasi parte dell'applicazione.

## Vantaggi dell'Uso di Named Routes

L'utilizzo di named routes (`route('nome')`) invece di URL hardcoded (`/percorso/specifico`) offre numerosi vantaggi:

1. **Indipendenza dalla Struttura URL**: Se il percorso della route cambia, tutti i riferimenti ad essa rimangono validi perché si basano sul nome e non sul percorso.

2. **Gestione Automatica della Localizzazione**: La funzione `route()` gestisce automaticamente il prefisso della lingua corrente, eliminando la necessità di includerlo manualmente.

3. **Gestione dei Parametri**: I parametri possono essere passati in modo strutturato e sicuro.

4. **Manutenibilità**: Il codice è più facile da mantenere e aggiornare, poiché le modifiche alla struttura delle URL richiedono aggiornamenti solo nella definizione della route, non in tutti i punti in cui è referenziata.

5. **Coerenza**: Garantisce che tutti i link all'interno dell'applicazione siano coerenti e aggiornati.

## Implementazione in il progetto

In il progetto, tutte le pagine principali del frontoffice utilizzano named routes definite nei file Folio. Ecco come sono implementate:

1. **Definizione**: Nei file Blade di Folio, le route sono nominate usando `name('nome-route')`.

2. **Utilizzo**: Per generare URL verso queste route, si utilizza la funzione `route('nome-route')` invece di URL hardcoded.

3. **Contenuti Dinamici**: Nei file JSON dei contenuti, i link dovrebbero utilizzare `route('nome-route')` quando si riferiscono a pagine interne dell'applicazione.

## Esempi Pratici

### Esempio 1: Link alla Pagina di Registrazione

**Corretto (usando named route):**
```php
<a href="{{ route('register') }}">Registrati</a>
```

**Errato (URL hardcoded):**
```php
<a href="/register">Registrati</a>
```

### Esempio 2: In File JSON di Contenuto

**Corretto:**
```json
{
    "cta_text": "INIZIA ORA",
    "cta_link": "{{ route('register') }}"
}
```

**Errato:**
```json
{
    "cta_text": "INIZIA ORA",
    "cta_link": "/register"
}
```

## Errori Comuni e Best Practices

### Errori Comuni

1. **URL Hardcoded**: Utilizzare URL hardcoded come `/register` o `/it/auth/register` invece di `route('register')`.

2. **Mancata Gestione della Localizzazione**: Non considerare che la funzione `route()` gestisce automaticamente il prefisso della lingua.

3. **Inconsistenza**: Mescolare l'uso di URL hardcoded e named routes in diverse parti dell'applicazione.

### Best Practices

1. **Usa Sempre Named Routes**: Per tutti i link interni all'applicazione, utilizza sempre `route('nome-route')`.

2. **Documenta i Nomi delle Route**: Mantieni una documentazione aggiornata dei nomi delle route disponibili.

3. **Evita URL Hardcoded**: Non utilizzare mai URL hardcoded per le pagine interne dell'applicazione.

4. **Verifica i Nomi delle Route**: Prima di utilizzare un nome di route, verifica che sia effettivamente definito in un file Folio.

5. **Gestione Parametri**: Quando una route richiede parametri, passali come array associativo: `route('user.profile', ['id' => $userId])`.
