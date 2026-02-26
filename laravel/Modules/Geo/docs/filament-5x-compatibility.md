# Filament 5.x compatibility - modulo Geo

**Versione Filament:** v5.2.1

## Stato compatibilità

Il modulo Geo è **compatibile** con Filament 5.x. Nessun breaking change funzionale rispetto a Filament 4.x.

## Note specifiche modulo

- Le widget Google Maps sono state disabilitate durante la migrazione Filament 4.x per incompatibilità con pacchetti di terze parti. La riattivazione va valutata con Filament 5.x
- `LocationResource` e componenti mappa necessitano verifica con i pacchetti aggiornati

## Regole architetturali

Tutte le classi Filament **devono** estendere le classi `XotBase*`:

| Tipo | Classe base |
|------|------------|
| Resource | `XotBaseResource` |
| ListRecords | `XotBaseListRecords` |
| CreateRecord | `XotBaseCreateRecord` |
| EditRecord | `XotBaseEditRecord` |
| ViewRecord | `XotBaseViewRecord` |
| Widget | `XotBaseWidget` |
## Inclusione nei Blade View

Per includere un widget Filament (che è un componente Livewire) all'interno di una vista Blade o di una pagina Folio, **non** usare la sintassi del tag `<livewire:module::widget-name />` a meno che non sia esplicitamente registrato. 

La sintassi corretta e sicura per Filament 5.x è l'uso diretto della classe:

```blade
@livewire(\Modules\User\Filament\Widgets\Auth\LoginWidget::class)
```

Questo evita errori di `ComponentNotFoundException` nelle architetture modulari.

| Section | `XotBaseSection` |

## Checklist modulo

- [x] Nessun import diretto da `Filament\*` base classes
- [ ] Verificare compatibilità pacchetti Google Maps con Filament 5.x
- [ ] Riattivare widget mappa se pacchetti compatibili
- [ ] Verificare Livewire 4.x dopo upgrade
- [ ] Verificare Tailwind CSS 4.1+ dopo upgrade

## Riferimenti

- [Guida upgrade Filament 5 (Xot)](../../Xot/docs/filament-5-upgrade-guide.md)
- [Regole Laraxot per Filament 5 (Xot)](../../Xot/docs/filament-5-laraxot-rules.md)
- [Documentazione ufficiale](https://filamentphp.com/docs/5.x/upgrade-guide)
