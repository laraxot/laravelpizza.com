# Componenti Blade di Filament

## Introduzione

In il progetto, utilizziamo i componenti Blade di Filament PHP come standard per la costruzione dell'interfaccia utente. Questo approccio garantisce:

1. **Consistenza**: I componenti Filament seguono un design system coerente
2. **Manutenibilità**: I componenti sono ben documentati e mantenuti dalla comunità
3. **Accessibilità**: I componenti sono progettati seguendo le best practice di accessibilità
4. **Performance**: I componenti sono ottimizzati per le performance

## Perché preferire i componenti Filament

### Esempio da evitare ❌

```blade
<a href="{{ route('register.type', ['type'=>$type]) }}">
    <x-ui.button class="w-full">{{ ucfirst($type) }}</x-ui.button>
</a>
```

Questo approccio presenta diversi problemi:
- Utilizza un componente personalizzato (`x-ui.button`)
- Richiede stili personalizzati
- Non è coerente con il design system di Filament
- Potrebbe non essere accessibile
- Richiede manutenzione aggiuntiva

### Esempio corretto ✅

```blade
<x-filament::button 
    size="sm" 
    href="{{ route('register.type', ['type'=>$type]) }}" 
    tag="a"
>
    {{ ucfirst($type) }}
</x-filament::button>
```

Questo approccio offre:
- Componente ufficiale Filament
- Stili predefiniti e coerenti
- Accessibilità garantita
- Documentazione ufficiale
- Supporto della comunità

## Componenti disponibili

I principali componenti Filament che dovremmo utilizzare sono:

1. **Bottoni**
   - `<x-filament::button>`
   - `<x-filament::icon-button>`
   - `<x-filament::link>`

2. **Form**
   - `<x-filament::input>`
   - `<x-filament::select>`
   - `<x-filament::checkbox>`
   - `<x-filament::radio>`

3. **Card e Contenitori**
   - `<x-filament::card>`
   - `<x-filament::section>`
   - `<x-filament::grid>`

4. **Feedback**
   - `<x-filament::alert>`
   - `<x-filament::badge>`
   - `<x-filament::notification>`

## Documentazione ufficiale

Per la documentazione completa dei componenti, consultare:
- [Documentazione ufficiale Filament](https://filamentphp.com/docs/3.x/support/blade-components/overview)
- [Componenti Blade di Filament](https://filamentphp.com/docs/3.x/support/blade-components/overview)

## Best Practices

1. **Sempre preferire i componenti Filament** ai componenti personalizzati
2. **Utilizzare i nomi corretti** dei componenti (es. `x-filament::button` invece di `x-ui.button`)
3. **Seguire la documentazione ufficiale** per le proprietà e gli attributi
4. **Mantenere la consistenza** nell'uso dei componenti in tutto il progetto
5. **Testare l'accessibilità** dei componenti utilizzati

## Esempi pratici

### Bottoni

```blade
<!-- Bottone primario -->
<x-filament::button>
    Salva
</x-filament::button>

<!-- Bottone secondario -->
<x-filament::button color="secondary">
    Annulla
</x-filament::button>

<!-- Bottone come link -->
<x-filament::button 
    href="{{ route('dashboard') }}" 
    tag="a"
>
    Vai alla Dashboard
</x-filament::button>
```

### Form

```blade
<!-- Input di testo -->
<x-filament::input
    label="Nome"
    name="name"
    required
/>

<!-- Select -->
<x-filament::select
    label="Ruolo"
    name="role"
    :options="['admin' => 'Amministratore', 'user' => 'Utente']"
/>
```

## Migrazione dai componenti personalizzati

Se stai migrando da componenti personalizzati a Filament:

1. Identifica i componenti personalizzati utilizzati
2. Trova l'equivalente Filament nella documentazione
3. Aggiorna il codice mantenendo la stessa funzionalità
4. Verifica che tutto funzioni correttamente
5. Rimuovi i componenti personalizzati non più utilizzati

## Supporto

Per domande o problemi con i componenti Filament:
- Consultare la documentazione ufficiale
- Aprire una issue nel repository del progetto
- Chiedere supporto nel canale Slack del team

## Collegamenti correlati

- [Regole per l'uso dei componenti Filament](../../../../docs/rules/filament-components.mdc)
- [Documentazione Filament nel CMS](../../../../docs/filament/componenti-blade.md)
- [Convenzioni namespace Filament](../convenzioni-namespace-filament.md)
- [Personalizzazioni avanzate Filament](../filament-personalizzazioni-avanzate.md) 

## Collegamenti tra versioni di componenti-blade.md
* [componenti-blade.md](docs/filament/componenti-blade.md)
* [componenti-blade.md](laravel/Modules/Cms/docs/filament/componenti-blade.md)

