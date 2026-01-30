# Model Context Protocol (MCP)

## Panoramica
Il Model Context Protocol (MCP) è un sistema progettato per mantenere la coerenza e il contesto dei modelli nel progetto, garantendo che le relazioni, le estensioni e le implementazioni seguano le regole architetturali stabilite.

## Struttura

### File di Contesto
```
/mcp/
├── contexts/
│   ├── models.md        # Contesto dei modelli
│   ├── relationships.md # Relazioni tra modelli
│   ├── extensions.md    # Estensioni e trait
│   └── interfaces.md    # Interfacce e contratti
├── validators/
│   ├── parental.md      # Validazione pattern Parental
│   ├── traits.md        # Validazione trait
│   └── contracts.md     # Validazione contratti
└── index.md            # Indice dei contesti
```

## Contesti Modello

### Pattern Parental
```yaml
context: "User Model Context"
models:
  - name: "User"
    type: "base"
    traits:
      - "HasFactory"
      - "Notifiable"
      - "HasParent"
    relationships:
      - "doctor"
      - "patient"
    table: "users"
    type_column: "type"

  - name: "Doctor"
    extends: "User"
    type: "child"
    traits:
      - "HasParent"
    context: "medical"
    validations:
      - "medical_license"
      - "specialization"
```

### Relazioni
```yaml
relationships:
  - name: "doctor_patient"
    type: "belongsToMany"
    models:
      - "Doctor"
      - "Patient"
    pivot: "doctor_patient"
    context: "medical"
```

## Validazione Contesto

### Comando Artisan
```php
// app/Console/Commands/McpValidateCommand.php
class McpValidateCommand extends Command
{
    protected $signature = 'mcp:validate {model? : Nome del modello da validare}';
    
    public function handle()
    {
        $this->validateModelContext();
        $this->validateRelationships();
        $this->validateExtensions();
    }
}
```

## Integrazione IDE

### VSCode
```json
{
    "mcp.context": {
        "models": {
            "User": {
                "extends": "Authenticatable",
                "traits": ["HasParent"],
                "context": "authentication"
            },
            "Doctor": {
                "extends": "User",
                "traits": ["HasParent"],
                "context": "medical"
            }
        }
    }
}
```

### PHPStorm
```xml
<inspection_tool class="McpContextInspection" enabled="true" level="ERROR">
    <option name="contexts">
        <value>
            <option name="User">authentication</option>
            <option name="Doctor">medical</option>
        </value>
    </option>
</inspection_tool>
```

## Automazione

### GitHub Actions
```yaml
name: MCP Context Validation
on: [push, pull_request]
jobs:
  mcp:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v2
      - name: Validate Model Context
        run: php artisan mcp:validate
```

### CI/CD
```yaml
stages:
  - context_validation
  - test
  - deploy

context_validation:
  stage: context_validation
  script:
    - php artisan mcp:validate
```

## Metriche

### Performance
- Tempo di validazione: <1s
- Falsi positivi: <1%
- Copertura contesti: 100%

### Monitoraggio
- Violazioni contesto
- Trend errori
- Tempo di risoluzione

## Collegamenti
- [Contesti Modello](./contexts/models.md)
- [Pattern Architetturali](./patterns.md)
- [Best Practices](./best-practices.md)

## Note
- Mantenere i contesti aggiornati
- Documentare le eccezioni
- Validare i nuovi modelli
- Testare i contesti 
