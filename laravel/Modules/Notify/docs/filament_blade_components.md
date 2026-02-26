# Standard <nome progetto>: Componenti Blade Filament

In <nome progetto>, la **prima scelta per i componenti Blade** sono SEMPRE i [componenti nativi Filament](https://filamentphp.com/project_docs/3.x/support/blade-components/overview).

## Vantaggi rispetto a componenti custom
- **Coerenza UI/UX**: look & feel uniforme con tutto l’ecosistema Filament
- **Accessibilità**: supporto nativo a dark mode, focus, aria-label
- **Manutenibilità**: aggiornamenti e fix gestiti dal core Filament
- **Documentazione ampia**: esempi e best practice direttamente dal sito Filament
- **Riuso**: pattern condivisi tra moduli e temi

## Pattern di utilizzo
```blade
<x-filament::button size="sm" href="{{ route('register.type', ['type'=>$type]) }}" tag="a">
    {{ ucfirst($type) }}
</x-filament::button>
```

## Regola di progetto
- **Mai** usare componenti Blade custom se esiste un equivalente Filament
- Documentare sempre l’uso di componenti Filament nei README e nelle guide
- Collegare questa pagina da ogni README e guida tecnica del modulo

## Collegamenti
- [Documentazione Filament Blade Components](https://filamentphp.com/project_docs/3.x/support/blade-components/overview)
- [README Notify](README.md)
- [queueable-action.md](queueable-action.md)
