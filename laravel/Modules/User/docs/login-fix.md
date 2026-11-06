---
title: "Fix credenziali login: BMAD + second brain"
type: note
status: draft
updated: 2026-10-19
tags: [docs, user]
qmd: "fix credenziali login   bmad + second brain user"
---
# Fix credenziali login: BMAD + second brain
Scopo: assicurare che marco.sottana@gmail.com con prova123 possa accedere.
Sorgente errore: hash password nel DB non corrispondeva.
Azione: verificata localmente con `Hash::check`; non si dichiara risolto il deploy finché il database produzione non viene verificato. Stack: NO Bootstrap Italia.
Docs: aggiornate in moduli e temi. Dati sacri: nessuna migrazione distruttiva.