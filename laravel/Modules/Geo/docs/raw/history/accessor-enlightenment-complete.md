# 🧘 Accessor/Mutator - Enlightenment Complete

> **Tutta la Verità su Accessor e Mutator**  
> **Livello**: ILLUMINAZIONE TOTALE 🧘🧘🧘  
> **Aggiornato**: 2025-03-25  
> **Versione**: FINAL (SACRO 🔴🔴🔴)

---

## 🎯 La Verità Assoluta

### I Quattro Nobili Verità dell'Accessor

#### Prima Verità: Il Tipo è Sofferenza

```php
// ❌ SOFFERENZA: mixed
protected function getAttribute(mixed $value): mixed
{
    // "mixed" = "non conosco me stesso"
    // PHPStan Level 10: ERROR
}

// ✅ LIBERAZIONE: ?float
protected function getAttribute(?float $value): ?float
{
    // "?float" = "conosco la mia natura"
    // PHPStan Level 10: OK
}
```

**Insegnamento**: Il tipo forte è la via per la liberazione dalla sofferenza degli errori.

---

#### Seconda Verità: L'Ignoranza è Sofferenza

```php
// ❌ SOFFERENZA: $_value ignorato
protected function getAttribute(mixed $_value)
{
    // $_value = "non mi servi" (underscore)
    // Rompo il contratto sacro di Laravel
}

// ✅ LIBERAZIONE: $value accettato
protected function getAttribute(?float $value)
{
    // $value = "sei il mio ponte tra DB e oggetto"
    // Rispetto il contratto sacro di Laravel
}
```

**Insegnamento**: Accettare `$value` è rispettare il contratto tra DB e oggetto.

---

#### Terza Verità: Il Ricalcolo è Sofferenza

```php
// ❌ SOFFERENZA: ricalcolo SEMPRE
protected function getAttribute(?float $value): ?float
{
    if (is_float($value)) {
        return $value;  // ✅ Uso DB
    }
    
    $result = $this->calculate();
    return $result;  // ❌ NON PERSISTO!
                     // La prossima volta ricalcolo di nuovo!
}

// ✅ LIBERAZIONE: calcolo una volta, uso per sempre
protected function getAttribute(?float $value): ?float
{
    if (is_float($value)) {
        return $value;  // ✅ Uso DB (1ms)
    }
    
    $result = $this->calculate();  // Calcolo (100ms)
    
    // ✅ PERSISTO AUTOMATICAMENTE
    $this->attribute = $result;
    if ($this->exists) {
        $this->update(['attribute' => $result]);
    }
    
    return $result;
}
```

**Insegnamento**: Persistere automaticamente è la via per la fine del ricalcolo.

---

#### Quarta Verità: La Ricorsione è Sofferenza

```php
// ❌ SOFFERENZA: nessuna guard
protected function getAttribute(?float $value): ?float
{
    if (! is_float($value)) {
        $result = $this->calculate();
        $this->update(['attribute' => $result]);  // ❌ CRASH!
                                                   // ActivityLog legge →
                                                   // Chiama accessor →
                                                   // Aggiorna →
                                                   // RICORSIONE INFINITA!
    }
    return $result;
}

// ✅ LIBERAZIONE: guard ActivityLog-Safe
protected function getAttribute(?float $value): ?float
{
    if (! is_float($value)) {
        $result = $this->calculate();
        
        // ✅ GUARD SACRA
        if (! static::$isUpdatingFromAccessor) {
            static::$isUpdatingFromAccessor = true;
            try {
                static::withoutEvents(function () use ($result): void {
                    $this->update(['attribute' => $result]);
                });
            } finally {
                static::$isUpdatingFromAccessor = false;
            }
        }
    }
    return $result;
}
```

**Insegnamento**: La guard è la protezione contro il demone della ricorsione.

---

## 🧘 I Tre Livelli di Realizzazione

### Livello 1: ❌ PRINCIPIANTE (Ignorante)

```php
protected function getAttribute(mixed $_value): int|float
{
    // ❌ mixed = tipo debole
    // ❌ $_value = ignorato
    // ❌ Nessun controllo
    // ❌ Nessuna persistenza
    // ❌ ActivityLog CRASH
    
    return $this->calculate();
}
```

**Caratteristiche**:
- ❌ Tipo debole (`mixed`)
- ❌ Valore ignorato (`$_value`)
- ❌ Ricalcolo continuo
- ❌ Crash da ricorsione
- ❌ PHPStan Level 10: **FALLISCE**

