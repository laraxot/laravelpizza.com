---
name: translation-guidelines-user-module
description: **Guide**: Structure translations in User module with 5-element standard
**Applies to**: All language files in laravel/Modules/User/lang/
**Enforced by**: Translation 5-Elements Rule

**Structure Requirements**:
1. Each translation must be an array with 5 elements:
   - key: Unique string (e.g. auth.email_address)
   - text: Base language string (e.g. Email address)
   - description: Usage context (e.g. 'Login form label')
   - context: Optional usage scenario (e.g. login_form)
   - placeholder: Input field example (e.g. you@example.com)

**File Structure Example**:
```php
// resources/lang/en/user.php
return [
    'auth.email_address' => [
        'key'         => 'auth.email_address',
        'text'        => 'Email address',
        'description' => 'Label for the email input field on the login form',
        'context'     => 'login_form',
        'placeholder' => 'you@example.com',
    ],
    
    'login.submit' => [
        'key'         => 'login.submit',
        'text'        => 'Login',
        'description' => 'Primary action button on login form',
        'context'     => 'login_form',
        'placeholder' => '',  // Omit if not used
    ],
];
```

**Key Rules**:
- Never use full sentences in code - always use `__('key.text')`
- Placeholder should be non-empty string (even if empty)
- Context helps translators understand usage
- Keep keys descriptive but short

**Validation**:
- All translation files checked by pre-commit hook
- Code reviews will reject files without 5-element structure
- LLM Wiki must reference this guideline

**References**:
- Rule file: .claude/rules/translation-5-elements.md
- Memory entry: translation-5-elements-rule.md
- LLM Wiki section: /llm-wiki-updates/translation-guide