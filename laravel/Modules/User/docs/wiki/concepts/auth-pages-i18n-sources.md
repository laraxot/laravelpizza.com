---
title: "User - da dove arrivano i testi di login e registrazione"
type: concept
tags: [user, i18n, lang, login, register, user_form]
created: 2026-10-07
updated: 2026-10-07
qmd: "User login register traduzioni user_form login_widget login_page register_page etichette grezze auto-writer"
issues:
discussions:
related:
  - "../../stories/auth-pages-i18n-en-de-es-2026-10-07.story.md"
---

# Sorgenti dei testi delle pagine auth

| Elemento | File lang | Chiavi |
| --- | --- | --- |
| Titolo, kicker, aiuto (login) | `auth.php` | `login_page.*` |
| Titolo, aiuto (registrazione) | `auth.php` | `register_page.*` |
| Link "Non hai un account?" | `login.php` | `no_account`, `register_now`, `forgot_password_text`, `reset_it` |
| Bottone e errore di login | `login.php` | `actions.login.label`, `actions.login.error` |
| **Etichette, placeholder, aiuto dei campi** | **`user_form.php`** | `fields.<campo>.{label,placeholder,helper_text,description}` |
| "Hai gia' un account?" | `registration.php` | `already_registered` |

`login_widget.php` NON alimenta le etichette del login: lo schema e' `UserForm`, quindi vale `user_form`.

## Trappole

- L'auto-writer, davanti a una chiave mancante, scrive il **nome del campo come valore**
  (`'label' => 'email'`). Sintomo in pagina: etichette minuscole grezze. Il test
  `tests/Feature/AuthPagesLocalesTest.php` lo intercetta.
- Se manca la chiave in una lingua, Laravel mostra l'italiano (fallback), senza errori.
- Le lingue servite dal selettore sono it, en, de, es.

## Controllo rapido

```bash
cd laravel && ./vendor/bin/pest Modules/User/tests/Feature/AuthPagesLocalesTest.php
```
