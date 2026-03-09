<x-filament::page>
    <div class="space-y-6" wire:poll.visible="{{ $this->isRunning ? '100' : '1000' }}">
        @if($this->isRunning)
            <div class="text-sm text-gray-500 bg-gray-50 p-2 rounded-lg border border-gray-200">
                The command is running. Please do not close this window.
                <br>
                Other actions are disabled until the command completes.
            </div>
        @endif

        <div class="flex space-x-4">
            <x-filament::section class="flex-1">
                <div class="flex items-center justify-between">
                    <span class="text-sm font-medium">{{ $publicKeyLabel }}</span>
                    @if($hasPublicKey)
                        <x-filament::badge color="success" icon="heroicon-m-check-circle">{{ $presentLabel }}</x-filament::badge>
                    @else
                        <x-filament::badge color="danger" icon="heroicon-m-x-circle">{{ $missingLabel }}</x-filament::badge>
                    @endif
                </div>
            </x-filament::section>

            <x-filament::section class="flex-1">
                <div class="flex items-center justify-between">
                    <span class="text-sm font-medium">{{ $privateKeyLabel }}</span>
                    @if($hasPrivateKey)
                        <x-filament::badge color="success" icon="heroicon-m-check-circle">{{ $presentLabel }}</x-filament::badge>
                    @else
                        <x-filament::badge color="danger" icon="heroicon-m-x-circle">{{ $missingLabel }}</x-filament::badge>
                    @endif
                </div>
            </x-filament::section>
        </div>
        
        <div 
            x-data="{ 
                init() {
                    this.$el.scrollTop = this.$el.scrollHeight;
                    this.$watch('$wire.output', () => {
                        this.$el.scrollTop = this.$el.scrollHeight;
                    });
                }
            }"
            class="bg-gray-900 text-gray-100 font-mono p-4 rounded-lg overflow-auto max-h-96 relative"
        >
            @if(filled($this->currentCommand))
                <div class="flex items-center justify-between mb-4 sticky top-0 bg-gray-900 py-2 border-b border-gray-700">
                    <h3 class="text-lg font-medium">Running command: php artisan {{ $this->currentCommand }}</h3>
                    <div>
                        @if($this->status === 'completed')
                            <x-filament::badge color="success">
                                Completed
                            </x-filament::badge>
                        @elseif($this->status === 'failed')
                            <x-filament::badge color="danger">
                                Failed
                            </x-filament::badge>
                        @elseif($this->isRunning)
                            <div class="flex items-center space-x-2">
                                <x-filament::loading-indicator class="h-5 w-5" />
                                <span class="text-sm">Running...</span>
                            </div>
                        @endif
                    </div>
                </div>
                @if(empty($this->output))
                    <div class="text-gray-400">
                        Waiting for output...
                    </div>
                @else
                    @foreach($this->output as $line)
                        @if(str_starts_with($line, '[ERROR]'))
                            <div class="whitespace-pre-wrap text-red-400 font-bold">{{ $line }}</div>
                        @else
                            <div class="whitespace-pre-wrap">{{ $line }}</div>
                        @endif
                    @endforeach
                @endif
            @else
                <div class="text-gray-400 italic">
                    Select a command from the header to begin.
                </div>
            @endif
        </div>

        @if(!empty($this->output))
            <div class="text-xs text-gray-500 text-right">
                Use mouse wheel to scroll output.
            </div>
        @endif
    </div>
</x-filament::page>
