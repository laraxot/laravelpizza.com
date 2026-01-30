<?php

declare(strict_types=1);

namespace Modules\Lang\Actions\Filament;

use Filament\Actions\Action;
use Filament\Forms\Components\Field;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Tables\Columns\Column;
use Filament\Tables\Filters\BaseFilter;
use Illuminate\Support\Arr;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use Modules\Lang\Actions\SaveTransAction;
use Modules\Xot\Actions\Cast\SafeStringCastAction;
use Modules\Xot\Actions\File\SvgExistsAction;
use Modules\Xot\Actions\GetTransKeyAction;
use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

class AutoLabelAction
{
    use QueueableAction;

    /**
     * Undocumented function.
     * return number of input added.
     */
    public function execute(Field|BaseFilter|Column|Step|Action|Section $component, string $type = 'label'): Field|BaseFilter|Column|Step|Action|Section
    {
        $backtrace = debug_backtrace();
        $backtrace_slice = array_slice($backtrace, 2);
        $class = Arr::first($backtrace_slice, function ($item) use ($component) {
            if ($item['function'] === 'execute') {
                return false;
            }

            if (
                isset($item['object'])
                    && Str::startsWith($item['object']::class, 'Modules\\')
                    && $item['object'] !== $component
            ) {
                return true;
            }

            if (isset($item['class']) && Str::startsWith($item['class'], 'Modules\\')) {
                $reflection_class = new \ReflectionClass($item['class']);
                if (! $reflection_class->isAbstract()) {
                    return true;
                }
            }

            return false;
        });

        if (is_array($class)) {
            $object_class = null;
            if (isset($class['object'])) {
                $object_class = $class['object']::class;
            }
            if (isset($class['class']) && $object_class === null) {
                $object_class = $class['class'];
            }
            if (is_null($object_class)) {
                throw new \Exception('No object class found');
            }
            $trans_key = app(GetTransKeyAction::class)->execute($object_class);
        } else {
            $trans_key = 'lang::txt';
        }

        $label_tkey = null;
        $val = 'no-set-val';

        if ($component instanceof Step) {
            Assert::string($val = $component->getLabel());
            $label_tkey = $trans_key.'.steps.'.$val.'';
        }
        if ($label_tkey === null && $component instanceof Section) {
            $val = $component->getHeading();
            if ($val === null) {
                $val = 'empty';
            }
            if (! is_string($val)) {
                $val = app(SafeStringCastAction::class)->execute($val);
            }
            $label_tkey = $trans_key.'.sections.'.$val.'';
        }
        if ($label_tkey === null && method_exists($component, 'getName')) {
            Assert::string($val = $component->getName());
            $label_tkey = $trans_key.'.fields.'.$val.'';
        }

        if ($component instanceof Action) {
            Assert::string($val = $component->getName());
            $label_tkey = $trans_key.'.actions.'.$val.'';
        }

        $label_key = $label_tkey.'.'.Str::snake($type);

        $label = trans($label_key);
        if (is_string($label) && $label_key === $label) { // se non esiste la traduzione, la salvo
            app(SaveTransAction::class)->execute($label_key, $val);
        }
        if (! is_string($label)) {
            $component->label('FIX:'.$label_key);

            return $component;
        }
        if ($label_key === $label || ! method_exists($component, $type)) {
            return $component;
        }
        /*
        if (is_string($label) && $label_key !== $label && method_exists($component, $type)) {

                if ($type === 'icon' && !app(SvgExistsAction::class)->execute($label)) {

                    $component->{$type}('heroicon-o-question-mark-circle');
                    return $component;
                }
                if (strip_tags($label) !== $label && in_array($type, ['helperText'], strict: true)) {
                    $component->{$type}(new HtmlString($label));
                } else {
                    $component->{$type}($label);
                }

        }
        */
        if ($type === 'icon' && app(SvgExistsAction::class)->execute($label)) {
            if (method_exists($component, 'iconButton')) {
                $component->iconButton();
            }
            $component->{$type}($label);

            // $component->label('FIX:'.$label_key);
            return $component;
        }
        if ($type === 'icon' && ! app(SvgExistsAction::class)->execute($label)) {
            // $component->{$type}($label);
            if (method_exists($component, 'iconButton')) {
                $component->iconButton();
            }

            // $component->label('FIX:'.$label_key);
            // $component->tooltip('FIX:'.$label_key);
            // $component->{$type}('heroicon-o-question-mark-circle');

            // $component->{$type}(null);
            return $component;
        }

        if (strip_tags($label) !== $label && in_array($type, ['helperText'], strict: true)) {
            $component->{$type}(new HtmlString($label));

            return $component;
        }

        $component->{$type}($label);

        return $component;
    }
}
