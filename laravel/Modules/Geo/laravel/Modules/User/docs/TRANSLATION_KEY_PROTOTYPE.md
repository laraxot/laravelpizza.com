Translation key prototype

Project convention: '<namespace>::<context>.<collection>.<item>.<type>'

Examples:
- user::auth.register.actions.submit.label -> label for the submit button in registration form
- user::auth.login.page.meta_title.label -> page meta title label for login

Why:
- Ensures predictable namespacing across modules and themes
- Easier to programmatically find translation entries
- Prevents collisions and improves maintainability

Action performed:
- Replaced occurrences of __('user::auth.register.submit') with __('user::auth.register.actions.submit.label') and added corresponding entry to Modules/User/lang/it/auth.php

Follow-ups:
- Run a repo-wide grep for occurrences of less-structured keys and standardize them.
- Add CI check to enforce prototype for new keys.