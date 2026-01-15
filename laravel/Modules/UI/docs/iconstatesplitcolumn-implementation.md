# IconStateSplitColumn Implementation

## Overview
The `IconStateSplitColumn` is a custom Filament table column component designed to display state transition icons in a compact, responsive grid layout. It extends Filament's `Column` component to provide an optimized user experience for state management in tables.
## Key Features
# IconStateSplitColumn Implementation

## Overview
The `IconStateSplitColumn` is a custom Filament table column component designed to display state transition icons in a compact, responsive grid layout. It extends Filament's `Column` component to provide an optimized user experience for state management in tables.
## Key Features
### 🎯 **Space Optimization**
- **Compact Design**: Minimizes table space usage while maintaining full functionality
- **Responsive Grid**: Adapts column count based on screen size
- **Efficient Layout**: Icons are arranged in a grid to maximize space utilization

### 📱 **Responsive Design**
- **Mobile**: 2 columns for touch-friendly interaction
- **Small screens**: 3 columns for better visibility
- **Medium screens**: 4 columns for optimal balance
- **Large screens**: 5 columns for enhanced layout
- **Extra large screens**: 6 columns for maximum utilization

### 🎨 **Enhanced UX/UI**
- **Hover Effects**: Smooth scale animation and color transitions
- **Visual Feedback**: Clear indication of interactive elements
- **Consistent Styling**: State-specific colors and icons throughout
- **Accessibility**: Full keyboard navigation and screen reader support

### 🔧 **Technical Features**
- **Error Handling**: Comprehensive error catching and user-friendly notifications
- **Modal Integration**: Enhanced modal dialogs with state-specific styling
- **Performance**: Optimized rendering and efficient state calculations
- **Clean Code**: Proper PHPDoc, consistent formatting, and maintainable structure
## Implementation
### Basic Usage
```php
use Modules\UI\Filament\Tables\Columns\IconStateSplitColumn;
use Modules\<nome modulo>\States\Appointment\AppointmentState;
use Modules\<nome modulo>\Models\Appointment;
use Modules\<nome modulo>\States\Appointment\AppointmentState;
use Modules\<nome modulo>\Models\Appointment;
use Modules\<nome modulo>\States\Appointment\AppointmentState;
use Modules\<nome modulo>\Models\Appointment;
use Modules\<nome progetto>\States\Appointment\AppointmentState;
use Modules\<nome progetto>\Models\Appointment;

## Implementation
### Basic Usage
```php
use Modules\UI\Filament\Tables\Columns\IconStateSplitColumn;
use Modules\<nome modulo>\States\Appointment\AppointmentState;
use Modules\<nome modulo>\Models\Appointment;
use Modules\<nome progetto>\States\Appointment\AppointmentState;
use Modules\<nome progetto>\Models\Appointment;

use Modules\<nome modulo>\States\Appointment\AppointmentState;
use Modules\<nome modulo>\Models\Appointment;

use Modules\<nome modulo>\States\Appointment\AppointmentState;
use Modules\<nome modulo>\Models\Appointment;

// In your Filament resource table configuration
'states' => IconStateSplitColumn::make()
    ->stateClass(AppointmentState::class, Appointment::class),
```

### Advanced Configuration
// Custom configuration

### Advanced Configuration
// Custom configuration
### Advanced Configuration
// Custom configuration
    ->stateClass(AppointmentState::class, Appointment::class)
    ->label('Azioni Stato')
    ->extraAttributes([
        'class' => 'custom-state-grid gap-2 p-2',
    ]),
```

