# Convenzione Naming Campi Utente: `first_name` e `last_name`

## Regola Fondamentale
In tutto il progetto, **usare SEMPRE** i campi `first_name` e `last_name` per rappresentare nome e cognome di una persona. **Non usare mai** `name`, `surname` o altre varianti.

## Motivazione
- **Internazionalizzazione**: `first_name` e `last_name` sono standard nelle API internazionali e nelle integrazioni con servizi esterni.
- **Coerenza Database e API**: Evita ambiguità tra nome completo e singolo campo, facilita mapping e sincronizzazione.
- **Compatibilità**: I principali framework, piattaforme e servizi (OAuth, CRM, ecc.) usano questi nomi.
- **Best Practice PSR-12/PHP Moderno**: Segue le convenzioni di naming dei progetti PHP moderni.
- **Evitare Errori di Traduzione**: `name` e `surname` sono ambigui e spesso tradotti/scambiati erroneamente.

## Implementazione
- Tutti i modelli devono usare `first_name` e `last_name`.
- Tutti i form, API e migrazioni devono accettare e restituire questi campi.
- Le traduzioni devono mappare correttamente questi campi nelle varie lingue.

## Collegamenti
- [Errore e regola nel modulo Patient](../../Patient/project_docs/naming-user-fields.md)

**Questa regola è trasversale e vincolante per tutti i moduli del progetto.**

## Collegamenti tra versioni di naming-user-fields.md
* [naming-user-fields.md](../../Patient/project_docs/naming-user-fields.md)

