# ProfileFactory - Meetup Module

Factory per la creazione di profili nel contesto Meetup. Il profilo Meetup estende `BaseProfile` (User) ma usa la connessione `meetup` e uno schema ridotto.

## Schema Tabella

La tabella `profiles` (connessione meetup) contiene solo:

| Colonna | Tipo | Note |
|---------|------|------|
| id | string(36) | UUID (da migrazione 2026) |
| user_id | string(36) | Riferimento a users, nullable |
| first_name | string | Nome |
| last_name | string | Cognome |
| fiscal_code | string | Codice fiscale italiano |
| phone | string | Telefono |
| email | string | Email |
| notes | text | Note contestuali meetup |

**Non presenti** (a differenza di BaseProfile User): bio, status, locale, timezone, preferences, extra, type, address, birth_date, gender, avatar, is_active.

## Utilizzo Base

```php
use Modules\Meetup\Models\Profile;

// Profilo senza utente associato
$profile = Profile::factory()->create();

// Profilo con utente
$profile = Profile::factory()->withUser()->create();

// Più profili
$profiles = Profile::factory()->count(5)->create();
```

## Stati Disponibili

### withUser()

Associa il profilo a un utente creato automaticamente:

```php
$profile = Profile::factory()->withUser()->create();
// $profile->user_id è valorizzato
```

### withFiscalCode()

Imposta un codice fiscale italiano valido (formato 16 caratteri):

```php
$profile = Profile::factory()->withFiscalCode()->create();
```

### organizer()

Profilo tipico di organizzatore eventi (notes descrittive):

```php
$profile = Profile::factory()->organizer()->create();
```

### speaker()

Profilo tipico di speaker/relatore:

```php
$profile = Profile::factory()->speaker()->create();
```

## Combinazione Stati

```php
// Organizzatore con utente e codice fiscale
$organizer = Profile::factory()
    ->withUser()
    ->withFiscalCode()
    ->organizer()
    ->create();

// Speaker con utente
$speaker = Profile::factory()
    ->withUser()
    ->speaker()
    ->create();
```

## Relazione con EventPerformer

`EventPerformer` collega `Event` a `User`, non a `Profile`. Per creare speaker per un evento:

```php
$event = Event::factory()->create();
$speaker = User::factory()->create();
EventPerformer::factory()
    ->forEvent($event)
    ->forPerformer($speaker)
    ->create();
```

Il profilo Meetup è il contesto esteso (fiscal_code, notes) per un utente nella piattaforma meetup.

## Collegamenti

- [factories.md](factories.md) - Indice factory Meetup
- [Profile Model](../app/Models/Profile.php)
- [EventPerformerFactory](factories.md#eventperformerfactory)
- [task-person-profile-enhancement.md](task-person-profile-enhancement.md) - Schema.org Person (futuro)
