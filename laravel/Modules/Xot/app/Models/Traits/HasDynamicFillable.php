<?php

declare(strict_types=1);

namespace Modules\Xot\Models\Traits;

use BackedEnum;
use UnitEnum;

trait HasDynamicFillable
{
    /**
     * Overrides the default getFillable method to include fields from specified Enums.
     *
     * Models using this trait should define a protected array property `$dynamicFillableEnums`
     * containing the fully qualified class names of Enums whose cases should be added to fillable.
     *
     * Example: protected array $dynamicFillableEnums = [AddressItemEnum::class, ContactTypeEnum::class];
     *
     * @return list<string>
     */
    public function getFillable(): array
    {
        $fillable = array_values(parent::getFillable());

        $dynamicFillableEnums = $this->dynamicFillableEnums ?? null;

        // Ensure the property is an array
        if (! is_array($dynamicFillableEnums)) {
            return $fillable;
        }

        foreach ($dynamicFillableEnums as $enumClass) {
            if (! is_string($enumClass) || $enumClass === '') {
                continue;
            }

            // Basic validation for enum class
            if (! enum_exists($enumClass)) {
                continue; // Skip invalid enum classes
            }

            // Get enum cases' values and merge
            $enumCases = $enumClass::cases();
            $enumFields = array_map(
                static function (UnitEnum $item): string {
                    if ($item instanceof BackedEnum) {
                        return (string) $item->value;
                    }

                    return $item->name;
                },
                $enumCases,
            );

            $fillable = array_merge($fillable, array_values($enumFields));
        }

        // Ensure unique values and reset keys for cleanliness
        return array_values(array_unique($fillable));
    }
}
