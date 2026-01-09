# Sistema di Blocchi

## Introduzione
Il sistema di blocchi di il progetto è un'architettura modulare che permette di costruire pagine e componenti attraverso blocchi riutilizzabili. Ogni blocco è un componente Filament che genera una struttura JSON standardizzata e viene renderizzato attraverso un componente Blade dedicato.

## Architettura

### Struttura Base
```
laravel/Modules/Cms/
├── app/
│   └── Filament/
│       └── Blocks/           # Definizioni Filament dei blocchi
├── Resources/
│   └── views/
│       └── components/
│           └── blocks/       # Componenti Blade per il rendering
└── docs/
    └── blocks/              # Documentazione dei blocchi
```

### Tipi di Blocchi

1. **[NavigationBlock](../laravel/Modules/Cms/docs/blocks/navigation-block.md)**
   - Gestione menu di navigazione
   - Header e footer
   - Menu multilivello
   - Supporto mobile

2. **ContentBlock**
   - Testo formattato
   - Immagini e media
   - Layout flessibile

3. **FormBlock**
   - Form interattivi
   - Validazione
   - Gestione submit

## Implementazione

### 1. Definizione Blocco
```php
use Filament\Forms\Components\Builder\Block;

class CustomBlock extends Block
{
    public static function getBlockSchema(): array
    {
        return [
            // Schema del blocco
        ];
    }
}
```

### 2. Struttura JSON
```json
{
    "type": "block_type",
    "data": {
        // Dati specifici del blocco
    }
}
```

### 3. Rendering
```php
// In PageContent
public function render()
{
    return view('cms::components.blocks.' . $this->type, [
        'block' => $this->data
    ]);
}
```

## Best Practices

### 1. Struttura
- Un blocco per funzionalità
- Schema JSON consistente
- Documentazione completa
- Test automatizzati

### 2. Performance
- Ottimizzazione cache
- Lazy loading
- Minimizzazione DOM
- Asset management

### 3. Manutenibilità
- Codice pulito
- Dipendenze chiare
- Versionamento
- Backup automatici

## Links
- [Documentazione Blocchi](../laravel/Modules/Cms/docs/blocks/)
- [Gestione Contenuti](content-management.md)
- [Best Practices UI](ui-best-practices.md)

## Note
Questa documentazione è parte del sistema di documentazione di il progetto. Per dettagli specifici sui singoli blocchi, consultare la documentazione dei rispettivi moduli.
# Sistema di Blocchi

## Introduzione
Il sistema di blocchi di il progetto è un'architettura modulare che permette di costruire pagine e componenti attraverso blocchi riutilizzabili. Ogni blocco è un componente Filament che genera una struttura JSON standardizzata e viene renderizzato attraverso un componente Blade dedicato.

## Architettura

### Struttura Base
```
laravel/Modules/Cms/
├── app/
│   └── Filament/
│       └── Blocks/           # Definizioni Filament dei blocchi
├── Resources/
│   └── views/
│       └── components/
│           └── blocks/       # Componenti Blade per il rendering
└── docs/
    └── blocks/              # Documentazione dei blocchi
```

### Tipi di Blocchi

1. **[NavigationBlock](../laravel/Modules/Cms/project_docs/blocks/navigation-block.md)**
1. **[NavigationBlock](../laravel/Modules/Cms/project_docs/blocks/navigation-block.md)**
1. **[NavigationBlock](../laravel/Modules/Cms/project_docs/blocks/navigation-block.md)**
   - Gestione menu di navigazione
   - Header e footer
   - Menu multilivello
   - Supporto mobile

2. **ContentBlock**
   - Testo formattato
   - Immagini e media
   - Layout flessibile

3. **FormBlock**
   - Form interattivi
   - Validazione
   - Gestione submit

## Implementazione

### 1. Definizione Blocco
```php
use Filament\Forms\Components\Builder\Block;

class CustomBlock extends Block
{
    public static function getBlockSchema(): array
    {
        return [
            // Schema del blocco
        ];
    }
}
```

### 2. Struttura JSON
```json
{
    "type": "block_type",
    "data": {
        // Dati specifici del blocco
    }
}
```

### 3. Rendering
```php
// In PageContent
public function render()
{
    return view('cms::components.blocks.' . $this->type, [
        'block' => $this->data
    ]);
}
```

## Best Practices

### 1. Struttura
- Un blocco per funzionalità
- Schema JSON consistente
- Documentazione completa
- Test automatizzati

### 2. Performance
- Ottimizzazione cache
- Lazy loading
- Minimizzazione DOM
- Asset management

### 3. Manutenibilità
- Codice pulito
- Dipendenze chiare
- Versionamento
- Backup automatici

## Links
- [Documentazione Blocchi](../laravel/Modules/Cms/project_docs/blocks/)
- [Documentazione Blocchi](../laravel/Modules/Cms/project_docs/blocks/)
- [Documentazione Blocchi](../laravel/Modules/Cms/project_docs/blocks/)
- [Gestione Contenuti](content-management.md)
- [Best Practices UI](ui-best-practices.md)

## Note
Questa documentazione è parte del sistema di documentazione di il progetto. Per dettagli specifici sui singoli blocchi, consultare la documentazione dei rispettivi moduli.
