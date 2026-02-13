# Guida Completa alla Validazione delle Traduzioni - <nome progetto>

## Panoramica

Questa guida documenta il processo completo di validazione delle traduzioni nel progetto <nome progetto>, seguendo i principi DRY (Don't Repeat Yourself) e KISS (Keep It Simple, Stupid).

## Regole Fondamentali

### 1. Regola helper_text Normalizzazione
**Se il valore di `helper_text` è uguale alla chiave del campo padre, DEVE essere impostato a stringa vuota (`''`).**

#### Esempio
```php
// ❌ ERRATO
'province' => [
    'helper_text' => 'province', // uguale alla chiave padre
],

// ✅ CORRETTO
'province' => [
    'helper_text' => '', // stringa vuota
],
```

### 2. Regola Testi Italiani in File Non Italiani
**I file di traduzione non italiani NON devono contenere testi chiaramente italiani.**

#### Pattern Problematici
- "è obbligatorio", "obbligatorio", "obbligatoria"
- Articoli italiani: " il ", " la ", " lo "
- Verbi coniugati: "inserisci", "seleziona"
- Caratteri accentati: "à", "è", "é", "ì", "ò", "ù"

#### Termini Accettabili (Internazionali)
- "email", "password", "admin", "login"
- "user", "create", "update", "delete"
- "save", "cancel", "submit", "reset"

## Struttura Traduzioni Standard

### Struttura Completa a 7 Elementi
Ogni campo di traduzione DEVE includere:

```php
'field_name' => [
    'label' => 'Etichetta del campo',
    'placeholder' => 'Testo di esempio',
    'tooltip' => 'Suggerimento breve',
    'helper_text' => 'Testo di aiuto dettagliato (o stringa vuota se uguale alla chiave)',
    'description' => 'Descrizione completa del campo',
    'icon' => 'heroicon-o-appropriate-icon',
    'color' => 'primary|secondary|success|danger|warning|info',
],
```

### Standard per Campi Geografici

#### Campo Città
```php
'city' => [
    'label' => 'City', // Tradotto appropriatamente
    'placeholder' => 'Enter city',
    'tooltip' => 'City of residence or location',
    'helper_text' => 'Enter the name of the city where you reside',
    'description' => 'Field to specify the user\'s city of residence',
    'icon' => 'heroicon-o-map-pin',
    'color' => 'primary',
],
```

#### Campo Provincia
```php
'province' => [
    'label' => 'Province', // Tradotto appropriatamente
    'placeholder' => 'Enter province',
    'tooltip' => 'Province of residence or state',
    'helper_text' => 'Enter the name of your province or state',
    'description' => 'Field to specify the user\'s province for registration',
    'icon' => 'heroicon-o-map',
    'color' => 'secondary',
],
```

#### Campo Regione
```php
'region' => [
    'label' => 'Region', // Tradotto appropriatamente
    'placeholder' => 'Select region',
    'tooltip' => 'Administrative region of belonging',
    'helper_text' => 'Select the administrative region where you reside',
    'description' => 'Field to specify the administrative region',
    'icon' => 'heroicon-o-globe-europe-africa',
    'color' => 'info',
],
```

### Standard per Campi di Autenticazione

#### Campo Login/Accedi
```php
'login' => [
    'label' => 'Login', // Tradotto appropriatamente
    'placeholder' => 'Click to login',
    'tooltip' => 'Access your personal account',
    'helper_text' => 'Click here to access your reserved area',
    'description' => 'Button to access the system with your credentials',
    'icon' => 'heroicon-o-arrow-right-on-rectangle',
    'color' => 'success',
],
```

## Traduzioni per Lingua

### Terminologia Standard

| Italiano | English | German | Spanish | French |
|----------|---------|--------|---------|--------|
| obbligatorio | required | erforderlich | obligatorio | obligatoire |
| è obbligatorio | is required | ist erforderlich | es obligatorio | est obligatoire |
| campo obbligatorio | required field | Pflichtfeld | campo obligatorio | champ obligatoire |
| inserisci | enter | eingeben | introducir | saisir |
| seleziona | select | auswählen | seleccionar | sélectionner |
| città | city | Stadt | ciudad | ville |
| provincia | province | Provinz | provincia | province |
| regione | region | Region | región | région |
| accedi | login | anmelden | iniciar sesión | se connecter |

## Script di Validazione

### 1. Helper Text Audit
```bash
cd laravel
php docs/helper-text-audit-script.php
```

### 2. Italian Text Validation
```bash
php docs/italian-text-validation-refined.php
```

### 3. Obbligatorio Specific Audit
```bash
php docs/obbligatorio-audit-script.php
```

## Processo DRY + KISS

### DRY (Don't Repeat Yourself)
1. **Template Riutilizzabili**: Struttura standardizzata per tutti i campi
2. **Script Automatici**: Validazione automatica senza lavoro manuale ripetitivo
3. **Documentazione Centralizzata**: Un solo punto di verità per tutti gli standard
4. **Terminologia Unificata**: Traduzioni coerenti per concetti simili

### KISS (Keep It Simple, Stupid)
1. **Regole Chiare**: Criteri semplici e comprensibili
2. **Processo Automatizzato**: Script che fanno il lavoro pesante
3. **Distinzione Netta**: Separazione chiara tra problemi reali e falsi positivi
4. **Validazione Semplificata**: Controlli automatici con output chiaro

## Workflow di Validazione

### Fase 1: Audit Automatico
1. Eseguire tutti gli script di validazione
2. Analizzare i report generati
3. Identificare problemi reali vs falsi positivi

### Fase 2: Correzione
1. Per ogni problema identificato:
   - Analizzare il contesto
   - Applicare la traduzione appropriata
   - Verificare la struttura completa a 7 elementi
   - Normalizzare helper_text se necessario

### Fase 3: Documentazione
1. Aggiornare documentazione modulo specifico
2. Aggiornare documentazione centrale
3. Creare collegamenti bidirezionali
4. Aggiornare memorie e regole

### Fase 4: Validazione Finale
1. Ri-eseguire tutti gli script di audit
2. Confermare che tutti i problemi sono risolti
3. Verificare conformità agli standard
4. Documentare il completamento

## Status Progetto <nome progetto>

### ✅ Validazioni Completate (2025-08-08)

1. **Helper Text Normalizzazione**: ✅ CONFORME
   - Nessun helper_text uguale alla chiave padre
   - Tutti i valori normalizzati correttamente

2. **Testi Italiani in File Non Italiani**: ✅ CONFORME
   - Nessun testo "è obbligatorio" trovato
   - Nessun testo "obbligatorio" trovato
   - Nessun pattern italiano reale identificato

3. **Struttura Traduzioni**: ✅ CONFORME
   - Tutti i campi principali hanno struttura a 7 elementi
   - Icone e colori differenziati per tipologia
   - Terminologia medica appropriata per ogni lingua

### File Corretti Durante il Progetto
1. `/Modules/User/lang/de/registration.php` - Campi city e state
2. `/Modules/User/lang/en/registration.php` - Campi city e province
3. `/Modules/User/lang/de/register_tenant.php` - Campo address
4. `/Themes/One/lang/de/auth.php` - Sezione login completa
5. `/Modules/Geo/lang/en/address.php` - Campi province e region

## Manutenzione Futura

### Controlli Periodici
- Eseguire script di validazione prima di ogni release
- Integrare controlli nei workflow CI/CD
- Formare team sui nuovi standard

### Aggiornamenti
- Mantenere lista termini internazionali aggiornata
- Aggiornare traduzioni quando si aggiungono nuove funzionalità
- Rivedere periodicamente la documentazione

### Prevenzione
- Utilizzare template standardizzati per nuove traduzioni
- Applicare regole durante code review
- Automatizzare controlli dove possibile

## Collegamenti alla Documentazione

### Documentazione Centrale
- [Struttura Campi Traduzione Completa](translation-field-structure-complete.md)
- [Riepilogo Finale Refactor](translation-refactor-complete-summary.md)

### Documentazione Moduli
- [User Module - City Field Refactor](../Modules/User/docs/translation-city-field-refactor-2025-08-08.md)
- [<nome progetto> Module - Refactor Summary](../Modules/<nome progetto>/docs/translation-refactor-summary-2025-08-08.md)
- [Geo Module - Helper Text Fix](../Modules/Geo/docs/helper-text-normalization-fix.md)

### Script e Tool
- [Helper Text Audit Script](helper-text-audit-script.php)
- [Italian Text Validation Script](italian-text-validation-refined.php)
- [Obbligatorio Audit Script](obbligatorio-audit-script.php)

---

**Data Creazione**: 8 Agosto 2025
**Ultima Validazione**: 8 Agosto 2025
**Status**: ✅ TUTTI I CONTROLLI SUPERATI
**Conformità**: ✅ PROGETTO COMPLETAMENTE CONFORME
