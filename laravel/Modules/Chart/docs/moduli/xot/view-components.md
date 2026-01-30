# Componenti View in Xot

## Struttura Base

I componenti View in Xot seguono una struttura specifica che si integra con il sistema di moduli di Laravel. Ecco le regole principali:

### Directory Structure
```
Modules/
  ├── ModuleName/
  │   ├── app/
  │   │   └── View/
  │   │       └── Components/
  │   │           ├── ComponentName.php
  │   │           └── _components.json
  │   └── resources/
  │       └── views/
  │           └── components/
  │               └── component-name.blade.php
```

### Namespace
- I componenti devono essere nel namespace `Modules\{ModuleName}\View\Components`
- Devono estendere `Modules\Xot\View\Components\XotBaseComponent`

### Naming Conventions
- Nome della classe: PascalCase (es. `UserProfile`)
- Nome del file: PascalCase.php (es. `UserProfile.php`)
- Nome della view: kebab-case.blade.php (es. `user-profile.blade.php`)

## XotBaseComponent

La classe base `XotBaseComponent` fornisce funzionalità essenziali:

### Caratteristiche Principali
- Gestione automatica delle view
- Sistema di cache per le view
- Gestione degli assets
- Supporto per attributi dinamici

### Metodi Chiave
```php
// Ottiene il percorso della view associata
public function getView(): string

// Gestisce il rendering del componente
public function render(): Renderable

// Gestisce gli assets del componente
public static function assets(): array
```

## Implementazione

### 1. Creare il Componente
```php
namespace Modules\Patient\View\Components;

use Modules\Xot\View\Components\XotBaseComponent;

class PatientCard extends XotBaseComponent
{
    public function __construct(
        public string $name,
        public string $surname,
        public ?string $photo = null
    ) {
    }
}
```

### 2. Creare la View
```php
// resources/views/components/patient-card.blade.php
<div class="patient-card">
    <img src="{{ $photo ?? 'default.jpg' }}" alt="{{ $name }} {{ $surname }}">
    <h3>{{ $name }} {{ $surname }}</h3>
</div>
```

### 3. Utilizzare il Componente
```php
<x-patient::patient-card 
    name="Mario"
    surname="Rossi"
    photo="path/to/photo.jpg"
/>
```

## Best Practices

1. **Organizzazione**
   - Mantenere i componenti in `app/View/Components`
   - Mantenere le view in `resources/views/components`
   - Utilizzare sottocartelle per componenti correlati

2. **Naming**
   - Usare nomi descrittivi e specifici
   - Seguire le convenzioni di naming di Laravel
   - Prefissare i componenti con il nome del modulo

3. **Performance**
   - Utilizzare la cache delle view quando possibile
   - Ottimizzare il caricamento degli assets
   - Minimizzare le dipendenze

4. **Manutenibilità**
   - Documentare i parametri del componente
   - Utilizzare type hints
   - Seguire i principi SOLID

## Problemi Comuni

1. **View Non Trovata**
   - Verificare il percorso della view
   - Controllare il nome del file
   - Assicurarsi che la view sia nel namespace corretto

2. **Assets Non Caricati**
   - Registrare gli assets nel metodo `assets()`
   - Verificare i percorsi degli assets
   - Controllare le dipendenze

3. **Attributi Non Passati**
   - Definire gli attributi nel costruttore
   - Utilizzare type hints appropriati
   - Fornire valori di default quando necessario

## Note Importanti

- I componenti View sono una parte fondamentale dell'architettura Xot
- Seguire sempre le convenzioni di naming e struttura
- Utilizzare la classe base `XotBaseComponent` per tutte le funzionalità comuni
- Mantenere la documentazione aggiornata
- Testare i componenti in diversi contesti 