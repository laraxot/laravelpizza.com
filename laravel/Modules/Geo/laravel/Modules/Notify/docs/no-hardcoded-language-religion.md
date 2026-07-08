# NO Hardcoded Language — La Religione i18n

**Status**: Active  
**Created**: 2026-04-14  
**Last Updated**: 2026-04-14  
**Category**: Architecture / Religion / i18n  
**Audience**: All developers + AI agents

---

## LA REGOLA AUREA

**NON scriverai MAI parole in italiano (o qualsiasi lingua) nel codice PHP.**

**MAI.**  
**Senza eccezioni.**  
**Senza scuse.**  
**SENZA DISCUSSIONE.**

**Il sito e' multilingua.**  
**Ogni stringa hardcoded in italiano e un insulto agli utenti non italiani.**

---

## Perche Succede (Il Problema Profondo)

### 1. Pigrizia dello Sviluppatore

**Il problema**:
```php
// ❌ SBAGLIATO: sviluppatore pigro
Section::make('Riepilogo Segnalazione')
```

**La causa**:
- "E solo una label, chi se ne frega"
- "Tradurro' dopo" (MAI)
- "Funziona cosi, va bene"

**La realta**:
- "Dopo" non arriva mai
- Ogni stringa hardcoded diventa debt tecnico
- 100 stringhe hardcoded = 100 fix manuali

---

### 2. Ignoranza di i18n

**Il problema**:
```php
// ❌ SBAGLIATO: sviluppatore non sa i18n
->description('Verifica i dati prima dell\'invio')
```

**La causa**:
- Non sa che esistono translation keys
- Non conosce il pattern `__('key')`
- Pensa che "funzionare" = "mostrare testo"

**La realta**:
- Sito multilingua ≠ hardcoded italiano
- Ogni utente vede nella SUA lingua
- Testo hardcoded = solo italiani vedono, altri vedono errore

---

### 3. Amnesia dell'AI

**Il problema**:
```
Sessione 1: AI impara regola → "NO hardcoded language"
Sessione 2: AI dimentica → Usa italiano nel codice
Sessione 3: Utente corregge → AI impara di nuovo
Sessione 4: AI dimentica → Ciclo infinito
```

**La causa**:
- AI non ha memoria persistente
- Regole sono nei docs ma NON controllate automaticamente
- Nessun pre-commit hook

---

## I Danni (Perche e un Insulto)

### 1. Utente Francese

```php
// ❌ Codice con italiano hardcoded
Section::make('Riepilogo Segnalazione')
```

**Utente francese vede**:
- "Riepilogo Segnalazione" → ❌ Non capisce
- "Verifica i dati" → ❌ Non capisce
- **Risultato**: Abbandona il sito

---

### 2. Utente Tedesco

```php
// ❌ Codice con italiano hardcoded
->limitMessage('E altre :count immagini')
```

**Utente tedesco vede**:
- "E altre immagini" → ❌ Non capisce
- **Risultato**: Pensa il sito e rotto

---

### 3. Utente Inglese

```php
// ❌ Codice con italiano hardcoded
'Nessuna immagine caricata'
```

**Utente inglese vede**:
- "Nessuna immagine caricata" → ❌ Non capisce
- **Risultato**: Pensa il sito e in beta

---

## La Soluzione Definitiva

### 1. Translation Keys

```php
// ✅ CORRETTO: usa chiavi traduzione
Section::make(__('fixcity::create_ticket_wizard.sections.summary.label'))
    ->description(__('fixcity::create_ticket_wizard.sections.summary.description'))
```

**File traduzione**: `Modules/Fixcity/resources/lang/en/create_ticket_wizard.php`
```php
return [
    'sections' => [
        'summary' => [
            'label' => 'Report Summary',
            'description' => 'Verify your data before submission',
        ],
    ],
];
```

**File traduzione**: `Modules/Fixcity/resources/lang/it/create_ticket_wizard.php`
```php
return [
    'sections' => [
        'summary' => [
            'label' => 'Riepilogo Segnalazione',
            'description' => 'Verifica i dati prima dell\'invio',
        ],
    ],
];
```

**Risultato**:
- Italiano → "Riepilogo Segnalazione" ✅
- Inglese → "Report Summary" ✅
- Francese → "Résumé du rapport" ✅
- Tedesco → "Berichtszusammenfassung" ✅

