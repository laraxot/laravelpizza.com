# Layout Best Practices - Meetup Theme

## Core Principles

- **Single-Column Layout**: All forms should use a single-column layout to guide the user's eye and simplify navigation, especially on mobile devices.
- **Logical Grouping**: Group related fields into logical sections (e.g., "Account Information", "Personal Details") to make forms appear less intimidating and easier to process.
- **Minimalism**: Embrace a minimalist design approach, focusing only on essential elements to reduce visual clutter and improve clarity.

## Implementation Guidelines

- **Form Width**: The registration form should have a maximum width to ensure readability on large screens, while remaining responsive and full-width on mobile. Avoid overly narrow, centered forms.
- **Spacing**: Use a consistent spacing system (e.g., an 8-point grid) for margins and padding to create a clean, organized visual hierarchy.
- **Headings**: Each form and section should have a clear, prominent heading.
- **Labels**: Position field labels directly above their corresponding input fields for optimal readability.

## Example

```
<div class="max-w-2xl mx-auto">
    <h1 class="text-3xl font-bold mb-8">Create Your Account</h1>

    <div class="space-y-6">
        <fieldset class="space-y-4">
            <legend class="text-lg font-medium">Account Information</legend>
            
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                <input type="email" id="email" name="email" class="mt-1 block w-full">
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" id="password" name="password" class="mt-1 block w-full">
            </div>
        </fieldset>

        <fieldset class="space-y-4">
            <legend class="text-lg font-medium">Personal Details</legend>
            
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                <input type="text" id="name" name="name" class="mt-1 block w-full">
            </div>
        </fieldset>
    </div>
</div>
```
