---
title: "UI: scopo del modulo"
type: concept
status: active
updated: 2026-10-27
---

# UI: scopo del modulo

## Scopo

UI e' il vocabolario visivo condiviso: colonne, componenti di form, widget, layout di
tabella e blocchi che gli altri moduli usano come mattoni, senza riscriverli. Il README
lo descrive come "componenti UI riutilizzabili e design system ... senza logica di
dominio" (`laravel/Modules/UI/README.md`, frontespizio).

Evidenza dei mattoni: `app/Filament/Tables/Columns/` (colonne come `PersonColumn`,
`OrganizationColumn`), `app/Filament/Forms/Components/` (`EnumSelect`, `TreeField`,
`InlineDatePicker`), `app/Enums/TableLayoutEnum.php` e
`app/Filament/Actions/Table/TableLayoutToggleTableAction.php`.

Consumatori reali fuori da UI: Incentivi, IndennitaCondizioniLavoro, IndennitaResponsabilita,
Media, Performance, Progressioni, Ptv, User e Xot (conteggio con
`grep -rl 'Modules\\UI\\' laravel/Modules`).

## Come raggiungerlo meglio

1. **Dichiarare chi possiede i dati.** UI ha tre migrazioni
   (`database/migrations/2026_07_15_100000_create_categories_table.php`, `..._100001_create_collections_table.php`,
   `..._100002_create_field_options_table.php`) e modelli `Category`, `Collection`,
   `FieldOption` (`app/Models/Category.php:60`). Un "vocabolario visivo" che persiste
   dati contraddice il README. **Azione:** o spostare queste tabelle nel modulo che le
   usa, o scrivere l'eccezione nel README.

2. **Togliere la dipendenza da User.** `app/Actions/GetUserDataAction.php:10` importa
   `Modules\User\Models\Profile`. Un componente di UI non dovrebbe conoscere il profilo
   utente. **Azione:** passare i dati gia' pronti come parametro o DTO.

3. **Rendere esplicita la dipendenza da Cms.** `app/Actions/Block/ResolveLocalizedBlockDataAction.php:23`
   cita `Modules\Cms\Actions\...` come stringa, protetta da `class_exists` (riga 25).
   Il modulo Cms non esiste in `laravel/Modules`. Il codice funziona senza, ma la
   dipendenza e' invisibile. **Azione:** un contratto vuoto in UI, implementato da Cms
   quando esiste.

## Confini

Il modulo NON fa:

- logica di dominio (indennita', valutazione, progressioni, anagrafica): le colonne
  mostrano il dato, non decidono nulla;
- definizione di ruoli, permessi o tenant: quelli stanno in User e Tenant;
- gestione della lingua: i testi vengono da Lang.

Dipendenze verso Xot: UI estende `Modules\Xot\Providers\XotBaseServiceProvider`
(`app/Providers/UIServiceProvider.php:8`). Un centinaio di riferimenti a Xot sono
attesi, perche' Xot e' la base. Il vincolo "Xot non dipende da nessuno" resta
violato da Xot verso UI (vedi `Xot/docs/purpose.md`).
