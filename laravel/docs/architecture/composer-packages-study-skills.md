# Composer Packages Study Skills

## Skill 1: Full Inventory Refresh
1. `composer show --format=json > /tmp/...json`
2. Aggiorna inventory + package study.
3. Verifica count totale/diretti/transitivi.

## Skill 2: Module Dependency Drift Detection
1. Leggi `Modules/*/composer.json`.
2. Confronta con pacchetti installati.
3. Apri remediation task per ogni declared-not-installed.

## Skill 3: Chaos-Oriented Package Triage
1. Classifica pacchetto in family.
2. Mappa blast radius (frontoffice/admin/i18n/data).
3. Esegui fix minimo e aggiorna docs rules/memory/skills.
