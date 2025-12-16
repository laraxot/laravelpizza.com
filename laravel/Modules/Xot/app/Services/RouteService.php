<?php

declare(strict_types=1);

namespace Modules\Xot\Services;

use Exception;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

/**
 * Class RouteService.
 * Modules\Xot\Services\RouteService.
 *
 * @method string urlAct($params)
 */
class RouteService
{
    /**
     * Verifica se l'utente è in modalità amministrazione.
     *
     * @param  array<string,string>  $params  Parametri aggiuntivi
     * @return bool True se l'utente è in modalità amministrazione, false altrimenti
     */
    public static function inAdmin(array $params = []): bool
    {
        // Se il parametro in_admin è specificato, lo restituiamo direttamente
        if (isset($params['in_admin'])) {
            // Convertiamo qualsiasi valore a booleano
            return (bool) $params['in_admin'];
        }

        // Se il primo segmento dell'URL è 'admin', siamo in modalità amministrazione
        if (Request::segment(1) === 'admin') {
            return true;
        }

        // Verifichiamo un caso speciale per le richieste Livewire
        $segments = Request::segments();

        // Se abbiamo almeno un segmento, è 'livewire' e la sessione 'in_admin' è true
        return (is_countable($segments) ? \count($segments) : 0) > 0 &&
            $segments[0] === 'livewire' &&
            session('in_admin', false) === true;
    }

    /**
     * @param  array<string,string>  $params
     */
    public static function urlAct(array $params): string
    {
        $query = [];
        $act = 'show';
        $row = (object) [];
        extract($params);
        /*
         * $mutator = $act.'_url';
         * try {
         * $route = $row->$mutator;
         * } catch (\Exception $e) {
         * $route = '#';
         * }
         */
        $route_action = (string) Route::currentRouteAction();
        Str::snake(Str::after($route_action, '@'));
        // Cannot call method getName() on mixed.
        $routename = ''; // Request::route()->getName();
        $old_act_route = last(explode('.', $routename));
        if (! \is_string($old_act_route)) {
            throw new Exception('['.__LINE__.']['.class_basename(self::class).']');
        }

        $routename_act = Str::before($routename, $old_act_route).''.$act;
        $route_current = Route::current();
        $route_params = [];
        if ($route_current instanceof \Illuminate\Routing\Route) {
            $route_params = $route_current->parameters();
            $routename = $route_current->getName();
        }

        /*
         * try {
         * $route_params = optional(\Route::current())->parameters();
         * } catch (\Exception $e) {
         * $route_params = [];
         * }
         */
        if (Route::has($routename_act)) {
            $parz = array_merge($route_params, [$row]);
            $parz = array_merge($parz, $query);

            return route($routename_act, $parz);
        }

        return '#'.$routename_act;
    }

    // se n=0 => 'container0'
    // se n=1 => 'containers.container1'
    /**
     * @param  array<string,string>  $params
     */
    public static function getRoutenameN(array $params): string
    {
        // default vars
        $n = 0;
        $act = 'show';
        extract($params);
        $tmp = [];
        // dddx(inAdmin());
        if (inAdmin($params)) {
            $tmp[] = 'admin';
        }

        for ($i = 0; $i <= $n; $i++) {
            $tmp[] = 'container'.$i;
        }

        $tmp[] = $act;

        return implode('.', $tmp);
    }

