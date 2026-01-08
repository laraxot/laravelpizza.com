<x-layouts.app>
    <div class="min-h-screen bg-gray-50 flex items-center justify-center py-16 px-4">
        <div class="agid-login-container">
            <!-- Login header -->
            <div class="agid-login-header">
                <img src="{{ asset('themes/Sixteen/images/logo.svg') }}" 
                     alt="{{ config('app.name', 'Ente Pubblico') }}" 
                     class="agid-login-logo"
                     onerror="this.style.display='none';">
                <h1 class="agid-login-title">Area riservata</h1>
            </div>
            
            <!-- Tab navigation -->
            <div class="agid-login-tabs">
                <button class="agid-tab-button active" 
                        id="login-tab"
                        onclick="switchTab('login')"
                        aria-selected="true">
                    Accedi
                </button>
                <button class="agid-tab-button" 
                        id="reset-tab"
                        onclick="switchTab('reset')"
                        aria-selected="false">
                    Reimposta la tua password
                </button>
            </div>
            
            <!-- Login form -->
            <div class="agid-tab-content active" id="login-content">
                @livewire(Modules\User\Filament\Widgets\Auth\LoginWidget::class)
            </div>
            
            <!-- Reset password form -->
            <div class="agid-tab-content" id="reset-content">
                <div class="text-center py-5 text-gray-600">
                    <p>Inserisci la tua email per ricevere le istruzioni per reimpostare la password.</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function switchTab(tabName) {
            // Hide all tab contents
            document.querySelectorAll('.agid-tab-content').forEach(content => {
                content.classList.remove('active');
            });
            
            // Deactivate all tab buttons
            document.querySelectorAll('.agid-tab-button').forEach(button => {
                button.classList.remove('active');
                button.setAttribute('aria-selected', 'false');
            });
            
            // Show selected tab content
            const content = document.getElementById(tabName + '-content');
            if (content) content.classList.add('active');
            
            // Activate selected tab button
            const button = document.getElementById(tabName + '-tab');
            if (button) {
                button.classList.add('active');
                button.setAttribute('aria-selected', 'true');
            }
        }
        
        // Keyboard navigation
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.agid-tab-button').forEach(button => {
                button.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        this.click();
                    }
                });
            });
        });
    </script>
</x-layouts.app> 