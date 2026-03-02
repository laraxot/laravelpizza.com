# Parse Error Fix - Blade Comment with @foreach

## Error

```
ParseError - syntax error, unexpected end of file, expecting "elseif" or "else" or "endif"
Location: Themes/Meetup/resources/views/components/layouts/main.blade.php:19
```

## Root Cause

In `/Modules/Cms/resources/views/components/metatags.blade.php`, there was a commented-out `@foreach` directive:

```blade
{{--
<meta name="theme-color" content="#ffffff">

@foreach (config('app.locales') as $locale => $lang)
    <link rel="alternate" hreflang="{{ $locale }}" href="...">
@endforeach
--}}
```

**Problem**: Blade still parses directives inside comment blocks, so the `@foreach` was being parsed but had no matching `@endforeach` before the comment ended.

## Solution

Removed the problematic `@foreach` directive from the comment:

```blade
{{-- Theme color and localized routes (commented out for now)
<meta name="theme-color" content="#ffffff">
--}}
```

## Critical Rule

**NEVER put Blade directives inside comment blocks** unless they are complete and balanced.

### ❌ WRONG:
```blade
{{--
@if($condition)
    <div>Content</div>
--}}
```

### ✅ CORRECT:
```blade
{{-- Simple comment without directives --}}
```

Or, if you need to comment out directives:

```blade
@if(false)
    @if($condition)
        <div>Content</div>
    @endif
@endif
```

## Files Modified

- `/Modules/Cms/resources/views/components/metatags.blade.php` (lines 50-56)

## Commands Run

```bash
php artisan view:clear
php artisan optimize:clear
```

## Lesson Learned

**Blade comments `{{-- --}}` do NOT prevent directive parsing**. Any `@directive` inside a comment block will still be parsed by Blade's compiler, which can cause syntax errors if directives are not properly closed.

**Better approaches**:
1. Remove the directive entirely
2. Use `@if(false)` instead of comments for conditional code
3. Use HTML comments `<!-- -->` for non-directive content

---

**Date**: [DATE]
**Status**: ✅ RESOLVED
