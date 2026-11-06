---
story_id: MEDIA-SUPPORT-001
title: "Contratto Media per upload foto mobile"
type: story
module: Media
status: supporting
owner: Media
updated: 2026-10-27
---

# Supporting handoff

La story owner è [FIXCITY-MEDIA-001](../../../../Fixcity/docs/bmad/stories/mobile-camera-upload.story.md).
Questa story non duplica il coordinamento: definisce soltanto il contratto
Media per temporary upload, sicurezza, ownership, MIME reale, limiti, cleanup e
rollback.

## Acceptance checklist

- [ ] Temporary upload legato alla sessione e all’utente quando autenticato.
- [ ] MIME e contenuto verificati server-side; estensione e MIME client non
      sono sufficienti.
- [ ] Limite server coerente con 10 MB senza accettare `image/*` indiscriminato.
- [ ] Temporanei scaduti, conversioni fallite e oggetti incompleti puliti.
- [ ] Fallimenti di trasferimento o `saveRelationships()` senza media orfani o
      ticket parziali.
- [ ] Test per HEIC normalizzato, MIME vuoto, MIME contraffatto, oversize,
      ownership e cleanup.

## References

- [Owner story](../../../../Fixcity/docs/bmad/stories/mobile-camera-upload.story.md)
- [Investigation](../mobile-camera-upload-investigation.md)
- [Plan](../mobile-camera-upload-plan.md)

`docs/chat/` è archivio storico e non è una coda operativa.
