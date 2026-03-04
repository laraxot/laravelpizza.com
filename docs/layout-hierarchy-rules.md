# Layout Hierarchy Rules

## Overview
The project uses a strict layout hierarchy to ensure consistency and maintainability.

## Layouts

### 1. `x-layouts.main`
- **Purpose**: The absolute barebones HTML document structure.
- **Content**: `<!DOCTYPE html>`, `<html>`, `<head>` (with `<x-metatags />`), `<body>`.
- **Usage**: This is the foundation for all other layouts. It should rarely be used directly by pages unless they need complete control over the body content without any wrapping structure.

### 2. `x-layouts.app`
- **Purpose**: The primary application layout.
- **Extends**: `x-layouts.main`
- **Content**: Includes the site's consistent header/navigation (`<x-header />`) and footer (`<x-footer />`).
- **Usage**: This is the default layout for most public-facing pages (Home, Events, Contact, etc.).

### 3. `x-layouts.guest`
- **Purpose**: Layout for authentication-related pages.
- **Extends**: `x-layouts.main`
- **Content**: A simplified layout, typically centered content, without the full site navigation/footer to minimize distractions.
- **Usage**: Login, Registration, Password Recovery, etc.

## Implementation Details
- **Blade Components**: All layouts are implemented as Blade components in `Themes/Meetup/resources/views/components/layouts/`.
- **Slots**: Use `$slot` for the main content.