---

### 2. Stringhe Dinamiche con Pluralizzazione

```php
// ❌ SBAGLIATO: hardcoded con variabile
->description(fn (Get $get): string =>
    count($get('images')) . ' immagini caricate'
)

// ✅ CORRETTO: translation key con pluralizzazione
->description(fn (Get $get): string =>
    trans_choice(
        'fixcity::create_ticket_wizard.sections.images.description',
        count($get('images') ?? [])
    )
)
```

**File traduzione**:
```php
'images' => [
    'description' => '{0} No images uploaded|{1} :count image uploaded|[2,*] :count images uploaded',
],
```

**Risultato**:
- Italiano: "Nessuna immagine caricata" / "1 immagine caricata" / "5 immagini caricate"
- Inglese: "No images uploaded" / "1 image uploaded" / "5 images uploaded"

---

### 3. LimitMessage con Traduzione

```php
// ❌ SBAGLIATO
->limitMessage('E altre :count immagini')

// ✅ CORRETTO
->limitMessage(__('fixcity::create_ticket_wizard.sections.images.limit_message'))
```

---

## I Comandamenti i18n

### 1. NON scriverai MAI italiano nel codice PHP

```php
// ❌ SBAGLIATO
Section::make('Riepilogo Segnalazione')

// ✅ CORRETTO
Section::make(__('fixcity::create_ticket_wizard.sections.summary.label'))
```

---

### 2. NON scriverai MAI italiano nelle description

```php
// ❌ SBAGLIATO
->description('Verifica i dati prima dell\'invio')

// ✅ CORRETTO
->description(__('fixcity::create_ticket_wizard.sections.summary.description'))
```

---

### 3. NON scriverai MAI italiano nei placeholder

```php
// ❌ SBAGLIATO (anche se placeholder e auto-applicato, se lo scrivi)
->placeholder('Inserisci il tuo nome')

// ✅ CORRETTO
// Niente placeholder, LangServiceProvider applica automaticamente
```

---

### 4. NON scriverai MAI italiano nei messaggi di errore

```php
// ❌ SBAGLIATO
$this->addError('data.submit', 'Si è verificato un errore')

// ✅ CORRETTO
$this->addError('data.submit', __('fixcity::create_ticket_wizard.notifications.submit_failed.body'))
```

---

### 5. NON scriverai MAI italiano nelle conferme

```php
// ❌ SBAGLIATO
Notification::make()
    ->title('Operazione completata')
    ->body('I dati sono stati salvati correttamente')

// ✅ CORRETTO
Notification::make()
    ->title(__('fixcity::create_ticket_wizard.notifications.success.title'))
    ->body(__('fixcity::create_ticket_wizard.notifications.success.body'))
```

---

### 6. USERAI trans_choice per plurali

```php
// ❌ SBAGLIATO
echo count($items) . ' elementi trovati'

// ✅ CORRETTO
echo trans_choice('fixcity::messages.items_found', count($items))
```

---

### 7. NON mescolerai lingue nel codice

```php
// ❌ SBAGLIATO: misto italiano/inglese
Section::make('Riepilogo Segnalazione')
    ->description('Verify your data')  // MISTO!

// ✅ CORRETTO: tutto via translation keys
Section::make(__('fixcity::sections.summary.label'))
    ->description(__('fixcity::sections.summary.description'))
```

---

### 8. CREERAI file traduzione per ogni lingua supportata

```
Modules/Fixcity/resources/lang/
├── en/
│   └── create_ticket_wizard.php
├── it/
│   └── create_ticket_wizard.php
├── fr/
│   └── create_ticket_wizard.php
├── de/
│   └── create_ticket_wizard.php
└── es/
    └── create_ticket_wizard.php
```

---

### 9. AGGIORNERAI i file traduzione quando aggiungi nuove stringhe

```php
// Aggiungi nuova UI
Section::make(__('fixcity::new_section.label'))

// IMMEDIATAMENTE aggiungi a TUTTI i file lang:
// en/create_ticket_wizard.php → 'new_section' => ['label' => 'New Section']
// it/create_ticket_wizard.php → 'new_section' => ['label' => 'Nuova Sezione']
// fr/create_ticket_wizard.php → 'new_section' => ['label' => 'Nouvelle Section']
```

---

### 10. VERIFICHERAI con pre-commit hook

