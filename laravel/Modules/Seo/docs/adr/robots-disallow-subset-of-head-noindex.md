---
title: "ADR — robots.txt chiude solo aree già noindex nel <head>: due elenchi, uno contenuto nell'altro"
type: decision
status: accepted
module: Seo
tags: [adr, seo, robots, noindex, cms]
created: 2026-11-24
updated: 2026-11-24
related:
  - ../../app/Actions/Robots/BuildRobotsTxtAction.php
  - ../../../Cms/app/Actions/Head/ResolveRobotsPolicyAction.php
  - ../../tests/Unit/Actions/Robots/RobotsSegmentsMatchHeadPolicyTest.php
---

# ADR: `robots.txt` chiude solo aree che il `<head>` dichiara già `noindex`

## Contesto

- Un `Disallow` in `robots.txt` impedisce al crawler di **leggere** la pagina, quindi anche il suo `meta robots noindex`.
  Una pagina chiusa ma linkata da fuori finisce nell'indice come URL «senza descrizione».
- Il `Disallow` non vale per le copie con la lingua scritta diversamente e non toglie dall'indice una pagina già nota:
  l'esclusione vera è il `noindex` del `<head>`, deciso da Cms `ResolveRobotsPolicyAction` (`HIDDEN_SEGMENTS`).
- `BuildRobotsTxtAction::PRIVATE_SEGMENTS` (`auth`, `area-personale`, `dashboard`, `notifications`, `profile`) chiude in
  ogni lingua le aree riservate che non hanno nulla da indicizzare, più `/admin` e `/*/admin` dei pannelli Filament.

Domanda: unificare i due elenchi o tenerli separati?

## Decisione

- Due elenchi separati, con un vincolo: ogni segmento chiuso in `robots.txt` deve essere anche `noindex` nel `<head>`
  (`PRIVATE_SEGMENTS` ⊆ `HIDDEN_SEGMENTS`). Il `<head>` può nasconderne di più (`coming-soon`, `preview-content`) senza
  chiuderli ai crawler, così il `noindex` resta leggibile.
- `robots.txt` è dinamico (`BuildRobotsTxtAction`, rotta `seo.robots`) e chiude con `Sitemap: <url assoluto>`; il comando
  `seo:robots` (`WriteRobotsTxtCommand`, lanciato a ogni deploy) scrive lo stesso contenuto in `public/robots.txt`: con
  un server web che cerca prima il file statico e ricade su Laravel con `error_page 404`, la rotta arriverebbe con stato
  404 e Google ignorerebbe il file, sitemap compresa.

## Alternative scartate

- Un elenco unico usato da entrambi: le pagine `noindex` diventerebbero anche `Disallow`, e il crawler non leggerebbe più
  il `noindex` che le toglie dall'indice.
- Solo `noindex`, niente `Disallow`: i crawler sprecano scansioni su aree riservate che rispondono redirect al login.
- `robots.txt` statico scritto a mano nel `public/` del progetto: perde le lingue configurate e la sitemap col dominio
  giusto (il file in `public/` è generato dal comando, non scritto a mano).

## Conseguenze

- Pro: le aree riservate non si scansionano e non finiscono nell'indice come URL vuote.
- Contro: due costanti in due moduli (Seo e Cms) da tenere allineate a mano; il test lo impone in una direzione sola.

## Verifica

- `cd laravel && vendor/bin/pest Modules/Seo/tests/Unit/Actions/Robots/RobotsSegmentsMatchHeadPolicyTest.php`: fallisce se
  un segmento di `PRIVATE_SEGMENTS` non è in `ResolveRobotsPolicyAction::HIDDEN_SEGMENTS`.
- `vendor/bin/pest Modules/Seo/tests/Unit/Actions/Robots/BuildRobotsTxtActionTest.php Modules/Seo/tests/Feature/WriteRobotsTxtCommandTest.php`:
  ogni area chiusa in ogni lingua, sitemap assoluta, file scritto uguale alla rotta.
