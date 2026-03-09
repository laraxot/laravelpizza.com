# Skill Operativa: Laravel Folio Debug

## Quando usarla

Usare questa skill quando il task riguarda:

- pagine in `resources/views/pages`;
- route file-based Folio;
- middleware inline `name()/middleware()/render()`;
- wildcard segment come `[slug]`, `[container0]`, `[slug0]`;
- bug di naming o middleware su frontoffice.

## Workflow

1. Verificare dove Folio e' montato nel provider applicativo.
2. Identificare il file pagina effettivamente matchato.
3. Controllare metadata inline:
   - `name()`
   - `middleware()`
   - `render()`
4. Ricostruire i middleware reali come unione tra mount-level e inline.
5. Verificare se i parametri route sono gia' passati da Folio/Volt.
6. Solo se si tocca PHP, eseguire quality gate completo.

## Anti-pattern

- debuggare una pagina Folio come se fosse una route controller-based;
- aggiungere estrazioni manuali di route params senza verificare binding gia' disponibile;
- duplicare route name in `routes/web.php` per pagine gia' servite da Folio.