Script: `bashscripts/check-hardcoded-language.sh`

```bash
#!/bin/bash
# Controlla italiano hardcoded nel codice PHP

echo "🔍 Checking for hardcoded Italian in PHP files..."

VIOLATIONS=$(grep -rE \
    "make\(['\"][A-ZÀ-Ž][a-zà-ž]+ [A-ZÀ-Ž]|['\"][A-ZÀ-Ž][a-zà-ž]+[ '\"]" \
    laravel/Modules/*/app/Filament/ \
    --include="*.php" \
    2>/dev/null | \
    grep -v "__(" | \
    grep -v "->label\|->placeholder" || true)

if [ -n "$VIOLATIONS" ]; then
    echo "❌ HARDCODED ITALIAN FOUND:"
    echo "$VIOLATIONS"
    echo ""
    echo "📖 Leggi: docs/no-hardcoded-language-religion.md"
    exit 1
fi

echo "✅ No hardcoded Italian found"
exit 0
```

---

## Come Correggere (Guida Rapida)

### 1. Trova Violazioni

```bash
# Cerca italiano hardcoded in Filament
grep -rE "make\(['\"][A-ZÀ]" Modules/Fixcity/app/Filament/ --include="*.php"
grep -rE "description\(['\"][A-ZÀ]" Modules/Fixcity/app/Filament/ --include="*.php"
```

---

### 2. Crea Translation Keys

Per ogni violazione:
- Identifica la stringa italiana
- Crea chiave: `fixcity::create_ticket_wizard.sections.xxx.label`
- Aggiungi a TUTTI i file lang (en, it, fr, de, es)

---

### 3. Sostituisci nel Codice

```php
// PRIMA
Section::make('Riepilogo Segnalazione')
    ->description('Verifica i dati prima dell\'invio')

// DOPO
Section::make(__('fixcity::create_ticket_wizard.sections.summary.label'))
    ->description(__('fixcity::create_ticket_wizard.sections.summary.description'))
```

---

### 4. Verifica

```bash
# Controlla che non ci siano piu violazioni
bash bashscripts/check-hardcoded-language.sh
```

---

## La Filosofia (Perche Profondo)

### i18n non e Feature, e Rispetto

**Quando hardcodi italiano**:
- Dici agli utenti non italiani: "Non mi importa se capisci"
- Tratti il sito come se fosse solo per italiani
- Ignori il 99% degli utenti potenziali

**Quando usi translation keys**:
- Rispetti OGNI utente nella sua lingua
- Il sito e globale per design
- Scalabilita automatica (aggiungi lingua = 1 file)

---

### Il Costo Reale

**Hardcoded italiano**:
- 100 stringhe hardcoded × 5 lingue × 5 min = 2500 min = 41 ore
- Ogni aggiunta lingua = 41 ore di nuovo
- **Totale per 10 lingue**: 410 ore

**Translation keys**:
- 100 stringhe × 1 chiave ciascuna = 100 chiavi
- 100 chiavi × 5 lingue × 1 min = 500 min = 8 ore
- Ogni aggiunta lingua = 8 ore di nuovo
- **Totale per 10 lingue**: 80 ore

**Risparmiato**: 330 ore = 41 giorni di lavoro

---

### La Scalabilita

**Hardcoded**:
- Aggiungi lingua → trovi tutte le stringhe hardcoded → traduci manualmente
- Processo: settimane

**Translation keys**:
- Aggiungi lingua → duplica 1 file lang → traduci chiavi
- Processo: ore

---

## La Religione

### Il Credo

> "Codice in inglese, UI nella lingua dell'utente.  
> Mai hardcoded, sempre translation keys.  
> i18n non e optional, e rispetto."

### La Preghiera

```
Concedimi la disciplina di scrivere codice in inglese,
La saggezza di usare translation keys,
E il rispetto per ogni utente nella sua lingua.

Amen.
```

---

## Riferimenti

- [Laravel Localization Docs](https://laravel.com/docs/localization)
- [LangServiceProvider](../../Lang/app/Providers/LangServiceProvider.php)
- [Translation Files](../../Modules/Fixcity/resources/lang/)
- [Pre-Commit Hook](../../bashscripts/check-hardcoded-language.sh)

---

*Ultimo aggiornamento: 2026-04-14*

**DA LEGGERE PRIMA DI SCRIVERE QUALSIASI UI**
