resources/views/filament/pages/guzzle-proxy-test.blade.php --}}
<x-filament-panels::page>
    <div class="space-y-6">
        {{-- Form per la configurazione --}}
        {{ $this->form }}
        
        {{-- Risultati del test --}}
        @if($testResults)
            <div class="mt-6">
                <x-filament::section>
                    <x-slot name="heading">
                        <div class="flex items-center space-x-2">
                            @if($testResults['success'])
                                <x-heroicon-s-check-circle class="w-5 h-5 text-success-500" />
                                <span class="text-success-600">Test Completato con Successo</span>
                            @else
                                <x-heroicon-s-x-circle class="w-5 h-5 text-danger-500" />
                                <span class="text-danger-600">Test Fallito</span>
                            @endif
                        </div>
                    </x-slot>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        @if($statusCode)
                            <div class="bg-gray-50 dark:bg-gray-800 p-3 rounded-lg">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Status Code</dt>
                                <dd class="mt-1 text-lg font-semibold 
                                    {{ $statusCode >= 200 && $statusCode < 300 ? 'text-success-600' : 'text-danger-600' }}">
                                    {{ $statusCode }}
                                </dd>
                            </div>
                        @endif
                        
                        @if($responseTime)
                            <div class="bg-gray-50 dark:bg-gray-800 p-3 rounded-lg">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Tempo di Risposta</dt>
                                <dd class="mt-1 text-lg font-semibold text-gray-900 dark:text-white">
                                    {{ $responseTime }}ms
                                </dd>
                            </div>
                        @endif
                        
                        @if(isset($testResults['proxy_used']))
                            <div class="bg-gray-50 dark:bg-gray-800 p-3 rounded-lg">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Proxy Utilizzato</dt>
                                <dd class="mt-1 text-sm font-mono text-gray-900 dark:text-white break-all">
                                    {{ $testResults['proxy_used'] }}
                                </dd>
                            </div>
                        @endif
                    </div>
                    
                    {{-- Messaggio di errore --}}
                    @if($errorMessage)
                        <div class="mb-4">
                            <x-filament::badge color="danger" size="lg">
                                Errore: {{ $errorMessage }}
                            </x-filament::badge>
                        </div>
                    @endif
                    
                    {{-- Headers di risposta --}}
                    @if(isset($testResults['headers']) && $testResults['success'])
                        <div class="mb-4">
                            <h4 class="text-sm font-semibold text-gray-900 dark:text-white mb-2">Headers di Risposta:</h4>
                            <div class="bg-gray-100 dark:bg-gray-900 p-3 rounded-md overflow-x-auto">
                                <pre class="text-xs"><code>{{ json_encode($testResults['headers'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</code></pre>
                            </div>
                        </div>
                    @endif
                    
                    {{-- Body di risposta --}}
                    @if(isset($testResults['body']) || isset($testResults['response_body']))
                        <div>
                            <h4 class="text-sm font-semibold text-gray-900 dark:text-white mb-2">
                                {{ $testResults['success'] ? 'Body di Risposta:' : 'Dettagli Errore:' }}
                            </h4>
                            <div class="bg-gray-100 dark:bg-gray-900 p-3 rounded-md overflow-x-auto max-h-96 overflow-y-auto">
                                <pre class="text-xs whitespace-pre-wrap"><code>{{ $testResults['body'] ?? $testResults['response_body'] ?? 'Nessun contenuto' }}</code></pre>
                            </div>
                        </div>
                    @endif
                </x-filament::section>
            </div>
        @endif
        
        {{-- Sezione informativa --}}
        <x-filament::section>
            <x-slot name="heading">
                ℹ️ Informazioni Test
            </x-slot>
            
            <div class="prose dark:prose-invert max-w-none">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Questo strumento permette di testare chiamate HTTP tramite proxy utilizzando Guzzle HTTP.
                    Configura i parametri del proxy e dell'endpoint target, quindi clicca su "Esegui Test" per verificare la connettività.
                </p>
                
                <div class="mt-3">
                    <h5 class="text-sm font-semibold text-gray-900 dark:text-white">Suggerimenti:</h5>
                    <ul class="text-xs text-gray-600 dark:text-gray-400 mt-1 space-y-1">
                        <li>• Usa <code>https://httpbin.org/ip</code> per testare se il proxy funziona correttamente</li>
                        <li>• Per API che richiedono autenticazione, aggiungi gli headers appropriati</li>
                        <li>• Verifica che il proxy sia raggiungibile e configurato correttamente</li>
                        <li>• I timeout lunghi possono causare problemi in ambienti di produzione</li>
                    </ul>
                </div>
            </div>
        </x-filament::section>
    </div>
</x-filament-panels::page>