---
title: "resource table columns"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "resource table columns"
issues: []
discussions: []
---

# Colonne delle Resource — verifica 2026-09-10

## Evidenze e decisioni

TranslationFile usa Sushi: getRows produce id, key, name, path, content; nessuna data di creazione. Distinguere file omonimi mediante key e path.

## Contratto e verifica

Ogni getTableColumns restituisce array<string, Column>. Le colonne primarie supportano lettura e ricerca; metadati tecnici restano selezionabili. Nessun campo aggiunto senza evidenza nel modello e nello schema/produttore Sushi. QMD search tentato prima delle modifiche: indisponibile per incompatibilità ABI better-sqlite3 (127/147); consultati direttamente sorgenti e documentazione.
