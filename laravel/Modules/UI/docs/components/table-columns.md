# Table Columns Components

## Overview
This document describes the custom table column components in the UI module, specifically designed for state management and visual representation in Filament tables.
## IconStateSplitColumn
### Purpose
The `IconStateSplitColumn` is designed to display multiple state transition icons in a compact grid layout within a single table column. Each icon represents a possible state transition that can be performed on the record.
### Enhanced Features (After Refactoring)
1. **Responsive Grid Layout**: Configures grid with appropriate columns for different screen sizes
   - Mobile: 2 columns
   - Small screens: 3 columns
   - Medium screens: 4 columns
   - Large screens: 5 columns
   - Extra large screens: 6 columns
2. **Optimized Space Usage**:
   - Compact design that minimizes table space usage
   - Efficient grid layout that maximizes space utilization
   - Small icons (32px) for maximum compactness
3. **Enhanced UX/UI**:
   - Smooth hover effects with scale animations
   - Clear visual feedback for interactive elements
   - Consistent styling with state-specific colors
   - Full accessibility support with keyboard navigation
4. **Technical Features**:
   - Comprehensive error handling with user-friendly notifications
   - Enhanced modal dialogs with state-specific styling
   - Optimized rendering and efficient state calculations
   - Clean code with proper PHPDoc and maintainable structure
### Basic Usage
```php
use Modules\UI\Filament\Tables\Columns\IconStateSplitColumn;
use Modules\<nome modulo>\States\Appointment\AppointmentState;
use Modules\<nome modulo>\Models\Appointment;
use Modules\<nome progetto>\States\Appointment\AppointmentState;
use Modules\<nome progetto>\Models\Appointment;
// In your Filament resource table configuration
'states' => IconStateSplitColumn::make()
    ->stateClass(AppointmentState::class, Appointment::class),
```
### Wire:Click Action Problem and Solution
**Problem**: The `wire:click` in Blade views cannot directly call methods from Column classes because Columns are not Livewire components.
**Solution**: Use Filament's Action system to handle icon clicks properly. The Column class should register actions that can be triggered from the Blade view.
### Implementation Pattern
// In IconStateSplitColumn.php
public function getActions(): array
{
    $actions = [];
    foreach ($this->getRecordStates() as $stateKey => $stateData) {
        $actions[] = Action::make($stateKey)
            ->icon($stateData['icon'])
            ->color($stateData['color'])
            ->action(function (Model $record) use ($stateData) {
                // Handle state transition
                $this->handleStateTransition($record, $stateData['class']);
            });
    }
    return $actions;
}
```blade
{{-- In Blade view --}}
@foreach ($getActions() as $action)
    {{ $action->render() }}
@endforeach
### Advanced Configuration
// Custom configuration
    ->stateClass(AppointmentState::class, Appointment::class)
    ->label('Azioni Stato')
    ->extraAttributes([
        'class' => 'custom-state-grid gap-2 p-2',
    ]),
### Template Features
The component uses a custom Blade template (`ui::filament.tables.columns.icon-state-split`) that provides:
- **Responsive Grid**: CSS Grid with responsive breakpoints
- **State Validation**: Checks for record existence and state transitions
- **Icon Rendering**: Uses Filament's icon component
- **Action Integration**: Wire:click for modal dispatching
- **Accessibility**: Proper ARIA labels and keyboard navigation
### Best Practices
1. **DRY (Don't Repeat Yourself)**:
   - Reusable state logic with centralized validation
   - Consistent styling with shared CSS classes
   - Single template handles all state types
2. **KISS (Keep It Simple, Stupid)**:
   - Simple API with single `stateClass()` method
   - Clear logic with straightforward validation
   - Minimal dependencies on Filament core components
3. **UI/UX Focus**:
   - Touch-friendly 32px minimum touch targets
   - Clear hover and focus states
   - Progressive enhancement without JavaScript
   - Full accessibility support
### Integration Examples
#### Appointment Management
// In AppointmentResource
'state_actions' => IconStateSplitColumn::make()
    ->label('Azioni'),
#### Patient Records
// In PatientResource
'status_actions' => IconStateSplitColumn::make()
    ->stateClass(PatientState::class, Patient::class)
    ->label('Stato Paziente'),
## IconStateGroupColumn
The `IconStateGroupColumn` displays state transition icons in a grouped layout, suitable for complex state management scenarios.
### Features
- **Grouped Layout**: Icons are grouped together in a single column
- **State Validation**: Only shows available state transitions
- **Modal Integration**: Enhanced modal dialogs for state changes
- **Error Handling**: Comprehensive error catching and notifications
### Usage
use Modules\UI\Filament\Tables\Columns\IconStateGroupColumn;
'state_group' => IconStateGroupColumn::make()
## SelectStateColumn
The `SelectStateColumn` provides a dropdown interface for state transitions, ideal for complex state machines with many possible transitions.
- **Dropdown Interface**: Clean dropdown for state selection
- **State Validation**: Only shows valid state transitions
- **Modal Integration**: Enhanced modal dialogs
- **Accessibility**: Full keyboard and screen reader support
use Modules\UI\Filament\Tables\Columns\SelectStateColumn;
'state_select' => SelectStateColumn::make()
## Comparison Table
| Feature | IconStateSplitColumn | IconStateGroupColumn | SelectStateColumn |
|---------|---------------------|---------------------|-------------------|
| **Layout** | Grid | Group | Dropdown |
| **Space Usage** | Compact | Medium | Minimal |
| **Visual Impact** | High | Medium | Low |
| **Complexity** | Simple | Medium | Complex |
| **Mobile Friendly** | Excellent | Good | Excellent |
| **Accessibility** | Excellent | Good | Excellent |
## Best Practices
### State Design
1. **Consistent Icons**: Use consistent icon sets across states
2. **Color Coding**: Implement meaningful color schemes
3. **Clear Labels**: Provide descriptive labels for all states
4. **Modal Forms**: Keep modal forms simple and focused
### Performance
1. **State Caching**: Cache state mappings when possible
2. **Lazy Loading**: Load state information on-demand
3. **Efficient Queries**: Optimize database queries for state checks
4. **Memory Management**: Clean up event listeners properly
### Accessibility
1. **Keyboard Navigation**: Ensure full keyboard support
2. **Screen Reader Support**: Provide proper ARIA labels
3. **Focus Management**: Maintain logical focus order
4. **Error Handling**: Provide clear error messages
## Troubleshooting
### Common Issues
1. **Icons Not Showing**
   - Check state class `icon()` method implementation
   - Verify state mapping configuration
   - Ensure proper state instance creation
2. **Actions Not Working**
   - Verify modal form schema implementation
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
## Related Documentation
- [State Management](../state-transitions.md)
- [Filament Components](../filament-components.md)
- [UI Architecture](../architecture_rules.md)
- [Accessibility Guidelines](../accessibility.md)
---
**Last Updated**: June 2025
**Version**: 2.0
**Compatibility**: Filament 4.x, Laravel 11.x
**Compatibility**: Filament 4.x, Laravel 11.x
**Compatibility**: Filament 3.x, Laravel 10.x
**Compatibility**: Filament 4.x, Laravel 11.x
**Compatibility**: Filament 4.x, Laravel 11.x
**Compatibility**: Filament 3.x, Laravel 10.x
**Compatibility**: Filament 4.x, Laravel 11.x
**Compatibility**: Filament 3.x, Laravel 10.x
