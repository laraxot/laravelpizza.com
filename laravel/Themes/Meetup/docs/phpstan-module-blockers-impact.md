# Module Quality Blockers Impact On Theme - 2026-03-10

## Perche' questa nota esiste

Il tema `Meetup` dipende dal buon stato dei moduli, soprattutto `Cms` e `User`.

## Impatto pratico

- se migration e factory nei moduli sono sintatticamente rotte, i quality gate globali smettono di essere affidabili;
- questo rallenta anche la verifica di regressioni frontoffice del tema, perche' il feedback statico complessivo si interrompe prima dei veri type errors applicativi;
- i fix tema possono quindi apparire "verdi" localmente mentre il repository resta rosso su blocker infrastrutturali nei moduli.

## Regola operativa

Quando si lavora sul tema e un run globale di `phpstan analyse Modules` fallisce con severe syntax errors, bisogna distinguere:

- regressioni del tema;
- blocker sintattici di moduli dipendenti.

Le due cose non vanno confuse nei report finali.

## Aggiornamento 2026-03-10

- il repository non e' piu' bloccato dai parse error iniziali nei cluster `Cms` e `User` corretti;
- il run globale e' passato da una fase con blocker sintattici diffusi a `106` errori semantici residui;
- questo rende di nuovo utile il feedback statico per il tema `Meetup`, ma non ancora affidabile al 100% finche' restano i cluster `Cms`, `Notify`, `Tenant` e `User/Passport`.

## Nota architetturale per il tema

- il tema non deve supplire a endpoint o controller legacy del modulo `Notify`;
- se compare un `NotificationTrackingController`, non va aggirato nel tema ma rimosso/ricondotto al dominio;
- anche la correzione di questi blocker va fatta forward-only, con commit correttivi espliciti e senza revert di storia condivisa.
