---
name: header-auth-flow-rule
description: Header authentication flow rule for User module
type: project
---

## Rule Overview

**Dynamic Header Content Based on Authentication State**  

The header of pages within the User module must display different content based on whether the user is authenticated:

### Unauthenticated State
- Shows "Accedi all'area personale"
- May include "Login" or "Register" calls-to-action

### Authenticated State
- Displays user avatar (avatar image)
- Shows nickname (username or display name)
- Provides dropdown menu with personalized actions:
  - Access to user's services
  - Access to practices
  - Access to notifications
  - Access to settings
  - Logout option

### Implementation Requirements
- Use Laravel's `Auth::check()` to determine authentication state in Blade templates
- For authenticated users, render the dropdown with the following structure:
  ```blade
  @auth
      <div class="user-menu">
          <img src="avatar-url" alt="Avatar">
          <span class="nickname">User Nickname</span>
          <div class="dropdown">
              <a href="{{ route('services.show') }}">My Services</a>
              <a href="{{ route('practices.show') }}">My Practices</a>
              <a href="{{ route('notifications.index') }}">Notifications</a>
              <a href="{{ route('settings.index') }}">Settings</a>
              <form action="{{ route('logout') }}" method="POST" class="logout-form">
                  @csrf
                  <button type="submit">Logout</button>
              </form>
          </div>
      </div>
  @endauth
  ```
- Ensure proper route protection with `auth` middleware for all personalized routes

### Security Considerations
- Always verify CSRF protection on logout forms
- Use HTTPS for all form submissions
- Ensure route definitions are properly secured with authenticated middleware

### Documentation Reference
- See `Modules/User/docs/wiki/rules/header-auth-flow.md` for this rule
- Refer to `Modules/User/docs/wiki/rules/navigation-properties.md` for navigation static properties restrictions

### Related Rules
- **Navigation Properties Rule** - Do not use static navigation properties from non-XotBasePage classes
- **5-Element Translation Rule** - All translation entries must follow the structured format
- **Dynamic UI Adaptation** - Header content must adapt based on authentication state
