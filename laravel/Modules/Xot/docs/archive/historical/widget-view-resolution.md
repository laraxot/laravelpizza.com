# Widget View Resolution - Risoluzione Automatica vs Manuale

**Status**: ✅ RISOLTO
**Problema**: `XotBaseWidget` sovrascriveva view definite manualmente

---

## 🔍 Problema Identificato

### Sintomo
```
View not found: pub_theme::filament.widgets.timeclock, employee::filament.widgets.timeclock
```

### Causa Root

Il widget `TimeClockWidget` definiva manualmente la view:
```php
protected string $view = 'employee::filament.widgets.time-clock-widget';
```

Ma il costruttore di `XotBaseWidget` cercava automaticamente la view basandosi sul nome della classe:
- Classe: `Modules\Employee\Filament\Widgets\TimeClockWidget`
- View cercata: `employee::filament.widgets.timeclock` (tutto minuscolo, senza trattino)
- View esistente: `employee::filament.widgets.time-clock-widget` (con trattino)

Il sistema lanciava un'eccezione perché la view automatica non esisteva, anche se la view manuale era corretta.

---

## ✅ Soluzione Implementata

### Modifica a `XotBaseWidget`

Il costruttore ora controlla se la view è già definita manualmente prima di cercarla automaticamente:

```php
public function __construct()
{
    // Se la view è già definita manualmente e diversa dal default, non cercarla automaticamente
    $defaultView = 'xot::filament.widgets.base';
    if ($this->view !== $defaultView && view()->exists($this->view)) {
        // View già definita manualmente, usala
        return;
    }

    // Cerca automaticamente la view basandosi sul nome della classe
    try {
        $view = app(GetViewByClassAction::class)->execute(static::class);
        if (view()->exists($view)) {
            $this->view = $view;
        }
    } catch (\Exception $e) {
        // Se la view automatica non esiste, mantieni quella definita manualmente o il default
        // Non lanciare eccezione se la view è già definita manualmente
        if ($this->view === $defaultView) {
            throw $e;
        }
    }
}
```

### Comportamento

1. **View definita manualmente**: Se il widget definisce una view diversa dal default e la view esiste, viene usata quella (non viene cercata automaticamente)
2. **View automatica**: Se la view non è definita manualmente, viene cercata automaticamente basandosi sul nome della classe
3. **Fallback**: Se la view automatica non esiste ma la view manuale è definita, non viene lanciata eccezione

---

## 📋 Pattern di Utilizzo

### Pattern 1: View Manuale (Raccomandato per nomi complessi)

```php
class TimeClockWidget extends XotBaseWidget
{
    protected string $view = 'employee::filament.widgets.time-clock-widget';

    public function getFormSchema(): array
    {
        return [];
    }
}
```

**Quando usare**:
- Nome widget complesso con trattini
- View con nome diverso dal pattern automatico
- Controllo esplicito sulla view utilizzata

### Pattern 2: View Automatica (Default)

```php
class SimpleWidget extends XotBaseWidget
{
    // Non definire $view - viene cercata automaticamente
    // Pattern: {modulo}::filament.widgets.{nome-classe-slug}
    // Esempio: employee::filament.widgets.simple-widget

    public function getFormSchema(): array
    {
        return [];
    }
}
```

**Quando usare**:
- Nome widget semplice che segue il pattern automatico
- Convenzione naming standard

---

## 🔗 Pattern di Naming View Automatico

Il sistema `GetViewByClassAction` converte il nome della classe in view seguendo questo pattern:

```
Modules\{Module}\Filament\Widgets\{WidgetName}
↓
{module-lowercase}::filament.widgets.{widget-name-slug}
```

**Esempi**:
- `Modules\Employee\Filament\Widgets\TimeClockWidget` → `employee::filament.widgets.timeclock`
- `Modules\Employee\Filament\Widgets\SimpleWidget` → `employee::filament.widgets.simple-widget`
- `Modules\UI\Filament\Widgets\GroupWidget` → `ui::filament.widgets.group`

**Nota**: Il sistema cerca anche `pub_theme::` come fallback prima del modulo.

---

## 🧪 Test Case

### Test 1: View Manuale Esistente
```php
class MyWidget extends XotBaseWidget
{
    protected string $view = 'employee::filament.widgets.my-custom-view';
    // ✅ Usa la view manuale, non cerca automaticamente
}
```

### Test 2: View Automatica
```php
class MyWidget extends XotBaseWidget
{
    // ✅ Cerca automaticamente: employee::filament.widgets.my-widget
}
```

### Test 3: View Manuale Non Esistente
```php
class MyWidget extends XotBaseWidget
{
    protected string $view = 'employee::filament.widgets.non-existent';
    // ⚠️ View non esiste, ma non viene cercata automaticamente
    // Il sistema userà questa view e fallirà al rendering
}
```

---

## 📝 Best Practices

1. **Definire sempre la view manualmente** se il nome widget è complesso o contiene trattini
2. **Verificare che la view esista** prima di definirla manualmente
3. **Usare naming consistente**: se possibile, seguire il pattern automatico
4. **Documentare view custom** nel widget se il nome non è ovvio

---

## 🔗 Collegamenti

- [XotBaseWidget.php](../../app/Filament/Widgets/XotBaseWidget.php) - Implementazione
- [GetViewByClassAction.php](../../app/Actions/View/GetViewByClassAction.php) - Logica risoluzione automatica
- [Widgets Initialization](./widgets-initialization.md) - Documentazione inizializzazione widget

---

*Documento creato il 2025-01-27 durante la risoluzione del bug "View not found: timeclock"*
