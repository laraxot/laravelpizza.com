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
