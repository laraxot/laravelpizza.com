<?php

declare(strict_types=1);

return array (
  'login' => 
  array (
    'username_or_email' => 'Käyttäjätunnus tai sähköposti',
    'forgot_password_link' => 'Unohditko salasanan?',
    'create_an_account' => 'Luo tili',
  ),
  'password_confirm' => 
  array (
    'heading' => 'Vahvista salasana',
    'description' => 'Vahvista salasanasi jatkaaksesi.',
    'current_password' => 'Nykyinen salasana',
  ),
  'two_factor' => 
  array (
    'heading' => 'Kaksivaiheinen tunnistautuminen',
    'description' => 'Vahvista pääsy tiliisi antamalla sovelluksen luoma varmennuskoodi.',
    'code_placeholder' => 'XXX-XXX',
    'recovery' => 
    array (
      'heading' => 'Kaksivaiheinen tunnistautuminen',
      'description' => 'Vahvista pääsy tilillesi antamalla palautuskoodi.',
    ),
    'recovery_code_placeholder' => 'abcdef-98765',
    'recovery_code_text' => 'Kadonnut laite?',
    'recovery_code_link' => 'Käytä palautuskoodi',
    'back_to_login_link' => 'Takaisin kirjautumiseen',
  ),
  'registration' => 
  array (
    'title' => 'Rekisteröi',
    'heading' => 'Luo tili',
    'submit' => 
    array (
      'label' => 'Kirjaudu',
    ),
    'notification_unique' => 'Tili tällä sähköpostilla on jo olemassa. Kirjaudu sisään.',
  ),
  'reset_password' => 
  array (
    'title' => 'Salasana unohdettu',
    'heading' => 'Palauta salasanasi',
    'submit' => 
    array (
      'label' => 'Lähetä',
    ),
    'notification_error' => 'Virhe: Yritä uudelleen myöhemmin. Pyydä uusi palautuslinkki.',
    'notification_error_link_text' => 'Yritä uudestaan',
    'notification_success' => 'Tarkista sähköpostisi ohjeita varten!',
  ),
  'verification' => 
  array (
    'title' => 'Vahvista sähköposti',
    'heading' => 'Sähköpostin vahvistus vaaditaan',
    'submit' => 
    array (
      'label' => 'Kirjaudu ulos',
    ),
    'notification_success' => 'Tarkista sähköpostisi ohjeita varten!',
    'notification_resend' => 'Sähköpostin vahvistus on lähetetty uudestaan',
    'before_proceeding' => 'Ennen kuin voit jatkaa, tarkista vahvistuslinkki sähköpostistasi.',
    'not_receive' => 'Jos et saanut sähköpostia,',
    'request_another' => 'paina tästä lähettääksesi uuden',
  ),
  'profile' => 
  array (
    'account' => 'Tili',
    'profile' => 'Profiili',
    'my_profile' => 'Profiilini',
    'personal_info' => 
    array (
      'heading' => 'Henkilökohtaiset tiedot',
      'subheading' => 'Muokkaa omia tietojasi.',
      'submit' => 
      array (
        'label' => 'Päivitä',
      ),
      'notify' => 'Profiili päivitetty!',
    ),
    'password' => 
    array (
      'heading' => 'Salasana',
      'subheading' => 'Pitää olla vähintään 8 merkkiä.',
      'submit' => 
      array (
        'label' => 'Päivitä',
      ),
      'notify' => 'Salasana vaihdettu!',
    ),
    '2fa' => 
    array (
      'title' => 'Kaksivaiheinen tunnistautuminen',
      'description' => 'Hallinnoi tilisi kaksivaiheista tunnistautumista (suositeltavaa).',
      'actions' => 
      array (
        'enable' => 'Ota käyttöön',
        'regenerate_codes' => 'Luo koodit uudestaan',
        'disable' => 'Ota pois käytöstä',
        'confirm_finish' => 'Vahvista & Lopeta',
        'cancel_setup' => 'Peruuta asetus',
      ),
      'setup_key' => 'Avaimen asetus',
      'not_enabled' => 
      array (
        'title' => 'Et ole ottanut kaksivaiheista tunnistautumista käyttöön.',
        'description' => 'Kun kaksivaiheinen tunnistautuminen on käytössä, sinulta kysytään satunnainen koodi varmistamista varten. Voit hankkia sen puhelimesi todentamissovelluksella.',
      ),
      'finish_enabling' => 
      array (
        'title' => 'Viimeistele kaksivaiheisen tunnistaumisen käyttöönotto.',
        'description' => 'Kaksivaiheise tunnistautumisen viimeistelemistä, skannaa QR-koodi puhelimesi todentamissovelluksella tai lisää annettu avain ja syötä luotu kertakäyttökoodi.',
      ),
      'enabled' => 
      array (
        'title' => 'Olet ottanut kaksivaiheisen tunnistautumisen käyttöön!',
        'description' => 'Kaksivaiheinen tunnistautuminen on päällä. Tämän avulla tilisi on turvallisempi.',
        'store_codes' => 'Pidä palautuskoodit turvallisessa sijainnissa. Näitä koodeja käytetään jos kaksivaiheisen tunnistautumisen laite ei ole saatavilla.',
        'show_codes' => 'Näytä palautuskoodit',
        'hide_codes' => 'Piilota palautuskoodit',
      ),
      'confirmation' => 
      array (
        'success_notification' => 'Koodi vahvistettu, kaksivaiheinen tunnistauminen on käytössä.',
        'invalid_code' => 'Antamasi koodi on viallinen.',
      ),
    ),
    'sanctum' => 
    array (
      'title' => 'API valtuutus',
      'description' => 'Hallinnoi API valtuutuuksia joiden avulla kolmannen osapuolen palvelut voivat ottaa yhteyden tähän palveluun puolestasi. HUOM: valtuutus näytetään luomisen yhteydessä. Jos menetät valtuutuksen, poista vanha ja luo uusi.',
      'create' => 
      array (
        'notify' => 'Valtuutus luotu!',
        'submit' => 
        array (
          'label' => 'Luo',
        ),
      ),
      'update' => 
      array (
        'notify' => 'Valtuutus päivitetty!',
      ),
    ),
  ),
  'clipboard' => 
  array (
    'link' => 'Kopioi leikepöydälle',
    'tooltip' => 'Kopioitu!',
  ),
  'fields' => 
  array (
    'email' => 
    array (
      'label' => 'Sähköposti',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'login' => 
    array (
      'label' => 'Kirjaudu',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'name' => 
    array (
      'label' => 'Nimi',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'password' => 
    array (
      'label' => 'Salasana',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'password_confirm' => 
    array (
      'label' => 'Vahvista salasana',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'new_password' => 
    array (
      'label' => 'Uusi salasana',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'new_password_confirmation' => 
    array (
      'label' => 'Vahvista uusi salasana',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'token_name' => 
    array (
      'label' => 'Valtuutuksen nimi',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'abilities' => 
    array (
      'label' => 'Kyvyt',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    '2fa_code' => 
    array (
      'label' => 'Koodi',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    '2fa_recovery_code' => 
    array (
      'label' => 'Palautuskoodi',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'created' => 
    array (
      'label' => 'Luotu',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'expires' => 
    array (
      'label' => 'Vanhenee',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'or' => 'Tai',
  'cancel' => 'Peruuta',
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
  'actions' => 
  array (
  ),
);
