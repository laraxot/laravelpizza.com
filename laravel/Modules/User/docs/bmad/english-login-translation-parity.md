---
title: "Login EN — parity del catalogo owner User"
type: story
status: done
module: User
created: 2026-09-27
updated: 2026-09-27
tags: [bmad, user, auth, i18n, ui-ux]
qmd: "User English login raw translation keys no account register forgot password reset"
issues:
  - "https://github.com/laraxot/base_fixcity_fila5/issues/383"
discussions:
  - "https://github.com/laraxot/base_fixcity_fila5/discussions/392"
related:
  - guest-login-italian-translation.md
  - ../../tests/Feature/LoginTranslationParityTest.php
---

# Problema

La view owner Sixteen chiama `user::login.no_account`, `register_now`,
`forgot_password_text` e `reset_it`. In italiano questi testi erano presenti,
mentre il catalogo `Modules/User/lang/en/login.php` non li definiva: il guest
inglese vedeva chiavi tecniche al posto dei link per registrazione e recupero.

# Criteri e verifica

- [x] Aggiungere i quattro testi inglesi nel catalogo owner User.
- [x] Test Feature `/en/auth/login` verifica i testi e l'assenza delle chiavi grezze.
- [x] Chromium responsive EN 320/768/1440: copy localizzato, nessuna chiave
  grezza, overflow o errore JS. I CTA sono renderizzati con le route owner.

La pagina si trova nel tema Sixteen, ma le traduzioni `user::login.*` appartengono
a `Modules/User`; mantenere questa ownership e riusare la pagina tematica senza
duplicare il testo nei cataloghi del tema.
