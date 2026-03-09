Nuovo hardening del workflow operativo:

- i quality gate post-edit per PHP non sono opzionali;
- `phpstan`, `phpmd` e `phpinsights` devono essere eseguiti sul perimetro minimo affidabile dopo ogni modifica;
- per file PHP testabili bisogna sempre valutare il test Pest associato, creandolo o aggiornandolo se manca;
- il report finale deve distinguere controlli eseguiti, bloccati e non applicabili.

Ho allineato questa regola sia nella governance globale sia nelle docs locali di modulo/tema, in modo che sia parte del contratto operativo multi-agente e non solo una preferenza temporanea.
