# Policy base strategy

## Obiettivo

Definire una strategia chiara e stabile su quale base usare per le policy dei moduli:

- `Modules\Xot\Models\Policies\XotBasePolicy`
- `Modules\User\Models\Policies\UserBasePolicy`

## Stato attuale osservato

Nel repository entrambe le basi sono usate in produzione:

- molti modelli tecnici/infrastrutturali estendono `XotBasePolicy`
- molti modelli identity/access estendono `UserBasePolicy`
- alcuni moduli applicativi usano ancora policy dirette senza estendere una base

Differenze concrete oggi osservabili nel codice:

- `XotBasePolicy` contiene un `before()` comune per il bypass `super-admin`
- `XotBasePolicy` esplicita anche una baseline `viewAny(): false`
- `UserBasePolicy` oggi replica il bypass `super-admin`, ma non dichiara la stessa baseline minima
- `UserBasePolicy` contiene anche una dipendenza `XotData` che qui non aggiunge semantica documentabile

## Regola decisionale (recommended)

### Usa `XotBasePolicy` quando

- la risorsa e' cross-modulo o infrastrutturale
- la policy deve rimanere neutra rispetto al dominio User
- vuoi il minimo contratto comune (es. super-admin override + default deny)
- vuoi la base architetturale piu' stabile e meno sorprendente per nuovi moduli

### Usa `UserBasePolicy` quando

- la risorsa e' nel dominio identita'/accesso utente
- la policy dipende da semantica role/permission tipica del modulo User
- vuoi un layer semantico esplicito di autorizzazione centrato su User
- hai helper o convenzioni che non sarebbero corretti nel core `Xot`

## Le due basi vanno tenute separate?

Si', ma con boundary esplicito:

- `XotBasePolicy` = base tecnica canonica
- `UserBasePolicy` = specializzazione dominio User

Separarle riduce coupling tra framework core e logica identity-specific.

Non vanno pero' tenute "separate ma uguali": se la seconda base non aggiunge semantica, diventa solo un alias con rischio drift.

## Anti-pattern da evitare

- policy di modulo business che dipendono da `UserBasePolicy` senza motivazione di dominio
- policy duplicate con stesso comportamento in basi diverse
- policy nuove senza estendere alcuna base quando non serve una deviazione reale
- introdurre nuove base policy di modulo senza un bounded context chiaro
- usare `before()` per infilare regole business locali invece di bypass globali o shortcut trasversali

## Miglioramenti consigliati

- introdurre una mini-matrice di scelta nelle docs modulo (decision tree)
- allineare gradualmente le policy business a una base dichiarata
- documentare eccezioni reali (con motivo) invece di accettare drift implicito
- esplicitare la convenzione di baseline minima che ogni base policy deve offrire
- evitare dipendenze non usate nelle base policy, perche' segnalano confine poco nitido

## Recommended target state

- `XotBasePolicy` resta la radice architetturale unica.
- `UserBasePolicy` resta solo se esprime davvero il linguaggio del dominio identity.
- Le policy dei moduli business preferiscono `XotBasePolicy`, salvo motivo scritto nel wiki locale.
- Ogni eccezione deve essere spiegata come scelta di boundary, non come abitudine.
- mantenere aggiornata una matrice modulo -> base policy

## Decision tree rapido

1. risorsa identity/auth/permission? -> `UserBasePolicy`
2. risorsa tecnica o cross-modulo? -> `XotBasePolicy`
3. risorsa business senza esigenze User-specific? -> preferire `XotBasePolicy`
4. eccezione? -> documentarla nel wiki del modulo

## Riferimenti

- [policy module matrix](./policy-module-matrix.md)
- [user policy inheritance boundary](../../../User/docs/wiki/concepts/policy-inheritance-boundary.md)
- [theme policy rendering boundary](../../../../Themes/Sixteen/docs/wiki/concepts/policy-rendering-boundary.md)
