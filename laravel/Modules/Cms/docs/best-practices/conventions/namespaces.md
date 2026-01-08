# Convenzioni Namespace

## Struttura Base
Nonostante i file possano trovarsi nella cartella `app/`, il namespace base per tutti i moduli è:
```php
Modules\<NomeModulo>\
```

### Esempio Corretto
File in: `laravel/Modules/Cms/app/Filament/Resources/SectionResource.php`
```php
namespace Modules\Cms\Filament\Resources;
```

### Esempio Errato ❌
```php
namespace Modules\Cms\App\Filament\Resources;
```

## Filament Components
Per i componenti Filament, seguire questa struttura:
```
Modules\Cms\Filament\
├── Resources\
│   ├── SectionResource.php
│   └── Pages\
├── Blocks\
│   ├── NavigationBlock.php
│   └── LogoBlock.php
└── Forms\
```

**Nota Importante**: 
- Il namespace per i blocchi Filament deve essere `Modules\<NomeModulo>\Filament\Blocks`
- NON utilizzare `Modules\<NomeModulo>\App\Filament\Blocks`
- Questa regola vale anche se i file risiedono fisicamente in `app/Filament/Blocks`

## Traduzioni
- NON utilizzare MAI il metodo `->label()` con stringhe hardcoded
- Utilizzare SEMPRE i file di traduzione nel percorso `Modules/<NomeModulo>/lang/<lingua>/`
- Utilizzare la funzione `__()` o `trans()` per accedere alle traduzioni
- Le traduzioni devono seguire la struttura gerarchica del modulo

### Esempio Corretto
```php
TextInput::make('name')
    ->translateLabel() // Usa la chiave di traduzione basata sul campo
    // oppure
    ->label(__('cms::sections.fields.name'))
```

### Esempio Errato ❌
```php
TextInput::make('name')
    ->label('Nome') // ❌ Stringa hardcoded
```

### Struttura delle Traduzioni
Le traduzioni devono seguire questa struttura:
```php
return [
    'sections' => [
        'fields' => [
            'name' => [
                'label' => 'Nome',
                'tooltip' => 'Inserisci il nome'
            ]
        ]
    ]
];
```

## Best Practices
1. **Namespace**:
   - Seguire sempre la struttura corretta dei namespace
   - Non includere `App` nel namespace anche se i file sono in `app/`
   - Mantenere la coerenza tra la struttura fisica e i namespace

2. **Traduzioni**:
   - Utilizzare sempre i file di traduzione
   - Non hardcodare le stringhe
   - Seguire la struttura gerarchica
   - Aggiungere tooltip e descrizioni dove necessario
   - Utilizzare il prefisso del modulo (es: `cms::`) per le traduzioni
   - Mantenere la coerenza tra le diverse lingue

3. **Documentazione**:
   - Mantenere aggiornata la documentazione
   - Aggiungere esempi chiari
   - Documentare le eccezioni
   - Fornire collegamenti bidirezionali

## Collegamenti
- [Documentazione Filament](../filament/README.md)
- [Struttura Moduli](../modules/structure.md)
- [Convenzioni di Codice](../coding/conventions.md)
- [Regole Traduzioni](../translations.md) 

## Collegamenti tra versioni di namespaces.md
* [namespaces.md](docs/conventions/namespaces.md)
* [namespaces.md](laravel/Modules/Xot/docs/conventions/namespaces.md)
* [namespaces.md](laravel/Modules/Cms/docs/conventions/namespaces.md)

