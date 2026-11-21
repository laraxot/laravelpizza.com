---
title: "TRANSLATION KEY PROTOTYPE"
module: user
type: integration
tags: [integrations, modules, user]
created: 2026-08-24
updated: 2026-10-18
status: draft
qmd: "translation key prototype user"
---

Translation key prototype

Project convention: '<namespace>::<context>.<collection>.<item>.<type>'
Project convention: '<namespace>::<context>.<collection>.<key>.<type>' (exactly five elements, counting the namespace)

Examples:
- user::auth.register.actions.submit.label -> label for the submit button in registration form
- user::auth.login.page.meta_title.label -> page meta title label for login
- user::auth.login.password.text -> password field label/text in the login collection

Invalid examples:
- user::auth.password
- user::auth.login.password
- pub_theme::accessibility.title

For the accessibility statement the theme uses
`pub_theme::accessibility.page.title.text`: `accessibility` is the context,
`page` the collection, `title` the key and `text` the type.

Why:
- Ensures predictable namespacing across modules and themes
- Easier to programmatically find translation entries
- Prevents collisions and improves maintainability

Action performed:
- Replaced occurrences of __('user::auth.register.submit') with __('user::auth.register.actions.submit.label') and added corresponding entry to Modules/User/lang/it/auth.php

Follow-ups:
- Run a repo-wide grep for occurrences of less-structured keys and standardize them.
- Add CI check to enforce prototype for new keys.
