# PHPStan Critical Rules - INTOCCABILE

## 🚨 REGOLA ASSOLUTA 🚨

**MAI, MAI, MAI modificare il file `/var/www/html/_bases/base_<nome progetto>/laravel/phpstan.neon`**

## Motivazione

La configurazione PHPStan è stata impostata correttamente e non deve essere modificata. Qualsiasi errore PHPStan deve essere risolto **SOLO** modificando il codice sorgente, non la configurazione.

## Cosa Fare Invece

### ✅ CORRETTO - Modificare il Codice

Quando PHPStan segnala errori, correggere:

1. **Annotazioni PHPDoc** nei modelli
2. **Tipi di ritorno** dei metodi
3. **Tipizzazione dei parametri**
4. **Logica del codice** per rispettare i tipi

### ❌ VIETATO - Modificare phpstan.neon

Non aggiungere mai:
- Nuove regole `ignoreErrors`
- Modifiche ai `excludePaths`
- Cambi al `level`
- Alterazioni di qualsiasi configurazione

## Esempi di Correzioni Corrette

### Errori di Covarianza Relazioni Eloquent

**❌ SBAGLIATO**: Aggiungere ignore in phpstan.neon
**✅ CORRETTO**: Modificare le annotazioni PHPDoc

```php
// PRIMA (errore PHPStan)
/**
 * @return BelongsTo<User, MyModel>
 */
public function user(): BelongsTo

// DOPO (corretto)
/**
 * @return BelongsTo<User, self>
 */
public function user(): BelongsTo
```

### Errori di Tipo Missing

**❌ SBAGLIATO**: Ignorare l'errore
**✅ CORRETTO**: Aggiungere il tipo mancante

```php
// PRIMA (errore PHPStan)
public function process($data)
{
    return $data->transform();
}

// DOPO (corretto)
public function process(Collection $data): Collection
{
    return $data->transform();
}
```

### Errori di Proprietà Undefined

**❌ SBAGLIATO**: Ignorare l'errore
**✅ CORRETTO**: Aggiungere @property nel PHPDoc

```php
// PRIMA (errore PHPStan)
class MyModel extends Model
{
    // Proprietà non documentata
}

// DOPO (corretto)
/**
 * @property string $name
 * @property int $age
 */
class MyModel extends Model
{
    // Proprietà documentate
}
```

## Processo di Risoluzione Errori PHPStan

### Fase 1: Identificazione
```bash
./vendor/bin/phpstan analyze --level=9
```

### Fase 2: Analisi
- Leggere attentamente il messaggio di errore
- Identificare il file e la riga specifica
- Comprendere il tipo di errore

### Fase 3: Correzione del Codice
- Modificare **SOLO** i file di codice sorgente
- Correggere annotazioni, tipi, logica
- **MAI** toccare phpstan.neon

### Fase 4: Verifica
```bash
./vendor/bin/phpstan analyze path/to/fixed/file.php --level=9
```

## Tipi di Errori Comuni e Soluzioni

### 1. Covarianza Template Types
**Errore**: `Template type TDeclaringModel is not covariant`
**Soluzione**: Usare `self` nelle annotazioni delle relazioni

### 2. Missing Return Type
**Errore**: `Method X does not have a return type`
**Soluzione**: Aggiungere tipo di ritorno esplicito

### 3. Undefined Property
**Errore**: `Access to an undefined property`
**Soluzione**: Aggiungere @property nel PHPDoc della classe

### 4. Wrong Parameter Type
**Errore**: `Parameter expects X, Y given`
**Soluzione**: Correggere il tipo del parametro o il valore passato

### 5. Cannot Cast Mixed
**Errore**: `Cannot cast mixed to string`
**Soluzione**: Aggiungere controlli di tipo o casting esplicito

## Escalation

Se un errore PHPStan sembra impossibile da risolvere modificando solo il codice:

1. **Rianalizzare** il problema più approfonditamente
2. **Consultare** la documentazione PHPStan/Laravel
3. **Cercare** soluzioni alternative nel codice
4. **Documentare** il problema nelle docs del modulo
5. **MAI** modificare phpstan.neon come soluzione

## Best Practices

### Prevenzione Errori
1. **Sempre** usare `declare(strict_types=1);`
2. **Sempre** specificare tipi di ritorno
3. **Sempre** tipizzare i parametri
4. **Sempre** documentare proprietà con @property
5. **Sempre** usare `self` nelle relazioni Eloquent

### Qualità del Codice
- Mantenere PHPStan livello 9+
- Scrivere codice type-safe
- Documentare correttamente con PHPDoc
- Seguire le convenzioni Laravel

## Conseguenze della Violazione

Modificare phpstan.neon può causare:
- **Mascheramento di errori reali**
- **Degradazione della qualità del codice**
- **Problemi di manutenibilità**
- **Inconsistenza nel progetto**
- **Debito tecnico**

## Conclusione

La configurazione PHPStan è **SACRA** e **INTOCCABILE**. Tutti gli errori PHPStan devono essere risolti migliorando la qualità del codice, non nascondendo i problemi.

---

**Priorità**: 🚨 CRITICA  
**Applicabilità**: Universale  
**Violazioni**: 🚫 VIETATE ASSOLUTAMENTE  
**Stato**: ✅ Regola Attiva e Vincolante
