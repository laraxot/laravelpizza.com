---
title: "Cosa resta da fare nel modulo Gdpr"
type: roadmap
module: Gdpr
updated: 2026-11-25
---

# Cosa resta da fare

Solo lavoro **tracciato da una story o da un debito verificato sul codice**: niente funzioni ipotetiche (backup, data export
automatico, PDF di report, "compliance score") che le vecchie roadmap elencavano senza codice ne' story. Lo stato delle
story e' quello del campo `status` nel loro frontmatter al 2026-11-25.

## Ordine proposto

| # | Intervento | Perche' prima | Fonte | Stato |
|---|---|---|---|---|
| 1 | Cancellazione con anonimizzazione, export dei dati, registro delle richieste (art. 12, 15, 17, 20) | e' il buco legale piu' grande: l'informativa non puo' promettere cio' che il modulo non fa | [DCP-140](stories/dcp-140-diritti-dellinteressato-procedura-e-strumenti.story.md) | `ready-for-dev`, serve la regola scritta sui contenuti pubblicati |
| 2 | Registrazione: verificare e chiudere i criteri di accettazione | il codice fa gia' quanto chiede la story (link all'informativa e ai termini con avviso di nuova scheda, `metadata.document_version`, seeder dei trattamenti, nessun marcatore di conflitto); manca la prova a database isolato (3 `Consent` con IP e versione) e una pagina Termini reale nel tenant | [DCP-135](stories/dcp-135-registrazione-documenti-accettati-termini-e-consensi-registrati.story.md) | `ready-for-dev`, da chiudere dopo la verifica |
| 3 | Cookie: guardia sui cookie realmente impostati rispetto all'inventario; audit visivo del banner | l'inventario e' dichiarato, la verifica che il server non ne imposti altri manca | [DCP-136](stories/dcp-136-cookie-inventario-informazione-e-guardia-sui-cookie-impostati.story.md), [DCP-136a](stories/dcp-136a-cookie-banner-stato-reale-audit-visivo.story.md) | `ready-for-dev` |
| 4 | Pagine legali del modulo (informativa, termini) come pagine e non come widget | oggi sono del progetto ospite e del modulo User | [12.1](stories/12.1.gdpr-owns-legal-pages.story.md) | `ready-for-dev` |
| 5 | Conservazione, log, minimizzazione tecnica | richiede la decisione del titolare sui termini | [DCP-141](stories/dcp-141-conservazione-log-e-minimizzazione-tecnica.story.md) | `needs-decision` |
| 6 | Registro dei trattamenti, DPIA, responsabili, violazioni | richiede dati e DPO | [DCP-142](stories/dcp-142-accountability-registro-trattamenti-dpia-dpa-e-violazioni.story.md) | `needs-data` |
| 7 | Sincronizzazione PHPStan completa | chiusura del debito di tipi | [gdpr-sync-phpstan-complete](stories/gdpr-sync-phpstan-complete.story.md) | `backlog` |

Gia' chiusi e da non riaprire: guardia del cablaggio del banner (DCP-445, `done`), terze parti prima del consenso (DCP-454,
`done`), traduzioni segnaposto, testi neutri della registrazione, audit `$model` delle tabelle.

## Debito tecnico senza story (da aprirne una se si lavora)

- Rendere `consents` non modificabile dal pannello (policy `update`/`delete` negate o resource in sola lettura) e aggiungere un
  test che lo provi ([admin-panel.md](admin-panel.md)).
- Unificare `ConsentResource`/`ProfileResource` duplicati; scegliere tra `RegisterWidget` e `GdprConsentForm`.
- Test per `DeleteAccountAction` e conversione di `RevokeGdprConsentsActionTest` in Pest con group `GDPR-REVOKE-INV-*`
  ([testing.md](testing.md)).
- Traduzioni mancanti: banner `fr`/`ru`, `register` completo in `es`/`fr`/`ru`, file di lingua `en`/`de` incompleti
  ([translations.md](translations.md)).
- Rendere le Action di consenso idempotenti nei confronti dei trattamenti mancanti (oggi `SaveRegistrationConsentsAction` li salta
  in silenzio) e togliere o collegare il listener `SaveGdprConsents` ([consents.md](consents.md)).
- Decidere il destino delle chiavi di `config/config.php` che nessun codice legge ([architecture.md](architecture.md)).

Il quadro dei difetti e' in [code-quality.md](code-quality.md).
