# Piano di completamento — Tenant

## Scopo
Isolare tenant, domini, configurazione e appartenenza utenti in una singola applicazione multi-tenant.

## Piano BMAD

1. Mappare risoluzione da `SERVER_NAME`, contesto tenant, config, connessioni e policy.
2. Verificare isolamento dati, cache, filesystem, queue e fallback quando il tenant manca.
3. Mantenere Actions e contratti come superficie pubblica; non ricreare servizi rimossi senza evidenza.
4. Verificare `SettingPage`, Data tenant-aware e test di bootstrap senza dati distruttivi.
5. Chiudere gate statici, Pest con SQLite condiviso e documentazione di sicurezza.

## Criteri di accettazione
La richiesta risolve un solo tenant in modo deterministico e nessun dato/config di un tenant attraversa il confine di un altro.

