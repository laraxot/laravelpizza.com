---
title: "Dashboard pannello Rating"
type: concept
module: Rating
status: active
qmd: "rating panel dashboard stats widget"
---

# Dashboard pannello Rating

## Perché

Il pannello Filament `rating/admin` aveva una `Dashboard` con view Blade vuota:
nessun widget, schermata bianca. Gap rispetto a Meetup/Geo (`getWidgets()` su
`XotBaseDashboard`).

## Cosa fa

`RatingPanelStatsOverviewWidget` mostra conteggi verificabili:

- criteri `ratings`
- collegamenti `rating_morph`

La dashboard non usa più la Blade vuota `rating::filament.pages.dashboard`.

## Cosa non fa

- Non sostituisce lo `StatsOverview` record-scoped (`HasRatingContract`).
- Non inventa metriche oltre i conteggi tabella.

## Collegamenti

- [Manuale utente](manuals/manuale-utente.md)
- `app/Filament/Pages/Dashboard.php`
- `app/Filament/Widgets/RatingPanelStatsOverviewWidget.php`
