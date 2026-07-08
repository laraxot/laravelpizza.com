# Guida alla Validazione con PHPStan Livello 7

## Introduzione

A partire dal 10 Marzo 2025, tutti i moduli del progetto devono essere validati con PHPStan a livello 7. Questo documento fornisce una guida completa su come eseguire la validazione, risolvere gli errori comuni e mantenere il codice conforme agli standard richiesti.

## Esecuzione della Validazione

### Validazione di Tutti i Moduli

Per validare tutti i moduli con PHPStan a livello 7:

```bash
# Posizionarsi nella directory principale di Laravel
cd /path/to/laravel
vendor/bin/phpstan analyse Modules --configuration=phpstan.neon
```

### Validazione di un Singolo Modulo

Per validare un singolo modulo:

```bash
# Posizionarsi nella directory principale di Laravel
cd /path/to/laravel
vendor/bin/phpstan analyse Modules/NomeModulo --configuration=phpstan.neon
```

### Generazione di un Baseline

Se ci sono troppi errori da risolvere immediatamente, è possibile generare un baseline:

```bash
# Posizionarsi nella directory principale di Laravel
cd /path/to/laravel
vendor/bin/phpstan analyse Modules/NomeModulo --configuration=phpstan.neon --generate-baseline
```

Questo creerà un file `phpstan-baseline.neon` che ignora gli errori esistenti, permettendo di concentrarsi sui nuovi errori.

## Errori Comuni e Soluzioni

### 1. Array Associativi nei Componenti Filament

#### Problema
```php
// ERRATO: Array numerico
public function getListTableColumns(): array
{
    return [
        TextColumn::make('name'),
        TextColumn::make('email'),
    ];
}
```

#### Soluzione
```php
// CORRETTO: Array associativo con chiavi string
public function getListTableColumns(): array
{
    return [
        'name' => TextColumn::make('name'),
        'email' => TextColumn::make('email'),
    ];
}
```

### 2. Accesso a Array Mixed

#### Problema
```php
// ERRATO: Accesso diretto a mixed
$lat = $response['results'][0]['geometry']['location']['lat'];
```

#### Soluzione
```php
// CORRETTO: Validazione e cast
/** @var array{results: array{0: array{geometry: array{location: array{lat: float}}}}} $response */
$response = $this->validateResponse($response);
$lat = $response['results'][0]['geometry']['location']['lat'];

private function validateResponse(mixed $response): array
{
    if (!is_array($response)) {
        throw new InvalidArgumentException('Response must be an array');
    }
    // Validazione della struttura
    return $response;
}
```

### 3. Generics nelle Collections

#### Problema
```php
// ERRATO: Type non specificato
/** @var Collection */
private $items;
```

#### Soluzione
```php
// CORRETTO: Specificare il tipo generico
/** @var Collection<int, \App\Models\User> */
private $items;
```

### 4. Cast e Conversioni di Tipo

#### Problema
```php
// ERRATO: Cast diretto da mixed
$latitude = (float)$data['latitude'];
```

#### Soluzione
```php
// CORRETTO: Validazione e poi cast
$latitude = is_numeric($data['latitude']) 
    ? (float)$data['latitude']
    : throw new InvalidArgumentException('Latitude must be numeric');
```

## Best Practices per PHPStan Livello 7

### 1. Dichiarare Sempre i Tipi di Ritorno

```php
// ERRATO
public function getUser()
{
    return User::find($this->user_id);
}

// CORRETTO
public function getUser(): ?User
{
    return User::find($this->user_id);
}
```

### 2. Utilizzare strict_types=1 in Tutti i File

```php
<?php

declare(strict_types=1);

namespace Modules\NomeModulo;

// Resto del codice
```

### 3. Documentare i Tipi Generici nelle Collections

```php
/**
 * @return Collection<int, User>
 */
public function getActiveUsers(): Collection
{
    return User::where('active', true)->get();
}
```

### 4. Validare i Dati Esterni Prima di Accedervi

```php
public function processApiResponse(mixed $response): void
{
    if (!is_array($response) || !isset($response['data']) || !is_array($response['data'])) {
        throw new InvalidArgumentException('Invalid API response format');
    }
    
    foreach ($response['data'] as $item) {
        // Ora è sicuro processare $item
    }
}
```

### 5. Utilizzare Array Associativi per i Componenti Filament

```php
public function getFormSchema(): array
{
    return [
        'name' => TextInput::make('name'),
        'active' => Toggle::make('active'),
    ];
}

public function getTableActions(): array
{
    return [
        'edit' => EditAction::make(),
        'delete' => DeleteAction::make(),
    ];
}
```

## Configurazione PHPStan

Il file di configurazione principale (`phpstan.neon`) è già impostato per il livello 7:

```neon
parameters:
    level: 7
    paths:
        - ./Modules
        - ./Themes
    # Altre configurazioni...
```

Ogni modulo può avere la propria configurazione specifica in `Modules/NomeModulo/phpstan.neon.dist`.

## Risoluzione dei Problemi

### Errore: "Call to an undefined method"

Questo errore si verifica quando si chiama un metodo che non esiste nella classe o nelle sue classi parent. Soluzioni:

1. Verificare che il metodo esista nella classe o nelle sue classi parent
2. Aggiungere un'annotazione `@method` nella classe per informare PHPStan del metodo
3. Implementare il metodo mancante

### Errore: "Access to an undefined property"

Questo errore si verifica quando si accede a una proprietà che non è dichiarata nella classe. Soluzioni:

1. Dichiarare la proprietà nella classe
2. Aggiungere un'annotazione `@property` nella classe
3. Utilizzare `@phpstan-ignore-next-line` se necessario (ma solo come ultima risorsa)

## Conclusione

Mantenere il codice conforme a PHPStan livello 7 garantisce una maggiore qualità e robustezza del software. Seguendo le best practices e risolvendo gli errori in modo sistematico, è possibile migliorare significativamente la manutenibilità e l'affidabilità del codice.
