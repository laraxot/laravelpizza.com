# Filament 5 + Laraxot Rules - Xot Module

## 🎯 Obiettivo

Definire le regole globali Laraxot per l’upgrade e l’utilizzo di **Filament 5.x** in tutti i moduli, mantenendo:

- coerenza architetturale con XotBase (Resources, Pages, Widgets, Panel Provider)
- compatibilità con le regole esistenti di Filament 4
- un flusso standard di migrazione da v4 a v5 (incluso script ufficiale `filament/upgrade`)

Queste regole estendono e non sostituiscono `filament-4-laraxot-rules.md`.

## 📚 Documentazione Completa

Per una guida completa e dettagliata su tutti i breaking changes e le procedure di upgrade, vedi:
**[Guida Completa Filament 5 + Livewire 4](filament-5-livewire-4-complete-guide.md)**

---

## ✅ Requisiti per Filament 5

Per poter usare Filament 5 in un modulo Laraxot/PTVX sono obbligatori:

- **PHP**: `>= 8.2` ✅ (Il progetto ha 8.3.6)
- **Laravel**: `>= 11.28` ⚠️ (Da verificare)
- **Livewire**: `>= 4.0` ⚠️ (Attualmente 3.7.6, da aggiornare)
- **Tailwind CSS**: `>= 4.0` ⚠️ (Da verificare)
- Tutti i plugin Filament devono essere **compatibili con v5** o disabilitati/documentati come non disponibili

> Ogni modulo che dipende da Filament deve verificare e documentare chiaramente:
> - versione minima di Laravel/Livewire effettivamente usata
> - plugin Filament obbligatori/facoltativi

---

## 🔑 Punto Fondamentale: Nessun Breaking Change Filament

**IMPORTANTE:** Filament 5 esiste **PRINCIPALMENTE per supportare Livewire 4**.

- **NON ci sono breaking changes funzionali** tra Filament 4 e 5
- **Tutte le API Filament rimangono compatibili**
- **L'unico motivo per l'upgrade è Livewire 4**
- **L'upgrade è considerato a basso rischio**

### Cosa NON Cambia

- **XotBaseResource**: Continua a funzionare senza modifiche
- **XotBasePages**: `XotBaseListRecords`, `XotBaseEditRecord`, etc. rimangono compatibili
- **XotBaseWidgets**: Tutte le classi widget rimangono valide
- **XotBaseActions**: Actions, TableActions, BulkActions non richiedono modifiche
- **Schemas**: Form, Table, Infolist continuano a funzionare
- **Resources**: Tutti i pattern esistenti rimangono validi

### Cosa Cambia (Livewire 4)

Tutti i cambiamenti sono legati alla migrazione a Livewire 4:

1. **Configurazione Livewire** da aggiornare
2. **Routing Livewire** da aggiornare
3. **wire:model behavior** da verificare (`.deep` modifier)
4. **Tag componenti** devono essere chiusi
5. **wire:transition** senza modificatori
6. **JavaScript hooks** deprecati

---

## 🔄 Procedura Ufficiale di Upgrade a Filament 5

**ATTENZIONE:** L'ordine corretto è **prima** Livewire v4, **poi** Filament v5.

