---
title: "Inventario documentazione dei moduli"
module: Xot
type: audit
<<<<<<< .merge_file_c3Fq81
qmd: "inventory inventario moduli"
=======
>>>>>>> .merge_file_3dljYk
---

# Inventario documentazione dei moduli

Audit filesystem eseguito il 2026-11-23. Questo documento è un indice di
evidenze, non una descrizione di funzionalità: le capacità restano quelle
indicate nei manuali owner e verificate dai riferimenti che contengono.

## Copertura rilevata

Tutti i 20 moduli presenti in `laravel/Modules` hanno:

- `docs/manuale-uso-attori.md`;
- `docs/manuals/manuale-utente.md`;
- `docs/manuals/manuale-utente.pdf`;
- almeno un'immagine in `docs/manuals/assets/`;
- `docs/adr/README.md` e almeno un ADR oltre al README;
- `docs/contracts/README.md`.

| Modulo | Manuale attori | Manuale MD/PDF | Screenshot manuale | ADR (escluso README) | Contract (escluso README e backup) |
| --- | --- | --- | --- | ---: | ---: |
| AI | sì | sì / sì | `front-office-home.png` | 1 | 1 |
| Activity | sì | sì / sì | `front-office-home.png` | 1 | 0 |
| Blog | sì | sì / sì | `front-office-home.png` | 1 | 0 |
| Cms | sì | sì / sì | `front-office-home.png` | 1 | 3 |
| Comment | sì | sì / sì | `front-office-home.png` | 4 | 0 |
| Event | sì | sì / sì | `front-office-home.png` | 1 | 0 |
| Fixcity | sì | sì / sì | `front-office-home.png` | 4 | 4 |
| Gdpr | sì | sì / sì | `front-office-home.png` | 3 | 1 |
| Geo | sì | sì / sì | `front-office-home.png` | 3 | 2 |
| Job | sì | sì / sì | `front-office-home.png` | 2 | 0 |
| Lang | sì | sì / sì | `front-office-home.png` | 2 | 0 |
| Media | sì | sì / sì | `front-office-home.png` | 2 | 1 |
| Mobile | sì | sì / sì | `front-office-home.png` | 2 | 0 |
| Notify | sì | sì / sì | `front-office-home.png` | 2 | 1 |
| Rating | sì | sì / sì | `front-office-home.png` | 2 | 0 |
| Seo | sì | sì / sì | `front-office-home.png` | 2 | 1 |
| Tenant | sì | sì / sì | `front-office-home.png` | 2 | 0 |
| UI | sì | sì / sì | `front-office-home.png` | 2 | 0 |
| User | sì | sì / sì | `auth-login.png` | 2 | 2 |
| Xot | sì | sì / sì | `front-office-home.png` | 24 | 2 |

## Evidenza degli screenshot

Gli asset sono file PNG presenti nel repository, non riferimenti mancanti. La
verifica con `sha256sum` ha però rilevato copie byte-identiche:

- Comment, Job, Rating e UI condividono lo stesso `front-office-home.png`;
- Fixcity, Gdpr e Geo condividono lo stesso file;
- Seo e Tenant condividono lo stesso file.

Questo dimostra riuso dell'asset, non che l'immagine sia falsa. Non è stata
trovata un'evidenza sufficiente per sostituire queste immagini con screenshot
specifici del modulo. Fixcity dispone inoltre di screenshot funzionali in
`docs/manuale/img/` e `docs/assets/`; User dispone di `auth-login.png` e di
immagini amministrative in `docs/img/`. Gli altri asset sotto `docs/` sono
stati inventariati ma non sono automaticamente screenshot del flusso utente.

## Mancanze e placeholder

Nessuna mancanza del contratto minimo è emersa per i 20 moduli. La scansione
dei quattro artefatti principali (`manuale-uso-attori.md`, manuale Markdown,
README di ADR e README di contracts) non ha trovato marker testuali
`placeholder`, `TODO`, `TBD`, `da completare` o `in costruzione`.

Restano da trattare come debito documentale, senza dichiararli mancanti:

- gli screenshot byte-identici elencati sopra, da rimpiazzare solo dopo una
  cattura reale del percorso owner;
- `Modules/Media/docs/contracts/path-generator-1.md.old`;
- `Modules/User/docs/contracts/hasteamsandusercontract.md.bak` e
  `teamcontract.md.bak`.

I file `.old` e `.bak` non sono stati modificati: sono artefatti storici e la
policy del progetto richiede una decisione esplicita prima di scegliere se
archiviarli o rimuoverli.

## Verifiche ripetibili

Comandi eseguiti dalla root del repository:

```bash
find laravel/Modules -mindepth 1 -maxdepth 1 -type d -printf '%f\n' | sort
find laravel/Modules/*/docs/manuals -maxdepth 1 -type f
find laravel/Modules/*/docs/adr -maxdepth 1 -type f
find laravel/Modules/*/docs/contracts -maxdepth 1 -type f
sha256sum laravel/Modules/*/docs/manuals/assets/*.png
```

Test owner da eseguire da `laravel/`:

```bash
vendor/bin/pest Modules/Xot/tests/Unit/Docs/ActorManualsTest.php \
  Modules/Xot/tests/Unit/Docs/PackagesHaveContractsAndAdrTest.php
```

Il test `ActorManualsTest` verifica anche la presenza del Markdown, del PDF e
di almeno un PNG per ogni modulo e tema mantenuto; il test ADR/contracts
verifica cartelle, README, struttura minima degli ADR e almeno un ADR
sostanziale per package.
