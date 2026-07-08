# Advanced ManageRelatedRecords - One Theme

## The "Sexy" Experience
The 'One' theme elevates the related record management with refined aesthetics and modern interactive patterns.

## Visual Enhancements
### 1. Glassmorphism & Shadowing
- Relational tables are contained in clean cards with subtle shadows (`shadow-sm`) and rounded corners (`rounded-xl`).
- Hover effects on rows use a light primary tint (`bg-primary-50/50`) to provide immediate feedback.

### 2. Micro-interactions
- **Modal Animations**: Slide-overs are preferred for creating/editing relations to keep the parent record visible in the background.
- **Button Vibrancy**: Primary buttons use gradients and scale slightly on hover.

### 3. Rich Data Visualization
- **Counters**: Display record counts in the navigation label as a badge.
- **Indicators**: Use tiny dot indicators for status instead of full badges when space is tight.

## Implementation Details
Use the `XotBaseManageRelatedRecords` patterns documented in `Xot` module to ensure the theme can extract labels and icons automatically.

```php
// Sexy One-Theme Column Example
TextColumn::make('progress')
    ->numeric()
    ->suffix('%')
    ->color('primary')
    ->weight('bold');
```
