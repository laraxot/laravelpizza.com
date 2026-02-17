<?php

declare(strict_types=1);

namespace Modules\User\Console\Commands;

use Filament\Support\Contracts\HasLabel;
use Illuminate\Console\Command;
use Illuminate\Contracts\Support\Htmlable;
use Modules\Xot\Actions\Cast\SafeObjectCastAction;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Datas\XotData;
use Webmozart\Assert\Assert;

use function Laravel\Prompts\select;
use function Laravel\Prompts\text;

/**
 * Command to change user type based on project configuration.
 *
 * This command allows administrators to change the type of a user
 * by selecting from available child types in the system.
 */
class ChangeTypeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'user:change-type';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change user type based on project configuration';

    /**
     * Create a new command instance.
     */

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $xot = XotData::make();
        $email = text('User email?');

        /** @var UserContract $user */
        $user = XotData::make()->getUserByEmail($email);

        if (! $user) {
            $this->error("User with email '{$email}' not found.");

            return;
        }
        if (! method_exists($user, 'getChildTypes')) {
            $this->error('User model does not have childTypes method.');

            return;
        }

        $childTypes = $xot->getUserChildTypes();

        // Get type label - BackedEnum needs HasLabel implementation
        $typeLabel = 'None';
        if (isset($user->type) && \is_object($user->type) && method_exists($user->type, 'getLabel')) {
            $enumType = $user->type;
            /** @var string|Htmlable|mixed */
            $label = $enumType->getLabel();
            if (\is_string($label)) {
                $typeLabel = $label;
            } elseif ($label instanceof Htmlable) {
                $typeLabel = $label->toHtml();
            } else {
                $typeLabel = (string) $label;
            }
        }

        Assert::string($typeLabel);
        $this->info('Current user type: '.$typeLabel);

        $typeClass = $xot->getUserChildTypeClass();
        /** @var array<string, string> */
        $options = [];
        foreach ($childTypes as $key => $item) {
            if (
                \is_object($item)
                    && method_exists($item, 'getLabel')
                    && app(SafeObjectCastAction::class)->hasNonNullProperty($item, 'value')
            ) {
                $value = app(SafeObjectCastAction::class)
                    ->getStringProperty($item, 'value', '');
                $options[$value] = (string) $item->getLabel();
            } else {
                $options[(string) $key] = 'Unknown';
            }
        }

        $newType = select('Select new user type:', $options);

        $newTypeEnum = $typeClass::tryFrom($newType);
        Assert::notNull($newTypeEnum);
        Assert::isInstanceOf($newTypeEnum, HasLabel::class);
        Assert::isInstanceOf($newTypeEnum, \BackedEnum::class);

        /* @var \BackedEnum&HasLabel $newTypeEnum */
        $user->type = (string) $newTypeEnum->value;
        $user->save();

        $label = $newTypeEnum->getLabel();
        $labelString = '';
        if (\is_string($label)) {
            $labelString = $label;
        } elseif ($label instanceof Htmlable) {
            $labelString = $label->toHtml();
        } else {
            $labelString = (string) $label;
        }
        $this->info("User type changed to '{$labelString}' for {$email}");
    }
}