L'upgrade da Filament 4 a 5 **DEVE** seguire l'ordine seguente (per l'intero progetto):

### Fase 1: Preparazione

1. **Backup del progetto**
   ```bash
   cp -r /var/www/_bases/base_laravelpizza/laravel \
         /var/www/_bases/base_laravelpizza_backup_$(date +%Y%m%d)
   ```

2. **Risolvere conflitti git**
   - Verifica `git status`
   - Risolvi tutti i conflitti (es. `SsoProviderResource.php`)
   - Commit delle modifiche

### Fase 2: Aggiornamento Config Livewire

Aggiorna `config/livewire.php` per v4:

```php
// ❌ Rimuovi/modifica queste chiavi
'layout' => 'components.layouts.app',
'lazy_placeholder' => null,
'smart_wire_keys' => false,

// ✅ Aggiungi/modifica queste chiavi
'component_layout' => 'layouts::app',
'component_placeholder' => null,
'smart_wire_keys' => true,
```

Vedi dettagli completi in [Guida Completa](filament-5-livewire-4-complete-guide.md#fase-2-aggiornamento-livewire-config).

### Fase 3: Upgrade Livewire a v4

1. **Aggiorna Livewire**
   ```bash
   composer require livewire/livewire:^4.0 -W
   ```

2. **Pulisci cache**
   ```bash
   php artisan optimize:clear
   php artisan config:clear
   php artisan cache:clear
   ```

3. **Verifica compatibilità componenti**
   - Segui la guida ufficiale: <https://livewire.laravel.com/docs/4.x/upgrading>
   - Verifica che tutti i componenti Livewire custom siano compatibili

### Fase 4: Upgrade Filament a v5

1. **Installare lo script di upgrade Filament** (solo temporaneamente, dev)

   ```bash
   composer require filament/upgrade:"^5.0" -W --dev
   ```

2. **Eseguire lo script di upgrade**

   ```bash
   vendor/bin/filament-v5
   ```

   - Lo script applica refactor automatici specifici del progetto (breaking changes comuni)
   - Ogni modulo DEVE:
     - revisionare i cambiamenti
     - aggiornare la propria documentazione `docs/` in base alle modifiche effettive

3. **Aggiornare il pacchetto principale Filament**

   ```bash
   composer require filament/filament:"^5.0" -W --no-update
   composer update
   ```

4. **Rimuovere il pacchetto di upgrade**

   ```bash
   composer remove filament/upgrade --dev
   ```

### Fase 5: Fix Manuali Livewire 4

Dopo l'upgrade, verifica e fix:

1. **wire:model non-standard** - aggiungi `.deep` se necessario
2. **wire:transition** - rimuovi modificatori
3. **wire:scroll** → **wire:navigate:scroll**
4. **Component tags** - assicurati siano chiusi

Vedi dettagli in [Guida Completa](filament-5-livewire-4-complete-guide.md#fase-5-verifiche-e-fissi-manuali).

### Fase 6: Build e Test

1. **Build frontend**
   ```bash
   npm run build
   ```

2. **Test completi**
   - Verifica pannello Filament
   - Testa resources, forms, tables, actions, widgets
   - Esegui PHPStan
   - Testa applicazione

> Nota: i comandi vanno eseguiti dalla root Laravel del progetto.
> Questa procedura va documentata sia in `Modules/Xot/docs` che nella documentazione root generale di progetto.

---

## 🏗️ Impatto Architetturale Laraxot

Filament 5 introduce cambi a livello di API e di ecosistema. Dal punto di vista Laraxot/Xot:

1. **XotBaseResource / XotBasePages / XotBaseWidget**
   - Continuano ad essere il **punto unico di estensione** per tutte le classi Filament.
   - È **vietato** introdurre nuove estensioni dirette di classi Filament (`ViewRecord`, `ListRecords`, `Widget`, ecc.).
   - Ogni breaking change v5 va assorbito **prima** nelle classi XotBase, **poi** propagato ai moduli.

2. **Schemas, Forms, Tables, Infolists**
   - Filament 5 continua il modello “schema-based” introdotto in v4.
   - Le regole di `filament-4-laraxot-rules.md` su uso di `Schema`, `getFormSchema()`, `getInfolistSchema()`, `getTableColumns()` restano valide e devono essere aggiornate solo per adeguarsi a nuove API o deprecation v5.

3. **Actions, Notifications, Widgets**
   - Azioni custom Filament continuano a seguire le regole Laraxot esistenti (override `setUp()`, niente stringhe hardcoded, traduzioni centralizzate, ecc.).
   - I widget devono continuare ad estendere le classi base Xot/UI, non direttamente widget Filament.
   - **Inclusione nei Blade View**: Per includere un widget Filament (che è un componente Livewire) all'interno di una vista Blade o di una pagina Folio, **non** usare la sintassi del tag `<livewire:module::widget-name />` a meno che non sia esplicitamente registrato. La sintassi corretta e sicura per Filament 5.x è l'uso diretto della classe: `@livewire(\Modules\User\Filament\Widgets\Auth\LoginWidget::class)`. Questo evita errori di `ComponentNotFoundException` nelle architetture modulari.
   - Ogni breaking change v5 su actions/widgets va documentato qui e nei moduli che li usano in modo intensivo (`UI`, `User`, `Notify`, `Cms`, `Job`, …).

4. **Panel configuration / AdminPanelProvider**
   - I provider Filament dei moduli (`Modules\*\Providers\Filament\AdminPanelProvider`) devono continuare ad estendere le classi XotBasePanel (`XotBaseMainPanelProvider`, `XotBasePanelProvider`).
   - Qualsiasi cambio nella configurazione pannello richiesto da Filament 5 (hook, navigation, user menu, ecc.) va implementato prima in Xot e poi documentato qui.

---

## 📚 Linee Guida di Documentazione per i Moduli

Ogni modulo che utilizza Filament **DEVE**:

1. Avere un documento di migrazione/upgrade a Filament 5 nella propria `docs/`, ad esempio:
   - `Modules/UI/docs/filament-5x-upgrade.md`
   - `Modules/User/docs/filament5-migration.md`
   - `Modules/Notify/docs/filament-v5-migration.md`

2. Strutturare il documento almeno con queste sezioni:
   - **Panoramica**: cosa fa il modulo in relazione a Filament
   - **Cambiamenti tra v4 e v5**: tabella o elenco v4 vs v5 (API Blade, components, actions, ecc.)
   - **Files modificati**: elenco file con breve descrizione
   - **Breaking changes risolti**: cosa rompeva e come è stato risolto
   - **Checklist**: passi pratici per verificare il corretto funzionamento dopo l’upgrade

3. Collegare il documento locale a questo file e, quando esiste, a un documento root generico Filament 5 del progetto.

---

## 🔍 Plugin Filament e Compatibilità v5

Prima/durante l’upgrade:

- Ogni modulo deve elencare i plugin Filament utilizzati (per es. calendari, media manager, ecc.).
- Per ogni plugin:
  - verificare se esiste una versione compatibile con v5
  - in caso contrario, **documentare** una di queste strategie:
    - disabilitazione temporanea (come fatto in UI per il calendario in v4)
    - sostituzione con altro plugin
    - fork/PR al plugin originale

La documentazione **DEVE** esplicitare cosa succede all’utente:
- funzionalità disabilitata vs alternativa temporanea
- stato del monitoraggio sul plugin (TODO, note future, ecc.).

---

## ✅ Checklist di Upgrade (progetto)

1. **Verifica prerequisiti**
   - [ ] PHP >= 8.2
   - [ ] Laravel >= 11.28
   - [ ] Livewire 4 installato e funzionante
   - [ ] Tailwind 4 configurato

2. **Script di upgrade**
   - [ ] Installato `filament/upgrade` (dev)
   - [ ] Eseguito `vendor/bin/filament-v5`
   - [ ] Revisionati i cambi automatici (per modulo)

3. **Update pacchetto principale**
   - [ ] Aggiornato `filament/filament` a `^5.0`
   - [ ] Eseguito `composer update`
   - [ ] Rimosso `filament/upgrade` dev

4. **Verifica per modulo**
   - [ ] Xot: aggiornate classi base + doc (`filament-5-laraxot-rules.md`)
   - [ ] UI: doc `filament-5x-upgrade.md` creata/aggiornata
   - [ ] User: doc `filament5-migration.md` creata/aggiornata
   - [ ] Notify: doc `filament-v5-migration.md` creata/aggiornata
   - [ ] Altri moduli Filament-heavy: doc specifica creata/aggiornata

5. **Qualità e test**
   - [ ] `php artisan view:cache` senza errori componenti Filament
   - [ ] PHPStan livello progetto (almeno 9) senza regressioni Filament
   - [ ] Test manuali pannello admin (login, navigazione, resources principali, widget, azioni, notifiche)

---

## 🔗 Collegamenti

- Guida ufficiale upgrade Filament 5: <https://filamentphp.com/docs/5.x/upgrade-guide>
- Documentazione Filament 5: <https://filamentphp.com/docs/5.x>
- Livewire 4 upgrade: <https://livewire.laravel.com/docs/4.x/upgrading>
- Regole esistenti Filament 4 Laraxot (stesso modulo): `filament-4-laraxot-rules.md`

---

*Questo documento è il riferimento centrale Xot per l’uso di Filament 5 nei moduli Laraxot/PTVX. Ogni variazione sostanziale alle API Filament deve essere riflessa qui e poi propagata alla documentazione dei singoli moduli.*
