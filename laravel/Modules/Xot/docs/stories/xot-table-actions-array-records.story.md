---
type: story
slug: xot-table-actions-array-records
title: "Azioni di riga di HasXotTable su tabelle con record array"
status: done
owner: Xot
created: 2026-11-10
updated: 2026-11-10
---

# Azioni di riga di `HasXotTable` su tabelle con record array

## Problema

Le closure di visibilita' di view/edit/delete in `HasXotTable::getTableActions()` erano tipizzate `Model $record`.
Le tabelle con record array (`->records()`, usate dai widget di riepilogo, es. la giacenza per codice EER nella
dashboard di Roosko) passano un array: `TypeError` e pagina in 500. Verificato dal vivo su `/roosko/admin`.

## Correzione

Le closure accettano `mixed` e mostrano l'azione solo se il record e' un `Model` autorizzato dalla resource. Per i
record array le azioni di riga del modello restano nascoste. I test `--filter=XotTable` danno lo stesso esito di
prima della modifica (7 falliti preesistenti per DB/hook, 14 passati).
