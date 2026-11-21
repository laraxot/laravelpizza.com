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

Consent e Event usano UUID: nessuna formattazione numerica. Consent espone treatment(), subject_id, accepted_at, revoked_at; non esiste subject() né is_accepted. Migrazioni 2024_01_01_000005/000006. Event cifra ip senza accessor di decifratura: non esporre ciphertext come IP. Profile eredita User BaseProfile: usare nomi, email e telefono confermati dalle migrazioni profiles. Treatment documentVersion/documentUrl confermati dalla migrazione 000002.

## Contratto e verifica

Ogni getTableColumns restituisce array<string, Column>. Le colonne primarie supportano lettura e ricerca; metadati tecnici restano selezionabili. Nessun campo aggiunto senza evidenza nel modello e nello schema/produttore Sushi. QMD search tentato prima delle modifiche: indisponibile per incompatibilità ABI better-sqlite3 (127/147); consultati direttamente sorgenti e documentazione.
