<?php

declare(strict_types=1);

return array (
  'backend' => 
  array (
    'access' => 
    array (
      'users' => 
      array (
        'delete_user_confirm' => 'Gebruiker permanent verwijderen? Overal in de applicaties waar gerefereerd wordt naar dit gebruikers-ID zal een fout ontstaan. Doorgaan op eigen risico. Dit kan niet ongedaan gemaakt worden.',
        'if_confirmed_off' => '(Als bevestiging uit staat)',
        'restore_user_confirm' => 'Herstel deze gebruiker naar de originele staat?',
      ),
    ),
    'dashboard' => 
    array (
      'title' => 'Beheer Dashboard',
      'welcome' => 'Welkom',
    ),
    'general' => 
    array (
      'all_rights_reserved' => 'Alle Rechten Voorbehouden.',
      'are_you_sure' => 'Zeker?',
      'boilerplate_link' => 'Laravel 5 Boilerplate',
      'continue' => 'Doorgaan',
      'member_since' => 'Lid sinds',
      'minutes' => ' minuten',
      'search_placeholder' => 'Zoeken...',
      'timeout' => 'Automatisch uitgelogd vanwege veiligheidsredenen aangezien er geen activiteit was in ',
      'see_all' => 
      array (
        'messages' => 'Alle messages bekijken',
        'notifications' => 'Bekijk alles',
        'tasks' => ' Alle taken bekijken',
      ),
      'status' => 
      array (
        'online' => 'Online',
        'offline' => 'Offline',
      ),
      'you_have' => 
      array (
        'messages' => '{0} U heeft geen berichten|{1} U heeft 1 bericht|[2,Inf] U heeft :number berichten',
        'notifications' => '{0} U heeft geen notificaties|{1} U heeft 1 notificatie|[2,Inf] U heeft :number notificaties',
        'tasks' => '{0} U heeft geen taken|{1} U heeft 1 taak|[2,Inf] U heeft :number taken',
      ),
    ),
    'search' => 
    array (
      'empty' => 'Please enter a search term.',
      'incomplete' => 'You must write your own search logic for this system.',
      'title' => 'Search Results',
      'results' => 'Search Results for :query',
    ),
    'welcome' => '<p>Dit is het AdminLTE thema door <a href="https://almsaeedstudio.com/" target="_blank">https://almsaeedstudio.com/</a>. Dit is een uitgeklede versie met alleen de stijlen and scripts om het geheel draaiende te krijgen. Download de volledige versie om componenten aan het dashboard toe te voegen.</p>
<p>Alle functionaliteit is voor de show, met uitzondering van de <strong>Toegangs Beheer</strong> aan de linkerkant. Deze boilerplate komt standaard met een volledig functionele toegangs beheer bibliotheek om gebruikers/rollen/permissies to beheren</p>
<p>Bedenk wel dat dit werk in uitvoering is en dat er fouten of andere problemen kunnen zijn die ik niet ben tegengekomen. Ik zal mijn best doen om deze te repareren wanneer ik deze ontvang.</p>
<p>Hopelijk geniet je van alle werk dat ik hierin heb gestopt. Bezoek de <a href="https://github.com/rappasoft/laravel-5-boilerplate" target="_blank">GitHub</a> pagina voor meer informatie en om <a href="https://github.com/rappasoft/Laravel-5-Boilerplate/issues" target="_blank">problemen</a> te rapporteren.</p>
<p><strong> Dit project is zeer veeleisend om bij te houden gegeven de snelheid waarmee de master Laravel branch verandert, dus elke vorm van hulp wordt gewaardeert.</strong></p>
<p>- Anthony Rappa</p>',
  ),
  'emails' => 
  array (
    'auth' => 
    array (
      'error' => 'Oeps!',
      'greeting' => 'Hallo!',
      'regards' => 'Groet,',
      'trouble_clicking_button' => 'Als u problemen heeft met de ":actionText" button, kopieer en plak dan de onderstaande URL in uw web browser:',
      'thank_you_for_using_app' => 'Dank u voor het gebruik van onze applicatie!',
      'password_reset_subject' => 'Uw Wachtwoord Reset Link',
      'password_cause_of_email' => 'U ontvangt deze email omdat we een wachtwoord reset verzoek hebben ontvangen voor uw account',
      'password_if_not_requested' => 'Als u geen wachtwoord reset heeft aangevraagd hoeft geen verdere actie te ondernemen.',
      'reset_password' => 'Klik hier om uw wachtwoord te resetten',
      'click_to_confirm' => 'Klik hier om uw account te bevestigen:',
    ),
  ),
  'frontend' => 
  array (
    'test' => 'Test',
    'tests' => 
    array (
      'based_on' => 
      array (
        'permission' => 'Permissie Gebaseerd - ',
        'role' => 'Rol Gebaseerd - ',
      ),
      'js_injected_from_controller' => 'Javascript geinjecteerd vanuit de Controller',
      'using_blade_extensions' => 'Gebruik makend van Blade Extensies',
      'using_access_helper' => 
      array (
        'array_permissions' => 'Gebruik makend van Access Helper met Array van Permissies van Namen of id\'s waar de gebruiker ze allemaal benodigd is.',
        'array_permissions_not' => 'Gebruik makend van Access Helper met Array van Permissies van Namen of id\'s waar de gebruiker ze niet allemaal benodigd is.',
        'array_roles' => 'Gebruik makend van Access Helper met Array van Permissies van Rolnamen of id\'s waar de gebruiker ze allemaal benodigd is.',
        'array_roles_not' => 'Gebruik makend van Access Helper met Array van Permissies van Rolnamen of id\'s waar de gebruiker ze niet allemaal benodigd is.',
        'permission_id' => 'Gebruik makend van Access Helper met Permissie ID',
        'permission_name' => 'Gebruik makend van Access Helper met Permission Naam',
        'role_id' => 'Gebruik makend van Access Helper met Rol ID',
        'role_name' => 'Gebruik makend van Access Helper met Rol Naam',
      ),
      'view_console_it_works' => 'U zou \'it works!\' in de console moeten zien, welke komt vanuit FrontendController@index',
      'you_can_see_because' => 'U kunt dit zien omdat u de rol heeft van \':role\'!',
      'you_can_see_because_permission' => 'U kunt dit zien omdat u de permissie van \':permission\'!',
    ),
    'user' => 
    array (
      'profile_updated' => 'Profiel succesvol bijgewerkt.',
      'password_updated' => 'Wachtwoord succesvol bijgewerkt.',
    ),
    'welcome_to' => 'Welkom bij :place',
  ),
  'navigation' => 
  array (
    'label' => 'Missing Navigation Label',
    'plural_label' => 'Missing Navigation Plural Label',
    'group' => 'Missing Group',
    'icon' => 'heroicon-o-puzzle-piece',
    'sort' => 100,
  ),
  'label' => 'Missing Label',
  'plural_label' => 'Missing Plural label',
  'fields' => 
  array (
  ),
  'actions' => 
  array (
  ),
);
