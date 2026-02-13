# XotBaseServiceProvider: Architettura, Ruolo e Best Practice

## Ruolo della Classe
`XotBaseServiceProvider` è la base astratta per tutti i service provider dei moduli Laraxot. Centralizza la registrazione di:
- Traduzioni
- Configurazioni
- Viste
- Migrazioni
- Componenti Blade e Livewire modulari
- Comandi
- Set di icone SVG modulari tramite Blade Icons

Questa centralizzazione garantisce:
- Modularità e isolamento tra moduli
- Riduzione delle collisioni di nomi
- Facilità di override e personalizzazione

## Flusso di Bootstrap dei Moduli
1. **Boot:**
   - Registra traduzioni, config, viste, migrazioni
   - Registra componenti Livewire e Blade tramite azioni custom
   - Registra comandi CLI
2. **Register:**
   - Registra provider secondari del modulo (Route, Event)
   - Registra set di icone SVG con fallback multipli e Assert

## Best Practice e Warning
- **Non modificare direttamente la logica di registrazione componenti nei singoli moduli:** usa override puliti e rispetta la struttura PSR-4.
- **Gestione errori:** tutti i path e nomi devono essere validati; in caso di fallback, loggare l’evento.
- **PHPDoc:** tutti i metodi pubblici/protetti devono essere tipizzati e documentati.
- **Strict Types:** sempre presente `declare(strict_types=1);`
- **Override:** per personalizzare la registrazione di componenti, estendere e sovrascrivere i metodi dedicati.

## Regola: Risoluzione Path Traduzioni tramite GetModulePathByGeneratorAction

**Mai usare** `module_path($this->name, 'lang')` direttamente per risolvere la cartella delle traduzioni. Usare sempre:

```php
$langPath = app(GetModulePathByGeneratorAction::class)->execute($this->name, 'lang');
```

### Motivazione
- Garantisce coerenza, override, testabilità e modularità tra tutti i moduli
- Permette di cambiare la struttura dei path senza modificare ogni singolo provider
- Evita bug in ambienti multi-tenant o con override custom

### Esempio pratico
```php
public function registerTranslations(): void
{
    $langPath = app(GetModulePathByGeneratorAction::class)->execute($this->name, 'lang');
    $this->loadTranslationsFrom($langPath, $this->nameLower);
    $this->loadJsonTranslationsFrom($langPath);
}
```

### Warning
- L’uso diretto di `module_path` può portare a divergenze, bug e difficoltà di manutenzione
- Questa regola va rispettata anche da tutte le classi che estendono il provider

**Backlink:** Vedi anche [CONFLITTI_MERGE_RISOLTI.md](./CONFLITTI_MERGE_RISOLTI.md)

## Esempio di Override Sicuro
```php
class CustomModuleServiceProvider extends XotBaseServiceProvider
{
    protected function registerBladeComponents(): void
    {
        // Registrazione custom mantenendo la chiamata parent
        parent::registerBladeComponents();
        // ...aggiunte custom
    }
}
```

## Warning su Blade Icons
- Il path degli SVG viene risolto tramite azione custom e fallback multipli.
- In caso di errori, usare Assert e loggare per debug.
- Evitare collisioni di prefissi tra moduli diversi.

## Collegamenti e Backlink
- [COMPONENTI_PERSONALIZZATI.md](./COMPONENTI_PERSONALIZZATI.md) — Regole e path per Blade components modulari
- [CONFLITTI_MERGE_RISOLTI.md](./CONFLITTI_MERGE_RISOLTI.md) — Tracciamento conflitti risolti su ServiceProvider
- [FILAMENT_TABLE_COLUMNS.md](./FILAMENT_TABLE_COLUMNS.md) — Standardizzazione metodi colonne Filament

---

**Ultimo aggiornamento:** 2025-05-13

**Nota:** Aggiornare SEMPRE questa documentazione in caso di modifiche architetturali o override nei moduli.
