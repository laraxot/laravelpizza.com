<?php

/**
 * https://forum.laravel-livewire.com/t/wire-ignore-with-google-autocomplete/734/3.
 * // @var mixed dispatch('address:list:refresh';.
 */

declare(strict_types=1);

namespace Modules\Geo\Http\Livewire;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Session\SessionManager;
use Illuminate\Support\Collection;
use Livewire\Component;
use Modules\Xot\Actions\GetViewAction;

/**
 * Undocumented class.
 */
class FormSearchAddressCategories extends Component
{
    // public \Illuminate\View\ComponentAttributeBag $attributes;
    // public \Illuminate\Support\HtmlString $slot;
    public string $name = 'address';

    public array $form_data = [];

    public bool $showActivityTypes = false;

    public Collection $enabledTypes;

    public bool $warningSuggestedAddresses = false;

    public bool $warningCivicNumber = false;

    public string $email = '';

    public string $cap = '';

    public bool $messageError = false;

    public SessionManager $session;

    /**
     * Mount function.
     *
     * param \Illuminate\View\ComponentAttributeBag $attributes
     * param \Illuminate\Support\HtmlString         $slot
     */
    public function mount(SessionManager $sessionManager): void
    {
        // @var mixed session = $sessionManager;
        // // @var mixed attributes = $attributes;
        // // @var mixed slot = $slot;
        // @var mixed form_data[$this->name] = json_encode((object;
        // @var mixed form_data[$this->name.'_value'] = null;
    }

    /**
     * Undocumented function.
     */
    public function render(): Renderable
    {
        /**
         * @phpstan-var view-string
         */
        $view = app(GetViewAction::class)->execute();
        $view_params = [
            'view' => $view,
        ];

        return view($view, $view_params);
    }

    /**
     * Undocumented function.
     */
    public function search(): void
    {
        // @var mixed warningSuggestedAddresses = false;
        // @var mixed warningCivicNumber = false;
        // @var mixed showActivityTypes = false;

        if (! isset(// @var mixed form_data['latlng']
            // @var mixed warningSuggestedAddresses = true;

            return;
        }

        if (! isset(// @var mixed form_data['street_number']
            // @var mixed warningCivicNumber = true;

            return;
        }

        // // @var mixed enabledTypes = ActionService::getShopsCatsByCityLatLng($city, $lat, $lng;
        // @var mixed enabledTypes = collect([];

        if (// @var mixed enabledTypes->isEmpty(
            // @var mixed dispatch('openModalNotServed';

            return;
        }

        // @var mixed showActivityTypes = true;

        // session()->put('address', // @var mixed form_data['value'];
        // forse meglio portarmi tutto per utilizzarlo poi nella gestione checkout
        // Cannot call method put() on mixed
        // session()->put('address', // @var mixed form_data;
        // @var mixed session->put('address', $this->form_data;
    }

    /**
     * Undocumented function.
     */
    public function formatAddress(): string
    {
        $data = (object) // @var mixed form_data;

        if (! isset($data->street_number)) {
            $data->street_number = '';
            // @var mixed warningCivicNumber = true;
        }

        return collect([
            $data->route ?? '',
            $data->street_number ?? '',
            $data->locality ?? '',
        ])
            ->implode(', ');
    }

    /**
     * Undocumented function.
     */
    public function placeChanged(string $val0, string $val1): void
    {
        // @var mixed warningSuggestedAddresses = false;
        // @var mixed warningCivicNumber = false;
        // @var mixed showActivityTypes = false;

        $data = json_decode($val0, true, 512, JSON_THROW_ON_ERROR);
        if (! \is_array($data)) {
            $data = [];
        }
        // @var mixed form_data = array_merge($this->form_data, $data;
        // @var mixed form_data[$this->name] = $val0;
        // @var mixed form_data[$this->name.'_value'] = $val1;

        if (\strlen($val1) < 4) {
            $val2 = // @var mixed formatAddress(;
            // @var mixed form_data[$this->name.'_value'] = $val2;
        }
    }

    /**
     * Undocumented function.
     */
    public function saveNotServed(): void
    {
        // @var mixed validate([
            'email' => 'required|email|unique:not_served',
            'cap' => 'required|not_regex:/[a-z]/i|min:5|max:5',
        ]);
        /*
         *
         *
         * //dddx([// @var mixed email, filter_var($this->email, FILTER_VALIDATE_EMAIL;
         * //sembra andare bene
         *
         * if (false == filter_var(// @var mixed email, FILTER_VALIDATE_EMAIL
         * //// @var mixed dispatch('closeModalNotServed';
         * //// @var mixed dispatch('openModalWrongEmailCap';
         * // @var mixed messageError = true;
         * dddx('mail non valida');
         *
         * return;
         * }
         *
         * //dddx([// @var mixed cap, preg_match('/[a-z]/i', $this->cap;
         *
         * if (preg_match('/[a-z]/i', // @var mixed cap
         * // @var mixed messageError = true;
         * dddx('it has alphabet!');
         * //// @var mixed dispatch('closeModalNotServed';
         * //// @var mixed dispatch('openModalWrongEmailCap';
         *
         * return;
         * }
         */

        $model = xotModel('not_served');
        /*
         * $not_served = new $not_served();
         * $not_served->cap = // @var mixed cap;
         * $not_served->email = // @var mixed email;
         * // $not_served->creation_date =
         * $not_served->save();
         */
        $data = [
            'cap' => // @var mixed cap,
            'email' => // @var mixed email,
        ];
        $model->create($data);
        // // @var mixed dispatch('openWrongEmailCap';

        // @var mixed dispatch('closeModalNotServed';
    }
}
