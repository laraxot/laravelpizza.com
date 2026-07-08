---
title: "Data/DTO omonimi tra moduli"
type: redundancy
owner: Modules/Xot
severity: high
created: 2026-05-22
issues:
  - "https://github.com/laraxot/base_fixcity_fila5/issues/89"
  - "https://github.com/laraxot/base_fixcity_fila5/issues/90"
related:
  - ../concepts/redundancy-catalog.md
---

# Classi Data con stesso nome, namespace diverso

## Problema

Stesso **basename** in moduli diversi — non è errore PHP (namespace distinti) ma **ambiguità dominio** e rischio drift.

| Classe | Path moduli |
|--------|-------------|
| **ArticleData** | `Xot/app/Datas/ArticleData.php`, `Blog/app/Datas/ArticleData.php`, `Blog/app/DataObjects/ArticleData.php` |
| **MetatagData** | `Xot/app/Datas/MetatagData.php`, `Seo/app/Data/MetatagData.php` |
| **RouteData** | `Xot/app/Datas/RouteData.php`, `Geo/app/Datas/RouteData.php` |
| **NotificationData** | `Xot/app/Datas/NotificationData.php`, `Notify/app/Datas/NotificationData.php` |

## Politica DRY

| DTO | Owner suggerito |
|-----|-----------------|
| ArticleData | **Blog** (unificare `Datas` + `DataObjects`) |
| MetatagData | **Seo** |
| RouteData | **Geo** o Xot se generico routing |
| NotificationData | **Notify** |

Xot mantiene solo DTO **veramente trasversali**; gli altri moduli **importano** dal owner o usano contract/interface.

## Tracker

[#90](https://github.com/laraxot/base_fixcity_fila5/issues/90).
