---
title: "gemini dependencies"
type: note
tags: [documentation]
created: 2026-09-26
<<<<<<< HEAD
updated: 2026-11-23
=======
<<<<<<< HEAD
<<<<<<< HEAD
updated: 2026-09-26
=======
updated: 2026-11-23
>>>>>>> laraxot/dev
=======
updated: 2026-11-23
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
qmd: "gemini dependencies"
issues: []
discussions: []
---

# GEMINI Dependencies

Gestione dipendenze Composer e moduli.

<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> laraxot/dev
---

title: "gemini dependencies"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "gemini dependencies"
issues: []
discussions: []
## Regola Critica

Il `composer.json` nella **root** (`laravel/composer.json`) **NON DEVE ESSERE MODIFICATO** per aggiungere dipendenze specifiche di un modulo.

---

<<<<<<< HEAD
=======
=======
## Regola Critica

>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
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
<<<<<<< HEAD
- [GEMINI.md originale](../../gemini.md)
=======
<<<<<<< HEAD
<<<<<<< HEAD
- [gemini.md originale](../../gemini.md)
=======
<<<<<<< HEAD
- [GEMINI.md originale](../../gemini.md)
=======
- [gemini.md originale](../../gemini.md)
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
=======
- [GEMINI.md originale](../../gemini.md)
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
- [Index principale](./index.md)
