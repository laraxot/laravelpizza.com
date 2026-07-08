# Sistema di Icone

## Utilizzo
Il modulo UI utilizza un sistema di icone standardizzato basato su:
- Heroicons per icone di sistema
- Font Awesome per icone aggiuntive
- Custom SVG per icone specifiche

## Implementazione
1. **Heroicons**
   - Utilizzare i componenti Blade
   - Supporto per stili solid/outline
   - Dimensioni standard definite

2. **Font Awesome**
   - Classe CSS fa-*
   - Supporto per stili regular/solid/brands
   - Dimensioni configurabili

3. **Custom SVG**
   - Salvare in resources/icons/
   - Utilizzare il componente x-icon
   - Supporto per colori e dimensioni

## Best Practices
- Mantenere consistenza nell'uso delle icone
- Preferire Heroicons per UI di sistema
- Usare Font Awesome per icone social/brand
- Custom SVG solo per icone specifiche del progetto

## Esempi
```blade
<x-heroicon-o-user class="w-6 h-6" />
<i class="fa fa-user"></i>
<x-icon name="custom-logo" class="w-8 h-8" />
```