---
title: "Task: Ottimizzare BaseUser Model - User"
type: concept
tags: [task, ottimizzare, baseuser]
created: 2026-07-14
updated: 2026-07-14
qmd: "task-ottimizzare-baseuser task: ottimizzare baseuser model - user"
issues: ["https://github.com/provtv/base_ptv_fila5/issues/124"]
discussions: ["https://github.com/provtv/base_ptv_fila5/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
status: draft
---

# Task: Ottimizzare BaseUser Model - User

**Modulo**: User
**Priorita'**: Bassa
**Completamento**: 60%

---

## Descrizione

Il modello BaseUser usa molti traits che aggiungono complessita'. Verificare che tutti siano necessari e ottimizzare le query N+1.

## Stato Attuale

Traits in uso: HasUuids, HasApiTokens, Notifiable, SoftDeletes, HasAuthenticationLogTrait, HasTeams, HasTenants, HasSpatiePermission, HasModules, HasSocialite, HasDevices, HasChildren, HasXotFactory.

## Azioni

1. Verificare che tutti i traits siano effettivamente utilizzati
2. Implementare eager loading per relazioni frequenti
3. Aggiungere indici database per query frequenti
4. Verificare performance con Laravel Debugbar

## Criteri di Completamento

- [ ] Audit traits completato
- [ ] Eager loading configurato per relazioni comuni
- [ ] N+1 queries eliminate
