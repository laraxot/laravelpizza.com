---
title: "log"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "log"
issues: []
discussions: []
status: draft
---

## [2026-06-05] docs | HackerNoon harness — tips 001-022 in wiki locale

- Stub/checklist: second-brain → canon Xot, ai-harness, [hackernoon map](../../../../../docs/wiki/concepts/hackernoon-ai-coding-tips-fixcity-map.md), [llm-wiki.txt](../../../../../bashscripts/tools/prompts/llm-wiki.txt)
- GitHub: [#272](https://github.com/laraxot/base_fixcity_fila5/issues/272) / [D#273](https://github.com/laraxot/base_fixcity_fila5/discussions/273)

---
module: "Gdpr"
---

# Gdpr - Wiki Activity Log

## [2026-05-11] Wiki Structure Created

- Created wiki structure: rules/, skills/, commands/, memories/, concepts/
- Created INDEX.md for each section
- Created module index.md
- Ready for on-demand loading via QMD

## [2026-10-14] docs | verifica degli ingressi contro il codice

- Riscritti `README.md` (identita', contenuto reale, limiti, quick start) e `00-INDEX.md` (indice canonico: ruolo delle directory, stato verificato delle promesse). `index.md` resta l'elenco per argomento; `00-index.md` e `INDEX.md` sono copie, segnate `stale`/`stub`; `readme.md` segnato `stale`.
- Segnati `stale` con prova nel testo: `gdpr-module-overview.md`, `gdpr-pdf-reports.md`, `task-export-dati-utente.md`, `gdpr-compliance-roadmap.md`, `user-registration-integration.md`.
- Fatti verificati: `Treatment` 0 righe e `Consent` 0 righe nel DB di sviluppo (tinker, sola lettura); `routes/web.php` e `routes/api.php` vuoti; nessun dispatch di `UserRegistered`; `cookie_banner_on` falso per il tenant Fixcity; `config/config.php` contiene dati di un altro progetto (assicurazioni) e chiavi che nessun codice legge.
- Pest su DB usa-e-getta (`bashscripts/tools/pest-scratch-db.sh`, con `DB_DATABASE_LIMESURVEY=` perche' lo script va in errore se la variabile manca): 68 passati e 186 falliti, i Feature con `A facade root has not been set`. Non e' una prova di regressione.
- Non toccati su richiesta del coordinatore: file con `cookie` o `privacy` nel nome o nel percorso, cartella `stories/`. Nessuna story di questa sessione e' stata scritta in `stories/`.
- Link rotti negli ingressi (criterio audit: file indice a profondita' 0 e 1): 22 prima, vedi la nota di memoria `bashscripts/ai/wiki/memories/docs-gdpr-rating-comment-blog-ai-studio.md` per il dopo.

## [2026-10-14] DCP-153 | cookiebar integrata nel modulo

- Una sola cookiebar nel modulo (vista `cookie-consent`, middleware `InjectCookieBanner`, inventario `GetCookieInventoryAction`, testi in it, en, de, es). Riferimento: `docs/cookie-banner.md`. Story: `stories/dcp-153-cookiebar-integrata-nel-modulo-gdpr.story.md`.
- Verifica: 17 test nel browser, 59 test Pest (modulo Fixcity, perche' i test del modulo Gdpr non avviano l'applicazione: 186 su 254 falliscono con «A facade root has not been set»), axe senza violazioni.
- Trappole: namespace delle traduzioni sovrascritto dal pacchetto, `lang/vendor/cookie-consent` che sovrascrive il modulo, configurazione sotto `gdpr.config.*`, flag del tenant valutato all'avvio, push del middleware perso.
- Segnati `stale`: `cookiebar-integration.md`, `second-brain/cookiebar-bootstrap-italia.md`, `cookie_consent.md`, `cookie-consent.md`, `cookie-consent-1.md`, `packages/cookie-consent.md`, `roadmap/cookie-consent.md`, `development/roadmap/cookie-consent.md`, `consent/cookie-consent.md`, `root-md-files/cookie-consent.md`, `_integration/cookie-consent.md`. Nessun file cancellato.

## [2026-10-14] dcp-178 | registrazione del cittadino a norma
- Verifica end-to-end: prova del consenso mai salvata (`treatments` vuota, 0 righe in `consents`), password senza regole, messaggio generico sulle caselle, nessun link a informativa e condizioni nel modulo, email marcata verificata senza verifica.
- Corretti: `RegisterWidget` (`rules()`/`messages()`, `Password::defaults()`), `SaveGdprConsentsAction` (trattamenti creati se mancano, versione del documento in `metadata`), vista e lang `register.php` (link in 4 lingue), refuso «(facoltativo]».
- Test `Modules/Fixcity/tests/Feature/Auth/RegistrationConsentTest.php` (rosso prima, verde dopo). Gate `go-live-gate.py` con `LEG-04`.
- Da decidere con il DPO: base giuridica, marketing, verifica email, regola sui ticket alla cancellazione, versione dei testi, conservazione di IP e user agent, eta' minima. Story: `stories/dcp-178-registrazione-e-disiscrizione-a-norma.story.md`.
## [2026-10-14] docs | confine registrazione e ciclo account

- Aggiunta la pagina canonica `concepts/registration-account-lifecycle.md`.
- Collegata a User, Sixteen e alle story BMAD 5.3–5.6.
- Nessun documento storico cancellato o rinominato.

