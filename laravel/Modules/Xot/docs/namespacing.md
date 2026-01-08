# Convenzioni Namespace in il progetto

## Struttura Namespace Standard

Nel progetto il progetto, tutti i namespace dei moduli devono seguire questa convenzione:

```
Modules\NomeModulo\{Categoria}
```

Dove:
- `NomeModulo` è il nome del modulo (es. Patient, Dental, Tenant)
- `{Categoria}` è la tipologia di classe (es. Models, Controllers, Actions)

## Directory vs Namespace

Importante: Sebbene le classi possano essere fisicamente situate nella directory `app/`, il namespace NON deve includere il segmento "app".

### Esempi Corretti:
- Classe: `/var/www/html/<nome progetto>/laravel/Modules/Patient/app/Models/Patient.php`
- Namespace: `Modules\Patient\Models`

### Esempi Errati:
- ❌ `Modules\Patient\app\Models` (non usare "app" nel namespace)
- ❌ `Modules\Patient\App\Models` (non usare "App" con la maiuscola)

## Importazione di Classi

Quando si fa riferimento a classi di altri moduli, usare sempre il namespace completo:

```php
use Modules\Patient\Models\Patient;
use Modules\Dental\Models\Treatment;
```

## Traits e Interfaces

I Traits seguono la stessa convenzione:
- Directory: `/var/www/html/<nome progetto>/laravel/Modules/Tenant/app/Traits/`
- Namespace: `Modules\Tenant\Traits\`

## Convenzioni PSR-12

Seguire sempre le convenzioni PSR-12, incluso l'uso di:
- `declare(strict_types=1);` all'inizio di ogni file PHP
- Namespace al singolare (es. `Models` non `Model`)
- Nomi delle classi al singolare (es. `Patient` non `Patients`)

## Autoload nei file composer.json

Nei file composer.json dei moduli, la configurazione di autoload dovrebbe essere:

```json
"autoload": {
    "psr-4": {
        "Modules\\NomeModulo\\": "app/"
    }
}
```

Questo indica che il namespace `Modules\NomeModulo\` corrisponde alla directory `app/`, ma nei namespace delle classi non includiamo "app".

## Risoluzione dei Problemi di Namespace

In caso di errori "Class not found", verificare:
1. Che il namespace della classe sia corretto (senza "app")
2. Che la classe sia nella giusta posizione nella struttura delle directory
3. Che i riferimenti alla classe usino il namespace completo corretto

Ultima modifica: 31/03/2025
