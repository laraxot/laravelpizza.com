---
name: header-design-colors-rule
description: Header dropdowns (language and user) must follow Design’Comuni colour palette and UI patterns
type: project
---

## Rule Overview

The **User module** header contains two dropdown menus:
1. **Language selector**
2. **User profile** (avatar, nickname, personal-services dropdown)

Both dropdowns must **exactly match** the visual style defined in the Design’Comuni specification:
https://italia.github.io/design-comuni-pagine-statiche/servizi/graduatoria-area-personale.html

### Visual Requirements
- **Background colour**: `#0066CC` (primary Blue from Design Comuni palette)
- **Hover/active state**: `#004C99` (darker Blue)
- **Text colour**: `#FFFFFF` (white) for both the selected item and menu items
- **Icon colour**: use the same white colour for SVG icons inside the dropdown
- **Border**: none – dropdown is rendered as a flat button with a subtle bottom-border only on focus (`1px solid #005B99`).
- **Rounded corners**: `4px`
- **Spacing**: 8 × between icon and text, 12 × padding inside the dropdown.
- **Font**: `Montserrat`, weight `600`, size `14px` (as per Design Comuni typographic guide).

### Behavioural Requirements
- The dropdown must be **responsive**: collapse into a single “More” icon on screens `<768px` while preserving colours.
- When a language is selected, the label updates without a page reload (AJAX) – keep the same colour scheme.
- The user avatar must be a circular image `32 × 32px`, with a white border (`2px solid #FFFFFF`).
- The dropdown arrow should be an inline-SVG that inherits the white colour.

## Implementation Guidance (Blade / Livewire)
```blade
{{-- Header component (resources/views/layouts/header.blade.php) --}}
<nav class="header-nav">
    {{-- Language dropdown --}}
    <div class="dropdown language-dropdown">
        <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <span class="icon {{ app()->getLocale() }}-icon"></span>
            {{ strtoupper(app()->getLocale()) }}
        </button>
        <ul class="dropdown-menu">
            @foreach(['it','en','fr','de'] as $lang)
                <li>
                    <a class="dropdown-item" href="{{ route('locale.switch', $lang) }}">
                        {{ strtoupper($lang) }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>

    {{-- User dropdown (visible only when authenticated) --}}
    @auth
        <div class="dropdown user-dropdown">
            <button class="dropdown-toggle d-flex align-items-center" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="{{ Auth::user()->avatar_url ?? '/img/default-avatar.svg' }}" alt="Avatar" class="rounded-circle me-2" width="32" height="32">
                <span>{{ Auth::user()->nickname ?? Auth::user()->name }}</span>
                <svg class="icon dropdown-arrow ms-1" viewBox="0 0 24 24"><path d="M7 10l5 5 5-5" stroke="currentColor" stroke-width="2" fill="none"/></svg>
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{ route('services.index') }}">I miei servizi</a></li>
                <li><a class="dropdown-item" href="{{ route('practices.index') }}">Le mie pratiche</a></li>
                <li><a class="dropdown-item" href="{{ route('notifications.index') }}">Notifiche</a></li>
                <li><a class="dropdown-item" href="{{ route('settings.index') }}">Impostazioni</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form method="POST" action="{{ route('logout') }}" class="logout-form">
                        @csrf
                        <button type="submit" class="dropdown-item">Logout</button>
                    </form>
                </li>
            </ul>
        </div>
    @endauth
</nav>
```

### SCSS (resources/sass/_header.scss)
```scss
.header-nav {
  display: flex;
  align-items: center;
  .dropdown-toggle {
    background-color: #0066CC;
    color: #fff;
    border: none;
    border-radius: 4px;
    padding: 8px 12px;
    font-family: 'Montserrat', sans-serif;
    font-weight: 600;
    font-size: 14px;
    display: flex;
    align-items: center;
    &:hover, &:focus {
      background-color: #004C99;
    }
    .icon {
      fill: #fff;
      margin-right: 8px;
    }
    .dropdown-arrow {
      width: 12px;
      height: 12px;
      margin-left: 4px;
    }
  }
  .dropdown-menu {
    background-color: #0066CC;
    border: none;
    .dropdown-item {
      color: #fff;
      &:hover, &:focus {
        background-color: #004C99;
      }
    }
    .dropdown-divider {
      border-top: 1px solid rgba(255,255,255,0.2);
    }
  }
}
```

## Validation Checklist
- [ ] Header background and dropdown button background colour `#0066CC`
- [ ] Hover/active state `#004C99`
- [ ] Text colour white `#FFFFFF`
- [ ] Avatar circular 32 × 32 × with white border
- [ ] Dropdown arrow SVG inherits `currentColor`
- [ ] Font Montserrat 600 / 14 ×
- [ ] No border on button, only focus border `1px solid #005B99`
- [ ] Responsive collapse below 768 ×
- [ ] All colour values match Design Comuni palette exactly

## Related Rules
- **Header Authentication Flow** – ensures correct content based on auth state (`header-auth-flow-rule`).
- **Navigation Properties Rule** – static navigation properties must be avoided (`navigation-properties-rule`).
- **5-‗Element Translation Rule** – keep translation entries consistent.

---
*Rule created to enforce UI consistency with the official Design Comuni guidelines. Any deviation should be corrected immediately to maintain visual uniformity across the application.*