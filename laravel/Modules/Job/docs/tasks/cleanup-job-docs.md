# Task: Job Docs Consolidation & Cleanup

## 📋 Obiettivo
Sfoltire l'enorme documentazione del modulo Job (120+ file), eliminando duplicati, file di backup e report temporanei prodotti da processi di analisi passati.

## 🚨 Problemi Identificati
- 122 file in root `docs/`.
- File duplicati con estensioni diverse (es. `artisan.md`, `artisan.txt`).
- File di backup `bottlenecks-detailed-1.md`, `conflict-resolution-1.md`.
- File vuoti (1 byte) creati come placeholder.
- Report di log sparsi (`phpstan-report.txt`).

## ✅ Checklist
- [ ] Rimuovere tutti i file con estensione `.txt` se duplicati dei `.md`.
- [ ] Eliminare i file con dimensione 1 byte o nulli.
- [ ] Archiviare file storici o di analisi specifica in `archive/`.
- [ ] Consolidare le varie roadmap (`roadmap-2025.md`) in `roadmap.md`.
- [ ] Aggiornare `00-index.md` con i percorsi corretti.

## 🔗 Riferimenti
- [Roadmap Job](../roadmap.md)
