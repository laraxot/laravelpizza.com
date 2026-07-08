---
title: "Code redundancy audit — User"
type: source
status: draft
tags: [code-audit, redundancy, dry, second-brain, module]
created: "2026-05-26"
updated: "2026-05-26"
owner: "User"
issue: "https://github.com/provtv/base_ptv_fila5_mono/issues/150"
---

# Code redundancy audit — User

## Scopo

Ridurre rumore, duplicazione e ambiguita' nel codice di questo module, senza perdere conoscenza storica.

## Metriche

| Voce | Valore |
|---|---:|
| File PHP analizzati | 918 |
| Rischio ridondanza | high |
| Basename duplicati locali | 12 |
| Hash normalizzati duplicati cross-owner | 19 |
| Class/trait/interface name ripetuti nel monorepo | 12 |
| File grandi >=350 righe | 6 |
| File PHP con marker Git | 0 |

## Evidenze

### Basename duplicati locali
- `CreateUserAction.php` x3
- `Login.php` x3
- `LanguageEnum.php` x2
- `TeamInvitation.php` x2
- `Logout.php` x2
- `LogoutWidget.php` x2
- `LoginWidget.php` x2
- `OauthAccessTokenResource.php` x2
- `SsoProviderResource.php` x2
- `OauthClientResource.php` x2
- `OauthAuthCodeResource.php` x2
- `.php-cs-fixer.dist.php` x2

### File grandi
- `resources/views/pages/profile/edit.blade.php`: 714 righe
- `app/Models/Traits/HasTeams.php`: 570 righe
- `app/Models/BaseUser.php`: 520 righe
- `resources/views/livewire/toast.blade.php`: 440 righe
- `app/Filament/Pages/SocialiteProviderSettingsPage.php`: 425 righe
- `database/seeders/UserMassSeeder.php`: 352 righe

### Nomi classe ripetuti
- `RouteServiceProvider`
- `EventServiceProvider`
- `LogoutListener`
- `LoginListener`
- `extends`
- `BaseModel`
- `Dashboard`
- `AdminPanelProvider`
- `from`
- `name`
- `if`
- `Profile`

## Consigli

- Unificare codice uguale in classi base Xot, trait o action riusabili.
- Prima di estrarre astrazioni, verificare se la duplicazione rappresenta differenze di dominio reali.
- Spostare decisioni stabili nel wiki owner; lasciare nei docs solo puntatori DRY.

## Dubbi e perplessita

- Alcuni duplicati possono essere intenzionali per isolamento modulare.
- I file grandi non sono automaticamente sbagliati: sono priorita' di review, non condanne.
- Evitare refactor globali senza test o issue dedicata.

## Zen, politica, religione, filosofia

- Zen: togliere il superfluo prima di inventare architettura.
- Politica: ogni modulo deve custodire il proprio confine; la base comune non deve diventare dominio nascosto.
- Religione: DRY e KISS sono dogmi utili solo se servono lo scopo.
- Filosofia: il codice e' memoria operativa; la documentazione spiega perche' esiste.

## Second Brain 2026 — note operative

- Markdown locale + Git restano la base piu' portabile: gli agenti leggono/scrivono file senza database esterni.
- AGENTS.md/SKILL.md devono restare manifest leggeri, con YAML/front matter e routing on-demand.
- I descrittori architetturali navigabili riducono i passi di localizzazione: ogni owner dovrebbe avere mappa scopo -> file chiave.
- AI utile = recupero mirato, non pre-caricamento: report atomici, QMD, issue e log.

## Prossimo passo

Aprire issue mirata per i primi 3 file grandi o per il duplicato cross-owner piu' evidente, poi validare con PHPStan/PHPMD/PHPInsights se si modifica codice.
