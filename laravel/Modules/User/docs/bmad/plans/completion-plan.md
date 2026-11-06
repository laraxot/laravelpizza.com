# Piano di completamento — User

## Scopo
Gestire identità, autenticazione, ruoli, team, tenant membership e OAuth con confini di autorizzazione chiari.

## Piano BMAD

1. Mappare login/logout, utenti, ruoli, policy, team, membership, social login e pannelli.
2. Verificare guard, controller base, `Panel|null`, redirect e classi ritirate nei test.
3. Consolidare Actions e contratti per autorizzazione e appartenenza, senza bypass nei componenti UI.
4. Verificare `SettingPage` e configurazione tenant senza esporre provider OAuth.
5. Chiudere PHPStan, Pest, security review e gate statici.

## Criteri di accettazione
Ogni azione è autorizzata nel contesto corretto, logout e redirect sono robusti e i test riflettono il pannello effettivo.

