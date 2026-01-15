# Utilizzo dei componenti Blade di Filament

## Regola fondamentale

Nel progetto <nome progetto>, esiste una regola fondamentale: **utilizzare sempre i componenti Blade forniti da Filament quando disponibili**, invece di creare componenti personalizzati duplicati.

## Vantaggi dei componenti Filament

I componenti Filament offrono numerosi vantaggi:

- **Design system coerente** con l'intero ecosistema Filament
- **Accessibilità già implementata** secondo standard moderni
- **Temi e personalizzazione** tramite configurazione centralizzata
- **Responsive design** ottimizzato per diverse dimensioni di schermo
- **Manutenzione semplificata** grazie agli aggiornamenti automatici
- **Documentazione completa e aggiornata**

## Componenti disponibili

Filament mette a disposizione molti componenti Blade riutilizzabili:

| Componente | Tag Filament | Non usare (personalizzati) |
|------------|--------------|----------------------------|
| Dropdown | `<x-filament::dropdown>` | `<x-profile.dropdown>` |
| Button | `<x-filament::button>` | Pulsanti personalizzati |
| Card | `<x-filament::card>` | Card personalizzate |
| Icon | `<x-filament::icon>` | Icon personalizzate |
| Modal | `<x-filament::modal>` | Modal personalizzate |
| Tabs | `<x-filament::tabs>` | Tab personalizzati |

## Esempi di utilizzo

### Dropdown (menu a tendina)

```blade
<x-filament::dropdown>
    <x-slot name="trigger">
        <button>
            {{ __('Menu') }}
        </button>
    </x-slot>

    <x-filament::dropdown.list>
        <x-filament::dropdown.list.item>
            {{ __('Profile') }}
        </x-filament::dropdown.list.item>

        {{-- Separatore --}}
        <div class="border-t border-gray-200 dark:border-gray-700 my-1"></div>

        <x-filament::dropdown.list.item>
            {{ __('Settings') }}
        </x-filament::dropdown.list.item>
    </x-filament::dropdown.list>
</x-filament::dropdown>
```

### Card (schede)

```blade
<x-filament::card>
    <x-slot name="heading">
        Titolo della scheda
    </x-slot>

    <x-slot name="description">
        Descrizione opzionale della scheda.
    </x-slot>

    Contenuto della scheda...

    <x-slot name="footer">
        <x-filament::button>
            Azione
        </x-filament::button>
    </x-slot>
</x-filament::card>
```

## Migrazione da componenti personalizzati a Filament

Per migrare da componenti personalizzati a componenti Filament:

1. **Identificare** i componenti personalizzati nel codice
2. **Trovare** l'equivalente Filament nella documentazione
3. **Sostituire** il componente personalizzato con quello Filament
4. **Adattare** eventuali slot o proprietà alle convenzioni Filament

## Errori comuni da evitare

1. ❌ **Non creare componenti personalizzati** che duplicano funzionalità già presenti in Filament
2. ❌ **Non modificare i componenti base di Filament**, ma estenderli se necessario
3. ❌ **Non mescolare stili personalizzati** con componenti Filament senza necessità
4. ❌ **Non usare versioni obsolete** dei componenti Filament

## Documentazione di riferimento

- [Documentazione ufficiale Filament Blade Components](https://filamentphp.com/docs/3.x/support/blade-components)
- [Dropdown](https://filamentphp.com/docs/3.x/support/blade-components/dropdown)
- [Button](https://filamentphp.com/docs/3.x/support/blade-components/button)
- [Card](https://filamentphp.com/docs/3.x/support/blade-components/card)
- [Icon](https://filamentphp.com/docs/3.x/support/blade-components/icon)
- [Modal](https://filamentphp.com/docs/3.x/support/blade-components/modal)

## Moduli correlati

- [User](../../User/docs/blade/using-filament-components.md) - Implementazione dei componenti profilo con Filament
