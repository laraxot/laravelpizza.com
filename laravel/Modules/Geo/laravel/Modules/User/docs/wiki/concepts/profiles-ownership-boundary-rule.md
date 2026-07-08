# Profiles ownership boundary rule

## Regola

Nel contesto Laraxot di questo repository, il contratto schema di `profiles` e' owner del modulo Fixcity.

## Implicazioni

- il modulo User non deve introdurre migrazioni additive su `profiles`
- non sono ammessi file con naming `add_*_to_profiles_table.php`
- eventuali cambi al contratto `profiles` passano dalla migrazione canonica `create_profiles_table` owner

## Rationale

- DRY: una sola fonte di verita' per il modello
- KISS: evitare catene additive e ownership ambigua tra moduli
- anti-regressione: prevenire conflitti e rollback complessi

## Riferimenti

- [profiles uuid single migration rule](../../../../../docs/wiki/concepts/profiles-uuid-single-migration-rule.md)
- [fixcity profiles uuid contract](../../../../Fixcity/docs/wiki/concepts/profiles-uuid-contract.md)
