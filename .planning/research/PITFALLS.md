# Pitfalls Research

**Domain:** Laraxot Modular Monolith (Meetup Platform)
**Researched:** 2026-03-05
**Confidence:** HIGH

## Critical Pitfalls

### Pitfall 1: Logic in Blade/Volt

**What goes wrong:**
Developers write complex database queries or business rules directly inside `.blade.php` files or Volt components.

**Why it happens:**
It's "faster" to prototype and seems easier than creating separate Action classes.

**How to avoid:**
Enforce the rule: All business logic MUST reside in Spatie Action classes. Volt components only handle UI state and call actions.

**Warning signs:**
- Presence of `Event::where(...)` or complex loops inside Blade.
- Volt component `mount()` methods longer than 10 lines.

**Phase to address:**
Phase 1 (Domain Layer) and Phase 3 (Front Office).

---

### Pitfall 2: Hardcoded Translations

**What goes wrong:**
UI strings like "Register Now" or "Upcoming Events" are hardcoded in English or Italian instead of using translation keys.

**Why it happens:**
Developers forget to use `__()` or `trans()` during rapid UI development.

**How to avoid:**
Use `LangServiceProvider` and ensure every module has a `lang/` directory with `it` and `en` files. Never use direct strings in `->label()`.

**Warning signs:**
- Literal strings in Blade files.
- Empty or missing `lang/` files in modules.

**Phase to address:**
Phase 4 (Localization).

---

### Pitfall 3: Missing WCAG 2.1 AA Compliance

**What goes wrong:**
The platform is built without proper ARIA labels, focus states, or color contrast, making it inaccessible to some users.

**Why it happens:**
Accessibility is often treated as an afterthought or "extra" feature.

**How to avoid:**
Integrate accessibility checks into the UI component development process. Use semantic HTML and standard ARIA patterns.

**Warning signs:**
- Lighthouse accessibility scores below 100.
- Missing `aria-label` on icons or interactive elements.

**Phase to address:**
Phase 3 (Front Office) and Phase 6 (Quality Gates).

---

## Technical Debt Patterns

Shortcuts that seem reasonable but create long-term problems.

| Shortcut | Immediate Benefit | Long-term Cost | When Acceptable |
|----------|-------------------|----------------|-----------------|
| Skipping Action classes | Faster initial dev. | Harder to test and reuse logic; breaks background job support. | Never (Laraxot requirement). |
| Hardcoding slugs in URLs | Quick routing. | Breaks SEO and makes localization difficult. | Never. |
| Using `property_exists()` | Simple check. | Fails with Eloquent magic attributes; causes bugs. | Never. |

## Integration Gotchas

Common mistakes when connecting to external services.

| Integration | Common Mistake | Correct Approach |
|-------------|----------------|------------------|
| Stripe | Handling payments in Volt. | Wrap Stripe API in a dedicated Spatie Action. |
| Google Maps | Including heavy JS on every page. | Use static map images for lists; only load JS on detail pages. |
| Mail Driver | Sync email sending. | Always use `QueueableAction` to send emails in the background. |

## Performance Traps

Patterns that work at small scale but fail as usage grows.

| Trap | Symptoms | Prevention | When It Breaks |
|------|----------|------------|----------------|
| N+1 Queries in Lists | Slow page loads for event lists. | Use `with(['venue', 'performers'])` in queries. | 50+ events. |
| Uncached CMS JSON | High disk I/O on every request. | Use Laravel Cache for parsed JSON blocks. | 100+ concurrent users. |
| Large Image Assets | Slow mobile load times. | Use Spatie Media Library conversions (WebP). | 10+ images per page. |

## Security Mistakes

Domain-specific security issues beyond general web security.

| Mistake | Risk | Prevention |
|---------|------|------------|
| Missing CSRF on registrations | Automated bot registrations. | Ensure `@csrf` is present in all Volt forms. |
| Exposing User IDs in URLs | Potential for ID enumeration. | Use UUIDs or Slugs (Events) for public URLs. |
| Insecure File Uploads | Malicious files uploaded as logos. | Validate mime types and use Spatie Media Library. |

## UX Pitfalls

Common user experience mistakes in this domain.

| Pitfall | User Impact | Better Approach |
|---------|-------------|-----------------|
| Complicated Registration | Users drop off before finishing. | Keep the initial form to email/name; collect more later. |
| No Confirmation State | Users don't know if registration worked. | Clear success message and immediate email confirmation. |
| Broken Mobile Layout | Site is unusable on-site at meetups. | Mobile-first design with Tailwind v4. |

## "Looks Done But Isn't" Checklist

Things that appear complete but are missing critical pieces.

- [ ] **Event CRUD:** Often missing [validation for overlapping dates] — verify [test cases]
- [ ] **Registration Flow:** Often missing [rate limiting] — verify [security audit]
- [ ] **Localization:** Often missing [translated SEO meta tags] — verify [meta tag dump]
- [ ] **CMS Pages:** Often missing [canonical URLs] — verify [SEO audit]

## Recovery Strategies

When pitfalls occur despite prevention, how to recover.

| Pitfall | Recovery Cost | Recovery Steps |
|---------|---------------|----------------|
| Logic in Blade | MEDIUM | Extract logic into Spatie Actions; refactor Blade to use Action results. |
| Broken Accessibility | HIGH | Perform WCAG audit; fix components globally in UI module. |
| Performance Bottlenecks | MEDIUM | Identify slow queries; implement eager loading and caching. |

## Pitfall-to-Phase Mapping

How roadmap phases should address these pitfalls.

| Pitfall | Prevention Phase | Verification |
|---------|------------------|--------------|
| Logic in Blade | Phase 1 & 3 | PR Review + PHPStan Level 10. |
| Hardcoded Strings | Phase 4 | Search for literal strings in resources/views. |
| Accessibility Issues | Phase 3 & 6 | Lighthouse Audit + Manual screen reader test. |

## Sources

- Laraxot Super Mucca Methodology.
- WCAG 2.1 AA Guidelines.
- Spatie Performance Best Practices.

---
*Pitfalls research for: Laravel Meetup Platform*
*Researched: 2026-03-05*
