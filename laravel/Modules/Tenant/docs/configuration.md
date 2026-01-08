
 # Tenant Configuration (source of truth)
 
 ## Scopo
 
 Questo documento descrive la risoluzione **tenant-aware** dei valori di configurazione tramite `TenantService::config()` e l'action `ResolveTenantConfigValueAction`.
 
 ## Regola d'uso
 
 - Usare `TenantService::config('app.name')` quando il valore può variare per tenant.
 - Evitare `config('app.name')` nel business code quando si richiede tenant-awareness.
 
 ## Strategia di merge
 
 Per una chiave `group.index` (es. `app.name`):
 
 1. leggere la configurazione base `config('app')`
 2. risolvere il tenant corrente con `GetTenantNameAction`
 3. leggere gli override tenant-specific `config("{tenant}.app")` dove `{tenant}` è convertito in prefisso con `str_replace('/', '.', $tenantName)`
 4. fare merge in modo che gli override vincano sulla base
 5. restituire il valore risolto (con supporto a default)
 
 ## Decision record (litigata): `runningInConsole()` e mutazioni globali
 
 ### Posizione A (perdente): bypass in console
 
 "Se siamo in console, usiamo direttamente `config($key, $default)` e saltiamo la logica tenant-aware."
 
 **Perché sembra sensato**:
 
 - in console spesso manca `$_SERVER['SERVER_NAME']`
 - si vuole evitare I/O e lookup tenant
 
 **Perché perde**:
 
 - nel nostro codice la console **non** significa assenza di tenant: `GetTenantNameAction` ha fallback su `config('app.url')`
 - queue worker, scheduler e composer scripts possono richiedere config tenant-aware (es. `morph_map.*`)
 - bypassare crea incoerenza tra ambienti e rompe bootstrap e risoluzioni dinamiche
 
 ### Posizione B (vincente): tenant risolvibile ≠ web, console ≠ no-tenant
 
 "Il criterio non è console vs web, ma la capacità di risolvere il tenant (con fallback) e di applicare override in modo deterministico."
 
 **Perché vince**:
 
 - mantiene coerenza tra HTTP, queue, scheduler, package discovery
 - rispetta la filosofia del modulo: tenant-awareness esplicita e ripetibile
 
 ### Ulteriore decisione: evitare `Config::set()`
 
 La risoluzione deve evitare mutazioni globali (`Config::set('app', ...)`) perché nei processi long-lived (queue) il config rimarrebbe contaminato tra esecuzioni.
 
 ## Note operative
 
 - Se un valore non esiste e viene passato un default, il default viene restituito senza side effects.
 - Gli override tenant-specific devono essere espressi nei file di configurazione del tenant.
