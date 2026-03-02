# Panel Provider Patterns - XotBasePanelProvider e XotBaseMainPanelProvider

## Pattern Obbligatorio: Assegnazione Valore di Ritorno Actions

### ⚠️ Regola Critica

Quando si chiamano Actions che restituiscono un `Panel` (es. `ApplyMetatagToPanelAction::execute()`), **SEMPRE** assegnare il valore di ritorno alla variabile `$panel` per mantenere la continuità dell'interfaccia fluente.

### ❌ ERRATO - Pattern che Causa ParseError in PHPStan

```php
public function panel(Panel $panel): Panel
{
    $panel = $panel
        ->default($default)
        ->login()
        ->passwordReset();

    // ❌ ERRORE: Manca l'assegnazione del valore di ritorno
    app(ApplyMetatagToPanelAction::class)->execute(panel: $panel);

    // ❌ ERRORE: PHPStan non riesce a risolvere il tipo dopo execute()
    $panel->maxContentWidth('full')  // ParseError: unexpected token "->"
        ->topNavigation($this->topNavigation);
}
```

### ✅ CORRETTO - Pattern con Assegnazione

```php
public function panel(Panel $panel): Panel
{
    $panel = $panel
        ->default($default)
        ->login()
        ->passwordReset();

    // ✅ CORRETTO: Assegnazione del valore di ritorno
    $panel = app(ApplyMetatagToPanelAction::class)->execute(panel: $panel);

    // ✅ CORRETTO: La catena fluente continua correttamente
    $panel = $panel
        ->maxContentWidth('full')
        ->topNavigation($this->topNavigation)
        ->globalSearch($this->globalSearch);

    return $panel;
}
```

## Perché è Critico

1. **Fluent Interface Continuity**: Il pattern fluent di Filament richiede che ogni metodo della catena restituisca l'oggetto stesso (`$this`) o un nuovo oggetto. Senza l'assegnazione, la catena si interrompe.

2. **Type Safety PHPStan**: PHPStan durante il bootstrap analizza staticamente il codice. Se il valore di ritorno di `execute()` non viene assegnato, PHPStan non può determinare correttamente il tipo di `$panel` nella riga successiva, causando `ParseError: unexpected token "->"`.

3. **Runtime Correctness**: Anche se potrebbe funzionare a runtime (dato che `execute()` modifica `$panel` per riferimento con `Panel &$panel`), l'assegnazione garantisce che eventuali modifiche o nuove istanze restituite siano correttamente propagate.

## Actions Panel Comuni

### ApplyMetatagToPanelAction

```php
public function execute(Panel &$panel): Panel
{
    // Modifica il panel e lo restituisce
    return $panel
        ->colors($metatag->getColors())
        ->brandLogo($metatag->getBrandLogo())
        // ...
}
```

**Pattern obbligatorio:**
```php
$panel = app(ApplyMetatagToPanelAction::class)->execute(panel: $panel);
```

### ApplyTenancyToPanelAction

```php
public function execute(Panel &$panel): Panel
{
    return $panel
        ->tenant($tenant_class)
        ->tenantRegistration(RegisterTenant::class)
        // ...
}
```

**Pattern obbligatorio:**
```php
$panel = app(ApplyTenancyToPanelAction::class)->execute(panel: $panel);
```

## Checklist Panel Provider

Prima di considerare completo un Panel Provider, verificare:

- [ ] Tutte le chiamate ad Actions che restituiscono `Panel` assegnano il valore di ritorno a `$panel`
- [ ] La catena fluent continua correttamente dopo ogni chiamata ad Action
- [ ] PHPStan passa senza errori (livello 9+)
- [ ] Il metodo `panel()` restituisce sempre `$panel` alla fine
- [ ] Non ci sono interruzioni nella catena fluent senza motivo

## Riferimenti

- [Filament Class Extension Rules](./filament-class-extension-rules.md)
- [Panel Provider Rules](../../docs/filament/filament_panel_provider_rules.md)
- [XotBasePanelProvider Source](../app/Providers/Filament/XotBasePanelProvider.php)
- [XotBaseMainPanelProvider Source](../app/Providers/Filament/XotBaseMainPanelProvider.php)

---

