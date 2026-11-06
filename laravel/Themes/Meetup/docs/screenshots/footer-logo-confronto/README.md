# Screenshot footer – confronto logo

Screenshot della **sola sezione footer** per confrontare il logo tra produzione (laravelpizza.com) e nostra implementazione (locale).

## File attesi

| File | Descrizione |
|------|-------------|
| `footer-laravelpizza-com.png` | Footer produzione |
| `footer-locale-it.png` | Footer nostra home (es. http://127.0.0.1:8000/it) |

## Come generare

Dalla cartella del tema (`laravel/Themes/Meetup`):

```bash
npm run screenshots:footer
```

Con URL locale diverso (es. porta 8000):

```bash
LOCAL_URL=http://127.0.0.1:8000/it npm run screenshots:footer
```

L’app locale deve essere avviata (es. `composer dev` da `laravel/`).

## Documentazione differenze e roadmap

Vedi [footer-logo-confronto](../../footer-logo-confronto.md).
