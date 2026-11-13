---
title: "FO-AUDIT - Alias Seo tenant Fixcity: bersagli canonici inesistenti"
type: story
status: done
updated: 2026-11-13
tags: [seo, alias, redirect, 301, front-office, audit, bmad, fixcity]
qmd: "seo path_aliases RedirectToCanonicalPath alias 301 contatti contacts cookie cookies chi-siamo domande-frequenti cookie-policy tenant config seo.php"
related:
  - ../wiki/concepts/sitemap-coverage-contract.md
  - ../../Fixcity/docs/front-office-production-audit.md
---

# FO-AUDIT - Alias Seo tenant Fixcity: bersagli canonici inesistenti

Issue: https://github.com/laraxot/base_fixcity_fila5/issues (audit front-office produzione)
Discussion: https://github.com/laraxot/base_fixcity_fila5/discussions

## Problema misurato

`SeoConfigData::$path_aliases` contiene i default del modulo (pensati per siti «comune»)
che non corrispondono alle pagine CMS di Fixcity. `RedirectToCanonicalPath` (middleware
globale) risponde 301 verso bersagli che non esistono:

| Alias | Redirect osservato | Destino reale | Esito |
|---|---|---|---|
| `/it/contatti` | 301 → `/it/contacts` | nessuna pagina `contacts` | **404** |
| `/it/cookie` | 301 → `/it/cookies` | pagina canonica è `cookie-policy` | **404** |
| `/it/about` | 301 → `/it/chi-siamo` | nessuna pagina `chi-siamo` | **404** |
| `/it/faqs` | 301 → `/it/faq` → 301 → `/it/domande-frequenti` | canonica `domande-frequenti` | 200 ma catena a 2 hop |
| `/it/home` | 301 → `/it` | home | 200 OK |

Errore duplice: un alias che punta a un 404 è peggio di nessun alias (soft-404 travestito
da redirect). E `faqs`→`faq` crea una catena perché `faq` a sua volta è un alias verso
`domande-frequenti`.

## Decisione

Il meccanismo previsto per override per-tenant è `config/{tenant}/seo.php`
(`MakesFromTenantConfig` → `GetTenantFilePathAction` → `config/local/fixcity/seo.php`,
`config/eu/fixcity/seo.php` per produzione). Si crea il file invece di toccare i
default del Data, che restano validi per gli altri tenant.

Alias Fixcity (solo bersagli che esistono davvero nel CMS):

- `cookie`, `cookies` → `cookie-policy`
- `faq`, `faqs` → `domande-frequenti`
- `home` → `` (home)
- `contatti`, `contacts`, `about`, `chi-siamo` → rimossi: nessuna pagina canonica
  esiste; l'URL risponde 404 diretto invece di redirect verso 404.

Nota: se in futuro si crea una pagina contatti/chi-siamo, si riaggiungono gli alias
 dalla SettingPage di Seo (Filament, solo super-admin).

## File

- `config/local/fixcity/seo.php` (nuovo)
- `config/eu/fixcity` è symlink a `../local/fixcity/`: lo stesso file copre anche il
  tenant di produzione fixcity.eu, nessun file separato necessario.

## Verifica

- `SeoConfigData::make()->pathAliases()` restituisce la mappa attesa.
- curl: `/it/contatti`, `/it/about`, `/it/cookie`, `/it/faqs`, `/it/home` → 301 a
  destinazioni 200; `/it/contacts`, `/it/chi-siamo` → 404 diretto.

## Non verificato / follow-up

- La pagina «contatti» non esiste nel CMS: il footer mostra i recapiti inline.
  Se serve una pagina contatti pubblica, è un lavoro di contenuto a parte.
