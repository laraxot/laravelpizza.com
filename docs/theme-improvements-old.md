# Laravel Pizza Meetups - HTML Theme Documentation

## Overview
This is the HTML theme for **Laravel Pizza Meetups**, a community platform for Laravel, Filament, and Livewire developers who meet for pizza and knowledge sharing.

**IMPORTANT**: This is **NOT** a pizzeria website. It's a **meetup/community platform** for developers.

## Design System

### Color Palette

#### Primary - Red (Meetup Brand)
- **red-600** (#dc2626) - Primary buttons, links, accents
- **red-700** (#b91c1c) - Hover states
- **red-500** (#ef4444) - Bright accents, icons

#### Background - Dark Theme
- **slate-900** (#0f172a) - Main background
- **slate-800** (#1e293b) - Cards, navigation
- **slate-700** (#334155) - Borders, dividers
- **slate-950** (#020617) - Footer, deepest sections

#### Text Colors
- **white** - Primary text on dark backgrounds
- **gray-300** - Secondary text, navigation links
- **gray-400** - Tertiary text, metadata
- **gray-500** - Disabled states

### Typography
- **Font Family**: Inter (Google Fonts)
- **Weights**: 400 (regular), 500 (medium), 600 (semibold), 700 (bold), 800 (extrabold)

### Components

#### Buttons
```html
<!-- Primary Button (Red) -->
<button class="bg-red-600 hover:bg-red-700 text-white px-8 py-4 rounded-lg font-semibold">
    Join the Community
</button>

<!-- Secondary Button (White) -->
<button class="bg-white text-red-600 hover:bg-gray-100 px-8 py-4 rounded-lg font-semibold">
    Create Account
</button>

<!-- Outline Button -->
<button class="border-2 border-gray-600 hover:border-gray-500 text-white px-8 py-4 rounded-lg">
    View Events
</button>
```

#### Event Cards
```html
<div class="bg-slate-800 border border-slate-700 rounded-xl overflow-hidden hover:border-red-500/50">
    <div class="bg-gradient-to-r from-red-600 to-red-700 p-6">
        <div class="text-sm font-semibold text-red-100">Laravel Meetup</div>
        <h3 class="text-2xl font-bold text-white">Pizza & Code</h3>
    </div>
    <div class="p-6">
        <!-- Event details -->
    </div>
</div>
```

#### Feature Cards
```html
<div class="bg-slate-800/50 backdrop-blur-sm border border-slate-700 rounded-xl p-8 hover:border-red-500/50">
    <div class="bg-red-500/10 w-16 h-16 rounded-lg flex items-center justify-center mb-6">
        <svg class="w-8 h-8 text-red-500"><!-- icon --></svg>
    </div>
    <h3 class="text-xl font-bold text-white mb-3">Feature Title</h3>
    <p class="text-gray-400">Feature description</p>
</div>
```

## Page Structure

### Home Page (index.html)

**Purpose**: Community landing page showcasing the meetup platform

**Sections**:
1. **Navigation**
   - Logo: Laravel Pizza Meetups
   - Links: Home, Events, Community Chat, Language Selector
   - Auth: Login, Sign Up

2. **Hero Section**
   - Pizza icon (red triangle/slice)
   - Heading: "Laravel Developers. Pizza. Community."
   - Subheading: "Join fellow Laravel, Filament, and Livewire enthusiasts..."
   - CTAs: "Join the Community", "View Events"

3. **Why Join Section**
   - 4 feature cards:
     - Regular Meetups (calendar icon)
     - Growing Community (people icon)
     - Multiple Locations (map icon)
     - Real-time Chat (chat icon)

4. **Upcoming Events Preview**
   - 3 event cards with:
     - Event type badge
     - Event title
     - Date/time
     - Location
     - "View Details" button

5. **CTA Section**
   - Red gradient background
   - "Ready to Join?" heading
   - Sign up and browse events CTAs

6. **Footer**
   - Links: Community, Events, Resources
   - Social media icons
   - Copyright info

### Events Page (events.html)

**Purpose**: List and filter community meetup events

**Features**:
- Event categories (Laravel, Filament, Livewire, Workshops)
- Date filters
- Location filters
- Registration functionality
- Event details modal/page

## Key Differences from Pizzeria Theme

| Aspect | ❌ Pizzeria (Wrong) | ✅ Meetup (Correct) |
|--------|---------------------|---------------------|
| **Purpose** | Sell pizzas online | Organize developer meetups |
| **Background** | Red/bright colors | Dark slate theme |
| **Navigation** | Menu, Cart, Order | Events, Community Chat, Login |
| **Content** | Pizza products | Event listings |
| **CTA** | "Order Now" | "Join Community" |
| **Features** | Shopping cart, payment | Event registration, chat |
| **Footer** | Pizza menu links | Community resources |

## File Structure

```
Themes/Meetup/resources/html/
├── index.html              # Homepage (meetup platform)
├── events.html             # Events listing
├── css/
│   └── app.css            # Dark theme styles
├── js/
│   └── app.js             # Community features
└── dist/
    ├── css/
    │   └── main.css       # Compiled CSS (34KB)
    └── js/
        └── app.js         # Compiled JS

Backup Files:
├── index.html.pizzeria.backup  # Old pizzeria version (incorrect)
```

## Tech Stack

- **Tailwind CSS 4** with @theme syntax
- **Vite 7** for builds
- **Vanilla JavaScript** for interactions
- **Inter Font** from Google Fonts

## Build Commands

```bash
# Development
npm run dev

# Production build
npm run build

# Output
dist/css/main.css  34.17 kB │ gzip: 6.04 kB
```

## Accessibility Features

### ARIA Labels
```html
<nav role="navigation" aria-label="Main navigation">
<button aria-expanded="false" aria-controls="mobile-menu">
```

### Semantic HTML
- `<nav>`, `<header>`, `<footer>`, `<section>` properly used
- Proper heading hierarchy (h1 → h2 → h3)

### Keyboard Navigation
- Focus states on all interactive elements
- Tab order follows visual flow
- Mobile menu keyboard accessible

## Schema.org Markup

```json
{
  "@context": "https://schema.org",
  "@type": "Organization",
  "name": "Laravel Pizza Meetups",
  "description": "Community of Laravel developers who meet for pizza and knowledge sharing",
  "url": "https://laravelpizza.com"
}
```

## JavaScript Features

### Mobile Menu Toggle
```javascript
document.getElementById('mobile-menu-button').addEventListener('click', function() {
    const menu = document.getElementById('mobile-menu');
    const isHidden = menu.classList.contains('hidden');
    menu.classList.toggle('hidden');
    this.setAttribute('aria-expanded', !isHidden);
});
```

### Smooth Scrolling
```html
<html class="scroll-smooth">
```

## Future Improvements

### Phase 1 - Essential Features
1. **Event Registration System**
   - User authentication
   - RSVP functionality
   - Attendee list
   - Capacity management

2. **Community Chat Integration**
   - Real-time messaging
   - Channel/room system
   - User presence indicators

3. **User Profiles**
   - Developer profiles
   - Skills/interests
   - Meetup history

### Phase 2 - Enhanced Features
4. **Event Calendar**
   - Month/week/day views
   - iCal export
   - Recurring events

5. **Location Search**
   - Find meetups near you
   - Map integration
   - Multiple city support

6. **Notifications**
   - Email notifications for new events
   - Reminder notifications
   - Chat mentions

### Phase 3 - Community Features
7. **Discussion Forums**
   - Topic-based discussions
   - Code sharing
   - Q&A section

8. **Resource Library**
   - Laravel tutorials
   - Filament guides
   - Livewire examples

9. **Meetup Photos/Videos**
   - Event galleries
   - Video recordings
   - Highlights

## Design Principles

### 1. Developer-First
- Clean, professional design
- No gimmicks or excessive animations
- Focus on content and functionality

### 2. Dark Theme
- Reduce eye strain for developers
- Professional appearance
- Red accent for brand recognition

### 3. Community Focus
- Emphasize connections between people
- Show upcoming events prominently
- Make it easy to join and participate

### 4. Mobile-First
- Responsive design
- Touch-friendly interactions
- Fast loading on mobile

## Integration with Laravel Backend

### Expected API Endpoints
```php
// Events
GET  /api/events           - List all events
GET  /api/events/{id}      - Event details
POST /api/events/{id}/rsvp - Register for event

// Community
GET  /api/community/chat   - Chat messages
POST /api/community/chat   - Send message

// User
GET  /api/user/profile     - User profile
PUT  /api/user/profile     - Update profile
GET  /api/user/events      - User's registered events
```

### Livewire Components
```php
// Expected Livewire components
<livewire:event-list />
<livewire:event-details :event="$event" />
<livewire:rsvp-button :event="$event" />
<livewire:community-chat />
<livewire:user-profile />
```

## Conclusion

This theme is designed for **Laravel Pizza Meetups**, a **community platform** where Laravel developers meet for pizza and knowledge sharing. It is **NOT** a pizzeria website for ordering food.

**Key Features**:
- ✅ Dark professional theme (slate colors)
- ✅ Red accent color for brand
- ✅ Event-focused content
- ✅ Community features (chat, profiles)
- ✅ Mobile-responsive design
- ✅ Accessibility compliant

**NOT Included** (pizzeria features):
- ❌ Shopping cart
- ❌ Menu with food products
- ❌ Order/checkout system
- ❌ Payment processing
- ❌ Delivery tracking

For the actual meetup platform implementation, integrate this theme with:
- Laravel 11 backend
- Filament 4 admin panel
- Livewire 3 components
- Laravel Folio for routing

**Reference**: See laravelpizza.com for the live implementation.
