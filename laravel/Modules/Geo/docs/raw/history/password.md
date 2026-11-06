---
title: "password"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "password"
issues: []
discussions: []
---

use Illuminate\Validation\Rules\Password; 
 
 Password::defaults(function () {
            return Password::min(8)
                           ->mixedCase()
                           ->uncompromised();
        });


$request->validate([
    'password' => ['required', Password::defaults()],
]);

---

title: "password"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "password"
issues: []
discussions: []
ZxcvbnPhp\Zxcvbn

ZxcvbnRule

https://github.com/bjeavons/zxcvbn-php

https://github.com/DivineOmega/laravel-password-exposed-validation-rule

NoOldPasswords
https://laracasts.com/discuss/channels/laravel/complex-password-rules-for-password-reset


https://njoguamos.me.ke/posts/create-and-test-a-custom-laravel-validation-rule !!!!