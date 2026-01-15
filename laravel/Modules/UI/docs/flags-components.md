# Componenti SVG Bandiere nel Modulo UI

## Collegamenti correlati
- [Documentazione centrale](/docs/README.md)
- [Collegamenti documentazione](/docs/collegamenti-documentazione.md)
- [Documentazione UI](/laravel/Modules/UI/docs/README.md)
- [Documentazione sezioni](/docs/sections.md)
- [Header: Lingua e Utente](/laravel/Themes/One/docs/sections/HEADER_LANGUAGE_USER_DROPDOWN.md)
- [Implementazione CMS](/laravel/Modules/Cms/docs/sections/HEADER_LANGUAGE_USER_DROPDOWN.md)

## Panoramica

Il modulo UI di  include una vasta collezione di SVG di bandiere nazionali che possono essere utilizzati come componenti Blade. Questi componenti sono autoregistrati e possono essere facilmente integrati in qualsiasi parte dell'applicazione, incluso il selettore di lingue nell'header.
Il modulo UI di <nome progetto> include una vasta collezione di SVG di bandiere nazionali che possono essere utilizzati come componenti Blade. Questi componenti sono autoregistrati e possono essere facilmente integrati in qualsiasi parte dell'applicazione, incluso il selettore di lingue nell'header.
Il modulo UI di <nome progetto> include una vasta collezione di SVG di bandiere nazionali che possono essere utilizzati come componenti Blade. Questi componenti sono autoregistrati e possono essere facilmente integrati in qualsiasi parte dell'applicazione, incluso il selettore di lingue nell'header.

## Struttura dei Componenti Bandiera

I file SVG delle bandiere sono archiviati in:
```
Modules/UI/resources/svg/flags/
Modules/UI/resources/svg/flags/
Modules/UI/resources/svg/flags/
```

