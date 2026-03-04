# Infolist Pages in Filament Resources

In the Laraxot framework, when creating a "View" page for a Filament resource that extends `Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord`, it is mandatory to implement the `getInfolistSchema()` method.

This method must return an `array` of Filament infolist components.

## Example:

use Modules\Xot\Filament\Schemas\Components\XotBaseSection as Section;
use Filament\Infolists\Components\TextEntry;
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;
use Modules\User\Filament\Resources\ClientResource;

class ViewClient extends XotBaseViewRecord
{
    protected static string $resource = ClientResource::class;

    public function getInfolistSchema(): array
    {
        return [
            'credentials' => Section::make('Client Credentials')
                ->schema([
                    //... infolist components
                ]),
            // ... other sections
        ];
    }
}
```

## Rationale

The `XotBaseViewRecord` base class provides a standardized structure for view pages. It requires the `getInfolistSchema()` method to build the infolist, which promotes consistency and abstracts away the `Infolist` object creation. This is a departure from the standard Filament `infolist()` method which injects the `Infolist` object.

As a general rule, always use `Modules\Xot\Filament\Schemas\Components\XotBaseSection` instead of the standard `Filament\Infolists\Components\Section`.
Also, the top-level array returned by `getInfolistSchema()` MUST always use string keys for its elements, typically matching the name of the `Section` or a logical identifier. Numeric keys are forbidden.
