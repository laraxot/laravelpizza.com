# Sistema di Icone

## Utilizzo
Il modulo UI utilizza un sistema di icone standardizzato basato su:
- Heroicons per icone di sistema
- Font Awesome per icone aggiuntive
- Custom SVG per icone specifiche

## Implementazione
### Versione Dettagliata
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

### Versione Alternativa
(vedi marker git, integrare eventuali dettagli tecnici aggiuntivi dalle versioni branch)

## Action GetAllIconsAction
- Scopo: carica dinamicamente tutte le icone disponibili per un determinato contesto UI (es. form, table).
- Parametri:
  - `string $context`: contesto di utilizzo delle icone.
- Ritorna: `array<string, array<string, mixed>>` una mappa di set di icone che include prefisso, nome e lista di icone.
- Utilizzo: invocata da componenti Livewire o controller per popolare dropdown o palette di icone.

[Classe GetAllIconsAction](/laravel/Modules/UI/app/Actions/Icon/GetAllIconsAction.php)

## Best Practices
- Mantenere consistenza nell'uso delle icone
- Preferire Heroicons per UI di sistema
- Usare Font Awesome per icone social/brand
- Custom SVG solo per icone specifiche del progetto

## Decisione Architetturale
Questa documentazione integra entrambe le versioni emerse dal conflitto per fornire sia una panoramica rapida sia una guida dettagliata, facilitando la consultazione a diversi livelli di approfondimento.

## Backlink
- [Torna a docs/links.md](../../../../docs/links.md)
- [Vedi anche: UI/docs/components.md](./components.md)
- [Vedi anche: Xot/docs/README.md](../../Xot/docs/README.md)

## Esempi
```blade
<x-heroicon-o-user class="w-6 h-6" />
<i class="fa fa-user"></i>
<x-icon name="custom-logo" class="w-8 h-8" />
```

## Collegamenti
- [Componenti UI](laravel/Modules/UI/docs/components.md)
- [Documentazione Filament](laravel/Modules/UI/docs/filament/README.md)
- [Convenzioni di Naming](laravel/Modules/UI/docs/naming-conventions.md)