Ogni bandiera è rappresentata da un file SVG con il codice ISO del paese come nome file (ad esempio, `it.svg` per l'Italia, `gb.svg` per il Regno Unito).

## Registrazione Automatica

I componenti SVG sono autoregistrati tramite il metodo `registerBladeIcons()` nel `XotBaseServiceProvider`. Questo metodo configura i set di icone Blade con il prefisso del modulo, consentendo di utilizzare i componenti SVG delle bandiere in qualsiasi vista Blade.

```php
public function registerBladeIcons(): void
{
    // ...
    $svgPath = module_path($this->name, $relativePath.'/../svg');
    // ...
    Config::set('blade-icons.sets.'.$this->nameLower.'.path', $svgPath);
    Config::set('blade-icons.sets.'.$this->nameLower.'.prefix', $this->nameLower);
}
```

## Utilizzo dei Componenti Bandiera

### Sintassi Base

I componenti SVG delle bandiere possono essere utilizzati con la seguente sintassi:

```blade
<x-ui-flags.it class="h-5 w-5" />
<x-ui-flags.gb class="h-5 w-5" />
<x-ui-flags.fr class="h-5 w-5" />
```

Dove:
- `ui` è il prefisso del modulo (in minuscolo)
- `flags` è la sottodirectory all'interno della cartella `svg`
- `it`, `gb`, `fr` sono i codici ISO dei paesi

### Attributi Supportati

I componenti SVG supportano tutti gli attributi HTML standard, inclusi:

- `class`: Per applicare classi CSS
- `style`: Per applicare stili inline
- `width` e `height`: Per dimensionare l'SVG
- `title`: Per aggiungere un titolo accessibile
- `aria-*`: Per migliorare l'accessibilità

### Esempio con Attributi

```blade
<x-ui-flags.it
    class="h-6 w-6 rounded-full shadow-sm"
    title="Italiano"
    aria-label="Seleziona lingua italiana"
/>
```

## Utilizzo dei Componenti Bandiera con Filament

### Sintassi Corretta
Le bandiere devono essere utilizzate come icone Filament:

```blade
{{-- Per icone semplici --}}
<x-filament::icon
    :icon="'ui-flags.' . $flagCode"
    class="h-5 w-5 text-gray-500 dark:text-gray-400"
    :label="$flagCode"
    aria-hidden="true"
/>

{{-- Per pulsanti con icone --}}
<x-filament::icon-button
    :icon="'ui-flags.' . $flagCode"
    class="h-5 w-5"
    :label="$flagCode"
    aria-hidden="true"
/>
```

### Vantaggi dell'Uso dei Componenti Filament
1. **Coerenza**: Mantiene lo stile del design system
2. **Tema Scuro**: Gestione automatica del tema scuro
3. **Accessibilità**: Componenti già ottimizzati per l'accessibilità
4. **Manutenibilità**: Codice più pulito e standardizzato

### Implementazione nel Selettore di Lingue
```blade
<x-filament::dropdown>
    <x-slot name="trigger">
        <x-filament::icon-button
            :icon="'ui-flags.' . $flagCode"
            class="h-5 w-5"
            :label="$flagCode"
            aria-hidden="true"
        />
    </x-slot>

    <x-filament::dropdown.list>
        @foreach($languages as $code => $language)
            <x-filament::dropdown.list.item>
                <x-filament::icon
                    :icon="'ui-flags.' . $code"
                    class="h-5 w-5 text-gray-500 dark:text-gray-400"
                    :label="$code"
                />
                <span>{{ $language['name'] }}</span>
            </x-filament::dropdown.list.item>
        @endforeach
    </x-filament::dropdown.list>
</x-filament::dropdown>
```

## Vantaggi dell'Utilizzo dei Componenti SVG

1. **Qualità Visiva**: Gli SVG sono vettoriali e mantengono la qualità a qualsiasi dimensione
2. **Personalizzazione**: Facile da personalizzare con classi CSS
3. **Prestazioni**: Gli SVG sono leggeri e non richiedono richieste HTTP aggiuntive
4. **Accessibilità**: Possibilità di aggiungere attributi di accessibilità
5. **Coerenza**: Utilizzo di componenti nativi di
5. **Coerenza**: Utilizzo di componenti nativi di <nome progetto>
5. **Coerenza**: Utilizzo di componenti nativi di <nome progetto>

## Bandiere Disponibili

Il modulo UI include bandiere per tutti i paesi ISO, tra cui:

- `it.svg`: Italia
- `gb.svg`: Regno Unito
- `fr.svg`: Francia
- `de.svg`: Germania
- `es.svg`: Spagna
- `us.svg`: Stati Uniti
- ... e molti altri

## Gestione delle Proporzioni delle Bandiere

### Proporzioni Originali
Le bandiere SVG hanno proporzioni specifiche che devono essere rispettate:
- Bandiere standard: rapporto 3:2 (es. Italia, Francia)
- Bandiere speciali: rapporto 2:1 (es. Regno Unito)

### Implementazione Corretta
Per visualizzare correttamente le bandiere, è necessario:

1. **Contenitore**:
   ```blade
   <div class="relative w-6 h-6 overflow-hidden rounded-full">
   ```

2. **Bandiera**:
   ```blade
   <x-dynamic-component
       :component="'ui-flags.' . $flagCode"
       class="w-6 h-4 absolute inset-0 object-contain"
       aria-hidden="true"
   />
   ```

### Note Importanti
- Usare `object-contain` invece di `object-cover` per mantenere le proporzioni
- Impostare l'altezza della bandiera a 2/3 della larghezza per il rapporto 3:2
- Per bandiere con rapporto 2:1, usare altezza = larghezza/2

### Esempio di Implementazione
```blade
<div class="relative w-6 h-6 overflow-hidden rounded-full ring-1 ring-gray-200">
    <x-dynamic-component
        :component="'ui-flags.' . $flagCode"
        class="w-6 h-4 absolute inset-0 object-contain"
        aria-hidden="true"
    />
</div>
```
# Componenti SVG Bandiere nel Modulo UI

## Collegamenti correlati
- [Documentazione centrale](/docs/README.md)
- [Collegamenti documentazione](/docs/collegamenti-documentazione.md)
- [Documentazione UI](/laravel/Modules/UI/docs/README.md)
- [Documentazione sezioni](/docs/sections.md)
- [Header: Lingua e Utente](/laravel/Themes/One/docs/sections/HEADER_LANGUAGE_USER_DROPDOWN.md)
- [Implementazione CMS](/laravel/Modules/Cms/docs/sections/HEADER_LANGUAGE_USER_DROPDOWN.md)

## Panoramica

Il modulo UI di <nome progetto> include una vasta collezione di SVG di bandiere nazionali che possono essere utilizzati come componenti Blade. Questi componenti sono autoregistrati e possono essere facilmente integrati in qualsiasi parte dell'applicazione, incluso il selettore di lingue nell'header.

## Struttura dei Componenti Bandiera

I file SVG delle bandiere sono archiviati in:
```
Modules/UI/resources/svg/flags/
```

Ogni bandiera è rappresentata da un file SVG con il codice ISO del paese come nome file (ad esempio, `it.svg` per l'Italia, `gb.svg` per il Regno Unito).

## Registrazione Automatica

I componenti SVG sono autoregistrati tramite il metodo `registerBladeIcons()` nel `XotBaseServiceProvider`. Questo metodo configura i set di icone Blade con il prefisso del modulo, consentendo di utilizzare i componenti SVG delle bandiere in qualsiasi vista Blade.

```php
public function registerBladeIcons(): void
{
    // ...
    $svgPath = module_path($this->name, $relativePath.'/../svg');
    // ...
    Config::set('blade-icons.sets.'.$this->nameLower.'.path', $svgPath);
    Config::set('blade-icons.sets.'.$this->nameLower.'.prefix', $this->nameLower);
}
```

## Utilizzo dei Componenti Bandiera

### Sintassi Base

I componenti SVG delle bandiere possono essere utilizzati con la seguente sintassi:

```blade
<x-ui-flags.it class="h-5 w-5" />
<x-ui-flags.gb class="h-5 w-5" />
<x-ui-flags.fr class="h-5 w-5" />
```

Dove:
- `ui` è il prefisso del modulo (in minuscolo)
- `flags` è la sottodirectory all'interno della cartella `svg`
- `it`, `gb`, `fr` sono i codici ISO dei paesi

### Attributi Supportati

I componenti SVG supportano tutti gli attributi HTML standard, inclusi:

- `class`: Per applicare classi CSS
- `style`: Per applicare stili inline
- `width` e `height`: Per dimensionare l'SVG
- `title`: Per aggiungere un titolo accessibile
- `aria-*`: Per migliorare l'accessibilità

### Esempio con Attributi

```blade
<x-ui-flags.it
    class="h-6 w-6 rounded-full shadow-sm"
    title="Italiano"
    aria-label="Seleziona lingua italiana"
/>
```

## Utilizzo dei Componenti Bandiera con Filament

### Sintassi Corretta
Le bandiere devono essere utilizzate come icone Filament:

```blade
{{-- Per icone semplici --}}
<x-filament::icon
    :icon="'ui-flags.' . $flagCode"
    class="h-5 w-5 text-gray-500 dark:text-gray-400"
    :label="$flagCode"
    aria-hidden="true"
/>

{{-- Per pulsanti con icone --}}
<x-filament::icon-button
    :icon="'ui-flags.' . $flagCode"
    class="h-5 w-5"
    :label="$flagCode"
    aria-hidden="true"
/>
```

### Vantaggi dell'Uso dei Componenti Filament
1. **Coerenza**: Mantiene lo stile del design system
2. **Tema Scuro**: Gestione automatica del tema scuro
3. **Accessibilità**: Componenti già ottimizzati per l'accessibilità
4. **Manutenibilità**: Codice più pulito e standardizzato

### Implementazione nel Selettore di Lingue
```blade
<x-filament::dropdown>
    <x-slot name="trigger">
        <x-filament::icon-button
            :icon="'ui-flags.' . $flagCode"
            class="h-5 w-5"
            :label="$flagCode"
            aria-hidden="true"
        />
    </x-slot>

    <x-filament::dropdown.list>
        @foreach($languages as $code => $language)
            <x-filament::dropdown.list.item>
                <x-filament::icon
                    :icon="'ui-flags.' . $code"
                    class="h-5 w-5 text-gray-500 dark:text-gray-400"
                    :label="$code"
                />
                <span>{{ $language['name'] }}</span>
            </x-filament::dropdown.list.item>
        @endforeach
    </x-filament::dropdown.list>
</x-filament::dropdown>
```

## Vantaggi dell'Utilizzo dei Componenti SVG

1. **Qualità Visiva**: Gli SVG sono vettoriali e mantengono la qualità a qualsiasi dimensione
2. **Personalizzazione**: Facile da personalizzare con classi CSS
3. **Prestazioni**: Gli SVG sono leggeri e non richiedono richieste HTTP aggiuntive
4. **Accessibilità**: Possibilità di aggiungere attributi di accessibilità
5. **Coerenza**: Utilizzo di componenti nativi di <nome progetto>

## Bandiere Disponibili

Il modulo UI include bandiere per tutti i paesi ISO, tra cui:

- `it.svg`: Italia
- `gb.svg`: Regno Unito
- `fr.svg`: Francia
- `de.svg`: Germania
- `es.svg`: Spagna
- `us.svg`: Stati Uniti
- ... e molti altri

## Gestione delle Proporzioni delle Bandiere

### Proporzioni Originali
Le bandiere SVG hanno proporzioni specifiche che devono essere rispettate:
- Bandiere standard: rapporto 3:2 (es. Italia, Francia)
- Bandiere speciali: rapporto 2:1 (es. Regno Unito)

### Implementazione Corretta
Per visualizzare correttamente le bandiere, è necessario:

1. **Contenitore**:
   ```blade
   <div class="relative w-6 h-6 overflow-hidden rounded-full">
   ```

2. **Bandiera**:
   ```blade
   <x-dynamic-component
       :component="'ui-flags.' . $flagCode"
       class="w-6 h-4 absolute inset-0 object-contain"
       aria-hidden="true"
   />
   ```

### Note Importanti
- Usare `object-contain` invece di `object-cover` per mantenere le proporzioni
- Impostare l'altezza della bandiera a 2/3 della larghezza per il rapporto 3:2
- Per bandiere con rapporto 2:1, usare altezza = larghezza/2

### Esempio di Implementazione
```blade
<div class="relative w-6 h-6 overflow-hidden rounded-full ring-1 ring-gray-200">
    <x-dynamic-component
        :component="'ui-flags.' . $flagCode"
        class="w-6 h-4 absolute inset-0 object-contain"
        aria-hidden="true"
    />
</div>
```

## Conclusione

L'utilizzo dei componenti SVG delle bandiere del modulo UI è il modo più efficace per rendere il selettore di lingue nell'header più accattivante e visibile. Questi componenti sono già integrati  e possono essere facilmente utilizzati in qualsiasi parte dell'applicazione.
