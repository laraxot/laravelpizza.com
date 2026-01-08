# XotBaseComponent

XotBaseComponent è la classe base astratta per tutti i componenti view nel modulo Xot. Fornisce funzionalità comuni e struttura di base per i componenti personalizzati.

## Caratteristiche Principali

- Gestione automatica del rendering delle view
- Sistema di cache per le view risolte
- Gestione degli asset
- Supporto per attributi HTML dinamici

## Proprietà

- `$attrs`: Array per gli attributi HTML del componente
- `$assets`: Array statico per la gestione degli asset del componente
- `$viewCache`: Cache per le view risolte

## Metodi Principali

### `assets(): array`
Restituisce l'array degli asset registrati per il componente.

### `getView(): string`
Risolve e restituisce il percorso della view del componente. Il metodo:
- Utilizza la cache per ottimizzare le prestazioni
- Costruisce il percorso della view basandosi sul namespace del componente
- Verifica l'esistenza della view
- Lancia un'eccezione se la view non esiste

### `render(): Renderable`
Renderizza il componente utilizzando la view risolta.

## Convenzioni di Naming

Le view dei componenti seguono questa convenzione:
- Percorso: `{module_name_lowercase}::components.{component_name_snake_case}`
- Esempio: Per un componente `UserProfile` nel modulo `Auth`, il percorso sarà `auth::components.user_profile`

## Best Practices

1. **Estensione**:
   ```php
   class MyComponent extends XotBaseComponent
   {
       // Implementazione specifica
   }
   ```

2. **View Corrispondenti**:
   - Creare le view nella directory corretta del modulo
   - Utilizzare lo stesso nome del componente in snake_case

3. **Asset Management**:
   - Registrare gli asset necessari nell'array statico `$assets`
   - Utilizzare percorsi relativi al modulo

## Integrazione

### Registrazione nel Service Provider
```php
public function boot()
{
    Blade::component('my-component', MyComponent::class);
}
```

### Utilizzo nel Template
```blade
<x-my-component :attribute="value" />
```

## Note per lo Sviluppo

- Estendere questa classe per tutti i nuovi componenti view nel modulo
- Mantenere la cache delle view per ottimizzare le prestazioni
- Seguire le convenzioni di naming per una migliore manutenibilità
- Documentare eventuali attributi personalizzati

## Link Rapidi

- [Implementazione](../../app/View/Components/XotBaseComponent.php)
- [Test](../../tests/Unit/View/Components/XotBaseComponentTest.php)
- [Esempi](../../examples/view-components.md)

## Dipendenze

- Illuminate\View\Component
- Illuminate\Contracts\Support\Renderable
- Illuminate\Support\Str 