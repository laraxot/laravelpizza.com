<?php

/**
 * https://forum.laravel-livewire.com/t/wire-ignore-with-google-autocomplete/734/3.
 * $this->dispatch('address:list:refresh');.
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
        $this->session = $sessionManager;
        // $this->attributes = $attributes;
        // $this->slot = $slot;
        $this->form_data[$this->name] = json_encode((object) [], JSON_THROW_ON_ERROR);
        $this->form_data[$this->name.'_value'] = null;
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
        $this->warningSuggestedAddresses = false;
        $this->warningCivicNumber = false;
        $this->showActivityTypes = false;

        if (! isset($this->form_data['latlng'])) {
            $this->warningSuggestedAddresses = true;

            return;
        }

        if (! isset($this->form_data['street_number'])) {
            $this->warningCivicNumber = true;

            return;
        }

        // $this->enabledTypes = ActionService::getShopsCatsByCityLatLng($city, $lat, $lng);
        $this->enabledTypes = collect([]);

        if ($this->enabledTypes->isEmpty()) {
            $this->dispatch('openModalNotServed');

            return;
        }

        $this->showActivityTypes = true;

        // session()->put('address', $this->form_data['value']);
        // forse meglio portarmi tutto per utilizzarlo poi nella gestione checkout
        // Cannot call method put() on mixed
        // session()->put('address', $this->form_data);
        $this->session->put('address', $this->form_data);
    }

    /**
     * Undocumented function.
     */
    public function formatAddress(): string
    {
        $data = (object) $this->form_data;

        if (! isset($data->street_number)) {
            $data->street_number = '';
            $this->warningCivicNumber = true;
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
        $this->warningSuggestedAddresses = false;
        $this->warningCivicNumber = false;
        $this->showActivityTypes = false;

        $data = json_decode($val0, true, 512, JSON_THROW_ON_ERROR);
        if (! \is_array($data)) {
            $data = [];
        }
        $this->form_data = array_merge($this->form_data, $data);
        $this->form_data[$this->name] = $val0;
        $this->form_data[$this->name.'_value'] = $val1;

        if (\strlen($val1) < 4) {
            $val2 = $this->formatAddress();
            $this->form_data[$this->name.'_value'] = $val2;
        }
    }

    /**
     * Undocumented function.
     */
    public function saveNotServed(): void
    {
        $this->validate([
            'email' => 'required|email|unique:not_served',
            'cap' => 'required|not_regex:/[a-z]/i|min:5|max:5',
        ]);
        /*
         *
         *
         * //dddx([$this->email, filter_var($this->email, FILTER_VALIDATE_EMAIL)]);
         * //sembra andare bene
         *
         * if (false == filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
         * //$this->dispatch('closeModalNotServed');
         * //$this->dispatch('openModalWrongEmailCap');
         * $this->messageError = true;
         * dddx('mail non valida');
         *
         * return;
         * }
         *
         * //dddx([$this->cap, preg_match('/[a-z]/i', $this->cap)]);
         *
         * if (preg_match('/[a-z]/i', $this->cap)) {
         * $this->messageError = true;
         * dddx('it has alphabet!');
         * //$this->dispatch('closeModalNotServed');
         * //$this->dispatch('openModalWrongEmailCap');
         *
         * return;
         * }
         */

        $model = xotModel('not_served');
        /*
         * $not_served = new $not_served();
         * $not_served->cap = $this->cap;
         * $not_served->email = $this->email;
         * // $not_served->creation_date =
         * $not_served->save();
         */
        $data = [
            'cap' => $this->cap,
            'email' => $this->email,
        ];
        $model->create($data);
        // $this->dispatch('openWrongEmailCap');

        $this->dispatch('closeModalNotServed');
    }
}
