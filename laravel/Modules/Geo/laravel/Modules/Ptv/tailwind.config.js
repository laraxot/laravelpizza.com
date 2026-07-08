import preset from './vendor/filament/support/tailwind.config.preset'

export default {
    presets: [preset],
    content: [
        './app/Filament/**/*.php',
        './resources/views/filament/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
        './Filament/**/*.php',
        './resources/views/filament/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
        '../../Modules/*/Filament/**/*.php',
        '../../Modules/*/resources/views/filament/**/*.blade.php',
        '../../Modules/*/vendor/filament/**/*.blade.php',
        '../../Filament/**/*.php',
        '../../resources/views/filament/**/*.blade.php',
        '../../vendor/filament/**/*.blade.php',
        '../../storage/framework/views/*.php',
    ],
}

