# Collegamento al Modulo User

Questo documento descrive le relazioni e i collegamenti tra il modulo Cms e il modulo User per quanto riguarda i componenti Filament e le convenzioni di namespace.

## Convenzioni di Namespace

Sia il modulo Cms che il modulo User seguono le stesse convenzioni di namespace per i componenti Filament:

- Il namespace corretto è sempre `Modules\<NomeModulo>\Filament`, anche se i file si trovano in `app/Filament`
- Non va mai aggiunto `App` nel namespace

Per dettagli specifici, consulta:
- [Convenzioni Namespace Filament](./convenzioni-namespace-filament.md) in questo modulo
- [Convenzioni di Namespace](../../User/docs/namespace-conventions.md) nel modulo User

## Punti di Integrazione

- **Componenti UI condivisi**: Alcuni componenti UI del modulo Cms sono utilizzati anche nel modulo User
- **Convenzioni di stile**: Entrambi i moduli seguono le stesse convenzioni di stile per garantire coerenza
- **Filament Resources**: I resource di entrambi i moduli interagiscono in diverse parti dell'applicazione

## Collegamenti Bidirezionali

- [Convenzioni di Namespace nel modulo User](../../User/docs/namespace-conventions.md)
- [Best Practices Filament nel modulo User](../../User/docs/FILAMENT_BEST_PRACTICES.md)

---

### Nota Importante
Quando aggiungi nuovi componenti Filament, assicurati di:
1. Utilizzare il namespace corretto
2. Seguire le convenzioni di stile condivise
3. Mantenere aggiornata la documentazione in entrambi i moduli

## Collegamenti tra versioni di user-link.md
* [user-link.md](laravel/Modules/Lang/docs/user-link.md)
* [user-link.md](laravel/Modules/Cms/docs/user-link.md)

