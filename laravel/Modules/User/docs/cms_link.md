# Collegamento al Modulo Cms

Questo documento descrive le relazioni e i collegamenti tra il modulo User e il modulo Cms per quanto riguarda i componenti Filament e le convenzioni di namespace.

## Convenzioni di Namespace

Sia il modulo User che il modulo Cms seguono le stesse convenzioni di namespace per i componenti Filament:

- Il namespace corretto è sempre `Modules\<NomeModulo>\Filament`, anche se i file si trovano in `app/Filament`
- Non va mai aggiunto `App` nel namespace

Per dettagli specifici, consulta:
- [Convenzioni di Namespace](./namespace-conventions.md) in questo modulo
- [Convenzioni Namespace Filament](../../Cms/docs/convenzioni-namespace-filament.md) nel modulo Cms

## Punti di Integrazione

- **Autenticazione e UI**: I componenti di autenticazione del modulo User sono integrati con l'interfaccia utente del modulo Cms
- **Widgets condivisi**: Alcuni widget del modulo User sono utilizzati nelle dashboard del modulo Cms
- **Filament Resources**: I resource di entrambi i moduli interagiscono in diverse parti dell'applicazione

## Collegamenti Bidirezionali

- [Convenzioni Namespace Filament nel modulo Cms](../../Cms/docs/convenzioni-namespace-filament.md)
- [Collegamento User-Cms nel modulo Cms](../../Cms/docs/user-link.md)

---

### Nota Importante
Quando aggiungi nuovi componenti Filament nel modulo User, assicurati di:
1. Utilizzare il namespace corretto `Modules\User\Filament`
2. NON includere `App` nel namespace
3. Seguire le convenzioni di stile condivise con il modulo Cms

## Collegamenti tra versioni di cms-link.md
* [cms-link.md](../../../Xot/docs/cms-link.md)
* [cms-link.md](../../../User/docs/cms-link.md)
* [cms-link.md](../../../UI/docs/cms-link.md)
* [cms-link.md](../../../Lang/docs/cms-link.md)

