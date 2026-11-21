---
title: "User — confine Table, i18n e riuso Filament"
type: story
status: review
epic: "USER-MODULE-EXCELLENCE"
module: User
created: 2026-09-29
updated: 2026-09-29
---

# Story — User: Table boundary, traduzioni e riuso

## Obiettivo

Rendere User coerente con Laraxot: le pagine `List*` orchestrano solo pagina/widget,
le `*Table` possiedono la configurazione tabellare, le traduzioni non espongono
placeholder tecnici e le estensioni concrete riusano basi stabili.

## Acceptance criteria

- [x] `UsersTable` estende `BaseUsersTable`, che estende `XotBaseResourceTable`.
- [x] `ListProfiles`, `ListUsers`, `ListRoles`, `ListPermissions`, `ListTeams` e
  `ListTenants` non dichiarano hook `getTable*`.
- [x] Tutti i `List*` delle Resource nei moduli non dichiarano più hook `getTable*`;
  la configurazione è nella Table class o nel default della base.
- [x] `BaseProfilesTable` incorpora identità, contatto, stato, media e audit con
  colonne secondarie collassabili.
- [x] Le stringhe user-facing che contenevano `.navigation` sono state sostituite;
  le chiavi tecniche `user::auth.navigation.*` sono state preservate.
- [x] Le modifiche mantengono tooltip/icone per azioni icon-only e non introducono
  label hardcoded nella UI.
- [x] Documentazione BMAD/wiki User e riferimenti ai temi aggiornati.
- [x] Ripristinati i contratti applicativi eliminati dal working tree (`Team`,
  `TeamInvitation`, `Membership` e le Resource Passport legacy ancora referenziate
  dalle pagine); senza questi file PHPStan non poteva risolvere il modulo.
- [x] Corretto il residuo `BaseAuthWidget.php` che conteneva Markdown nel file PHP
  e impediva il bootstrap Laravel.
- [x] Spostati anche i due casi Socialite annidati nel cluster (`SocialProvider` e
  `SsoProvider`), sfuggiti al primo audit limitato alle Resource top-level.

## Decisione architetturale

Il metodo `XotBaseResource::table()` risolve la `*Table` e invoca `HasXotTable`;
gli hook sulla pagina List sono quindi duplicati o inerti. I metodi duplicati sono
stati rimossi dalla pagina; i casi senza equivalente sono stati trasferiti alla
Table class oppure eliminati se erano default/no-op. Questo evita divergenze silenziose
tra la UI dichiarata e quella realmente eseguita.

## Verifica

Audit AST/rg: nessun metodo `getTable*` residuo nelle pagine `List*.php` dei moduli
(restano solo fixture di test e commenti). PHPStan User e PHPStan globale `Modules/`:
**verdi, 0 errori**.
Pest User è stato avviato fuori dall'host vietato ma non ha prodotto output dopo
oltre due minuti; è stato interrotto per evitare un processo appeso e resta il gate
da ripetere in un ambiente test stabile.

## Lezione second brain

La scansione deve includere anche `Filament/Clusters/**/Resources/**`, non soltanto
`Filament/Resources/**`. Inoltre una pagina List senza errore di sintassi può essere
in conflitto con un metodo `final` della base: il bootstrap Laravel è un gate
necessario prima di fidarsi di PHPStan.

`qmd update` è stato eseguito; l'installazione locale indicizza però una collection
di un checkout diverso (`base_fixcity_fila5`), quindi la memoria è stata lasciata
anche nel modulo e deve essere riallineata alla collection PTVX. `graphify` non è
installato nel PATH di questo ambiente: l'aggiornamento del grafo resta da eseguire
quando il binario sarà disponibile.

## Audit successivo — 2026-09-29

È stata rieseguita la verifica sull'intero albero `laravel/Modules/*/app/Filament/Resources/**/Pages/List*.php`:

- 154 pagine List analizzate;
- 0 pagine con `getTable*` dichiarati;
- 0 interventi applicativi necessari.

L'unica directory senza `Tables/` è `Ptv/ReportResource`, ma la sua pagina è un
alias legacy che estende `StabiDirigenteResource\Pages\ListStabiDirigentes`; la
tabella effettiva è quindi già `StabiDirigenteResource/Tables/StabiDirigentesTable`.
Creare una seconda Table class violerebbe DRY e potrebbe disallineare l'alias.
Sono stati inclusi anche i percorsi annidati già presenti nei moduli; il controllo
ha distinto i metodi reali dai soli commenti e dalle fixture di test.
