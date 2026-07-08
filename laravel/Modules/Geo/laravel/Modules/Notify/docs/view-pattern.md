# Pattern view() — Variabile view-string + Parametri Espliciti

**Regola**: Per ogni chiamata a view() usare variabile tipizzata view-string e parametri espliciti.

## Pattern Preferito

```php
/** @phpstan-var view-string $viewName */
$viewName = 'pub_theme::components.layouts.guest';
$viewParams = [];

return view($viewName, $viewParams);
```

## Logica

1. **Type safety**: view-string è più preciso di (string) — PHPStan sa che è un path Blade valido
2. **Estensibilità**: Stessa struttura con 0 o N parametri — aggiungere dati = popolare $viewParams
3. **Consistenza**: Sempre view($viewName, $viewParams) — nessun default implicito
4. **Manutenibilità**: View name e params in un blocco, facile modificare

## Con parametri

```php
/** @phpstan-var view-string $viewName */
$viewName = 'fixcity::components.blocks.ticket-list';
$viewParams = [
    'tickets' => $this->tickets,
    'status' => $this->status,
];

return view($viewName, $viewParams);
```

## Da evitare

```php
// ❌ Stringa inline, parametri impliciti
return view('pub_theme::components.layouts.guest');

// ❌ Cast (string) perde semantica view-string
return view((string) $view);
```

## Collegamenti

- [phpstan_critical_rules](../.cursor/rules/phpstan_critical_rules.md)
- [AGENTS.md](../AGENTS.md)
