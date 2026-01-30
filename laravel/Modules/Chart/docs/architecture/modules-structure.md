# Struttura e Convenzioni dei Moduli

## Organizzazione Generale

### Namespace e Autoload
- Ogni modulo ha il proprio `composer.json` per namespace e autoload
- Namespace delle classi: `Modules\<Nome>\` (non `Modules\<Nome>\app`)
- Directory in minuscolo seguono PSR-4:
  - `app/` per il codice PHP
  - `resources/` per assets e viste
  - `config/` per configurazioni
  - `database/` per migrazioni e seeders
- `Resources` (maiuscolo) solo per classi PHP Resource
- Viste Blade sempre in `resources/views/`

### Documentazione
- Documentazione tecnica specifica del modulo in `docs/` del modulo
- Documentazione root solo per indice con link bidirezionali
- Distribuzione per tipo:
  - Generica: `Xot` (componenti base e funzionalità condivise)
  - Specifica progetto: root (documentazione progetto-specifica)
  - Frontend: `Cms` (gestione contenuti e frontend)
  - UI: `UI` (componenti UI e stili)
  - Utenti: `User` (gestione utenti)
  - Tenant: `Tenant` (gestione multi-tenant)
  - Traduzioni: `Lang` (localizzazione e traduzioni)
  - Media: `Media` (gestione file e media)
  - Notifiche: `Notify` (sistema di notifiche)
  - Report: `Report` (generazione report)
  - GDPR: `Gdpr` (gestione privacy)
  - Jobs: `Job` (processi asincroni)
  - Grafici: `Chart` (visualizzazione dati)

## Convenzioni di Codice

### Azioni Tabella
- `getTableActions()` e `getBulkActions()` restituiscono array con chiavi stringa
- Rimuovere se restituiscono solo azioni standard
- Includere `...parent::getTableActions()` se si aggiungono azioni personalizzate
- Esempio:
  ```php
  // ❌ Da evitare
  protected function getTableActions(): array
  {
      return [
          EditAction::make(),
          DeleteAction::make(),
      ];
  }
  
  // ✅ Corretto
  protected function getTableActions(): array
  {
      return [
          'custom' => [
              'label' => __('actions.custom'),
              'action' => 'customAction',
          ],
          ...parent::getTableActions(),
      ];
  }
  ```

### Traduzioni
- Mai usare `->label('')` direttamente
- Utilizzare sempre traduzioni in `lang/{locale}`
- Esempio:
  ```php
  // ❌ Da evitare
  ->label('Nome')
  
  // ✅ Corretto
  ->label(__('user::fields.name'))
  ```

### Frontoffice
- Utilizzare Folio + Volt + Livewire + Widget
- Nessuna rotta in `web.php`
- Blade in `Themes/{ThemeName}/resources/views/pages/`
- Form complessi con `@livewire(\Modules\{Module}\Filament\Widgets)`
- Widget estendono `XotBaseWidget` con `HasForms`
- Campi definiti in `getFormSchema()`
- Esempio:
  ```blade
  <!-- ❌ Da evitare -->
  @livewire('form-component')
  
  <!-- ✅ Corretto -->
  @livewire(\Modules\Cms\Filament\Widgets\CustomFormWidget::class)
  ```

### Ereditarietà
- Non estendere direttamente classi Filament
- Utilizzare `XotBase` in `Xot`
- Esempio:
  ```php
  // ❌ Da evitare
  class MyResource extends Resource
  
  // ✅ Corretto
  class MyResource extends XotBaseResource
  ```

### Azioni Form
- Utilizzare array associativi per le azioni
- Esempio:
  ```php
  protected function getFormActions(): array
  {
      return [
          'save' => [
              'label' => __('filament::actions.save'),
              'action' => 'save',
          ],
      ];
  }
  ```

### Dati Utente
- Utilizzare `first_name` e `last_name` separati
- Evitare campi generici come `name`
- Esempio:
  ```php
  // ❌ Da evitare
  $user->name = 'Mario Rossi';
  
  // ✅ Corretto
  $user->first_name = 'Mario';
  $user->last_name = 'Rossi';
  ```

### Prompt
- Prompt condivisi in singola stringa
- Senza formattazione/acapo
- Esempio:
  ```php
  // ❌ Da evitare
  $prompt = "Inserisci il nome\n
             Inserisci il cognome";
  
  // ✅ Corretto
  $prompt = "Inserisci il nome e il cognome";
  ```

### Script
- Script solo in cartelle `bashscripts` esistenti
- Nessuno script in altre directory
- Esempio:
  ```bash
  # ❌ Da evitare
  /scripts/update.sh
  
  # ✅ Corretto
  /bashscripts/update-gitignore.sh
  ```

## Collegamenti Documentazione

### Link Bidirezionali
- Mantenere link bidirezionali tra docs dei moduli
- Aggiornare sempre i link quando si modifica la struttura
- Esempio di link:
  ```markdown
  [Documentazione Modulo X](../../X/docs/README.md)
  [Documentazione Root](../../../docs/README.md)
  ```

### Contenuto Documentazione
- Documentare "perché" e "cosa", non "come"
- Focus su decisioni architetturali e scelte progettuali
- Evitare istruzioni passo-passo
- Esempio:
  ```markdown
  # ❌ Da evitare
  ## Come creare un nuovo modulo
  1. Esegui questo comando
  2. Modifica questo file
  3. Aggiungi questa configurazione
  
  # ✅ Corretto
  ## Scopo del modulo
  Questo modulo gestisce X perché Y è necessario per Z
  ```

## Esempi di Struttura

### Modulo Base
```
ModuleName/
├── Actions/              # Azioni (a livello root)
├── app/
│   ├── Http/             # Controllers, Middleware, etc.
│   │   └── Livewire/      # Componenti Livewire
│   ├── Models/            # Modelli
│   ├── Providers/         # Service Providers
│   └── Services/          # Servizi
├── resources/
│   ├── css/
│   ├── js/
│   └── views/
├── config/
├── database/
│   ├── migrations/
│   └── seeders/
├── docs/
│   ├── README.md
│   └── ...
└── composer.json
```

### Esempi di Path Corretti

```bash

# ✅ CORRETTO
Modules/User/Actions/User/DeleteUserAction.php

# ❌ ERRATO
Modules/User/app/Actions/User/DeleteUserAction.php
```

### Documentazione Modulo
```markdown

# Modulo Nome

## Collegamenti
- [Documentazione Root](../../../docs/README.md)
- [Modulo Xot](../../Xot/docs/README.md)
- [Modulo UI](../../UI/docs/README.md)

## Scopo
Descrizione del perché esiste questo modulo e cosa fa

## Dipendenze
- Modulo Xot
- Modulo UI

## Struttura
Descrizione della struttura e delle scelte architetturali
``` 
