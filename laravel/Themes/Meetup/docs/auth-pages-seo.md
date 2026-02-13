# SEO Guidelines for Auth Pages

## Meta Tags

Every auth page must have unique meta tags:

```blade
<x-layouts.app>
    <x-slot name="title">
        {{ __('gdpr::register.title') }} - LaravelPizza
    </x-slot>

    <x-slot name="description">
        {{ __('gdpr::register.subtitle') }}
    </x-slot>
</x-layouts.app>
```

## Requirements

### Title
- Unique per page
- Include brand name
- Max 60 characters

### Description
- Unique per page
- Include primary keyword
- Max 160 characters

### Keywords (Optional)
- Comma-separated
- Relevant terms only

## URL Structure

```
/{locale}/auth/login
/{locale}/auth/register
/{locale}/auth/password/reset
```

## Hreflang

For multilingual sites, add hreflang in layout:

```html
<link rel="alternate" hreflang="it" href="https://laravelpizza.com/it/auth/register">
<link rel="alternate" hreflang="en" href="https://laravelpizza.com/en/auth/register">
<link rel="alternate" hreflang="x-default" href="https://laravelpizza.com/it/auth/register">
```

## Schema Markup

Add structured data for auth pages:

```html
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebPage",
  "name": "{{ __('gdpr::register.title') }}",
  "description": "{{ __('gdpr::register.subtitle') }}"
}
</script>
```

## Best Practices

- [ ] Unique title per language
- [ ] Unique description per language
- [ ] Proper URL structure
- [ ] Hreflang tags
- [ ] No duplicate content
- [ ] Canonical URL set

## Related Docs
- [UI/UX Guidelines](./auth-pages-uiux.md)
- [WCAG Accessibility](./wcag.md)
