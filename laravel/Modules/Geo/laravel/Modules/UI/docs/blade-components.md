# Componenti Blade

## Registrazione Automatica

I componenti Blade vengono registrati automaticamente da `XotBaseServiceProvider`. Non è necessario registrare manualmente i componenti nei Service Provider dei moduli.

## Struttura dei Componenti

I componenti Blade devono essere posizionati nella seguente struttura:

```
Modules/
  └── ModuleName/
      └── resources/
          └── views/
              └── components/
                  └── ComponentName.blade.php
```

## Namespace dei Componenti

Il namespace dei componenti viene gestito automaticamente seguendo questa convenzione:

```php
Modules\ModuleName\View\Components
```

## Esempio di Componente

```php
<?php

namespace Modules\ModuleName\View\Components;

use Illuminate\View\Component;

class ExampleComponent extends Component
{
    public function __construct()
    {
        // Inizializzazione del componente
    }

    public function render()
    {
        return view('module-name::components.example-component');
    }
}
```

## Traduzioni

Le traduzioni per i componenti devono essere definite nei file di traduzione del modulo:

```php
// resources/lang/it/module-name.php
return [
    'components' => [
        'example-component' => [
            'title' => 'Titolo',
            'description' => 'Descrizione'
        ]
    ]
];
```

## Best Practices

1. ✅ Usa sempre il namespace corretto
2. ✅ Posiziona i componenti nella cartella corretta
3. ✅ Definisci le traduzioni nei file di traduzione
4. ✅ Non registrare manualmente i componenti
5. ✅ Segui le convenzioni di naming

## Errori Comuni

1. ❌ Registrazione manuale dei componenti
   ```php
   // ERRATO
   Blade::componentNamespace('Modules\\ModuleName\\View\\Components', 'module-name');
   ```

2. ❌ Posizionamento errato dei componenti
   ```
   // ERRATO
   Modules/ModuleName/View/Components/ComponentName.blade.php
   ```

3. ❌ Namespace errato
   ```php
   // ERRATO
   namespace App\View\Components;
   ```

## Note Importanti

1. La registrazione dei componenti è gestita automaticamente
2. Seguire la struttura delle cartelle corretta
3. Usare i namespace appropriati
4. Definire le traduzioni nei file di traduzione
5. Non duplicare la logica di registrazione
