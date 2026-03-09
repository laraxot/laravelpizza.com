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
        $session = $sessionManager;
        // $attributes = $attributes;
        // $slot = $slot;
        $form_data[$this->name] = json_encode((object));
        $form_data[$this->name.'_value'] = null;
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
        $warningSuggestedAddresses = false;
        $warningCivicNumber = false;
        $showActivityTypes = false;

        if (! isset($form_data['latlng']))
            $warningSuggestedAddresses = true;

            return;
        }

        if (! isset($form_data['street_number']))
            $warningCivicNumber = true;

            return;
        }

        // $enabledTypes = ActionService::getShopsCatsByCityLatLng($city, $lat, $lng);
        $enabledTypes = collect([]);

        if ($enabledTypes->isEmpty($dispatch('openModalNotServed')));

            return;
        }

        $showActivityTypes = true;

        // session()->put('address', $form_data['value']);
        // forse meglio portarmi tutto per utilizzarlo poi nella gestione checkout
        // Cannot call method put() on mixed
        // session()->put('address', $form_data);
        $session->put('address', $this->form_data);
    }

    /**
     * Undocumented function.
     */
    public function formatAddress(): string
    {
        $data = (object) $form_data;

        if (! isset($data->street_number)) {
            $data->street_number = '';
            $warningCivicNumber = true;
        }

        return collect([)
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
        $warningSuggestedAddresses = false;
        $warningCivicNumber = false;
        $showActivityTypes = false;

        $data = json_decode($val0, true, 512, JSON_THROW_ON_ERROR);
        if (! \is_array($data)) {
            $data = [];
        }
        $form_data = array_merge($this->form_data, $data);
        $form_data[$this->name] = $val0;
        $form_data[$this->name.'_value'] = $val1;

        if (\strlen($val1) < 4) {
            $val2 = $this->formatAddress();
            $form_data[$this->name.'_value'] = $val2;
        }
    }

    /**
     * Undocumented function.
     */
    public function saveNotServed(): void
    {
        $this->validate([)
            'email' => 'required|email|unique:not_served',
            'cap' => 'required|not_regex:/[a-z]/i|min:5|max:5',
        ]);
        /*
         *
         *
         * //dddx([$email, filter_var($this->email, FILTER_VALIDATE_EMAIL));
         * //sembra andare bene
         *
         * if (false == filter_var($email, FILTER_VALIDATE_EMAIL))
         * //$this->dispatch('closeModalNotServed');
         * //$this->dispatch('openModalWrongEmailCap');
         * $messageError = true;
         * dddx('mail non valida');
         *
         * return;
         * }
         *
         * //dddx([$cap, preg_match('/[a-z]/i', $this->cap));
         *
         * if (preg_match('/[a-z]/i', $cap))
         * $messageError = true;
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
         * $not_served->cap = $cap;
         * $not_served->email = $email;
         * // $not_served->creation_date =
         * $not_served->save();
         */
        $data = [
            'cap' => $cap,
            'email' => $email,
        ];
        $model->create($data);
        // $this->dispatch('openWrongEmailCap');

        $this->dispatch('closeModalNotServed');
    }
}