## Architecture
### Class Structure
```

## Architecture
### Class Structure
## Architecture
### Class Structure
class IconStateSplitColumn extends Column
{
    protected string $view = 'ui::filament.tables.columns.icon-state-split';
    protected string $stateClass = '';
    protected string $modelClass = '';

    protected function setUp(): void
    {
        parent::setUp();
        $this->label('Stati');
    }
    public function stateClass(string $stateClass, string $modelClass): static
        // Configure states and model
    public function getRecordStates(): array
        // Return array of available states
    public function canTransitionTo($recordId, $stateClass): bool
        // Check if transition is possible
}
### State Integration
The component integrates with Spatie's Laravel State package:

    public function stateClass(string $stateClass, string $modelClass): static
        // Configure states and model
    public function getRecordStates(): array
        // Return array of available states
    public function canTransitionTo($recordId, $stateClass): bool
        // Check if transition is possible
}
### State Integration
The component integrates with Spatie's Laravel State package:
1. **State Mapping**: Uses `getStateMapping()` to retrieve available states
2. **State Validation**: Checks current state for transition possibilities
3. **Error Handling**: Comprehensive error catching with logging
4. **Performance**: Efficient state calculations with proper caching

## Visual Design

## Visual Design

## Visual Design

## Visual Design

## Visual Design

## Visual Design

## Visual Design

## Visual Design
## Visual Design
### Grid Layout
- **Responsive Breakpoints**: Automatically adjusts column count based on screen size
- **Gap Management**: Consistent spacing between icons (gap-1)
- **Padding**: Minimal padding (p-1) for compact appearance

### Icon Design
- **Size**: 32px (2rem) for optimal touch targets
- **Shape**: Circular buttons with rounded-full class
- **Colors**: State-specific colors with hover effects
- **Transitions**: Smooth scale and color transitions

### Interactive Elements
- **Hover Effects**: Scale up to 110% on hover
- **Focus States**: Ring focus indicators for accessibility
- **Tooltips**: Enhanced tooltips with arrow indicators
- **Disabled States**: Reduced opacity for unavailable actions

## Template Structure

## Template Structure

## Template Structure

## Template Structure

## Template Structure

## Template Structure

## Template Structure

## Template Structure
## Template Structure
### Blade Template Features
- **Responsive Grid**: CSS Grid with responsive breakpoints
- **State Validation**: Checks for record existence and state transitions
- **Icon Rendering**: Uses Filament's icon component
- **Action Integration**: Wire:click for modal dispatching
- **Accessibility**: Proper ARIA labels and keyboard navigation

### CSS Classes
```css
.state-icon-button {
    min-width: 2rem;
    min-height: 2rem;
    transition: all 0.2s ease;
}

.state-icon-button:hover {
    transform: scale(1.1);
## Best Practices
}

