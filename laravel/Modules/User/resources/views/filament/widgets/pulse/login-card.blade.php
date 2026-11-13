
<x-pulse::card
    :cols="$cols"
    :rows="$rows"
    :class="$class"
    wire:poll.60s
>
    <x-pulse::card-header name="Accessi utenti" />

    <div class="space-y-4 p-4">

        <div class="grid grid-cols-3 gap-4">
            @foreach ([
                'Oggi' => 'today',
                '7 giorni' => 'last_7_days',
                '30 giorni' => 'last_30_days',
            ] as $label => $key)
                <div>
                    <div class="text-xs text-gray-500">
                        {{ $label }}
                    </div>

                    <div class="text-xl font-bold tabular-nums">
                        {{ number_format($stats[$key] ?? 0, 0, ',', '.') }}
                    </div>
                </div>
            @endforeach
        </div>

        <div
            wire:ignore
            class="relative h-52 w-full"
            x-data="loginPulseChart({
                labels: @js($stats['labels']),
                values: @js($stats['trend']),
            })"
        >
            <canvas x-ref="canvas"></canvas>
        </div>

        <div class="flex justify-between border-t pt-3 text-sm">
            <span>Totale accessi</span>

            <strong>
                {{ number_format($stats['total'] ?? 0, 0, ',', '.') }}
            </strong>
        </div>
    </div>
</x-pulse::card>

@script
<script>
Alpine.data('loginPulseChart', (config) => ({
    chart: null,
    unsubscribe: null,

    init() {
        this.chart = new Chart(this.$refs.canvas, {
            type: 'line',

            data: {
                labels: config.labels,
                datasets: [{
                    label: 'Accessi',
                    data: config.values,
                    borderColor: '#9333ea',
                    backgroundColor: '#9333ea20',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.2,
                    pointHitRadius: 10,
                }],
            },

            options: {
                responsive: true,
                maintainAspectRatio: false,

                interaction: {
                    mode: 'index',
                    intersect: false,
                },

                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0,
                        },
                    },
                },

                plugins: {
                    legend: {
                        display: false,
                    },
                    tooltip: {
                        displayColors: false,
                    },
                },
            },
        });

        this.unsubscribe = this.$wire.on(
            'login-chart-update',
            ({ labels, values }) => {
                if (!this.chart) {
                    return;
                }

                this.chart.data.labels = labels;
                this.chart.data.datasets[0].data = values;
                this.chart.update();
            }
        );
    },

    destroy() {
        this.unsubscribe?.();
        this.chart?.destroy();
    },
}));
</script>
@endscript
