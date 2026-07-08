# Icon Rendering Policy

## Regola

Quando dobbiamo mostrare icone o SVG nel progetto, la priorita' e':

1. Filament way con `<x-filament::icon>`
2. Filament way con `<x-filament::icon-button>` se il nodo e' un bottone icona
3. `@svg(...)` solo quando serve rendere un'icona custom registrata o un set SVG non coperto dal componente Filament

## Motivazione

- piu' coerenza visiva e semantica;
- meno frammentazione tra helper, componenti dinamici e Blade grezzo;
- maggiore uniformita' con il resto dell'admin e dei temi;
- markup piu' leggibile e piu' facile da manutenere.

## Esempi

### Corretto

```blade
<x-filament::icon icon="heroicon-o-users" class="w-5 h-5" />
```

```blade
<x-filament::icon-button icon="heroicon-o-bell" />
```

```blade
@svg('predict-bottlecap', 'w-5 h-5')
```

### Da evitare se non necessario

```blade
<x-dynamic-component :component="$item['icon']" />
```

## Regola pratica

- se l'icona e' gia' nel registry Filament/Blade Icons del progetto, usare prima il componente Filament;
- se l'icona e' custom SVG del modulo o del tema, usare `@svg(...)`;
- non introdurre nuovi pattern se uno di questi due basta.