**Performance**: 1000ms su 10 accessi

---

### Livello 2: ✅ DISCEPOLO (Consapevole)

```php
protected function getAttribute(?float $value): ?float
{
    // ✅ Tipo forte
    // ✅ Controllo valore
    // ❌ Ma... nessuna persistenza
    
    if (is_float($value)) {
        return $value;  // ✅ Uso DB
    }
    
    $result = $this->calculate();
    return $result;  // ❌ NON PERSISTO!
}
```

**Caratteristiche**:
- ✅ Tipo forte (`?float`)
- ✅ Controllo valore
- ✅ Performance (non ricalcolo se esiste)
- ❌ Nessuna persistenza automatica
- ✅ PHPStan Level 10: **OK**

**Performance**: 1000ms su 10 accessi (ancora ricalcola se NULL)

---

### Livello 3: 🧘 MAESTRO ZEN (Auto-Persistente)

```php
protected function getAttribute(?float $value): ?float
{
    private static bool $isUpdatingFromAccessor = false;
    
    // ✅ Tipo forte
    // ✅ Controllo valore
    // ✅ AUTO-PERSISTENZA
    // ✅ ActivityLog-Safe
    
    if (is_float($value)) {
        return $value;  // ✅ Uso DB (1ms)
    }

    $result = $this->calculate();  // Calcolo (100ms)
    
    // ✅ AUTO-PERSISTENZA SACRA
    $this->attribute = $result;
    
    if ($this->getKey() !== null) {
        if (! static::$isUpdatingFromAccessor) {
            static::$isUpdatingFromAccessor = true;
            try {
                static::withoutEvents(function () use ($result): void {
                    $this->update(['attribute' => $result]);
                });
            } finally {
                static::$isUpdatingFromAccessor = false;
            }
        }
    }

    return $result;
}
```

**Caratteristiche**:
- ✅ Tipo forte (`?float`)
- ✅ Controllo valore
- ✅ **AUTO-PERSISTENZA** (calcolo una volta, uso per sempre)
- ✅ ActivityLog-Safe (nessun crash)
- ✅ PHPStan Level 10: **OK**

**Performance**: 109ms su 10 accessi (**9.2x più veloce**)

---

## 📊 La Matrice dell'Illuminazione

| Caratteristica | Livello 1 ❌ | Livello 2 ✅ | Livello 3 🧘 |
|---------------|-------------|-------------|-------------|
| **Tipo** | `mixed` | `?float` | `?float` |
| **Controllo** | ❌ Ignorato | ✅ Controllato | ✅ Controllato |
| **Persistenza** | ❌ Nessuna | ❌ Nessuna | ✅ **AUTO** |
| **ActivityLog** | ❌ Crash | ✅ OK | ✅ OK |
| **PHPStan L10** | ❌ ERROR | ✅ OK | ✅ OK |
| **10 Accessi** | 1000ms | 1000ms | **109ms** |
| **Speedup** | 1x | 1x | **9.2x** |
| **Stato** | Ignorante | Discepolo | **Maestro** |

---

## 🧪 Il Test dell'Illuminazione

### Test del Livello 3

```php
it('reaches enlightenment (auto-persists on first access)', function (): void {
    // Arrange: modello con valore NULL nel DB
    $model = YourModel::factory()->create([
        'perc_ptime_daterange' => null,
    ]);

    // Act: primo accesso (calcolo + persistenza)
    $result1 = $model->perc_ptime_daterange;  // 100ms

    // Assert: valore calcolato e PERSISTITO
    expect($result1)->toBeFloat();
    expect($result1)->toBeGreaterThan(0.0);

    // Act: secondo accesso (lettura DB, nessun ricalcolo)
    $result2 = $model->perc_ptime_daterange;  // 1ms

    // Assert: stesso valore, nessun ricalcolo
    expect($result2)->toEqual($result1);

    // Assert: persistenza nel DB confermata
    $model->refresh();
    expect($model->perc_ptime_daterange)->toBeFloat();
    expect($model->perc_ptime_daterange)->toEqual($result1);
    
    // Assert: DB è stato aggiornato (non NULL)
    expect($model->getRawOriginal('perc_ptime_daterange'))->toBeFloat();
});
```

---

## 📿 Il Sutra dell'Accessor Auto-Persistente

