<?php

declare(strict_types=1);

use Modules\IndennitaCondizioniLavoro\Models\CondizioniLavoroAdm;
use Modules\IndennitaCondizioniLavoro\Models\CondizioniLavoroRep;
use Modules\IndennitaCondizioniLavoro\Models\ServizioEsternoRep;
use Modules\IndennitaResponsabilita\Models\IndennitaResponsabilita;
use Modules\IndennitaResponsabilita\Models\LettF;
use Modules\Sigma\Models\_ListaTbl;
use Modules\User\Models\User;
use Modules\Xot\Models\Profile;
use Modules\Xot\Models\Widget;

return ['__lista_tbl' => _ListaTbl::class,
    'application' => 'Modules\User\Models\Application',
    'area' => 'Modules\User\Models\Area',
    'article' => 'Modules\Blog\Models\Article',
    'blog' => 'Modules\Blog\Models\Blog',
    'category' => 'Modules\Blog\Models\Category',
    'comment' => 'Modules\Blog\Models\Comment',
    'condizioni_lavoro_adm' => CondizioniLavoroAdm::class,
    'condizioni_lavoro_rep' => CondizioniLavoroRep::class,
    'conf' => 'Modules\Xot\Models\Conf',
    'contact' => 'Modules\Blog\Models\Contact',
    'container' => 'Modules\Blog\Models\Container',
    'doc' => 'Modules\Blog\Models\Doc',
    'event' => 'Modules\Blog\Models\Event',
    'home' => 'Modules\Xot\Models\Home',
    'image' => 'Modules\Xot\Models\Image',
    'indennita_responsabilita' => IndennitaResponsabilita::class,
    'lett_f' => LettF::class,
    'location' => 'Modules\Blog\Models\Location',
    'metatag' => 'Modules\Xot\Models\Metatag',
    'my_rating' => 'Modules\Rating\Models\MyRating',
    'page' => 'Modules\Blog\Models\Page',
    'photo' => 'Modules\Blog\Models\Photo',
    'privacy' => 'Modules\Blog\Models\Privacy',
    'profile' => Profile::class,
    'rating' => 'Modules\Rating\Models\Rating',
    'servizio_esterno_rep' => ServizioEsternoRep::class,
    'settings' => 'Modules\Settings\Models\Settings',
    'tag' => 'Modules\Blog\Models\Tag',
    'translation' => 'Modules\Xot\Models\Translation',
    'trasferte_Modules\User\Models\Usererte\Models\Trasferte',
    'trasferte_dip' => 'Modules\Trasferte\Models\Trasferte',
    'user' => User::class,
    'widget' => Widget::class,
];