.state-icon-button:hover {
    transform: scale(1.1);
## Best Practices
.state-icon-button:hover {
    transform: scale(1.1);
## Best Practices
### DRY (Don't Repeat Yourself)
- **Reusable State Logic**: Centralized state transition validation
- **Consistent Styling**: Shared CSS classes and design patterns
- **Template Reuse**: Single template handles all state types

### KISS (Keep It Simple, Stupid)
- **Simple API**: Single method `stateClass()` for configuration
- **Clear Logic**: Straightforward state validation and rendering
- **Minimal Dependencies**: Only depends on Filament core components

### UI/UX Focus
- **Touch-Friendly**: 32px minimum touch targets
- **Visual Feedback**: Clear hover and focus states
- **Progressive Enhancement**: Works without JavaScript
- **Accessibility**: Full keyboard and screen reader support

## Error Handling

## Error Handling

## Error Handling

## Error Handling

## Error Handling

## Error Handling

## Error Handling

## Error Handling
## Error Handling
### Graceful Degradation
- **Missing States**: Handles empty state mappings gracefully
- **Invalid Records**: Validates record existence before processing
- **State Errors**: Catches and displays user-friendly error messages

### User Feedback
- **Success Notifications**: Confirms successful state transitions
- **Error Notifications**: Displays detailed error information
- **Loading States**: Visual feedback during transitions

## Performance Considerations

## Performance Considerations

## Performance Considerations

## Performance Considerations

## Performance Considerations

## Performance Considerations

## Performance Considerations

## Performance Considerations
## Performance Considerations
### Efficient Rendering
- **Lazy Loading**: Only renders visible state transitions
- **Caching**: State mappings are cached appropriately
- **Minimal DOM**: Compact HTML structure
### Memory Management
- **Clean References**: Proper cleanup of event listeners
- **Efficient Queries**: Optimized database queries for state checks
## Accessibility Features

### Memory Management
- **Clean References**: Proper cleanup of event listeners
- **Efficient Queries**: Optimized database queries for state checks
## Accessibility Features
### Keyboard Navigation
- **Tab Order**: Logical tab sequence through state buttons
- **Focus Indicators**: Clear visual focus indicators
- **Keyboard Actions**: Enter/Space key support for activation

### Screen Reader Support
- **ARIA Labels**: Proper labeling for screen readers
- **Role Attributes**: Correct semantic roles
- **State Announcements**: Dynamic state change announcements

## Mobile Optimization

## Mobile Optimization

## Mobile Optimization

## Mobile Optimization

## Mobile Optimization

## Mobile Optimization

## Mobile Optimization

## Mobile Optimization
## Mobile Optimization
### Touch Interface
- **Touch Targets**: 32px minimum for reliable touch interaction
- **Gesture Support**: Swipe and tap gesture recognition
- **Viewport Adaptation**: Responsive design for all screen sizes

### Performance
- **Reduced Animations**: Optimized animations for mobile devices
- **Efficient Rendering**: Minimal reflows and repaints
- **Battery Optimization**: Efficient event handling
## Integration Examples
### Appointment Management
// In AppointmentResource
'state_actions' => IconStateSplitColumn::make()
    ->label('Azioni'),
### Patient Records

## Integration Examples
### Appointment Management
// In AppointmentResource
'state_actions' => IconStateSplitColumn::make()
    ->label('Azioni'),
### Patient Records
// In PatientResource
'status_actions' => IconStateSplitColumn::make()
    ->stateClass(PatientState::class, Patient::class)
    ->label('Stato Paziente'),
```

## Troubleshooting
### Common Issues
```

## Troubleshooting
### Common Issues
## Troubleshooting
### Common Issues
1. **Icons Not Showing**
   - Check state class configuration
   - Verify state mapping exists
   - Ensure proper error handling

2. **Actions Not Working**
   - Verify modal action setup
   - Check state transition logic
   - Ensure proper error handling

2. **Actions Not Working**
   - Verify modal action setup
   - Check state transition logic
2. **Actions Not Working**
   - Verify modal action setup
   - Check state transition logic
2. **Actions Not Working**
   - Verify modal action setup
   - Check state transition logic
3. **Styling Issues**
   - Check CSS class conflicts
   - Verify responsive breakpoints
   - Test on different screen sizes

### Debug Tips

### Debug Tips

### Debug Tips

### Debug Tips

### Debug Tips

### Debug Tips

### Debug Tips

### Debug Tips
### Debug Tips
1. **Enable Debug Mode**: Check browser console for errors
2. **State Inspection**: Verify state instances are created correctly
3. **Modal Testing**: Test modal forms independently
4. **Accessibility Testing**: Use screen reader and keyboard navigation

## Recent Fixes (June 2025)

## Recent Fixes (June 2025)

## Recent Fixes (June 2025)

## Recent Fixes (June 2025)

## Recent Fixes (June 2025)

## Recent Fixes (June 2025)

## Recent Fixes (June 2025)

## Recent Fixes (June 2025)
## Recent Fixes (June 2025)
### Critical Bug Fixes
1. **State Initialization Error**: Fixed issue with `$field` property not being initialized
   - **Problem**: Creating State instance with model class instead of model instance
   - **Solution**: Use current state from record instead of creating new instance
   - **Impact**: Prevents "Typed property must not be accessed before initialization" error

2. **Action Integration**: Fixed wire:click not working in table columns
   - **Problem**: wire:click doesn't work in Filament table columns
   - **Solution**: Implemented custom JavaScript event system with Livewire integration
   - **Impact**: Enables proper action handling for state transitions

3. **Error Handling**: Added comprehensive error handling with logging
   - **Problem**: Unhandled exceptions causing application crashes
   - **Solution**: Try-catch blocks with proper error handling
   - **Impact**: Graceful degradation and better debugging

4. **Template Simplification**: Streamlined Blade template for better performance
   - **Problem**: Complex template logic causing rendering issues
   - **Solution**: Simplified template with proper error handling
   - **Impact**: Faster rendering and better reliability

### Action System Implementation
#### Problem Analysis
The main issue was that `wire:click` doesn't work directly in Filament table columns because they are not Livewire components. The solution implements a custom event system:

### Action System Implementation
#### Problem Analysis
The main issue was that `wire:click` doesn't work directly in Filament table columns because they are not Livewire components. The solution implements a custom event system:
### Action System Implementation
#### Problem Analysis
The main issue was that `wire:click` doesn't work directly in Filament table columns because they are not Livewire components. The solution implements a custom event system:
#### Solution Architecture
```javascript
// Custom event dispatch
onclick="window.dispatchEvent(new CustomEvent('state-transition', {
    detail: {
        recordId: {{ $record->id }},
        stateClass: '{{ $state['class']::class }}',
        action: 'prova'
    }
}))"
// Event listener for Livewire integration
document.addEventListener('state-transition', function(event) {
    const { recordId, stateClass, action } = event.detail;
    if (window.Livewire) {
        window.Livewire.find(document.querySelector('[wire\\:id]').getAttribute('wire:id'))
            .call(action, recordId, stateClass);
});

// Event listener for Livewire integration
document.addEventListener('state-transition', function(event) {
    const { recordId, stateClass, action } = event.detail;
    if (window.Livewire) {
        window.Livewire.find(document.querySelector('[wire\\:id]').getAttribute('wire:id'))
            .call(action, recordId, stateClass);
});
#### Key Features
1. **Custom Event System**: Uses JavaScript CustomEvent for action dispatching
2. **Livewire Integration**: Connects to parent Livewire component for server communication
3. **Error Handling**: Graceful fallback for missing Livewire context
4. **State Validation**: Checks transition possibility before showing actions

#### Usage Example
// In your Filament resource

#### Usage Example
// In your Filament resource
#### Usage Example
// In your Filament resource
// The component automatically handles:
// - State validation
// - Action dispatching
// - Error handling
// - UI feedback
```

```

```

```

```

```

### Code Quality Improvements
1. **DRY Principle**: Removed duplicate code and centralized logic
2. **KISS Principle**: Simplified API and reduced complexity
3. **Error Handling**: Added proper error handling without logging
4. **Type Safety**: Improved type checking and validation
5. **Action System**: Implemented proper action handling for table columns
**Compatibility**: Filament 3.x, Laravel 10.x
**Compatibility**: Filament 3.x, Laravel 10.x

---
**Last Updated**: June 2025
**Version**: 2.1
**Compatibility**: Filament 3.x, Laravel 10.x
**Compatibility**: Filament 3.x, Laravel 10.x
**Compatibility**: Filament 3.x, Laravel 10.x
**Compatibility**: Filament 3.x, Laravel 10.x
**Compatibility**: Filament 3.x, Laravel 10.x
**Compatibility**: Filament 3.x, Laravel 10.x

---
**Last Updated**: June 2025
**Version**: 2.1
**Compatibility**: Filament 3.x, Laravel 10.x
**Compatibility**: Filament 3.x, Laravel 10.x
**Compatibility**: Filament 3.x, Laravel 10.x
**Compatibility**: Filament 3.x, Laravel 10.x
---
**Last Updated**: June 2025
**Version**: 2.1
**Compatibility**: Filament 3.x, Laravel 10.x
# IconStateSplitColumn Implementation

## Overview

The `IconStateSplitColumn` is a custom Filament table column component designed to display state transition icons in a compact, responsive grid layout. It extends Filament's `Column` component to provide an optimized user experience for state management in tables.

## Key Features

### 🎯 **Space Optimization**
- **Compact Design**: Minimizes table space usage while maintaining full functionality
- **Responsive Grid**: Adapts column count based on screen size
- **Efficient Layout**: Icons are arranged in a grid to maximize space utilization

### 📱 **Responsive Design**
- **Mobile**: 2 columns for touch-friendly interaction
- **Small screens**: 3 columns for better visibility
- **Medium screens**: 4 columns for optimal balance
- **Large screens**: 5 columns for enhanced layout
- **Extra large screens**: 6 columns for maximum utilization

### 🎨 **Enhanced UX/UI**
- **Hover Effects**: Smooth scale animation and color transitions
- **Visual Feedback**: Clear indication of interactive elements
- **Consistent Styling**: State-specific colors and icons throughout
- **Accessibility**: Full keyboard navigation and screen reader support

### 🔧 **Technical Features**
- **Error Handling**: Comprehensive error catching and user-friendly notifications
- **Modal Integration**: Enhanced modal dialogs with state-specific styling
- **Performance**: Optimized rendering and efficient state calculations
- **Clean Code**: Proper PHPDoc, consistent formatting, and maintainable structure

## Implementation

### Basic Usage

```php
use Modules\UI\Filament\Tables\Columns\IconStateSplitColumn;
use Modules\<nome progetto>\States\Appointment\AppointmentState;
use Modules\<nome progetto>\Models\Appointment;

// In your Filament resource table configuration
'states' => IconStateSplitColumn::make()
    ->stateClass(AppointmentState::class, Appointment::class),
```

### Advanced Configuration

```php
// Custom configuration
'states' => IconStateSplitColumn::make()
    ->stateClass(AppointmentState::class, Appointment::class)
    ->label('Azioni Stato')
    ->extraAttributes([
        'class' => 'custom-state-grid gap-2 p-2',
    ]),
```

## Architecture

### Class Structure

```php
class IconStateSplitColumn extends Column
{
    protected string $view = 'ui::filament.tables.columns.icon-state-split';
    protected string $stateClass = '';
    protected string $modelClass = '';

    protected function setUp(): void
    {
        parent::setUp();
        $this->label('Stati');
    }

    public function stateClass(string $stateClass, string $modelClass): static
    {
        // Configure states and model
    }

    public function getRecordStates(): array
    {
        // Return array of available states
    }

    public function canTransitionTo($recordId, $stateClass): bool
    {
        // Check if transition is possible
    }
}
```

### State Integration

The component integrates with Spatie's Laravel State package:

1. **State Mapping**: Uses `getStateMapping()` to retrieve available states
2. **State Validation**: Checks current state for transition possibilities
3. **Error Handling**: Comprehensive error catching with logging
4. **Performance**: Efficient state calculations with proper caching

## Visual Design

### Grid Layout
- **Responsive Breakpoints**: Automatically adjusts column count based on screen size
- **Gap Management**: Consistent spacing between icons (gap-1)
- **Padding**: Minimal padding (p-1) for compact appearance

### Icon Design
- **Size**: 32px (2rem) for optimal touch targets
- **Shape**: Circular buttons with rounded-full class
- **Colors**: State-specific colors with hover effects
- **Transitions**: Smooth scale and color transitions

### Interactive Elements
- **Hover Effects**: Scale up to 110% on hover
- **Focus States**: Ring focus indicators for accessibility
- **Tooltips**: Enhanced tooltips with arrow indicators
- **Disabled States**: Reduced opacity for unavailable actions

## Template Structure

### Blade Template Features
- **Responsive Grid**: CSS Grid with responsive breakpoints
- **State Validation**: Checks for record existence and state transitions
- **Icon Rendering**: Uses Filament's icon component
- **Action Integration**: Wire:click for modal dispatching
- **Accessibility**: Proper ARIA labels and keyboard navigation

### CSS Classes
```css
.state-icon-button {
    min-width: 2rem;
    min-height: 2rem;
    transition: all 0.2s ease;
}

.state-icon-button:hover {
    transform: scale(1.1);
}
```

## Best Practices

### DRY (Don't Repeat Yourself)
- **Reusable State Logic**: Centralized state transition validation
- **Consistent Styling**: Shared CSS classes and design patterns
- **Template Reuse**: Single template handles all state types

### KISS (Keep It Simple, Stupid)
- **Simple API**: Single method `stateClass()` for configuration
- **Clear Logic**: Straightforward state validation and rendering
- **Minimal Dependencies**: Only depends on Filament core components

### UI/UX Focus
- **Touch-Friendly**: 32px minimum touch targets
- **Visual Feedback**: Clear hover and focus states
- **Progressive Enhancement**: Works without JavaScript
- **Accessibility**: Full keyboard and screen reader support

## Error Handling

### Graceful Degradation
- **Missing States**: Handles empty state mappings gracefully
- **Invalid Records**: Validates record existence before processing
- **State Errors**: Catches and displays user-friendly error messages

### User Feedback
- **Success Notifications**: Confirms successful state transitions
- **Error Notifications**: Displays detailed error information
- **Loading States**: Visual feedback during transitions

## Performance Considerations

### Efficient Rendering
- **Lazy Loading**: Only renders visible state transitions
- **Caching**: State mappings are cached appropriately
- **Minimal DOM**: Compact HTML structure

### Memory Management
- **Clean References**: Proper cleanup of event listeners
- **Efficient Queries**: Optimized database queries for state checks

## Accessibility Features

### Keyboard Navigation
- **Tab Order**: Logical tab sequence through state buttons
- **Focus Indicators**: Clear visual focus indicators
- **Keyboard Actions**: Enter/Space key support for activation

### Screen Reader Support
- **ARIA Labels**: Proper labeling for screen readers
- **Role Attributes**: Correct semantic roles
- **State Announcements**: Dynamic state change announcements

## Mobile Optimization

### Touch Interface
- **Touch Targets**: 32px minimum for reliable touch interaction
- **Gesture Support**: Swipe and tap gesture recognition
- **Viewport Adaptation**: Responsive design for all screen sizes

### Performance
- **Reduced Animations**: Optimized animations for mobile devices
- **Efficient Rendering**: Minimal reflows and repaints
- **Battery Optimization**: Efficient event handling

## Integration Examples

### Appointment Management
```php
// In AppointmentResource
'state_actions' => IconStateSplitColumn::make()
    ->stateClass(AppointmentState::class, Appointment::class)
    ->label('Azioni'),
```

### Patient Records
```php
// In PatientResource
'status_actions' => IconStateSplitColumn::make()
    ->stateClass(PatientState::class, Patient::class)
    ->label('Stato Paziente'),
```

## Troubleshooting

### Common Issues

1. **Icons Not Showing**
   - Check state class configuration
   - Verify state mapping exists
   - Ensure proper error handling

2. **Actions Not Working**
   - Verify modal action setup
   - Check state transition logic
   - Ensure proper error handling

3. **Styling Issues**
   - Check CSS class conflicts
   - Verify responsive breakpoints
   - Test on different screen sizes

### Debug Tips

1. **Enable Debug Mode**: Check browser console for errors
2. **State Inspection**: Verify state instances are created correctly
3. **Modal Testing**: Test modal forms independently
4. **Accessibility Testing**: Use screen reader and keyboard navigation

## Recent Fixes (June 2025)

### Critical Bug Fixes
1. **State Initialization Error**: Fixed issue with `$field` property not being initialized
   - **Problem**: Creating State instance with model class instead of model instance
   - **Solution**: Use current state from record instead of creating new instance
   - **Impact**: Prevents "Typed property must not be accessed before initialization" error

2. **Action Integration**: Fixed wire:click not working in table columns
   - **Problem**: wire:click doesn't work in Filament table columns
   - **Solution**: Implemented custom JavaScript event system with Livewire integration
   - **Impact**: Enables proper action handling for state transitions

3. **Error Handling**: Added comprehensive error handling with logging
   - **Problem**: Unhandled exceptions causing application crashes
   - **Solution**: Try-catch blocks with proper error handling
   - **Impact**: Graceful degradation and better debugging

4. **Template Simplification**: Streamlined Blade template for better performance
   - **Problem**: Complex template logic causing rendering issues
   - **Solution**: Simplified template with proper error handling
   - **Impact**: Faster rendering and better reliability

### Action System Implementation

#### Problem Analysis
The main issue was that `wire:click` doesn't work directly in Filament table columns because they are not Livewire components. The solution implements a custom event system:

#### Solution Architecture
```javascript
// Custom event dispatch
onclick="window.dispatchEvent(new CustomEvent('state-transition', {
    detail: {
        recordId: {{ $record->id }},
        stateClass: '{{ $state['class']::class }}',
        action: 'prova'
    }
}))"

