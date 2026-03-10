# Public Profile Route Memory

- nel progetto attuale il profilo pubblico ha avuto collisioni tra route Folio duplicate e catch-all;
- la verifica utile non e' solo sul nome utente: va controllata anche la presenza nel body di label localizzate come `Profilo pubblico` e `Dettagli profilo`;
- `PageSchemaBuilder` deve leggere il profilo pubblico in modo phpstan-safe, senza property access diretto su contract incompleti.
