# Convenzioni per Template Blade di Filament 

## Struttura Standard dei Template di Pagina

Ogni template di pagina Filament  **DEVE** seguire questa struttura standardizzata per garantire coerenza nell'interfaccia utente e nelle funzionalità.

## Elementi Obbligatori

Ogni template di pagina Filament deve includere:

1. **Tag radice**: `<x-filament-panels::page>`
2. **Sezione principale**: `<x-filament::section>`
3. **Tre slot** all'interno della sezione:
   - `heading`: Titolo della pagina
   - `description`: Breve descrizione della funzionalità della pagina
   - `footer`: Pulsanti di azione o altre funzionalità di navigazione

## Esempio Completo e Corretto

```blade
<x-filament-panels::page>
    <x-filament::section>
        <x-slot name="heading">
            Test Invio [Tipo di Messaggio]
        </x-slot>

        <x-slot name="description">
            Utilizza questo form per testare l'invio di [tipo di messaggio] tramite diversi provider.
        </x-slot>

        {{ $this->nomeForm }}

        <x-slot name="footer">
            <div class="flex items-center justify-end gap-x-3">
                <x-filament::button wire:click="methodName" type="submit" color="primary">
                    Invia [Tipo di Messaggio]
                </x-filament::button>
            </div>
        </x-slot>
    </x-filament::section>
</x-filament-panels::page>
```

## Elementi Opzionali ma Consigliati

1. **Indicatore di caricamento**:
   ```blade
   <x-filament::loading-indicator class="h-5 w-5" wire:loading wire:target="methodName"/>
   ```

2. **Gestione degli errori**:
   ```blade
   {{ $error_message ?? '--' }}
   ```

## Rischi di Non Conformità

Non seguire queste convenzioni può portare a:

1. **Inconsistenza UI**: Esperienza utente incoerente tra le diverse pagine
2. **Funzionalità mancanti**: Elementi obbligatori come i pulsanti di azione potrebbero essere assenti
3. **Accessibilità ridotta**: Mancanza di descrizioni può impattare l'accessibilità
4. **Manutenibilità difficoltosa**: Strutture non standard sono più difficili da mantenere

## Verifica di Conformità

Per verificare che tutti i template seguano queste convenzioni:

```bash
grep -L "name=\"description\"" Modules/*/resources/views/filament/pages/*.blade.php
grep -L "name=\"footer\"" Modules/*/resources/views/filament/pages/*.blade.php
grep -L "name=\"description\"" Modules/*/resources/views/filament/pages/*.blade.php
grep -L "name=\"footer\"" Modules/*/resources/views/filament/pages/*.blade.php
grep -L "name=\"description\"" Modules/*/resources/views/filament/pages/*.blade.php
grep -L "name=\"footer\"" Modules/*/resources/views/filament/pages/*.blade.php
```

## Riferimenti

- [Filament UI Components](https://filamentphp.com/docs/panels/components)
- [Laravel Blade Templates](https://laravel.com/docs/blade)
- [Accessibilità Web](https://www.w3.org/WAI/fundamentals/accessibility-intro/)
