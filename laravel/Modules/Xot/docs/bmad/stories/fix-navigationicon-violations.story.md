---
title: "Xot - fix-navigationicon-violations.story.md"
module: Xot
bmad: true
status: draft
updated: 2026-10-23
tags: [docs, xot, bmad]
qmd: "bmad story   fix navigationicon dichiarazioni vietate in resource che estendono xotbaseresource xot"
---

# BMAD Story: Fix navigationIcon dichiarazioni vietate in Resource che estendono XotBaseResource

## Epic
XOT-ARCH-002

## AC
- [ ] Rimuovere `protected static string|\BackedEnum|null $navigationIcon` da tutti i Resource che estendono XotBaseResource
- [ ] Le icone devono essere gestite esclusivamente tramite traduzioni (Lang module) o PanelModuleAdapter
- [ ] Nessuna regressione funzionale: le icone devono continuare a comparire correttamente nell'UI
- [ ] PHPStan max verde sui file modificati (se possibile nell'ambiente)

## Target Files
- Modules/IndennitaCondizioniLavoro/app/Filament/Resources/AssenzaResource.php:22
- Modules/IndennitaCondizioniLavoro/app/Filament/Resources/UploadResource.php:29
- Modules/IndennitaCondizioniLavoro/app/Filament/Resources/CondizioniLavoroResource.php:30
- Modules/Incentivi/app/Filament/Resources/PhaseResource.php:20
- Modules/Incentivi/app/Filament/Resources/DefaultActivityResource.php:20
- Modules/Ptv/app/Filament/Resources/BaseCategoriaProproResource.php:28
- Modules/Ptv/app/Filament/Resources/BaseMessageResource.php:19
- Modules/Ptv/app/Filament/Resources/BaseCriteriOptionResource.php:21

## Task
1. Per ogni file target, rimuovere la riga che dichiara $navigationIcon
2. Verificare che le icone siano comunque presenti via traduzioni (controllare lang files)
3. Eseguire phpstan modulare sui moduli interessati per confermare assenza di errori
4. Documentare la decisione in memoria/second-brain

## References
- [[sources/obs-2026-10-06-xotbaseresource-navigationicon-rule-swarm-docs-org]]
- Regola BMAD: chi estende XotBaseResource non deve avere navigationIcon (traduzioni gestiscono)

## Status
Todo