# Gestione automatica delle label in Filament tramite LangServiceProvider

## Funzionamento
- LangServiceProvider applica automaticamente la label corretta tramite AutoLabelAction a tutte le colonne, actions e fields Filament.
- Non serve mai usare ->label(): la label viene ricavata dalla chiave di traduzione secondo convenzione.
- Se la traduzione non esiste, il sistema può crearla o segnalarla (fallback).

## Pattern
- Label, heading, help e placeholder SOLO in file di traduzione modulo.
- Convenzione chiavi: `modulo.resource.fields.campo.label` o `modulo.resource.actions.azione.label`.
- Nessuna label hardcoded nei file Filament.

## Anti-pattern
- Uso di ->label() nei componenti Filament.
- Label hardcoded.

## Test di regressione
- Test statico che cerca ->label( nei file Filament.
- Test che verifica la presenza di tutte le chiavi di traduzione.

## Collegamenti
- [docs root](../../../../docs/actions.md)
- [docs Xot](../../../Xot/docs/MODULE_NAMESPACE_RULES.md)

