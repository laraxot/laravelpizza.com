# GEMINI Dependencies

Gestione dipendenze Composer e moduli.

---

## Regola Critica

Il `composer.json` nella **root** (`laravel/composer.json`) **NON DEVE ESSERE MODIFICATO** per aggiungere dipendenze specifiche di un modulo.

---

## Workflow Corretto

1. **Aggiungi il pacchetto** nel `composer.json` del **MODULO specifico** (es: `Modules/Meetup/composer.json`).
2. **Esegui** `composer run go` dalla cartella `laravel/`.
   - Questo esegue `composer update -W`
   - Grazie al plugin `wikimedia/composer-merge-plugin`, fonde le dipendenze dei moduli nel progetto principale.

---

## Perché?

- Mantiene i moduli **portabili** e auto-contenuti
- Evita di "sporcare" il file principale del progetto
- Segue l'architettura modulare di `nWidart/laravel-modules`

---

## Esempio

```json
// Modules/Meetup/composer.json
{
    "require": {
        "intervention/image": "^3.0"
    }
}
```

```bash
cd laravel
composer run go
```

---

## Dipendenze nei Moduli Attuali

| Modulo | Dipendenze |
|--------|------------|
| User | laravel/passport, socialiteproviders/*, spatie/laravel-permission |
| Media | intervention/image, spatie/laravel-medialibrary |
| Xot | spatie/laravel-data, spatie/laravel-queueable-action, guzzlehttp/guzzle |

---

## 🔗 Link

- [Indice GEMINI](./gemini-split-index.md)
- [packages-spatie.md](./packages-spatie.md)
- [GEMINI.md originale](../../GEMINI.md)
- [Index principale](./index.md)
