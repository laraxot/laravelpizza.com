---
title: "Translation Key Prototype"
type: concept
tags: [translation, key, prototype]
created: 2026-07-14
updated: 2026-07-14
qmd: "translation-key-prototype translation key prototype"
issues: ["https://github.com/provtv/base_ptv_fila5/issues/124"]
discussions: ["https://github.com/provtv/base_ptv_fila5/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
status: draft
---

Translation key prototype

Project convention: '<namespace>::<context>.<collection>.<item>.<type>'
Project convention: '<namespace>::<context>.<collection>.<key>.<type>' (exactly five elements, counting the namespace)

Examples:
- user::auth.register.actions.submit.label -> label for the submit button in registration form
- user::auth.login.page.meta_title.label -> page meta title label for login
- user::auth.login.password.text -> password field text

Why:
- Ensures predictable namespacing across modules and themes
- Easier to programmatically find translation entries
- Prevents collisions and improves maintainability

Action performed:
- Replaced occurrences of __('user::auth.register.submit') with __('user::auth.register.actions.submit.label') and added corresponding entry to Modules/User/lang/it/auth.php

Follow-ups:
- Run a repo-wide grep for occurrences of less-structured keys and standardize them.
- Add CI check to enforce prototype for new keys.
