# Volt Auto-Injection vs Mount() Method - Best Practices

## ❌ Anti-Pattern: Parameter Assignment in Mount()

**SBAGLIATO - Mai fare questo:**
```php
new class extends Component {
    public string $container0;
    public string $slug0;
    
    public function mount(string $container0, string $slug0): void
    {
        // ❌ MAI fare questo - Volt auto-inietta i parametri route!
        $this->container0 = $container0;
        $this->slug0 = $slug0;
    }
};
```

## ✅ Correct Pattern: Volt Auto-Injection

**CORRETTO - Lasciare Volt fare l'auto-iniezione:**
```php
new class extends Component {
    // Volt auto-inietta automaticamente questi parametri dalla route
    public string $container0;
    public string $slug0;
    
    public function mount(): void
    {
        // ✅ OK - Usare mount() solo per logica aggiuntiva che richiede i parametri
        // $this->container0 e $this->slug0 sono già popolati da Volt
        
        $this->pageSlug = $this->container0 . '.view';
        $this->data = [
            'container0' => $this->container0,
            'slug0' => $this->slug0,
        ];
    }
};
```

## Separazione di Responsabilità

### ✅ CORRETTO:
- **Volt auto-injection**: Assegna parametri route alle proprietà
- **Mount() method**: Solo logica aggiuntiva che usa i parametri

### ❌ SBAGLIATO:
- **Mount() method**: Assegna parametri route alle proprietà (ridondante)

## Perché Questo Approccio?

### 1. **Separation of Concerns**
- Volt gestisce l'iniezione parametri
- Mount() gestisce solo logica aggiuntiva

### 2. **Evita Ridondanza**
- Non duplicare assegnazioni già fatte da Volt

### 3. **Chiarezza Intenzionale**
- Ogni componente ha un ruolo specifico
- Facile capire cosa fa cosa

### 4. **Best Practice Livewire Volt**
- Segue le convenzioni Volt
- Più prevedibile e mantenibile

## Esempi di Logica Valid in Mount()

### ✅ OK - Usare parametri per costruire altri valori:
```php
public function mount(): void
{
    // Usare i parametri per costruire altri valori
    $this->pageSlug = $this->container0 . '.view';
    $this->templatePath = 'templates.' . $this->container0 . '.detail';
}
```

### ✅ OK - Validazioni aggiuntive:
```php
public function mount(): void
{
    if (empty($this->slug0)) {
        abort(404);
    }
}
```

### ❌ NO - Assegnare parametri route:
```php
public function mount(string $container0, string $slug0): void
{
    // MAI - Volt già li assegna
    $this->container0 = $container0;
    $this->slug0 = $slug0;
}
```

## Quando Usare Mount() vs Auto-Injection

### Usa Auto-Injection (Volt) per:
- Parametri route (es. `{container0}`, `{slug0}`)
- Valori che vengono direttamente dalle route

### Usa Mount() per:
- Logica che richiede i parametri auto-iniettati
- Validazioni aggiuntive
- Costruzione di valori derivati
- Inizializzazione di variabili complesse

## Regole d'Oro

1. **Non assegnare parametri route manualmente** - Volt lo fa automaticamente
2. **Usare mount() per logica aggiuntiva** - non per assegnazioni parametri
3. **I parametri route sono disponibili immediatamente** - non serve aspettare mount()
4. **La logica di business va nei componenti inclusi** - non nelle pagine Folio
5. **Seguire la separazione: routing → view → business logic**

Questo approccio assicura che il codice sia:
- **Pulito**: Nessuna ridondanza
- **Prevedibile**: Comportamento consistente
- **Mantenibile**: Ruoli chiari per ogni componente
- **Testabile**: Facile testare logica separata