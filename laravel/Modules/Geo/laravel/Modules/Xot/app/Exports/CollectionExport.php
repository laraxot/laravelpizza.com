<?php

declare(strict_types=1);

namespace Modules\Xot\Exports;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection as SupportCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Modules\Lang\Actions\TransArrayAction;
use Modules\Xot\Actions\Cast\SafeArrayByModelCastAction;
use Modules\Xot\Actions\Cast\SafeStringCastAction;
use Webmozart\Assert\Assert;

/**
 * @implements WithMapping<Model>
 */
class CollectionExport implements FromCollection, ShouldQueue, WithHeadings, WithMapping
{
    use Exportable;

    /** @var SupportCollection<int, mixed>|EloquentCollection<int, Model> */
    public SupportCollection|EloquentCollection $collection;

    /** @var array<int, string> */
    public array $headings;

    public ?string $transKey;

    /** @var array<int, string>|null */
    public ?array $fields = null;

    /**
     * @param SupportCollection<int, mixed>|EloquentCollection<int, Model> $collection
     * @param array<int, string>                                           $fields
     */
    public function __construct(SupportCollection|EloquentCollection $collection, ?string $transKey = null, array $fields = [])
    {
        $this->collection = $collection;
        $this->transKey = $transKey;
        $this->fields = $fields;
        $this->headings = [];
    }

    /**
     * @return array<int, string>
     */
    public function getHead(): array
    {
        if (\is_array($this->fields) && ! empty($this->fields)) {
            return $this->fields;
        }

        $head = $this->collection->first();
        Assert::isInstanceOf($head, Model::class);

        return array_keys($head->getAttributes());
    }

    /**
     * @return array<int|string, string>
     */
    public function headings(): array
    {
        $headings = $this->getHead();
        $transKey = $this->transKey;

        return app(TransArrayAction::class)->execute($headings, $transKey);
    }

    /**
     * @return SupportCollection<int, mixed>|EloquentCollection<int, Model>
     */
    public function collection(): SupportCollection|EloquentCollection
    {
        return $this->collection;
    }

    /**
     * @return array<int|string, mixed>
     */
    public function map(mixed $row): array
    {
        if (null === $this->fields || empty($this->fields)) {
            Assert::isInstanceOf($row, Model::class);
            $res = app(SafeArrayByModelCastAction::class)->execute($row);

            return array_values(Arr::map($res, function ($value, $_key): string {
                if ($value instanceof \BackedEnum) {
                    if (method_exists($value, 'getLabel')) {
                        return SafeStringCastAction::cast($value->getLabel());
                    }

                    return SafeStringCastAction::cast($value->value);
                }

                return SafeStringCastAction::cast($value);
            }));
        }

        $data = [];

        foreach ($this->fields as $field) {
            $value = data_get($row, $field);
            if (\is_object($value)) {
                if (enum_exists($value::class) && method_exists($value, 'getLabel')) {
                    $value = $value->getLabel();
                }
            }
            $data[] = SafeStringCastAction::cast($value);
        }

        return $data;
    }
}
