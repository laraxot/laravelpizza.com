# Guida alla Risoluzione degli Errori PHPStan Livello 9

Questa guida documenta i pattern di errore più comuni trovati durante l'analisi di livello 9 con PHPStan e le strategie per risolverli.

## Tipi di Errore Comuni e Soluzioni

### 1. Accesso a Valori `mixed`

PHPStan a livello 9 è molto più rigoroso riguardo ai valori di tipo `mixed`. A differenza dei livelli inferiori, non consente automaticamente l'accesso a chiavi di array o proprietà su un valore `mixed`.

#### Errori comuni:
- `Cannot access offset 'xxx' on mixed`
- `Cannot call method xxx() on mixed`
- `Part $variable (mixed) of encapsed string cannot be cast to string`

#### Soluzione:
Aggiungere controlli espliciti di tipo prima di accedere alla proprietà o chiamare il metodo:

```php
// Errato
$result = $data['key'];

// Corretto
if (is_array($data) && isset($data['key'])) {
    $result = $data['key'];
}

// Oppure con assert
assert(is_array($data));
$result = $data['key'];

// Per la conversione in stringhe:
// Errato
$message = "Value: {$value}";

// Corretto
$message = "Value: " . (is_scalar($value) ? (string) $value : '');
```

### 2. Operazioni Binarie con Tipi `mixed`

Non è possibile concatenare una stringa con un valore di tipo `mixed`.

#### Errori comuni:
- `Binary operation "." between mixed and ' ' results in an error`
- `Binary operation "." between non-falsy-string and mixed results in an error`

#### Soluzione:
```php
// Errato
$fullName = $firstName . ' ' . $lastName;

// Corretto
$firstName = is_scalar($firstName) ? (string) $firstName : '';
$lastName = is_scalar($lastName) ? (string) $lastName : '';
$fullName = $firstName . ' ' . $lastName;
```

### 3. Cast di Tipi `mixed`

Non è possibile fare un cast diretto di `mixed` a tipi come `int`, `float` o `string`.

#### Errori comuni:
- `Cannot cast mixed to int`
- `Cannot cast mixed to float`
- `Cannot cast mixed to string`

#### Soluzione:
```php
// Errato
$total = (float) $amount;

// Corretto
$total = is_numeric($amount) ? (float) $amount : 0.0;
```

### 4. Parametri di Funzione con Tipo Errato

I tipi di parametri non corrispondono a quelli attesi dalla funzione.

#### Errori comuni:
- `Parameter #1 $xxx of method Yyy::zzz() expects string, mixed given`
- `Parameter #1 $xxx of function yyy() expects string, mixed given`
- `Parameter #1 $xxx of function yyy() expects string, string|null given`

#### Soluzione:
```php
// Errato
function processPath($path) {
    return base_path($path);
}

// Corretto
function processPath($path) {
    if (!is_string($path)) {
        $path = '';  // o lancia un'eccezione, o un valore di default appropriato
    }
    return base_path($path);
}
```

### 5. Errori nei Tipi di Ritorno

I tipi di ritorno non corrispondono a quelli dichiarati.

#### Errori comuni:
- `Method Xxx::yyy() should return int|null but returns mixed`
- `Method Xxx::yyy() should return array<int, array<string, mixed>> but returns array<mixed>`

#### Soluzione:
```php
// Errato
public function getValue(): int
{
    return $this->data['value'];
}

// Corretto
public function getValue(): int
{
    return isset($this->data['value']) && is_numeric($this->data['value']) 
        ? (int) $this->data['value'] 
        : 0;
}
```

### 6. Errori nei Tipi Generici

Mancanza di specificazione completa dei tipi generici nelle annotazioni dei metodi.

#### Errori comuni:
- `Generic type Xxx<Yyy> in PHPDoc tag @return does not specify all template types of class Xxx: Zzz, Www`

#### Soluzione:
```php
// Errato
/**
 * @return BelongsToMany<User>
 */
public function users()

// Corretto
/**
 * @return BelongsToMany<User, BaseProfile>
 */
public function users()
```

## Strategie Generali

1. **Controlli di tipo espliciti**: Aggiungere sempre controlli di tipo prima di utilizzare valori che potrebbero essere `mixed`.
2. **Asserzioni di tipo**: Utilizzare `assert()` per informare PHPStan sul tipo di una variabile.
3. **Valori predefiniti sicuri**: Fornire valori predefiniti tipizzati quando un valore potrebbe essere `null` o `mixed`.
4. **Annotazioni PHPDoc complete**: Assicurarsi che le annotazioni PHPDoc specifichino tutti i tipi generici richiesti.
5. **Tipi di ritorno espliciti**: Garantire che i metodi restituiscano esattamente il tipo dichiarato, con conversioni esplicite se necessario.

## Annotazioni per Ignorare Errori Specifici

In alcuni casi è necessario ignorare errori specifici. Utilizzare queste annotazioni con parsimonia:

```php
/** @phpstan-ignore-next-line */
$value = $data['key'];

// Oppure
$value = $data['key']; /** @phpstan-ignore-line */
```

Per categorie specifiche:
```php
/** @phpstan-ignore offsetAccess.nonOffsetAccessible */
$value = $data['key'];
``` 