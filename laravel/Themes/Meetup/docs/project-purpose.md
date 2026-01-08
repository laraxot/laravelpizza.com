# Project Purpose: Laravel Pizza Meetups

## Overview
**Laravel Pizza Meetups** is a community-driven web platform dedicated to connecting developers within the Laravel ecosystem (including Filament and Livewire). The project aims to facilitate the organization of local meetups, knowledge sharing, and professional networking, all centered around the shared love for code and pizza.

## Core Objectives
1.  **Community Building**: Create a central hub for Laravel developers to connect, chat, and collaborate.
2.  **Event Management**: Provide a robust system for organizing and discovering local meetups and events.
3.  **Knowledge Sharing**: Foster an environment for learning through workshops, talks, and community discussions.

## Technical Scope & Implementation

### Architecture
-   **Framework**: Laravel (PHP)
-   **Frontend**: Laravel Folio pages with Volt/Livewire components, styled with Tailwind CSS and Alpine.js for client-side enhancements.
-   **Build Tool**: Vite
-   **Modularity**: The project uses `nwidart/laravel-modules` to organize features into distinct modules (e.g., `Meetup`, `User`, `Activity`).

### Front Office Architecture (Folio + Volt)
-   **Laravel Folio**: File-based routing system (NO controllers/routes in web.php/api.php)
    -   Pages automatically created from Blade files in `/resources/views/pages/`
    -   Example: `/resources/views/pages/events/index.blade.php` → `/events`
-   **Laravel Volt**: Declarative components with PHP logic and Blade templates in single files
    -   Reduces boilerplate code
    -   Enables reactive UIs without traditional controllers
-   **File Structure**:
    -   `/Themes/Meetup/resources/views/pages/` - Public-facing pages managed by Folio
    -   `/Themes/Meetup/resources/views/components/` - Reusable Volt/Livewire components
    -   `/Themes/Meetup/resources/views/layouts/` - Page layouts

### Critical Implementation Rule
-   **Front Office**: Use ONLY Folio + Volt + Livewire (NO controllers)
-   **Back Office**: Use traditional controllers and routes (Filament admin)
-   **NEVER** write routes in web.php/api.php for front office functionality
-   **NEVER** create controllers for front office pages (use Folio + Volt instead)

### Current Development State (Meetup Theme)
The `Meetup` theme is currently in the prototyping phase, located at `laravel/Themes/Meetup/resources/html`.

#### Key Components
-   **Navigation**: A responsive, reusable header component implemented via JavaScript injection (`js/navigation.js`). It includes:
    -   Logo and branding
    -   Navigation links (Home, Events, Chat)
    -   Language selection dropdown
    -   Authentication links (Login/Register)
    -   Mobile menu toggle
-   **Footer**: A standardized footer component implemented via JavaScript injection (`js/footer.js`), containing:
    -   Project branding and mission statement
    -   Quick links to resources and community pages
    -   Social media links
-   **Pages**:
    -   `index.html`: Landing page with event highlights and community features.
    -   `events.html`: Listing of upcoming meetups and events.
    -   `login.html` / `register.html`: User authentication pages.
    -   `chat.html`: Community chat interface (placeholder).

### Design System
-   **Styling**: Tailwind CSS is used for utility-first styling, ensuring a modern and responsive design.
-   **Interactivity**: Alpine.js handles client-side interactions like dropdowns and mobile menus.
-   **Assets**: Standardized assets (logos, icons) are managed within the theme's resource directories.

## Future Roadmap
-   **Backend Integration**: Transition the static HTML prototypes into dynamic Folio pages powered by Livewire/Volt components.
-   **User Profiles**: Implement full user profile management and dashboard features using Volt components.
-   **Event Booking**: Add functionality for users to RSVP and book tickets for events with Volt-powered forms.
-   **Real-time Chat**: Integrate real-time chat functionality using Laravel Reverb or similar technologies with Volt components.
-   **Folio Route Structure**: Implement comprehensive file-based routing for all public pages.
-   **Volt Component Library**: Build reusable Volt components following the pizza metaphor design system.

## Folio + Volt Implementation Strategy

### Route Structure
The theme will implement Laravel Folio routing with the following structure:
- `/` - Homepage (index.blade.php)
- `/events` - Event listing (events/index.blade.php)
- `/events/{event}` - Event detail (events/[event].blade.php)
- `/profile/{user}` - User profile (profile/[user].blade.php)
- `/dashboard` - User dashboard (dashboard.blade.php)
- `/chat` - Community chat (chat.blade.php)

### Volt Component Guidelines
- All interactive elements will use Laravel Volt components
- Components will follow the pizza metaphor design system
- State management will be handled within Volt components
- Form validation will use Volt's built-in validation features
