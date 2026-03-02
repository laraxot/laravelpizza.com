# Task: Geo Docs Consolidation & Cleanup

## 📋 Obiettivo
Sfoltire l'enorme documentazione del modulo Geo (370+ file), eliminando duplicati, file di backup e report temporanei prodotti da processi di analisi passati.

## 🚨 Problemi Identificati
- 379 file in root `docs/`.
- File duplicati con estensioni diverse (es. `__eloquent.md`, `__eloquent.txt`).
- File di backup `README.md.cleaned`, `comprehensive-guide-backup.md`.
- Report di coverage enormi in formato `.txt` (es. `coverage_full.txt`).

## ✅ Checklist
- [ ] Rimuovere tutti i file con estensione `.txt` se duplicati dei `.md`.
- [ ] Eliminare i file di backup (`-backup.md`, `.cleaned`).
- [ ] Archiviare file storici o di analisi specifica in `archive/`.
- [ ] Consolidare le varie guide agli indirizzi in `address-implementation.md`.
- [ ] Aggiornare `00-index.md` rimuovendo riferimenti a path inesistenti.

## 🔗 Riferimenti
- [ROADMAP Geo](../roadmap.md)
