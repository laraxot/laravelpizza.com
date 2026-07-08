# Task: Media Docs Consolidation & Cleanup

## 📋 Obiettivo
Sfoltire l'enorme documentazione del modulo Media (160+ file), eliminando duplicati, file di backup temporanei (`.md~head`) e file di log sparsi.

## 🚨 Problemi Identificati
- 167 file in root `docs/`.
- File duplicati con estensioni diverse (es. `aws.md`, `aws.txt`).
- File di backup di Git/Merge (`.md~2f8e9ec`, `.md~head`).
- Report di coverage enormi in formato `.md`.
- File placeholder con prefissi strani (es. `--stream.md`, `-competitors.md`).

## ✅ Checklist
- [ ] Rimuovere tutti i file con estensione `.txt` se duplicati dei `.md`.
- [ ] Eliminare i file di backup di sistema (`~head`, `~hash`).
- [ ] Archiviare file storici o di analisi specifica in `archive/`.
- [ ] Consolidare le varie roadmap in `roadmap.md`.
- [ ] Aggiornare `00-index.md` rimuovendo riferimenti a file temporanei.

## 🔗 Riferimenti
- [Roadmap Media](../roadmap.md)
