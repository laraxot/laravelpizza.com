<?php

declare(strict_types=1);

namespace Modules\UI\Filament\Forms\Components;

// use bjeavons\ZxcvbnPhp\Zxcvbn;
use Modules\Xot\Filament\Forms\Components\XotBaseTextInput;

class PasswordStrengthField extends XotBaseTextInput
{
    /**
     * Setup iniziale del componente.
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @var view-string $viewString */
        $viewString = 'ui::filament.forms.components.password-strength';
        $this->view($viewString);
    }

    public function evaluateStrength(): static
    {
        $this->afterStateUpdated(static function (string $state): void {
            unset($state);
            // $zxcvbn = new Zxcvbn();
            // $result = $zxcvbn->passwordStrength($state);
            // Ottieni il punteggio della password (da 0 a 4)
            // $score = $result['score'];
            /*
             * // Puoi gestire la logica in base al punteggio qui (opzionale)
             * if ($score < 3) {
             * $this->warning('La tua password è troppo debole!');
             * } else {
             * $this->info('La tua password è abbastanza forte.');
             * }
             */
            // $this->state(['passwordStrengthScore' => $score]);
        });

        return $this;
    }
}