    /*
     * public static function urlRelatedPanel(array $params){
     * $act = 'show';
     * extract($params);
     * if (! isset($panel)) {
     * dddx(['err' => 'panel is missing']);
     *
     * return;
     * }
     * if (! isset($related_name)) {
     * dddx(['err' => 'related_name is missing']);
     *
     * return;
     * }
     * $parents = collect([]);
     * $panel_curr = $panel;
     *
     * while (null != $panel_curr->getParent()) {
     * $parents->prepend($panel_curr->getParent());
     * $panel_curr = $panel_curr->getParent();
     * }
     * $container_root = $panel->getRow();
     * if ($parents->count() > 0) {
     *
     * //$tmp='['.$parents->count().']';
     * //foreach($parents as $parent){
     * //    $tmp.=$parent->getRow()->post_type.'-';
     * //}
     * //return $tmp;
     *
     * $container_root = $parents->first()?->row;
     * }
     *
     * //$containers_class = self::getContainersClass();
     * //$n = collect($containers_class)->search(get_class($container_root));
     * //if (null === $n) {
     * //    $n = 0;
     * //}
     *
     * $n = 0;
     *
     * $route_name = self::getRoutenameN(['n' => $n + 1 + $parents->count(), 'act' => $act]);
     * $route_current = \Route::current();
     * $route_params = is_object($route_current) ? $route_current->parameters() : [];
     *
     * $i = 0;
     * foreach ($parents as $parent) {
     * $route_params['container'.($n + $i)] = $parent->postType();
     * $route_params['item'.($n + $i)] = $parent->guid();
     * ++$i;
     * }
     * $route_params['container'.($n + $i)] = $panel->postType();
     * $route_params['item'.($n + $i)] = $panel->guid();
     * ++$i;
     * $route_params['container'.($n + $i)] = $related_name;
     *
     * $route_params['page'] = 1;
     * $route_params['_act'] = '';
     * unset($route_params['_act']);
     * try {
     * $url = str_replace(url(''), '', route($route_name, $route_params));
     * } catch (\Exception $e) {
     * if (request()->input('debug', false)) {
     * dddx([
     * 'route_name' => $route_name,
     * 'route_params' => $route_params,
     * 'line' => __LINE__,
     * 'file' => __FILE__,
     * 'e' => $e->getMessage(),
     * ]);
     * }
     *
     * return '#['.__LINE__.']['.class_basename($this).']';
     * }
     *
     * return $url;
     * }
     */
    /**
     * @param  array<string,string>  $params
     */
    public static function urlLang(array $params = []): string
    {
        extract($params);

        return '?';

        /*
         * return '?'.$lang; //da fixare dopo
         * //$row=$this->row;
         * //$row->lang=$lang;
         * //return '/wip'.$this->url();
         * $route_name = \Route::currentRouteName();
         * $route_params = optional(\Route::current())->parameters();
         * $route_params['lang'] = $lang;
         * [$containers, $items] = params2ContainerItem($route_params);
         * $n_items = count($items);
         * //dddx($n_items);//1
         * //dddx($route_name); containers.show
         * for ($i = 0; $i < $n_items; ++$i) {
         * $v = $items[$i];
         * if (method_exists($v, 'postLang')) {
         * $tmp = $v->postLang($lang)->first();
         * if (is_object($tmp)) {
         * $guid = $tmp->guid;
         * } else {
         * $guid = '#';
         * //dddx(app()->getLocale());
         * $v_post = $v->post;
         * if (null == $v_post) {
         * break;
         * }
         * $new_post = $v_post->replicate();
         * $fields = ['title', 'subtitle', 'txt', 'meta_description', 'meta_keywords'];
         * foreach ($fields as $field) {
         * $trans = ImportService::trans(['q' => $new_post->$field, 'from' => app()->getLocale(), 'to' => $lang]);
         *
         * //dddx([
         * //    'from'=>app()->getLocale(),
         * //    'to'=>$lang,
         * //    'trans'=>$trans,
         *
         * //]);
         *
         * $new_post->$field = $trans;
         * }
         * $new_post->lang = $lang;
         * $new_post->save();
         * $guid = $new_post->guid;
         * }
         * } else {
         * $route_key_name = $v->getRouteKeyName();
         * $guid = $v->$route_key_name;
         * }
         *
         * $route_params['item'.$i] = $guid;
         * //dddx($route_params['item'.$i]->guidLang);
         * }
         * //dddx($route_params);
         * //return '/wip['.__LINE__.']['.class_basename($this).']';
         * try {
         * return route($route_name, $route_params);
         * } catch (\Exception $e) {
         * return url($lang);
         * }
         */
    }

    /**
     * Function getAct.
     *
     * @throws Exception
     */
    public static function getAct(): string
    {
        $route_action = Route::currentRouteAction();
        if ($route_action === null) {
            throw new Exception('$route_action is null');
        }

        $act = Str::after($route_action, '@');

        // --- i prossimi 2 if son per i controller con metodo invoke
        if (Str::contains($act, '\\')) {
            $act = Str::afterLast($act, '\\');
        }

        if (Str::endsWith($act, 'Controller')) {
            $act = Str::before($act, 'Controller');
        }

        return Str::snake($act);
    }

    /**
     * Function.
     *
     * @throws Exception
     */
    public static function getModuleName(): string
    {
        $route_action = Route::currentRouteAction();
        if ($route_action === null) {
            throw new Exception('$route_action is null');
        }

        return Str::between($route_action, 'Modules\\', '\Http');
    }

    /**
     * Function.
     *
     * @throws Exception
     */
    public static function getControllerName(): string
    {
        $route_action = Route::currentRouteAction();
        if ($route_action === null) {
            throw new Exception('$route_action is null');
        }

        return Str::between($route_action, 'Http\Controllers\\', 'Controller');
    }

    public static function getView(): string
    {
        $controllerName = self::getControllerName();
        $tmp_arr = explode('\\', $controllerName);

        $params = getRouteParameters();
        [$containers, $items] = params2ContainerItem($params);

        $params['containers'] = implode('.', $containers);

        return collect($tmp_arr)
            ->filter(static fn ($item): bool => ! \in_array($item, ['Module', 'Item'], false))
            ->map(static function ($item) use ($params) {
                $item = Str::snake($item);

                return $params[$item] ?? $item;
            })
            ->implode('.');
    }
}
