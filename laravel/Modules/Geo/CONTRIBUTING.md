Contributing: policy issue-linking

Per evitare che modifiche non siano tracciate con issue GitHub, seguire queste regole locali e remote:

Local hooks (raccomandato):
1. Impostare hook locali in repository: `git config core.hooksPath .githooks`
2. Rendere eseguibili gli hook: `chmod +x .githooks/*`

Commit messages:
- Includere riferimento a issue nel messaggio: e.g. "Add STANDARD.md (Closes #123)" or include "Refs #123".

CI enforcement:
- La pipeline GitHub Actions verifica PR e commit; se non trovata una issue, creerà una issue automaticamente e commenterà la PR richiedendo aggiornamento.

Agents:
- Tutti gli agenti AI devono rispettare AGENTS_POLICY.md; le violazioni saranno bloccate dalla CI.

If you are an integrator: run `git config core.hooksPath .githooks` once after cloning to enable local checks.
