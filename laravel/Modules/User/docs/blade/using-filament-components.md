# Utilizzo dei componenti Blade di Filament

> **NOTA IMPORTANTE**: Questo documento è un riferimento specifico per il modulo User.
> La documentazione completa sui componenti Blade si trova nel [modulo UI](../../../UI/docs/blade/component-registration.md).
## Regola fondamentale: utilizzare i componenti Filament
Nel progetto , **abbiamo l'obbligo di utilizzare i componenti Blade forniti da Filament quando disponibili**, invece di creare componenti personalizzati che duplicano funzionalità già esistenti.
> La documentazione completa sui componenti Blade si trova nel [modulo UI](../../../UI/project_docs/blade/component-registration.md).
Nel progetto <nome progetto>, **abbiamo l'obbligo di utilizzare i componenti Blade forniti da Filament quando disponibili**, invece di creare componenti personalizzati che duplicano funzionalità già esistenti.
## Migrazione da componenti personalizzati a componenti Filament
### Dropdown personalizzato vs Filament Dropdown
Il componente `<x-profile.dropdown>` è un esempio di componente personalizzato che dovrebbe essere sostituito dal componente Filament equivalente.
#### Componente personalizzato (DA NON USARE):
```blade
<x-profile.dropdown>
    <x-slot name="trigger">
        <!-- Contenuto trigger -->
    </x-slot>
    <x-profile.dropdown-link href="{{ route('profile.show') }}">
        {{ __('Profile') }}
    </x-profile.dropdown-link>
</x-profile.dropdown>
```
#### Componente Filament (DA USARE):
<x-filament::dropdown>
    <x-filament::dropdown.list>
        <x-filament::dropdown.list.item
            href="{{ route('profile.show') }}"
            tag="a"
        >
            {{ __('Profile') }}
        </x-filament::dropdown.list.item>
    </x-filament::dropdown.list>
</x-filament::dropdown>
## Vantaggi dei componenti Filament
1. **Design system coerente** con il resto dell'applicazione
2. **Accessibilità integrata** e testata
3. **Responsive design** ottimizzato
4. **Manutenzione centralizzata** (aggiornamenti automatici)
5. **Temi e personalizzazione** tramite il sistema di Filament
## Documentazione di riferimento
- [Documentazione ufficiale Filament Dropdown](https://filamentphp.com/docs/3.x/support/blade-components/dropdown)
- [Filament Blade Components](https://filamentphp.com/docs/3.x/support/blade-components)
- [Documentazione ufficiale Filament Dropdown](https://filamentphp.com/project_docs/3.x/support/blade-components/dropdown)
- [Filament Blade Components](https://filamentphp.com/project_docs/3.x/support/blade-components)
## Errori comuni da evitare
1. ❌ Creare componenti personalizzati che duplicano componenti Filament esistenti
2. ❌ Modificare profondamente i componenti Filament invece di estenderli
3. ❌ Mescolare stili personalizzati con componenti Filament
4. ❌ Non tenere aggiornati i componenti alla versione corrente di Filament
