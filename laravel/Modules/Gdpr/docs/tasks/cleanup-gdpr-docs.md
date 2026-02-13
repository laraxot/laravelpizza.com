# Task: Gdpr Docs Consolidation & Cleanup

## 📋 Obiettivo
Sfoltire l'enorme documentazione del modulo Gdpr (100+ file), eliminando duplicati, file di report temporanei e indici obsoleti provenienti da merge errati.

## 🚨 Problemi Identificati
- 101 file in root `docs/`.
- File vuoti (0/1 byte) o duplicati (es. `algolia-docsearch-duplicate.md`).
- Mix di file "roadmap" in diverse directory.
- File di log `phpstan-report.txt` e `phpmd-report.txt` sparsi.

## ✅ Checklist
- [ ] Rimuovere tutti i file con suffisso `-1.md`, `-duplicate.md`.
- [ ] Eliminare i file con dimensione 0 o 1 byte.
- [ ] Archiviare file storici in `archive/`.
- [ ] Consolidare le varie roadmap nel `roadmap.md` principale.
- [ ] Aggiornare `00-index.md` con la nuova struttura snella.

## 🔗 Riferimenti
- [Roadmap Gdpr](../roadmap.md)