// Event listener for Livewire integration
document.addEventListener('state-transition', function(event) {
    const { recordId, stateClass, action } = event.detail;

    if (window.Livewire) {
        window.Livewire.find(document.querySelector('[wire\\:id]').getAttribute('wire:id'))
            .call(action, recordId, stateClass);
    }
});
```

#### Key Features
1. **Custom Event System**: Uses JavaScript CustomEvent for action dispatching
2. **Livewire Integration**: Connects to parent Livewire component for server communication
3. **Error Handling**: Graceful fallback for missing Livewire context
4. **State Validation**: Checks transition possibility before showing actions

#### Usage Example
```php
// In your Filament resource
'states' => IconStateSplitColumn::make()
    ->stateClass(AppointmentState::class, Appointment::class),

// The component automatically handles:
// - State validation
// - Action dispatching
// - Error handling
// - UI feedback
```

### Code Quality Improvements
1. **DRY Principle**: Removed duplicate code and centralized logic
2. **KISS Principle**: Simplified API and reduced complexity
3. **Error Handling**: Added proper error handling without logging
4. **Type Safety**: Improved type checking and validation
5. **Action System**: Implemented proper action handling for table columns

---

**Last Updated**: June 2025
**Version**: 2.1
**Compatibility**: Filament 3.x, Laravel 10.x
**Compatibility**: Filament 3.x, Laravel 10.x
**Compatibility**: Filament 3.x, Laravel 10.x
