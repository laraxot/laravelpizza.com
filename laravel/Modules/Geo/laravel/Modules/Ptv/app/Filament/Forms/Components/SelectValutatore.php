<?php

declare(strict_types=1);

namespace Modules\Ptv\Filament\Forms\Components;

use Closure;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
// Added
use Modules\Ptv\Models\StabiDirigente;
use Modules\Xot\Filament\Forms\Components\XotBaseSelect;
use Webmozart\Assert\Assert;

class SelectValutatore extends XotBaseSelect
{
    /** @var Closure|array<string, mixed> */
    public Closure|array $where = [];

    /**
     * Imposta le condizioni per la query
     *
     * @param Closure|array<string, mixed> $where
     */
    public function where(Closure|array $where): static
    {
        $this->where = $where;

        return $this;
    }

    /**
     * @return array<string, mixed>
     */
    /**
     * @return array<string, mixed>
     */
    public function getWhere(): array
    {
        Assert::isArray($res = $this->evaluate($this->where));
        /** @var array<string, mixed> $res */

        $where = [];
        foreach ($res as $key => $value) {
            if (is_string($key)) {
                $where[$key] = $value;
            }
        }

        return $where;
    }

    protected function setUp(): void
    {
        parent::setUp();
        $backtrace = debug_backtrace();
        $module_name = ''; // Default value
        $callingClass = Arr::first($backtrace, function ($item) {
            return isset($item['class'])
                && $item['class'] !== static::class // Exclude self
                && ! Str::startsWith($item['class'], 'Filament\\') // Exclude Filament internals
                && Str::startsWith($item['class'], 'Modules\\'); // Look for Modules
        });

        if ($callingClass !== null && isset($callingClass['class'])) {
            $module_name = Str::of($callingClass['class'])->betweenFirst('Modules\\', '\\')->toString();
        } else {
            // Fallback if module name cannot be determined
            $module_name = 'Xot'; // Default module or throw exception
        }
        /** @var class-string<StabiDirigente> $valutatore */
        $valutatore = 'Modules\\'.$module_name.'\\Models\\StabiDirigente';

        $this->options(function () use ($valutatore) {
            $data = [];
            $rows = $valutatore::where($this->getWhere())
                ->whereRaw('valutatore_id = id')
                ->get();
            foreach ($rows as $row) {
                /** @var StabiDirigente $row */
                $data[$row->id] = $row->id.']'.$row->nome_diri; // . implode('-',$this->getWhere());
            }

            return $data;
        });

        // $this->native(false);
    }
}
