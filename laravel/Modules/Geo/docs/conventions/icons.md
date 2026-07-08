# Convenzioni per le Icone SVG

## Struttura Directory
```
ModuleNome/
└── Resources/
    └── svg/
        └── nome-icona.svg
```

## Naming Convention
1. File SVG:
   - Tutto minuscolo
   - Parole separate da trattini
   - Estensione .svg
   - Esempio: `user-profile.svg`

2. Riferimento nelle Traduzioni:
   - Format: `{module-name}-{svg-name}`
   - module-name: nome del modulo in minuscolo
   - svg-name: nome del file svg senza estensione
   - Esempio:
     ```
     Modulo: Incentivi
     File: Resources/svg/bonus-calc.svg
     Icon nel file traduzione: 'icon' => 'incentivi-bonus-calc'
     ```

## Struttura SVG
```xml
<?xml version="1.0" encoding="UTF-8"?>
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-6 h-6">
  <style>
    /* Animazioni */
    @keyframes nomeAnimazione {
      /* definizione keyframes */
    }
    /* Stili elementi */
    .elemento {
      fill: currentColor;
      transform-origin: center;
      opacity: 0.8;
    }
    /* Hover states */
    svg:hover .elemento {
      animation: nomeAnimazione 2s infinite;
    }
  </style>
  <!-- Elementi SVG -->
</svg>
```

## Regole Animazioni
1. Ogni SVG deve avere almeno un'animazione hover
2. Usare currentColor per il riempimento
3. Mantenere dimensioni 24x24 viewport
4. Ottimizzare per performance
5. Nominare classi in modo descrittivo

## Esempi Pratici

### Modulo Blog
```
Blog/Resources/svg/post-edit.svg
Riferimento: 'icon' => 'blog-post-edit'
```

### Modulo Users
```
Users/Resources/svg/profile-view.svg
Riferimento: 'icon' => 'users-profile-view'
```

### Modulo Shop
```
Shop/Resources/svg/cart-add.svg
Riferimento: 'icon' => 'shop-cart-add'
```

## Validazione
- Il nome del modulo deve essere in minuscolo
- Il nome dell'icona deve corrispondere al file SVG
- Il prefisso deve corrispondere al nome del modulo
- Non usare caratteri speciali o spazi

## Best Practices
1. Mantenere le animazioni leggere e fluide
2. Testare su diversi browser
3. Ottimizzare il codice SVG
4. Documentare animazioni complesse
5. Usare nomi descrittivi e coerenti
