---
title: "Pannello di amministrazione (Filament)"
type: reference
module: Gdpr
updated: 2026-11-25
---

# Pannello di amministrazione

Pannello `gdpr::admin` (`Providers/Filament/AdminPanelProvider`, estende `XotBasePanelProvider`). Sviluppato su **Filament v5**
(Livewire v4, Schemas) con le basi `XotBase*`: nessuna classe estende direttamente `Filament\*`
(regola e tabella di corrispondenza in `Modules/Xot/docs/xotbase-extension-rules.md`). Un widget Filament si include nelle viste
con `@livewire(\Modules\...\Widget::class)`, non con il tag `<livewire:modulo::widget>`.

## Resource

Ogni resource ha `Pages/{List,Create,Edit}`, `Schemas/{Form,Infolist}` e `Tables/*Table` e restituisce da `getTableColumns()` un
`array<string, Column>`.

| Resource | Modello | Colonne principali | Note |
|---|---|---|---|
| `ConsentResource` | `Consent` | id, `treatment.name`, `subject_id`, date (nascoste di default) | `Consent` ha `treatment()`, `subject_id`, `accepted_at`, `revoked_at`; non esistono `subject()` ne' `is_accepted`. |
| `TreatmentResource` | `Treatment` | name, active, required, `documentVersion`, `documentUrl` (link), weight | Form: toggle `active`/`required`, nome (max 191), descrizione, versione, URL, peso. |
| `EventResource` | `Event` | id, date | `ip` e `payload` sono cifrati nel modello: non esporli senza passare dall'accessor. |
| `ProfileResource` | `Profile` | come `BaseProfile` | Il modello `Profile` e' del modulo User (connessione `gdpr` qui). |

Le colonne si aggiungono solo con evidenza nel modello e nello schema; UUID: nessuna formattazione numerica.

## Pagine

- `SettingPage`: `consent_lifetime` (minimo 180), `info_banner`, `policy_path` ([cookie-banner.md](cookie-banner.md)).
- `Dashboard` (`XotBaseDashboard`), `EditProfile` (`XotBaseEditProfile`, non scoperta automaticamente).
- Cluster `Profile` (`XotBaseCluster`): contiene copie di `ConsentResource` e `ProfileResource` (vedi debito sotto).

## Permessi

`GdprBasePolicy::before()` autorizza tutto al super admin del progetto (`XotData::super_admin` = email) e ai ruoli `super-admin`
e `gdpr::admin` (ADR `module-admin-role-policy-bypass` del modulo Xot). Le altre ability delle policy
(`ConsentPolicy`, `EventPolicy`, `ProfilePolicy`, `TreatmentPolicy`) chiamano `hasPermissionToOrCreate('<risorsa>.<ability>')`,
es. `consent.viewAny`, `consent.update`, `consent.delete`: chi le ha puo' creare, modificare e cancellare righe di `consents`
dal pannello. L'append-only e' una regola delle Action, non del database ([consents.md](consents.md)).

## Debito noto

- `ConsentResource` e `ProfileResource` esistono due volte: in `app/Filament/Resources/` e in
  `app/Filament/Clusters/Profile/Resources/` (pagine, schemi, tabelle). Il `ConsentForm` differisce (il cluster usa `Section`,
  quello standalone `Select::relationship`). Da unificare tenendo la versione standalone; `ProfileResource` dovrebbe vivere in `User`.
