<?php

declare(strict_types=1);

$adm_theme = 'Zero';
// $adm_theme = 'SoftUi';
// $adm_theme = 'MaterialAdm';
$pub_theme = $adm_theme;
// $theme = 'SbAdmin';
// $pub_theme = 'MaterialBlog';

return [
    'adm_theme' => $adm_theme,
    'pub_theme' => $pub_theme,

    'enable_ads' => '2',
    'forcessl' => false,
    'login_type' => '1',
    'main_module' => 'Ptv',
    'notUsePanelMiddleware' => false,
    'primary_lang' => 'it',
    'show_trans_key' => false,
    'test' => 'ooo',
    'disable_frontend_dynamic_route' => true,
    'disable_admin_dynamic_route' => true,
    'super_admin' => 'marco.sottana@gmail.com',
];
