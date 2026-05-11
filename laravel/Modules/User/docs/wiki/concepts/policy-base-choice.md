# Policy Base Choice

## Scopo

Definire linee guida chiare su quando estendere `UserBasePolicy` vs `XotBasePolicy` nel modulo User.

## Principio

`UserBasePolicy` estende `XotBasePolicy` aggiungendo un layer semantico specifico per il dominio identity/utente. Le due basi devono rimanere separate per mantenere una chiara separation of concerns.

## Quando usare `UserBasePolicy`

Estendi `UserBasePolicy` quando:

- La policy riguarda modelli di autenticazione, identità, team, ruoli o permessi specifici del dominio User
- La policy rappresenta regole del dominio User con semantica chiaramente centrata sull'actor utente
- Si desidera un layer di autorizzazione che eredita il comportamento di super-admin override da `XotBasePolicy` ma aggiunge controlli specifici per il contesto User
- Esempi: `UserPolicy`, `RolePolicy`, `PermissionPolicy`, `TeamPolicy`, `ProfilePolicy`

## Quando usare `XotBasePolicy` direttamente

Estendi direttamente `XotBasePolicy` quando:

- La policy riguarda modelli infrastrutturali o tecnici non legati specificamente al dominio User
- La policy deve rimanere neutra rispetto al dominio User (es. policy di sistema, cache, logging)
- Si condivide la policy cross-modulo senza dipendenze identity-specific
- Si vuole il minimo contratto comune (super-admin override + default deny)
- Esempi: `SessionPolicy`, `CachePolicy`, `LogPolicy`, `InformationSchemaTablePolicy`

## Perchè mantenere entrambe separate

1. **Separazione delle responsabilità**: `XotBasePolicy` = base tecnica canonica, `UserBasePolicy` = specializzazione dominio User
2. **Minore coupling architettonico**: riduce le dipendenze tra framework core e logica identity-specific
3. **Scelta esplicita e documentabile**: ogni policy nuova deve giustificare chiaramente la scelta della base
4. **Facilità di manutenzione**: cambiamenti nel core (`XotBasePolicy`) non impattano inesperatamente sulle policy User-specific

## Anti-pattern da evitare

- Policy di modulo business che dipendono da `UserBasePolicy` senza motivazione di dominio chiaro
- Policy duplicate con comportamento identico in basi diverse
- Policy nuove che non estendono alcuna base quando serve una deviazione reale (in tal caso, creare una base intermedia appropriata)
- Dipendenza implicita da `UserBasePolicy` in contesti dove sarebbe più appropriata `XotBasePolicy`

## Miglioramenti consigliati

1. **Decision tree nei documenti di modulo**: aggiungere una matrice di scelta chiara in ogni modulo
2. **Tracciamento delle eccezioni**: documentare ogni eccezione alla regola con rationale specifico
3. **Allineamento graduale**: spostare gradualmente le policy business esistenti verso una base dichiarata esplicitamente
4. **Revisione periodica**: verificare che le policy estendano la base appropriata durante code review

## Riferimenti

- [Policy base strategy (Xot)](../../Xot/docs/wiki/concepts/policy-base-strategy.md)
- [Policy inheritance boundary (User)](./policy-inheritance-boundary.md)
- [Profiles ownership boundary rule](./profiles-ownership-boundary-rule.md)