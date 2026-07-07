# Filament widgets: cartella dominio + classe ruolo

## Religione

**Il nome della classe NON ripete il dominio.** Il dominio è la **cartella** sotto `Filament/Widgets/`.

| Vietato | Corretto |
|---------|----------|
| `Widgets\TicketViewWidget` | `Widgets\Ticket\ViewWidget` |
| `Widgets\CreateTicketWizardWidget` | `Widgets\Ticket\CreateWizardWidget` (target) |
| `Widgets\Auth\LoginWidget` (User) | ✅ già conforme |

## Perché (filosofia / zen)

- **Politica modulare:** un widget = un ruolo su un aggregato (`Ticket`, `Auth`, `Rating`).
- **DRY nei namespace:** `ViewWidget` è leggibile nel contesto `Ticket\`; niente prefissi `Ticket*` su ogni file.
- **KISS in CMS JSON:** `Modules\Fixcity\Filament\Widgets\Ticket\ViewWidget` — percorso = documentazione vivente.
- **Allineamento risorse:** `GetViewByClassAction` risolve `fixcity::filament.widgets.ticket.view` da `Ticket\ViewWidget`.

## Struttura file

```
Modules/<Modulo>/app/Filament/Widgets/
├── Ticket/
│   └── ViewWidget.php          → namespace ...\Widgets\Ticket
├── Auth/
│   └── LoginWidget.php         → namespace ...\Widgets\Auth
```

```
Modules/<Modulo>/resources/views/filament/widgets/
├── ticket/
│   └── view.blade.php
```

## CMS content block

```json
{
  "type": "widget",
  "data": {
    "view": "ui::components.blocks.widget.simple",
    "widget": "Modules\\Fixcity\\Filament\\Widgets\\Ticket\\ViewWidget"
  }
}
```

## Esempio Fixcity FO

- Classe: `Modules\Fixcity\Filament\Widgets\Ticket\ViewWidget`
- Base: `XotBaseInfolistWidget`
- Schema: `TicketInfolist::getInfolistSchema()`
- Pagina: `tickets.view.json`

## Legacy (migrazione graduale)

Widget ancora in root `Widgets/` con prefisso entità (`CreateTicketWizardWidget`, `TicketsMapWidget`) vanno spostati in sottocartella dominio quando toccati — non lasciare doppioni.

## Collegamenti

- [ticket-fo-detail-filament-widget-infolist](../../../../../../docs/wiki/decisions/ticket-fo-detail-filament-widget-infolist.md)
- [tickets-view-cms-folio-page](../../../Fixcity/docs/wiki/concepts/tickets-view-cms-folio-page.md) (modulo Fixcity)
- [GetViewByClassAction](../../app/Actions/View/GetViewByClassAction.php)
- Regola Cursor: `.cursor/rules/filament-widget-domain-folder.mdc`
