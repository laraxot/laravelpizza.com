# Memory: Git Forward Only

- Nel progetto git si usa per studio e audit, non per riportare file o branch a uno stato vecchio.
- `git revert` non e' la scorciatoia ammessa per "annullare": prima si capisce il delta utile, poi si implementa una fix forward-only nel codice corrente.
- La storia si preserva non solo evitando rewrite, ma evitando proprio il ritorno meccanico a snapshot precedenti come metodo di lavoro.
