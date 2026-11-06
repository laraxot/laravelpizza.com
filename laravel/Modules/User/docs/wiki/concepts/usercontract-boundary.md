---
title: "UserContract boundary"
type: concept
module: User
status: active
updated: 2026-10-18
tags: [user, contract, architecture, bmad]
qmd: "UserContract contratto identita BaseUser astrazione consumer capability"
---

# UserContract è il confine dei consumer

`BaseUser` è una implementazione astratta interna al modulo User. Non è il tipo
che i consumer devono usare per riconoscere un utente: un modulo o un tema può
fornire un modello utente diverso, purché rispetti il contratto condiviso.

## Regola

Nei listener, widget, action, policy e viste che ricevono l'utente dall'Auth
manager usare:

```php
use Modules\User\Contracts\UserContract;

if (! $user instanceof UserContract) {
    return;
}
```

Non usare `instanceof BaseUser` per il controllo di identità. Quel controllo
vincola inutilmente il consumer alla classe astratta e rompe l'estensibilità
per modelli concreti di altri moduli.

## Capability aggiuntive

`UserContract` certifica l'identità applicativa, non ogni capability opzionale.
Per una relazione o un comportamento non dichiarato dal contratto principale:

- usare il contratto specifico, se esiste;
- per le notifiche usare `UserNotificationsContract`;
- per i log di autenticazione usare `HasAuthentications`;
- non ricadere su `BaseUser` solo per ottenere un narrowing comodo.

## Action Auth (esempio canonico)

`RecordAuthenticationLogAction::execute` tipizza
`UserContract&HasAuthentications`: identità + relazione `authentications()`.
I listener `LoginListener` / `FailedLoginListener` fanno lo stesso doppio
`instanceof` prima di chiamare l'action. Type-hintare `BaseUser` sarebbe
equivalente a confrontare con l'astratta: vietato.

## Verifica

Quando si modifica un consumer utente, cercare `BaseUser`, `User` e i relativi
`instanceof` nel modulo/tema, verificare il contratto realmente disponibile e
aggiungere la regola a questa pagina se emerge una nuova capability condivisa.
Guardrail sorgente: `tests/Unit/Actions/Auth/RecordAuthenticationLogActionTest.php`.

## Collegamenti (second brain)

- Decisione cross-modulo Xot: [user-contract-boundary.md](../../../../Xot/docs/bmad/user-contract-boundary.md)
- Tema Sixteen (consumer auth): [user-contract-boundary.md](../../../../../Themes/Sixteen/docs/auth/user-contract-boundary.md)
- Log BMAD modulo User: [bmad-second-brain.md](../../bmad-second-brain.md)
- Campagna PHPStan sui test (ortogonalmente ai contratti): [phpstan-pest-patterns-modulo-notify.md](../../../../Notify/docs/wiki/memories/phpstan-pest-patterns-modulo-notify.md)
