---
title: "Xot: tenancy Filament opzionale e cartella dei componenti per i pannelli trasversali"
type: story
status: review
priority: P1
created: 2026-11-05
updated: 2026-11-05
module: Xot
depends_on: []
related: [area-cliente-cantieri]
owned_scope: [app/Providers/Filament/XotBasePanelProvider.php, docs/panel-provider.md]
tags: [filament, tenancy, panel, customer]
qmd: "xot panel provider tenancy hasTenancy componentsDirectory pannello cliente customer"
---

# Xot: tenancy Filament opzionale e cartella dei componenti per i pannelli trasversali

## Story

Come **sviluppatore di un modulo Laraxot**
voglio **dichiarare un pannello trasversale (cliente, fornitore) con la tenancy di Filament e con i suoi componenti in una cartella propria**
così da **dare a un utente esterno solo i suoi dati senza ricopiare la configurazione del pannello né mescolare le sue resource con quelle amministrative**.

## Perché

- `XotBasePanelProvider` aveva `->tenant()` commentato e scopriva i componenti solo da `app/Filament/{Resources,Pages,...}`.
- Un pannello cliente ospitato da un modulo, con `$discoverModuleComponents = true`, si ritrovava tutte le resource amministrative del modulo; con `false` andava montato a mano componente per componente.
- Il primo caso reale è l'area cliente di Roosko (story `Modules/Roosko/docs/stories/01.area-cliente-cantieri.story.md`).

## Acceptance criteria

1. `protected bool $hasTenancy = false`: se `true` il pannello chiama `->tenant(XotData::make()->getTenantClass(), slugAttribute: 'slug')`.
2. `protected ?string $componentsDirectory = null`: se valorizzato (es. `'Customer'`) la scoperta usa `app/Filament/{dir}/{Resources,Pages,Widgets,Clusters}` e il namespace corrispondente.
3. I pannelli admin esistenti non cambiano comportamento: default invariati.
4. Documentato in `docs/panel-provider.md`.

## Dev notes

- Firma verificata nei sorgenti Filament 5: `Panel::tenant(?string $model, ?string $slugAttribute = null, ?string $ownershipRelationship = null)` (`packages/panels/src/Panel/Concerns/HasTenancy.php:149`).
- Lo scope globale registrato dalle resource vale solo quando il pannello corrente è quello che lo ha registrato (`Resources/Resource/Concerns/BelongsToTenant.php`, `registerTenancyModelGlobalScope`): gli admin degli stessi modelli non vengono filtrati.
- L'utente deve implementare `HasTenants`: `Modules\User\Models\BaseUser` lo fa già con `tenants()` su `XotData::getTenantClass()`.

## Dev agent record

- 2026-11-05 — Claude: implementati `$hasTenancy` e `$componentsDirectory`, rimossi i `->tenant()` commentati, aggiornata la documentazione. `php -l` ok; PHPStan e Pest da eseguire nell'installazione con vendor.