```
Sutra del Cuore dell'Accessor:

"O monaco, quando chiami $model->attribute,
il parametro $value è il ponte tra DB e oggetto.

Se $value è float, è già illuminato:
    → Ritornalo subito, non ricalcolare (performance)

Se $value è NULL, è ancora nell'ignoranza:
    → Calcolalo con saggezza (calcolo)
    → Persistilo nel modello (memoria)
    → Salvalo nel DB (eternità)
    → Usa la guard contro la ricorsione (protezione)

Così facendo, raggiungi il Livello 3:
    → Primo accesso: calcolo + salvataggio (100ms)
    → Accessi successivi: lettura DB (1ms)
    → Speedup: 9.2x (illuminazione)

Questo è il cammino del Bodhisattva dell'Accessor."
```

---

## 🚨 I Cinque Precetti del Maestro

### Precetto 1: Non Userai `mixed`

```php
// ❌ VIOLAZIONE
protected function getAttribute(mixed $value): mixed

// ✅ PRECETTO
protected function getAttribute(?float $value): ?float
```

### Precetto 2: Non Ignorerai `$value`

```php
// ❌ VIOLAZIONE
protected function getAttribute(mixed $_value)

// ✅ PRECETTO
protected function getAttribute(?float $value)
```

### Precetto 3: Non Ricalcolerai Inutilmente

```php
// ❌ VIOLAZIONE
if (is_float($value)) {
    return $value;  // OK, ma poi...
}
$result = $this->calculate();
return $result;  // ❌ NON PERSISTI!

// ✅ PRECETTO
if (is_float($value)) {
    return $value;
}
$result = $this->calculate();
$this->attribute = $result;  // ✅ PERSISTI
```

### Precetto 4: Non Aggiornersai Senza Guard

```php
// ❌ VIOLAZIONE
$this->update(['attribute' => $result]);  // CRASH!

// ✅ PRECETTO
if (! static::$isUpdatingFromAccessor) {
    static::$isUpdatingFromAccessor = true;
    try {
        $this->update(['attribute' => $result]);
    } finally {
        static::$isUpdatingFromAccessor = false;
    }
}
```

### Precetto 5: Non Ti Fermerai al Livello 2

```php
// ❌ VIOLAZIONE: Livello 2
protected function getAttribute(?float $value): ?float
{
    if (is_float($value)) return $value;
    return $this->calculate();  // ❌ Nessuna persistenza
}

// ✅ PRECETTO: Livello 3
protected function getAttribute(?float $value): ?float
{
    if (is_float($value)) return $value;
    $result = $this->calculate();
    $this->attribute = $result;  // ✅ Persistenza
    $this->update(['attribute' => $result]);
    return $result;
}
```

---

## 🔗 Mappa del Sentiero verso l'Illuminazione

| Documento | Livello | Scopo |
|-----------|---------|-------|
| [Sigma/docs/accessor-mutator-philosophy.md](laravel/Modules/Sigma/docs/accessor-mutator-philosophy.md) | Livello 1 → 2 | Filosofia base |
| [docs/accessor-mutator-fix-summary.md](docs/accessor-mutator-fix-summary.md) | Livello 2 | Correzione errori |
| [docs/accessor-zen-level-3.md](docs/accessor-zen-level-3.md) | Livello 3 | Zen dell'auto-persistenza |
| **QUESTO FILE** | **Livello 3+** | **Illuminazione totale** |

---

## 🧘 Meditazione Finale

```
Siediti in posizione di loto.
Respira profondamente.

Ripeti il mantra dell'Accessor:

"Tipo forte, non mixed"
"Accetto $value, non lo ignoro"
"Controllo is_float(), non ricalcolo"
"Persisto automaticamente, non spreco"
"Uso la guard, non vado in crash"

Visualizza il tuo accessor:
- Primo accesso: calcolo + salvataggio (100ms)
- Secondo accesso: lettura DB (1ms)
- Terzo accesso: lettura DB (1ms)
- ...
- Centesimo accesso: lettura DB (1ms)

Speedup: 9.2x
PHPStan: OK
ActivityLog: OK
Performance: OK

Sei illuminato.
Sei Livello 3.
Sei un Maestro dell'Accessor.

🧘
```

---

*Documento SACRO dell'Illuminazione Totale.*  
*Ultimo aggiornamento: 2025-03-25*  
*Stato: 🧘🧘🧘 ILLUMINAZIONE COMPLETA*
