<?php

declare(strict_types=1);

namespace Modules\Chart\Tables\Columns;

use Filament\Tables\Columns\Column;
use Illuminate\Contracts\View\View;
use Modules\Chart\Datas\AnswersChartData;

use function Safe\json_encode;

// use Illuminate\Session\SessionManager;

class ChartColumn extends Column
{
    // class ChartColumn extends Component
    public string $dataChecksum;

    public ?string $filter = null;

    // protected string $view='filament::widgets.chart-widget';
    // protected $listeners = ['refreshChartColumn' => '$refresh'];
    /** @var array<string, mixed> */
    public array $chartData = [
        'datasets' => [
            [
                'label' => 'loading...',
                'data' => [],
            ],
        ],
        'labels' => [],
    ];

    public string $chartType = 'bar';

    /** @var array<string, mixed> */
    public array $chartOptions = [];

    protected static ?string $heading = null;

    protected static ?string $maxHeight = null;

    /** @var array<string, mixed>|null */
    protected static ?array $options = null;

    /** @var array<string, mixed>|null */
    protected ?array $cachedData = null;

    protected string $view = 'chart::tables.columns.chart-column';

    public function applyAnswersChartData(AnswersChartData $answersChartData): self
    {
        $this->chartData = $answersChartData->getChartJsData();
        $this->chartType = $answersChartData->getChartJsType();
        $this->chartOptions = $answersChartData->getChartJsOptions();
        $this->cachedData = null;

        // dddx([$this->getCachedData(),$this->getData()]);
        // $this->emit('refreshChartColumn');
        // filterChartData
        return $this;
    }

    public function render(): View
    {
        $viewParams = [
            'obj' => $this,
        ];

        /** @var view-string $viewName */
        $viewName = $this->view;

        return view($viewName, $viewParams);
    }

    /**
     * @return array<string, mixed>
     */
    public function getCachedData(): array
    {
        return $this->cachedData ??= $this->getData();
    }

    public function getMaxHeight(): ?string
    {
        return static::$maxHeight;
    }

    /**
     * @return array<string, mixed>|null
     */
    public function getOptions(): ?array
    {
        return $this->chartOptions;
    }

    public function getType(): string
    {
        return $this->chartType;
    }

    public function updateChartData(): void
    {
        $newDataChecksum = $this->generateDataChecksum();

        if ($newDataChecksum !== $this->dataChecksum) {
            $this->dataChecksum = $newDataChecksum;

            // Assert::methodNotExists($this, 'emitSelf', $message = 'function emitSelf not exists');
            // NON E' LIVEWIRE
            // $this->emitSelf('updateChartData', [
            //    'data' => $this->getCachedData(),
            // ]);
        }
    }

    public function updatedFilter(): void
    {
        $newDataChecksum = $this->generateDataChecksum();

        if ($newDataChecksum !== $this->dataChecksum) {
            $this->dataChecksum = $newDataChecksum;

            // NON E' LIVEWIRE
            // $this->emitSelf('updateChartData', [
            //    'data' => $this->getCachedData(),
            // ]);
        }
    }

    public function getHeading(): ?string
    {
        return static::$heading;
    }

    protected function generateDataChecksum(): string
    {
        return md5(json_encode($this->getCachedData()));
    }

    /**
     * @return array<string, mixed>
     */
    protected function getData(): array
    {
        return $this->chartData;
    }

    /**
     * @return array<string, mixed>|null
     */
    protected function getFilters(): ?array
    {
        return null;
    }
}
