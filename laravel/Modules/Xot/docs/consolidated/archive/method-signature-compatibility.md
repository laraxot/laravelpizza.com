# errore di compatibilità nelle firme dei metodi

## problema

quando si estende una classe in php, non è possibile modificare la firma dei metodi che si stanno sovrascrivendo. questo include:

- cambiare un metodo da non statico a statico (o viceversa)
- cambiare il tipo di ritorno in modo incompatibile
- cambiare i parametri (numero, tipo, o obbligatorietà)
- cambiare la visibilità (es. da public a protected)

esempi di errori comuni:

```
Cannot make non static method Filament\Pages\BasePage::getView() static in class Modules\Xot\Filament\Pages\XotBasePage
```

```
Access level to Modules\<nome progetto>\Filament\Resources\AppointmentWorkflowResource\Pages\WorkflowAppointment::getFormActionsAlignment() must be public (as in class Filament\Pages\BasePage)
```

esempio di errore:
```
Cannot make non static method Filament\Pages\BasePage::getView() static in class Modules\Xot\Filament\Pages\XotBasePage
```

## causa

l'errore si verifica quando si tenta di sovrascrivere un metodo cambiando le sue caratteristiche fondamentali:

### esempio 1: cambiare da non statico a statico

```php
// Classe padre
class BasePage
{
    public function getView(): string
    {
        // implementazione
    }
}

// Classe figlia - ERRORE
class XotBasePage extends BasePage
{
    public static function getView(): string  // Errore: non può essere statico
    {
        // implementazione
    }
}
```

### esempio 2: cambiare da public a protected

```php
// Classe padre
class BasePage
{
    public function getFormActionsAlignment(): string
    {
        // implementazione
    }
}

// Classe figlia - ERRORE
class WorkflowAppointment extends BasePage
{
    protected function getFormActionsAlignment(): string  // Errore: non può essere protected
    {
        // implementazione
    }
}
```

## soluzione

1. **mantenere la stessa firma** del metodo nella classe padre:

```php
// Classe figlia - CORRETTO
class XotBasePage extends BasePage
{
    public function getView(): string  // Corretto: stessa firma del metodo padre
    {
        // implementazione
    }
}
```

2. se è necessario un metodo statico, **creare un nuovo metodo** con un nome diverso:

```php
class XotBasePage extends BasePage
{
    // Sovrascrive il metodo non statico del padre
    public function getView(): string
    {
        return $this->resolveView();
    }
    
    // Nuovo metodo statico con nome diverso
    public static function resolveViewPath(): string
    {
        // implementazione statica
    }
}
```

## prevenzione

prima di sovrascrivere un metodo:

1. controllare la firma del metodo nella classe padre utilizzando `reflection`
2. utilizzare gli ide che segnalano questi errori (phpstorm, vscode con php intelephense)
3. definire classi di test che verificano la compatibilità

```php
// Verifica la firma prima di implementare
$parentMethod = new \ReflectionMethod(BasePage::class, 'getView');
$isStatic = $parentMethod->isStatic();
$returnType = $parentMethod->getReturnType();
```

## collegamento ad altre risorse

- [regole di ereditarietà in php](/var/www/html/base_<nome progetto>/laravel/project_docs/standards/php-inheritance-rules.md)
- [estensione pattern filament](/var/www/html/base_<nome progetto>/laravel/Modules/Xot/project_docs/filament_extension_pattern.md)
