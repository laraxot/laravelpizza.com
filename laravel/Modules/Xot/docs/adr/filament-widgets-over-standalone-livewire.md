---
title: "ADR — Nessun Livewire standalone: usare Filament Widget, Resource e Page"
type: decision
status: accepted
module: Xot
created: 2026-11-23
updated: 2026-11-24
qmd: "filament widgets over standalone livewire nessun"
---

# Nessun Livewire standalone: usare Filament Widget

## Contesto

Il progetto usa Filament 5 come pannello amministrativo e come sistema di componenti UI. Livewire è una dipendenza di
Filament (un Filament Widget è un componente Livewire sotto il cofano), ma un componente Livewire autonomo nei moduli
crea una seconda superficie di autodiscovery e di gestione dello stato:

- due sistemi di componenti paralleli da mantenere;
- duplicazione di form, validazione, autorizzazione e lifecycle;
- componenti difficili da testare in isolamento (richiedono un TestCase Livewire dedicato);
- incoerenza di stile e pattern nel codice.

Quale superficie interattiva usa il codice nuovo, senza eliminare il runtime Livewire che Filament richiede?

## Driver della decisione

- Una sola superficie interattiva, governata da Filament.
- Integrazione nativa con schema, Policy, pannelli e test Pest.
- Basi Xot riusabili per mantenere coerenti tutti i moduli: i widget appartengono al pannello che li espone e il modulo
  Xot riusa i punti di estensione Filament invece di creare superfici Livewire parallele.
- Codice nuovo più semplice da scoprire e mantenere.

## Decisione

**Non si introducono componenti Livewire standalone** in `Modules/*/app/Http/Livewire` o equivalenti come superficie
primaria. Il codice nuovo e le migrazioni dei componenti interattivi usano:

1. **Filament Widget**, preferibilmente `XotBaseWidget`, `XotBaseSchemaWidget` o le altre basi Filament di Xot, per i
   componenti riutilizzabili (dashboard, statistiche, form);
2. **Filament Resource** per CRUD e tabelle;
3. **Filament Page** per le pagine standalone;
4. **Blade + Alpine.js** per la logica frontend semplice senza backend PHP.

La decisione non elimina la dipendenza tecnica da Livewire: viene vietata la superficie autonoma, non il runtime
necessario a Filament.

Esempio, errato (Livewire standalone) e corretto (Filament Widget nel modulo owner):

```php
// Errato: app/Livewire/Stats.php
class Stats extends Component
{
    public function render()
    {
        return view('livewire.stats');
    }
}

// Corretto: Modules/<Modulo>/app/Filament/Widgets/StatsWidget.php
class StatsWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    public function mount(): void
    {
        $this->data = $this->loadStats();
    }
}
```

Quando NON si applica: i componenti legacy già esistenti si mantengono finché non vengono rifattorizzati; le librerie
esterne che dipendono da Livewire si integrano tramite un wrapper Filament.

## Alternative scartate

- Un componente Livewire dedicato per ogni interazione: duplica stato, lifecycle e autorizzazione già forniti da
  Filament, e frammenta autorizzazione e test.
- Widget Livewire standalone fuori dal pannello, o lo stesso widget duplicato in più moduli.
- Blade con stato JavaScript ad hoc come superficie primaria: perde l'integrazione con form, schemi Filament e Policy e
  rende più difficile il test.
- Rimozione completa di Livewire: incompatibile con il modello interattivo di Filament.

## Conseguenze

- Buono: un solo sistema di componenti da mantenere, coerenza stilistica e funzionale, testing semplificato sul Widget e
  sul suo schema (non su un componente Livewire autonomo), supporto per temi, plugin e configurazioni centralizzate.
- Buono: il codice nuovo vive in `Filament/Widgets` del modulo owner.
- Cattivo: per componenti molto specifici Filament può sembrare sovra-strutturato, e la sua curva di apprendimento è più
  ripida di Livewire puro.
- Debito: i residui legacy senza consumer restano debito esplicito e si ritirano con una story BMAD, senza creare nuovi
  gemelli. Al 2026-11-24 dodici moduli hanno ancora file in `app/Http/Livewire` (AI, Chart, CloudStorage, Cms, Gdpr,
  Geo, Job, Limesurvey, Quaeris, Setting, UI, User): è il debito legacy che la decisione ammette.

## Conferma

- Il codice nuovo vive in `Filament/Widgets` del modulo owner; le basi Filament di Xot sono il punto di partenza.
- Story di migrazione: [adr-0008-no-standalone-livewire-widgets](../stories/adr-0008-no-standalone-livewire-widgets.story.md).
- La scelta è confermata dai test architetturali del modulo Xot e dalle classi base Filament owner.

## Verifica

- `cd laravel && vendor/bin/pest Modules/Xot/tests/Unit/NoLivewireDirectoriesInModulesTest.php`: guardia che asserisce
  l'assenza di `Modules/*/app/Http/Livewire` (`Modules/Xot/tests/Unit/NoLivewireDirectoriesInModulesTest.php`). Finché
  il debito legacy sopra non è ritirato, quell'assenza non è vera nel checkout: la guardia e il debito vanno
  riconciliati dalla story di migrazione, non ignorati.
- `cd laravel && vendor/bin/pest Modules/User/tests/Unit/Filament/Widgets/Auth/AuthSchemaDelegationContractTest.php`:
  esempio di Widget Filament con schema delegato al posto di un componente Livewire autonomo
  (`Modules/User/tests/Unit/Filament/Widgets/Auth/AuthSchemaDelegationContractTest.php`).
