<?php

declare(strict_types=1);


use App\Models\User;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Schemas\Schema;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\HtmlString;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

use function Laravel\Folio\middleware;
use function Laravel\Folio\name;

middleware(['guest']);
name('register');

new class extends Component {
    #[Validate('required')]
    public $name = '';

    #[Validate('required|email|unique:users')]
    public $email = '';

    #[Validate('required|min:8|same:passwordConfirmation')]
    public $password = '';

    #[Validate('required|min:8|same:password')]
    public $passwordConfirmation = '';

    public function register()
    {
        $this->validate();

        $user = User::create([
            'email' => $this->email,
            'name' => $this->name,
            'password' => Hash::make($this->password),
        ]);

        event(new Registered($user));

        Auth::login($user, true);

        return redirect()->intended('/');
    }
};

?>

<x-layouts.app>
    <div class="min-h-screen bg-gradient-to-b from-blue-50 to-white py-12">
        <div class="max-w-lg mx-auto px-6">
            <!-- Logo e intestazione -->
            <div class="text-center mb-8">
                <div class="flex justify-center mb-4">
                    <x-ui.logo class="h-12 text-blue-900" />
                </div>
                <h1 class="text-3xl font-light text-blue-900">Benvenuto in <span class="font-bold">il progetto</span></h1>
                <p class="text-gray-600 mt-2">Crea il tuo account per accedere a tutti i servizi1</p>
            </div>

            <!-- Card contenente il form di registrazione -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <!-- Intestazione card -->
                <div class="bg-blue-900 px-6 py-4">
                    <h2 class="text-xl font-medium text-white flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                        </svg>
                        Registrazione
                    </h2>
                </div>

                <!-- Form di registrazione -->
                <div class="p-6">
                    @livewire(\Modules\User\Filament\Widgets\RegistrationWidget::class)
                </div>
            </div>

            <!-- Footer con informazioni aggiuntive -->
            <div class="mt-8 text-center text-sm text-gray-500">
                <p>Hai bisogno di assistenza? <a href="#" class="text-blue-800 hover:underline">Contattaci</a></p>
            </div>
        </div>
    </div>
</x-layouts.app>
