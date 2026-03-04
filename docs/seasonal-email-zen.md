# The Zen of Seasonal Emails

**Date**: 2025-12-19
**By**: Antigravity

## Philosophy

The seasonal email system is not just about changing colors or adding snowflakes. It's about **Contextual Empathy**.
When a user receives an email in December, the digital environment should reflect the physical one. It creates a seamless connection between the brand and the user's reality.

### The "Why"

- **Human connection**: Seasonal themes make automated communications feel "hand-crafted" and timely.
- **Attention**: A festive template stands out in a monotonous inbox.
- **Joy**: Small details (a twinkling star, a falling flake) bring a micro-moment of delight.

## The Strategy

We avoid hardcoding logic (`if (date == december)`) inside business classes.
Instead, we rely on **Architecture**:
1.  **Context Resolution**: `GetThemeContextAction` determines *what* season it is.
2.  **Asset Resolution**: `GetMailLayoutAction` finds the *best fit* asset (`christmas.html` vs `base.html`).
3.  **Data Injection**: `SpatieEmail::mergeData()` injects the *content* specifics.

This separation allows:
- **Designers** to work on HTML (`christmas-elegant.html`).
- **Developers** to work on logic (`GetThemeContextAction`).
- **Marketers** to craft content (`MailTemplate` in DB).

## Implementation Details

### Data Passing Pattern

Data must flow transparently to the view.
- **Input**: `mergeData(['code' => 'XMAS25'])`
- **Process**: Merged into `$this->data`
- **Output**: Rendered via Mustache `{{ code }}`

### The "Elegant" Variant

We introduced `christmas-elegant.html` to serve a specific need: **Professional Festivity**.
Not all brands want red/green and cartoons. Some want "Silent Night" — deep blues, gold, serif fonts.
This demonstrates the flexibility of the system: multiple "skins" for the same context.

## Reflections & Future

- **Memory**: The system works best when "Convention over Configuration" is respected.
- **Improvement**: We could add a "Preview" feature in the backend to see how `base.html` transforms contextually.
- **Verification**: Static analysis tools (PHPStan/PHPMD) ensure the *plumbing* is leak-proof, but only the *human eye* can verify the *feeling* of the template.

*"Code is temporary, the feeling you give the user is permanent."*
