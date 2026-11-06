---
title: "registration: Consolidated Documentation"
module: user
type: integration
tags: [integrations, modules, user]
created: 2026-08-24
updated: 2026-08-24
status: draft
qmd: "registration   consolidated documentation user"
---

# registration: Consolidated Documentation

Consolidated from **8** individual files.

## Table of Contents

- [---](#registration-widget-3)
- [---](#registration-widget-fileupload-fix)
- [---](#registration-widget-fileupload)
- [---](#registration-widget-update)
- [---](#registration-widget)
- [Registration Widget Documentation](#registration_widget)
- [RegistrationWidget FileUpload Fix](#registration_widget_fileupload_fix)
- [Aggiornamento relativo a DoctorResource.php](#registration_widget_update)

---

## registration-widget-3

*Consolidated from: `registration-widget.md`*
*Consolidated from: `registration-widget-filament-resource.md`*

title: "Registration Widget 3"
type: concept
tags: [registration, widget]
created: 2026-07-14
updated: 2026-07-14
qmd: "registration-widget-3 registration widget 3"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---

- [Filament Resource Guidelines](../../../Modules/Xot/docs/rules/filament-resource-guidelines.md)
---
module: theme
topic: registration_widget
canonical: ../../../Themes/docs/shared-components/registration-widget.md
---

See canonical documentation: ../../../Themes/docs/shared-components/registration-widget.md
canonical: ../../../Themes/docs/shared-components/registration-widget-filament-resource.md
---

See canonical documentation: ../../../Themes/docs/shared-components/registration-widget-filament-resource.md
---

## registration-widget-fileupload-fix

*Consolidated from: `registration-widget-fileupload-fix.md`*

title: "RegistrationWidget FileUpload Fix"
type: concept
tags: [registration, widget, fileupload, fix]
created: 2026-07-14
updated: 2026-07-14
qmd: "registration-widget-fileupload-fix registrationwidget fileupload fix"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---

# RegistrationWidget FileUpload Fix

## Problema Risolto
Il `RegistrationWidget` mostrava l'errore `foreach() argument must be of type array|object, string given` durante il caricamento dei dati del form per utenti esistenti con file allegati.
## Causa del Problema
Il widget utilizzava il metodo `getFormFill()` per popolare il form con i dati esistenti dell'utente. Tuttavia, quando un utente aveva già dei file allegati salvati nel database:
1. I file venivano salvati come **stringhe** (percorsi dei file) nel database
2. Filament FileUpload si aspetta **array** di percorsi file
3. Questo mismatch causava l'errore quando Filament tentava di iterare sui file
## Codice Prima della Correzione
```php
public function getFormFill(): array
{
    $model = $this->getFormModel();

    if ($model->exists) {
        return $model->toArray(); // ❌ PROBLEMA: file salvati come stringhe
    }
    // resto del metodo...
}
```
## Codice Dopo la Correzione
        try {
            $data = $model->toArray();

            // CORREZIONE BUG: Converti i campi file upload da stringhe ad array per Filament
            $attachments = [];
            try {
                $reflection = new \ReflectionClass($model);
                if ($reflection->hasProperty('attachments')) {
                    $property = $reflection->getProperty('attachments');
                    if ($property->isStatic()) {
                        /** @phpstan-ignore-next-line */
                        $attachments = $model::$attachments ?? [];
                    }
                }
            } catch (\ReflectionException $e) {
                // Se la proprietà non esiste, continua con array vuoto
            }
            foreach ($attachments as $attachment) {
                if (isset($data[$attachment]) && is_string($data[$attachment])) {
                    // Converte stringa singola in array per compatibilità Filament
                    $data[$attachment] = [$data[$attachment]];
            return $data;
        } catch (\Exception $e) {
            // Fallback per problemi con enum
            Log::warning("Errore in toArray() per modello {$this->model}: " . $e->getMessage());
            $attributes = $model->getAttributes();
            // Applica la stessa conversione anche agli attributi
                if (isset($attributes[$attachment]) && is_string($attributes[$attachment])) {
                    $attributes[$attachment] = [$attributes[$attachment]];
            return $attributes;
        }
## Logica della Correzione
### 1. Identificazione Sicura degli Attachments
Invece di accedere direttamente a `$model::$attachments` (che causa errori PHPStan), uso la reflection per verificare se la proprietà esiste:
$attachments = [];
try {
    $reflection = new \ReflectionClass($model);
    if ($reflection->hasProperty('attachments')) {
        $property = $reflection->getProperty('attachments');
        if ($property->isStatic()) {
            /** @phpstan-ignore-next-line */
            $attachments = $model::$attachments ?? [];
} catch (\ReflectionException $e) {
    // Se la proprietà non esiste, continua con array vuoto
### 2. Conversione Type-Safe
Per ogni campo attachment, verifico se è una stringa e la converto in array:
foreach ($attachments as $attachment) {
    if (isset($data[$attachment]) && is_string($data[$attachment])) {
        // Converte stringa singola in array per compatibilità Filament
        $data[$attachment] = [$data[$attachment]];
### 3. Gestione del Fallback
La stessa logica viene applicata anche nel caso di fallback quando `toArray()` fallisce.
## Vantaggi della Soluzione
1. **Type Safety**: Usa reflection per accesso sicuro alle proprietà statiche
2. **Backward Compatibility**: Gestisce sia stringhe che array esistenti
3. **Graceful Fallback**: Funziona anche se la proprietà `$attachments` non esiste
4. **PHPStan Compliant**: Evita errori di analisi statica
## Scenario di Test
### Before (Errore)
// Dati nel database
$user->health_card = 'session-uploads/xyz/file.pdf';  // Stringa
// getFormFill() restituisce
['health_card' => 'session-uploads/xyz/file.pdf']
// Filament FileUpload cerca di iterare
foreach($state as $file) {  // ❌ ERRORE: $state è stringa, non array
    // ...
### After (Funziona)
// getFormFill() restituisce (dopo correzione)
['health_card' => ['session-uploads/xyz/file.pdf']]  // Array!
// Filament FileUpload può iterare correttamente
foreach($state as $file) {  // ✅ OK: $state è array
## Impact su Altri Componenti
Questa correzione è compatibile con:
1. **Nuovi upload**: FileUpload continua a funzionare normalmente
2. **Form validation**: Le regole di validazione rimangono invariate
3. **Salvataggio**: I file vengono ancora salvati come stringhe nel database
4. **Altri widget**: Non impatta widget che non gestiscono file
## Testing
Per testare la correzione:
1. **Crea un utente** con file allegati
2. **Salva i file** tramite il wizard di registrazione
3. **Torna indietro** ai dati salvati (usando email + token)
4. **Verifica** che i file vengano caricati correttamente nel form
5. **Continua** il wizard senza errori
## Monitoraggio
Aggiungere logging per monitorare la conversione:
Log::debug("Converting file upload field", [
    'attachment' => $attachment,
    'original_type' => gettype($data[$attachment]),
    'converted_type' => 'array',
    'session_id' => session()->getId()
]);
## Best Practice Future
Per evitare simili problemi in futuro:
1. **Consistency**: Mantenere i tipi di dati consistenti tra database e form
2. **Testing**: Testare sempre il reload di dati esistenti
3. **Type Checking**: Usare type checking difensivo nei callback
4. **Documentation**: Documentare i tipi di dati attesi per ogni campo
## Riferimenti
- [Problema principale: docs/fileupload-foreach-error-fix.md](../../../../docs/project/fileupload-foreach-error-fix.md)
- [Correzione XotBaseResource: Modules/Xot/project_docs/fileupload-components.md](../../xot/project_docs/fileupload-components.md)
- [Problema principale: docs/fileupload-foreach-error-fix.md](../../../../docs/fileupload-foreach-error-fix.md)
- [Correzione XotBaseResource: Modules/Xot/docs/fileupload-components.md](../../../../Xot/docs/fileupload-components.md)
- [Registration Widget base: registration-widget.md](./registration-widget.md)
# RegistrationWidget FileUpload Fix

## Problema Risolto

Il `RegistrationWidget` mostrava l'errore `foreach() argument must be of type array|object, string given` durante il caricamento dei dati del form per utenti esistenti con file allegati.

## Causa del Problema

Il widget utilizzava il metodo `getFormFill()` per popolare il form con i dati esistenti dell'utente. Tuttavia, quando un utente aveva già dei file allegati salvati nel database:

1. I file venivano salvati come **stringhe** (percorsi dei file) nel database
2. Filament FileUpload si aspetta **array** di percorsi file
3. Questo mismatch causava l'errore quando Filament tentava di iterare sui file

## Codice Prima della Correzione

```php
public function getFormFill(): array
{
    $model = $this->getFormModel();

    if ($model->exists) {
        return $model->toArray(); // ❌ PROBLEMA: file salvati come stringhe
    }

    // resto del metodo...
}
```

## Codice Dopo la Correzione

```php
public function getFormFill(): array
{
    $model = $this->getFormModel();

    if ($model->exists) {
        try {
            $data = $model->toArray();

            // CORREZIONE BUG: Converti i campi file upload da stringhe ad array per Filament
            $attachments = [];
            try {
                $reflection = new \ReflectionClass($model);
                if ($reflection->hasProperty('attachments')) {
                    $property = $reflection->getProperty('attachments');
                    if ($property->isStatic()) {
                        /** @phpstan-ignore-next-line */
                        $attachments = $model::$attachments ?? [];
                    }
                }
            } catch (\ReflectionException $e) {
                // Se la proprietà non esiste, continua con array vuoto
            }

            foreach ($attachments as $attachment) {
                if (isset($data[$attachment]) && is_string($data[$attachment])) {
                    // Converte stringa singola in array per compatibilità Filament
                    $data[$attachment] = [$data[$attachment]];
                }
            }

            return $data;
        } catch (\Exception $e) {
            // Fallback per problemi con enum
            Log::warning("Errore in toArray() per modello {$this->model}: " . $e->getMessage());

            $attributes = $model->getAttributes();

            // Applica la stessa conversione anche agli attributi
            $attachments = [];
            try {
                $reflection = new \ReflectionClass($model);
                if ($reflection->hasProperty('attachments')) {
                    $property = $reflection->getProperty('attachments');
                    if ($property->isStatic()) {
                        /** @phpstan-ignore-next-line */
                        $attachments = $model::$attachments ?? [];
                    }
                }
            } catch (\ReflectionException $e) {
                // Se la proprietà non esiste, continua con array vuoto
            }

            foreach ($attachments as $attachment) {
                if (isset($attributes[$attachment]) && is_string($attributes[$attachment])) {
                    $attributes[$attachment] = [$attributes[$attachment]];
                }
            }

            return $attributes;
        }
    }

    // resto del metodo...
}
```

## Logica della Correzione

### 1. Identificazione Sicura degli Attachments

Invece di accedere direttamente a `$model::$attachments` (che causa errori PHPStan), uso la reflection per verificare se la proprietà esiste:

```php
$attachments = [];
try {
    $reflection = new \ReflectionClass($model);
    if ($reflection->hasProperty('attachments')) {
        $property = $reflection->getProperty('attachments');
        if ($property->isStatic()) {
            /** @phpstan-ignore-next-line */
            $attachments = $model::$attachments ?? [];
        }
    }
} catch (\ReflectionException $e) {
    // Se la proprietà non esiste, continua con array vuoto
}
```

### 2. Conversione Type-Safe

Per ogni campo attachment, verifico se è una stringa e la converto in array:

```php
foreach ($attachments as $attachment) {
    if (isset($data[$attachment]) && is_string($data[$attachment])) {
        // Converte stringa singola in array per compatibilità Filament
        $data[$attachment] = [$data[$attachment]];
    }
}
```

### 3. Gestione del Fallback

La stessa logica viene applicata anche nel caso di fallback quando `toArray()` fallisce.

## Vantaggi della Soluzione

1. **Type Safety**: Usa reflection per accesso sicuro alle proprietà statiche
2. **Backward Compatibility**: Gestisce sia stringhe che array esistenti
3. **Graceful Fallback**: Funziona anche se la proprietà `$attachments` non esiste
4. **PHPStan Compliant**: Evita errori di analisi statica

## Scenario di Test

### Before (Errore)
```php
// Dati nel database
$user->health_card = 'session-uploads/xyz/file.pdf';  // Stringa

// getFormFill() restituisce
['health_card' => 'session-uploads/xyz/file.pdf']

// Filament FileUpload cerca di iterare
foreach($state as $file) {  // ❌ ERRORE: $state è stringa, non array
    // ...
}
```

### After (Funziona)
```php
// Dati nel database
$user->health_card = 'session-uploads/xyz/file.pdf';  // Stringa

// getFormFill() restituisce (dopo correzione)
['health_card' => ['session-uploads/xyz/file.pdf']]  // Array!

// Filament FileUpload può iterare correttamente
foreach($state as $file) {  // ✅ OK: $state è array
    // ...
}
```

## Impact su Altri Componenti

Questa correzione è compatibile con:

1. **Nuovi upload**: FileUpload continua a funzionare normalmente
2. **Form validation**: Le regole di validazione rimangono invariate
3. **Salvataggio**: I file vengono ancora salvati come stringhe nel database
4. **Altri widget**: Non impatta widget che non gestiscono file

## Testing

Per testare la correzione:

1. **Crea un utente** con file allegati
2. **Salva i file** tramite il wizard di registrazione
3. **Torna indietro** ai dati salvati (usando email + token)
4. **Verifica** che i file vengano caricati correttamente nel form
5. **Continua** il wizard senza errori

## Monitoraggio

Aggiungere logging per monitorare la conversione:

```php
Log::debug("Converting file upload field", [
    'attachment' => $attachment,
    'original_type' => gettype($data[$attachment]),
    'converted_type' => 'array',
    'session_id' => session()->getId()
]);
```

## Best Practice Future

Per evitare simili problemi in futuro:

1. **Consistency**: Mantenere i tipi di dati consistenti tra database e form
2. **Testing**: Testare sempre il reload di dati esistenti
3. **Type Checking**: Usare type checking difensivo nei callback
4. **Documentation**: Documentare i tipi di dati attesi per ogni campo

## Riferimenti

- [Problema principale: docs/fileupload-foreach-error-fix.md](../../../../docs/fileupload-foreach-error-fix.md)
- [Correzione XotBaseResource: Modules/Xot/docs/fileupload-components.md](../../../../Xot/docs/fileupload-components.md)
- [Registration Widget base: registration-widget.md](./registration-widget.md)

---

## registration-widget-fileupload

*Consolidated from: `registration-widget-fileupload.md`*

module: theme
topic: registration-widget-fileupload
canonical: ../../../Themes/docs/shared-components/registration-widget-fileupload-fix.md
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---

See canonical documentation: ../../../Themes/docs/shared-components/registration-widget-fileupload-fix.md

---

## registration-widget-update

*Consolidated from: `registration-widget-update.md`*

title: "Aggiornamento relativo a DoctorResource.php"
type: concept
tags: [registration, widget, update]
created: 2026-07-14
updated: 2026-07-14
qmd: "registration-widget-update aggiornamento relativo a doctorresource.php"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---

# Aggiornamento relativo a DoctorResource.php

## Nota del 2025-05-15
In relazione al widget di registrazione, ho aggiornato la documentazione per riflettere la modifica apportata a `DoctorResource.php` nel modulo Patient. Il metodo `getPersonalInfoStep` ora include i campi `first_name`, `last_name` ed `email`, essenziali per la raccolta dati durante la registrazione dei dottori.
### Impatto sul Widget di Registrazione
- **Coerenza Dati**: Assicurarsi che il widget di registrazione sia compatibile con i nuovi campi separati per nome e cognome.
- **Email**: L'aggiunta del campo email è cruciale per garantire che il widget possa inviare comunicazioni post-registrazione.
## Aggiornamento del 2025-05-15 (Ultimo)
Ho aggiornato ulteriormente la documentazione per riflettere un cambiamento nella gestione delle traduzioni in `DoctorResource.php`. La proprietà `$translationPrefix` è stata reintrodotta per supportare le traduzioni personalizzate, ma nei metodi del wizard i riferimenti diretti a questa proprietà sono stati sostituiti con namespace di traduzione diretti (`patient::doctor-resource`).
- **Coerenza Traduzioni**: Questo cambiamento garantisce che le traduzioni siano applicate correttamente nel widget di registrazione, mantenendo la coerenza con il resto del sistema.
**Collegamenti correlati**:
- [Documentazione DoctorResource](../modules/patient/project_docs/doctor-resource-update.md)
- [Documentazione principale](../project_docs/roadmap_frontoffice/08-registrazione-odontoiatra.md)
- [Documentazione Doctor Model](../modules/patient/project_docs/doctor-model-update.md)
- [Documentazione DoctorResource](../modules/patient/docs/doctor-resource-update.md)
- [Documentazione principale](../../docs/roadmap_frontoffice/08-registrazione-odontoiatra.md)
- [Documentazione Doctor Model](../modules/patient/docs/doctor-model-update.md)
# Aggiornamento relativo a DoctorResource.php

## Nota del 2025-05-15

In relazione al widget di registrazione, ho aggiornato la documentazione per riflettere la modifica apportata a `DoctorResource.php` nel modulo Patient. Il metodo `getPersonalInfoStep` ora include i campi `first_name`, `last_name` ed `email`, essenziali per la raccolta dati durante la registrazione dei dottori.

### Impatto sul Widget di Registrazione
- **Coerenza Dati**: Assicurarsi che il widget di registrazione sia compatibile con i nuovi campi separati per nome e cognome.
- **Email**: L'aggiunta del campo email è cruciale per garantire che il widget possa inviare comunicazioni post-registrazione.

## Aggiornamento del 2025-05-15 (Ultimo)

Ho aggiornato ulteriormente la documentazione per riflettere un cambiamento nella gestione delle traduzioni in `DoctorResource.php`. La proprietà `$translationPrefix` è stata reintrodotta per supportare le traduzioni personalizzate, ma nei metodi del wizard i riferimenti diretti a questa proprietà sono stati sostituiti con namespace di traduzione diretti (`patient::doctor-resource`).

### Impatto sul Widget di Registrazione
- **Coerenza Traduzioni**: Questo cambiamento garantisce che le traduzioni siano applicate correttamente nel widget di registrazione, mantenendo la coerenza con il resto del sistema.

**Collegamenti correlati**:
- [Documentazione DoctorResource](../modules/patient/docs/doctor-resource-update.md)
- [Documentazione principale](../../docs/roadmap_frontoffice/08-registrazione-odontoiatra.md)
- [Documentazione Doctor Model](../modules/patient/docs/doctor-model-update.md)

---

## registration-widget

*Consolidated from: `registration-widget.md`*

title: "Registration Widget Documentation"
type: concept
tags: [registration, widget]
created: 2026-07-14
updated: 2026-07-14
qmd: "registration-widget registration widget documentation"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---

# Registration Widget Documentation

## Overview
Il file `RegistrationWidget.php` si trova in `Modules/User/app/Filament/Widgets/RegistrationWidget.php`. Questo widget è utilizzato per la registrazione di diversi tipi di utenti in applicazioni basate su Laravel con Filament. Il modulo `User` è progettato per essere riutilizzabile in vari progetti, quindi la logica del widget deve essere flessibile e adattabile a contesti diversi.
Il file `RegistrationWidget.php` si trova in `Modules/User/app/Filament/Widgets/RegistrationWidget.php`. Questo widget è utilizzato per la registrazione di diversi tipi di utenti in applicazioni basate su Laravel con Filament. Il modulo `User` è progettato per essere riutilizzabile in vari progetti, quindi la logica del widget deve essere flessibile e adattabile a contesti diversi.
## Current Issues
Dopo aver esaminato il codice, ho notato che manca la parte relativa al salvataggio vero e proprio dei dati dell'utente e all'impostazione dello stato dell'utente dopo la registrazione. Questo è essenziale per completare il flusso di registrazione. Inoltre, il widget deve gestire diversi tipi di utenti, quindi la logica di salvataggio deve essere configurabile in base al tipo di utente specificato tramite la proprietà `$type`.
## Recent Updates
Recentemente, il codice è stato aggiornato per introdurre una strategia più dinamica e modulare:
- **Importazione di `Illuminate\Support\Str`**: Per manipolare stringhe e creare dinamicamente il nome della classe di azione.
- **Nuove proprietà `$model` e `$action`**: Definite nel metodo `mount()` per determinare il modello associato al tipo di utente e l'azione di registrazione corrispondente (ad esempio, `Modules\Patient\Actions\Doctor\RegisterAction`).
- **Metodo `register()` aggiornato**: Ora utilizza un'azione personalizzata (`app($this->action)->execute($data)`) invece di implementare direttamente la logica di salvataggio, permettendo una maggiore flessibilità e riutilizzabilità.
## Recommended Modifications
Di seguito sono riportati i consigli per modificare `RegistrationWidget.php` al fine di includere il salvataggio dei dati e l'impostazione dello stato, mantenendo la flessibilità per l'uso in diversi progetti:
1. **Utilizzo di Azioni Dinamiche**:
   - Continuare a utilizzare la strategia basata su `$action` per delegare la logica di registrazione a classi specifiche come `Modules\Patient\Actions\Doctor\RegisterAction` o `Modules\Patient\Actions\Patient\RegisterAction`.
2. **Impostazione dello Stato dell'Utente**:
   - Assicurarsi che ogni azione personalizzata gestisca lo stato dell'utente in base al tipo e al contesto del progetto.
3. **Gestione del Workflow (se applicabile)**:
   - Nelle azioni personalizzate, implementare la logica per i workflow di moderazione o altri passaggi specifici del progetto.
4. **Notifica o Reindirizzamento**:
   - Configurare le azioni per gestire notifiche o reindirizzamenti in modo personalizzato per ogni tipo di utente.
### Example Code
```php
public function register()
{
    $data = $this->form->getState();
    app($this->action)->execute($data);
    session()->flash('message', 'Registrazione completata con successo.');
    return redirect()->route($this->getConfirmationRoute());
}
public function mount(string $type): void
    $this->type = $type;
    $this->resource = XotData::make()->getUserResourceClassByType($type);
    $this->model = $this->resource::getModel();
    $this->action = Str::of($this->model)->replace('\\Models\\', '\\Actions\\')->append('\\RegisterAction')->toString();
    $this->form->fill();
protected function getConfirmationRoute(): string
    // Route configurabile in base al progetto
    $mapping = app()->make('user_route_mapping') ?? [];
    return $mapping[$this->type] ?? 'user.registration.confirmation';
```
## References
- [Namespace Issues](../../../../docs/project/references/namespace-issues.md)
- [Filament Resource Guidelines](../../../modules/xot/project_docs/rules/filament-resource-guidelines.md)
- [Namespace Issues](../../../../docs/references/namespace-issues.md)
- [Filament Resource Guidelines](../../../modules/xot/docs/rules/filament-resource-guidelines.md)
# Registration Widget Documentation

## Overview

Il file `RegistrationWidget.php` si trova in `Modules/User/app/Filament/Widgets/RegistrationWidget.php`. Questo widget è utilizzato per la registrazione di diversi tipi di utenti in applicazioni basate su Laravel con Filament. Il modulo `User` è progettato per essere riutilizzabile in vari progetti, quindi la logica del widget deve essere flessibile e adattabile a contesti diversi.

## Current Issues

Dopo aver esaminato il codice, ho notato che manca la parte relativa al salvataggio vero e proprio dei dati dell'utente e all'impostazione dello stato dell'utente dopo la registrazione. Questo è essenziale per completare il flusso di registrazione. Inoltre, il widget deve gestire diversi tipi di utenti, quindi la logica di salvataggio deve essere configurabile in base al tipo di utente specificato tramite la proprietà `$type`.

## Recent Updates

Recentemente, il codice è stato aggiornato per introdurre una strategia più dinamica e modulare:
- **Importazione di `Illuminate\Support\Str`**: Per manipolare stringhe e creare dinamicamente il nome della classe di azione.
- **Nuove proprietà `$model` e `$action`**: Definite nel metodo `mount()` per determinare il modello associato al tipo di utente e l'azione di registrazione corrispondente (ad esempio, `Modules\Patient\Actions\Doctor\RegisterAction`).
- **Metodo `register()` aggiornato**: Ora utilizza un'azione personalizzata (`app($this->action)->execute($data)`) invece di implementare direttamente la logica di salvataggio, permettendo una maggiore flessibilità e riutilizzabilità.

## Recommended Modifications

Di seguito sono riportati i consigli per modificare `RegistrationWidget.php` al fine di includere il salvataggio dei dati e l'impostazione dello stato, mantenendo la flessibilità per l'uso in diversi progetti:

1. **Utilizzo di Azioni Dinamiche**:
   - Continuare a utilizzare la strategia basata su `$action` per delegare la logica di registrazione a classi specifiche come `Modules\Patient\Actions\Doctor\RegisterAction` o `Modules\Patient\Actions\Patient\RegisterAction`.

2. **Impostazione dello Stato dell'Utente**:
   - Assicurarsi che ogni azione personalizzata gestisca lo stato dell'utente in base al tipo e al contesto del progetto.

3. **Gestione del Workflow (se applicabile)**:
   - Nelle azioni personalizzate, implementare la logica per i workflow di moderazione o altri passaggi specifici del progetto.

4. **Notifica o Reindirizzamento**:
   - Configurare le azioni per gestire notifiche o reindirizzamenti in modo personalizzato per ogni tipo di utente.

### Example Code

```php
public function register()
{
    $data = $this->form->getState();
    app($this->action)->execute($data);
    session()->flash('message', 'Registrazione completata con successo.');
    return redirect()->route($this->getConfirmationRoute());
}

public function mount(string $type): void
{
    $this->type = $type;
    $this->resource = XotData::make()->getUserResourceClassByType($type);
    $this->model = $this->resource::getModel();
    $this->action = Str::of($this->model)->replace('\\Models\\', '\\Actions\\')->append('\\RegisterAction')->toString();
    $this->form->fill();
}

protected function getConfirmationRoute(): string
{
    // Route configurabile in base al progetto
    $mapping = app()->make('user_route_mapping') ?? [];
    return $mapping[$this->type] ?? 'user.registration.confirmation';
}
```

## References

- [Namespace Issues](../../../../docs/references/namespace-issues.md)
- [Filament Resource Guidelines](../../../modules/xot/docs/rules/filament-resource-guidelines.md)

---

## registration_widget

*Consolidated from: `registration_widget.md`*


## Overview

Il file `RegistrationWidget.php` si trova in `/var/www/html/saluteora/laravel/Modules/User/app/Filament/Widgets/RegistrationWidget.php`. Questo widget è utilizzato per la registrazione di diversi tipi di utenti in applicazioni basate su Laravel con Filament. Il modulo `User` è progettato per essere riutilizzabile in vari progetti, quindi la logica del widget deve essere flessibile e adattabile a contesti diversi.

## Current Issues

Dopo aver esaminato il codice, ho notato che manca la parte relativa al salvataggio vero e proprio dei dati dell'utente e all'impostazione dello stato dell'utente dopo la registrazione. Questo è essenziale per completare il flusso di registrazione. Inoltre, il widget deve gestire diversi tipi di utenti, quindi la logica di salvataggio deve essere configurabile in base al tipo di utente specificato tramite la proprietà `$type`.

## Recent Updates

Recentemente, il codice è stato aggiornato per introdurre una strategia più dinamica e modulare:
- **Importazione di `Illuminate\Support\Str`**: Per manipolare stringhe e creare dinamicamente il nome della classe di azione.
- **Nuove proprietà `$model` e `$action`**: Definite nel metodo `mount()` per determinare il modello associato al tipo di utente e l'azione di registrazione corrispondente (ad esempio, `Modules\Patient\Actions\Doctor\RegisterAction`).
- **Metodo `register()` aggiornato**: Ora utilizza un'azione personalizzata (`app($this->action)->execute($data)`) invece di implementare direttamente la logica di salvataggio, permettendo una maggiore flessibilità e riutilizzabilità.

## Recommended Modifications

Di seguito sono riportati i consigli per modificare `RegistrationWidget.php` al fine di includere il salvataggio dei dati e l'impostazione dello stato, mantenendo la flessibilità per l'uso in diversi progetti:

1. **Utilizzo di Azioni Dinamiche**:
   - Continuare a utilizzare la strategia basata su `$action` per delegare la logica di registrazione a classi specifiche come `Modules\Patient\Actions\Doctor\RegisterAction` o `Modules\Patient\Actions\Patient\RegisterAction`.

2. **Impostazione dello Stato dell'Utente**:
   - Assicurarsi che ogni azione personalizzata gestisca lo stato dell'utente in base al tipo e al contesto del progetto.

3. **Gestione del Workflow (se applicabile)**:
   - Nelle azioni personalizzate, implementare la logica per i workflow di moderazione o altri passaggi specifici del progetto.

4. **Notifica o Reindirizzamento**:
   - Configurare le azioni per gestire notifiche o reindirizzamenti in modo personalizzato per ogni tipo di utente.

### Example Code

```php
public function register()
{
    $data = $this->form->getState();
    app($this->action)->execute($data);
    session()->flash('message', 'Registrazione completata con successo.');
    return redirect()->route($this->getConfirmationRoute());
}

public function mount(string $type): void
{
    $this->type = $type;
    $this->resource = XotData::make()->getUserResourceClassByType($type);
    $this->model = $this->resource::getModel();
    $this->action = Str::of($this->model)->replace('\\Models\\', '\\Actions\\')->append('\\RegisterAction')->toString();
    $this->form->fill();
}

protected function getConfirmationRoute(): string
{
    // Route configurabile in base al progetto
    $mapping = app()->make('user_route_mapping') ?? [];
    return $mapping[$this->type] ?? 'user.registration.confirmation';
}
```

## References

- [Namespace Issues](../../../docs/references/namespace-issues.md)
- [Filament Resource Guidelines](../../../Modules/Xot/docs/rules/filament-resource-guidelines.md)

---

## registration_widget_fileupload_fix

*Consolidated from: `registration_widget_fileupload_fix.md`*


## Problema Risolto

Il `RegistrationWidget` mostrava l'errore `foreach() argument must be of type array|object, string given` durante il caricamento dei dati del form per utenti esistenti con file allegati.

## Causa del Problema

Il widget utilizzava il metodo `getFormFill()` per popolare il form con i dati esistenti dell'utente. Tuttavia, quando un utente aveva già dei file allegati salvati nel database:

1. I file venivano salvati come **stringhe** (percorsi dei file) nel database
2. Filament FileUpload si aspetta **array** di percorsi file
3. Questo mismatch causava l'errore quando Filament tentava di iterare sui file

## Codice Prima della Correzione

```php
public function getFormFill(): array
{
    $model = $this->getFormModel();
    
    if ($model->exists) {
        return $model->toArray(); // ❌ PROBLEMA: file salvati come stringhe
    }
    
    // resto del metodo...
}
```

## Codice Dopo la Correzione

```php
public function getFormFill(): array
{
    $model = $this->getFormModel();
    
    if ($model->exists) {
        try {
            $data = $model->toArray();
            
            // CORREZIONE BUG: Converti i campi file upload da stringhe ad array per Filament
            $attachments = [];
            try {
                $reflection = new \ReflectionClass($model);
                if ($reflection->hasProperty('attachments')) {
                    $property = $reflection->getProperty('attachments');
                    if ($property->isStatic()) {
                        /** @phpstan-ignore-next-line */
                        $attachments = $model::$attachments ?? [];
                    }
                }
            } catch (\ReflectionException $e) {
                // Se la proprietà non esiste, continua con array vuoto
            }
            
            foreach ($attachments as $attachment) {
                if (isset($data[$attachment]) && is_string($data[$attachment])) {
                    // Converte stringa singola in array per compatibilità Filament
                    $data[$attachment] = [$data[$attachment]];
                }
            }
            
            return $data;
        } catch (\Exception $e) {
            // Fallback per problemi con enum
            Log::warning("Errore in toArray() per modello {$this->model}: " . $e->getMessage());
            
            $attributes = $model->getAttributes();
            
            // Applica la stessa conversione anche agli attributi
            $attachments = [];
            try {
                $reflection = new \ReflectionClass($model);
                if ($reflection->hasProperty('attachments')) {
                    $property = $reflection->getProperty('attachments');
                    if ($property->isStatic()) {
                        /** @phpstan-ignore-next-line */
                        $attachments = $model::$attachments ?? [];
                    }
                }
            } catch (\ReflectionException $e) {
                // Se la proprietà non esiste, continua con array vuoto
            }
            
            foreach ($attachments as $attachment) {
                if (isset($attributes[$attachment]) && is_string($attributes[$attachment])) {
                    $attributes[$attachment] = [$attributes[$attachment]];
                }
            }
            
            return $attributes;
        }
    }
    
    // resto del metodo...
}
```

## Logica della Correzione

### 1. Identificazione Sicura degli Attachments

Invece di accedere direttamente a `$model::$attachments` (che causa errori PHPStan), uso la reflection per verificare se la proprietà esiste:

```php
$attachments = [];
try {
    $reflection = new \ReflectionClass($model);
    if ($reflection->hasProperty('attachments')) {
        $property = $reflection->getProperty('attachments');
        if ($property->isStatic()) {
            /** @phpstan-ignore-next-line */
            $attachments = $model::$attachments ?? [];
        }
    }
} catch (\ReflectionException $e) {
    // Se la proprietà non esiste, continua con array vuoto
}
```

### 2. Conversione Type-Safe

Per ogni campo attachment, verifico se è una stringa e la converto in array:

```php
foreach ($attachments as $attachment) {
    if (isset($data[$attachment]) && is_string($data[$attachment])) {
        // Converte stringa singola in array per compatibilità Filament
        $data[$attachment] = [$data[$attachment]];
    }
}
```

### 3. Gestione del Fallback

La stessa logica viene applicata anche nel caso di fallback quando `toArray()` fallisce.

## Vantaggi della Soluzione

1. **Type Safety**: Usa reflection per accesso sicuro alle proprietà statiche
2. **Backward Compatibility**: Gestisce sia stringhe che array esistenti
3. **Graceful Fallback**: Funziona anche se la proprietà `$attachments` non esiste
4. **PHPStan Compliant**: Evita errori di analisi statica

## Scenario di Test

### Before (Errore)
```php
// Dati nel database
$user->health_card = 'session-uploads/xyz/file.pdf';  // Stringa

// getFormFill() restituisce
['health_card' => 'session-uploads/xyz/file.pdf']

// Filament FileUpload cerca di iterare
foreach($state as $file) {  // ❌ ERRORE: $state è stringa, non array
    // ...
}
```

### After (Funziona)
```php
// Dati nel database
$user->health_card = 'session-uploads/xyz/file.pdf';  // Stringa

// getFormFill() restituisce (dopo correzione)
['health_card' => ['session-uploads/xyz/file.pdf']]  // Array!

// Filament FileUpload può iterare correttamente
foreach($state as $file) {  // ✅ OK: $state è array
    // ...
}
```

## Impact su Altri Componenti

Questa correzione è compatibile con:

1. **Nuovi upload**: FileUpload continua a funzionare normalmente
2. **Form validation**: Le regole di validazione rimangono invariate  
3. **Salvataggio**: I file vengono ancora salvati come stringhe nel database
4. **Altri widget**: Non impatta widget che non gestiscono file

## Testing

Per testare la correzione:

1. **Crea un utente** con file allegati
2. **Salva i file** tramite il wizard di registrazione
3. **Torna indietro** ai dati salvati (usando email + token)
4. **Verifica** che i file vengano caricati correttamente nel form
5. **Continua** il wizard senza errori

## Monitoraggio

Aggiungere logging per monitorare la conversione:

```php
Log::debug("Converting file upload field", [
    'attachment' => $attachment,
    'original_type' => gettype($data[$attachment]),
    'converted_type' => 'array',
    'session_id' => session()->getId()
]);
```

## Best Practice Future

Per evitare simili problemi in futuro:

1. **Consistency**: Mantenere i tipi di dati consistenti tra database e form
2. **Testing**: Testare sempre il reload di dati esistenti
3. **Type Checking**: Usare type checking difensivo nei callback
4. **Documentation**: Documentare i tipi di dati attesi per ogni campo

## Riferimenti

- [Problema principale: docs/fileupload-foreach-error-fix.md](../../../docs/fileupload-foreach-error-fix.md)
- [Correzione XotBaseResource: Modules/Xot/docs/fileupload-components.md](../../../../Xot/docs/fileupload-components.md)
- [Registration Widget base: registration-widget.md](./registration-widget.md)


---

## registration_widget_update

*Consolidated from: `registration_widget_update.md`*


## Nota del 2025-05-15

In relazione al widget di registrazione, ho aggiornato la documentazione per riflettere la modifica apportata a `DoctorResource.php` nel modulo Patient. Il metodo `getPersonalInfoStep` ora include i campi `first_name`, `last_name` ed `email`, essenziali per la raccolta dati durante la registrazione dei dottori.

### Impatto sul Widget di Registrazione
- **Coerenza Dati**: Assicurarsi che il widget di registrazione sia compatibile con i nuovi campi separati per nome e cognome.
- **Email**: L'aggiunta del campo email è cruciale per garantire che il widget possa inviare comunicazioni post-registrazione.

## Aggiornamento del 2025-05-15 (Ultimo)

Ho aggiornato ulteriormente la documentazione per riflettere un cambiamento nella gestione delle traduzioni in `DoctorResource.php`. La proprietà `$translationPrefix` è stata reintrodotta per supportare le traduzioni personalizzate, ma nei metodi del wizard i riferimenti diretti a questa proprietà sono stati sostituiti con namespace di traduzione diretti (`patient::doctor-resource`).

### Impatto sul Widget di Registrazione
- **Coerenza Traduzioni**: Questo cambiamento garantisce che le traduzioni siano applicate correttamente nel widget di registrazione, mantenendo la coerenza con il resto del sistema.

**Collegamenti correlati**:
- [Documentazione DoctorResource](../Modules/Patient/docs/doctor-resource-update.md)
- [Documentazione principale](../docs/roadmap_frontoffice/08-registrazione-odontoiatra.md)
- [Documentazione Doctor Model](../Modules/Patient/docs/doctor-model-update.md)

---

**Consolidated by:** Phase 2f intelligent merging
**Date:** 2026-08-04
