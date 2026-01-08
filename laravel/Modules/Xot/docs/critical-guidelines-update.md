# Aggiornamento Linee Guida Critiche - Agosto 2025

## 1. VIOLAZIONE GRAVE: Cartella Docs Root

### Problema Identificato
La cartella `/var/www/html/ptvx/docs` ESISTE e viola la regola fondamentale:
- ❌ **VIOLAZIONE CRITICA**: Cartella docs root esistente
- ❌ **RIFERIMENTI ASSOLUTI**: Link hardcoded in vari moduli
- ❌ **DUPLICAZIONE**: Documentazione fuori dai moduli

### Riferimenti Trovati
Nei seguenti file sono presenti riferimenti assoluti alla cartella docs root:
- `Modules/Progressioni/docs/translations-index.md:56-58`
- `Modules/Progressioni/docs/translation-system.md:269`
- `Modules/Progressioni/docs/sigma_integration.md:283-285`
- `Modules/Progressioni/docs/filament-resources-index.md:63-65`

### Azioni Correttive Immediate

#### A. Eliminazione Cartella Root Docs
```bash
# 1. Spostare il contenuto utile nei moduli appropriati
# 2. Eliminare la cartella root docs
rm -rf /var/www/html/ptvx/docs/

# 3. Verificare che non esistano altre cartelle docs root
find /var/www/html/ptvx -maxdepth 2 -name "docs" -type d | grep -E "(^/var/www/html/ptvx/docs$)"
# Se restituisce output → ERRORE CRITICO
```

#### B. Correzione Riferimenti
Sostituire tutti i riferimenti assoluti con riferimenti relativi:

**PRIMA (VIETATO):**
```markdown
- [Traduzioni Root](/var/www/html/ptvx/docs/translations.md)
- [Standard Traduzioni](/var/www/html/ptvx/docs/translation-standards.md)
```

**DOPO (CORRETTO):**
```markdown
- [Traduzioni](../../Xot/docs/translations.md)
- [Standard Traduzioni](../../Xot/docs/translation-standards.md)
```

#### C. Struttura Documentazione Corretta
```
Modules/
├── Xot/docs/                 # Documentazione generale e cross-modulo
│   ├── translations.md       # Gestione traduzioni
│   ├── translation-standards.md
│   └── filament-best-practices.md
├── Activity/docs/            # Documentazione specifica modulo
├── Badge/docs/
└── ... altri moduli
```

## 2. ERRORE GRAVE: property_exists su Magic Properties

### Problema Identificato
Utilizzo di `property_exists()` per verificare proprietà magiche dei modelli Laravel:
- ❌ **NON FUNZIONA** per proprietà magiche (__get/__set)
- ❌ **FALSI NEGATIVI** per attributi dei modelli
- ❌ **VIOLA** il funzionamento di Eloquent

### Esempi Errati Trovati
```php
// ❌ SBAGLIATO - Non funziona con magic properties
if (property_exists($record, 'email')) {
    throw new \InvalidArgumentException('Model must have email property');
}

// ❌ SBAGLIATO - Per proprietà statiche magiche
$attachments = property_exists($model, 'attachments') ? $model::$attachments : [];
```

### Soluzioni Corrette

#### A. Per Proprietà di Istanza (Magic Properties)
```php
// ✅ CORRETTO - Usare isset() per magic properties
if (!isset($record->email)) {
    throw new \InvalidArgumentException('Model must have email attribute');
}

// ✅ CORRETTO - Verificare negli attributes
if (!array_key_exists('email', $record->getAttributes())) {
    throw new \InvalidArgumentException('Model must have email attribute');
}

// ✅ CORRETTO - Per relazioni
if (!$record->relationLoaded('user')) {
    throw new \InvalidArgumentException('User relation must be loaded');
}
```

#### B. Per Proprietà Statiche
```php
// ✅ CORRETTO - Verifica esistenza proprietà statiche
if (property_exists($model, 'attachments')) {
    $attachments = $model::$attachments;
} else {
    $attachments = [];
}

// ✅ MIGLIORE - Pattern con default value
$attachments = property_exists($model, 'attachments') 
    ? $model::$attachments 
    : [];
```

#### C. Per Metodi
```php
// ✅ CORRETTO - Per metodi
if (!method_exists($record, 'getEmailAttribute')) {
    throw new \InvalidArgumentException('Model must implement getEmailAttribute method');
}
```

### Eccezioni all'Utilizzo di property_exists

**SI PUÒ USARE property_exists SOLO per:**
- Proprietà statiche reali (non magiche)
- Proprietà di classe concrete
- Configurazioni statiche

**NON SI PUÒ USARE property_exists per:**
- Attributi dei modelli (magic properties)
- Relazioni Caricate
- Accessors/Modificators
- Proprietà dinamiche

## 3. Piano di Correzione

### Fase 1: Eliminazione Docs Root (24 ore)
- [ ] Spostare documentazione utile in `Modules/Xot/docs/`
- [ ] Eliminare cartella `/var/www/html/ptvx/docs`
- [ ] Aggiornare tutti i riferimenti assoluti

### Fase 2: Correzione property_exists (48 ore)
- [ ] Cercare tutti gli usi di `property_exists` nel codice
- [ ] Sostituire con `isset()` per magic properties
- [ ] Verificare funzionamento con test

### Fase 3: Validazione e Testing (24 ore)
- [ ] Eseguire test completi
- [ ] Verificare assenza di regressioni
- [ ] Aggiornare documentazione

## 4. Regole Aggiornate

### Regola 1: Documentazione
**"TUTTA la documentazione deve risiedere ESCLUSIVAMENTE nelle cartelle `docs` dei moduli specifici."**

### Regola 2: Magic Properties
**"MAI usare `property_exists()` per verificare proprietà magiche dei modelli Laravel. Usare `isset()` o verifiche specifiche."**

### Regola 3: Riferimenti
**"MAI usare percorsi assoluti nella documentazione. Usare SEMPRE riferimenti relativi."**

## 5. Sanzioni per Violazioni
- **Violazione Regola 1**: Blocco immediato del deployment
- **Violazione Regola 2**: Correzione obbligatoria entro 24 ore
- **Violazione Regola 3**: Correzione nel successivo commit

## 6. Verifica Automatica
```bash
# Verifica cartelle docs root
find /var/www/html/ptvx -maxdepth 2 -name "docs" -type d | grep -E "(^/var/www/html/ptvx/docs$)"

# Verifica usi errati di property_exists
grep -r "property_exists" /var/www/html/ptvx/laravel/Modules/ --include="*.php" | grep -v "static" | grep -v "::"
```

---

**DATA EFFETTIVA**: 2025-08-20
**PRIORITÀ**: CRITICA
**RESPONSABILE**: Tutto il team sviluppo

*Questo documento sostituisce tutte le linee guida precedenti in conflitto.*