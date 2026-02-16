<?php

declare(strict_types=1);

return array (
  'password_confirm' => 
  array (
    'heading' => 'Confirmar palavra-passe',
    'description' => 'Por favor, confirme a sua palavra-passe para completar esta acção.',
    'current_password' => 'Palavra-passe actual',
  ),
  'two_factor' => 
  array (
    'heading' => 'Autenticação por 2 Factores',
    'description' => 'Por favor, confirme o acesso à sua conta indicando o código gerado pela sua aplicação de autenticação.',
    'code_placeholder' => 'XXX-XXX',
    'recovery' => 
    array (
      'heading' => 'Autenticação por 2 Factores',
      'description' => 'Por favor, confirme o acesso à sua conta indicando um dos códigos de recuperação.',
    ),
    'recovery_code_placeholder' => 'abcdef-98765',
    'recovery_code_text' => 'Perdeu o dispositivo?',
    'recovery_code_link' => 'Utilizar um código de recuperação',
    'back_to_login_link' => 'Voltar ao início',
  ),
  'profile' => 
  array (
    'account' => 'Conta',
    'profile' => 'Perfil',
    'my_profile' => 'O Meu Perfil',
    'subheading' => 'Gerir o meu perfil de utilizador.',
    'personal_info' => 
    array (
      'heading' => 'Informação Pessoal',
      'subheading' => 'Gerir a minha informação pessoal.',
      'submit' => 
      array (
        'label' => 'Actualizar',
      ),
      'notify' => 'Perfil actualizado com sucesso!',
    ),
    'password' => 
    array (
      'heading' => 'Palavra-passe',
      'subheading' => 'Deve conter, no mínimo, 8 caracteres.',
      'submit' => 
      array (
        'label' => 'Actualizar',
      ),
      'notify' => 'Palavra-passe actualizada com sucesso!',
    ),
    '2fa' => 
    array (
      'title' => 'Autenticação por 2 Factores',
      'description' => 'Gerir a autenticação por 2 factores para a minha conta (recomendado).',
      'actions' => 
      array (
        'enable' => 'Activar',
        'regenerate_codes' => 'Regerar Códigos de Recuperação',
        'disable' => 'Desactivar',
        'confirm_finish' => 'Confirmar & concluir',
        'cancel_setup' => 'Cancelar ativação',
      ),
      'setup_key' => 'Chave de Configuração',
      'must_enable' => 'É necessário activar a Autenticação por 2 Factores para utilizar esta aplicação.',
      'not_enabled' => 
      array (
        'title' => 'Ainda não activou a autenticação por 2 factores.',
        'description' => 'Quando a autenticação por 2 factores está activa, ser-lhe-á pedido uma chave segura e aleatória, durante o processo de autenticação. Pode obter esta chave através da aplicação Google Authenticator no seu telemóvel.',
      ),
      'finish_enabling' => 
      array (
        'title' => 'Concluir a activação da autenticação por 2 factores.',
        'description' => 'Para concluir a activação da autenticação por 2 factores, leia o código QR utilizando a aplicação de autenticação no seu telemóvel ou indique a chave de configuração e insira o código OTP gerado.',
      ),
      'enabled' => 
      array (
        'notify' => 'Autenticação por 2 factores activada.',
        'title' => 'Autenticação por 2 factores activada!',
        'description' => 'A autenticação por 2 factores encontra-se activada! Esta autenticação ajuda a manter a sua conta mais segura.',
        'store_codes' => 'Os seguintes códigos podem ser utilizados para recuperar o acesso à sua conta caso perca o seu telemóvel. Atenção! Estes códigos só serão mostrados uma vez.',
      ),
      'disabling' => 
      array (
        'notify' => 'Autenticação por 2 factores desactivada.',
      ),
      'regenerate_codes' => 
      array (
        'notify' => 'Foram gerados novos códigos de recuperação.',
      ),
      'confirmation' => 
      array (
        'success_notification' => 'Código verificado. Autenticação por 2 factores activada.',
        'invalid_code' => 'O código que indicou é inválido.',
      ),
    ),
    'sanctum' => 
    array (
      'title' => 'Chaves únicas API',
      'description' => 'Gerir chaves únicas API que permitem a serviços de terceiros a aceder a esta aplicação com os seus dados.',
      'create' => 
      array (
        'notify' => 'Chave única criada com sucesso!',
        'message' => 'A sua chave única será mostrada, apenas, uma vez aquando da sua criação. Se a perder, terá de a eliminar e criar uma nova.',
        'submit' => 
        array (
          'label' => 'Criar',
        ),
      ),
      'update' => 
      array (
        'notify' => 'Chave única actualizada com sucesso!',
      ),
      'copied' => 
      array (
        'label' => 'Já copiei a minha chave única',
      ),
    ),
  ),
  'clipboard' => 
  array (
    'link' => 'Copiar para a área de transferência',
    'tooltip' => 'Copiado!',
  ),
  'fields' => 
  array (
    'avatar' => 
    array (
      'label' => 'Avatar',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'email' => 
    array (
      'label' => 'E-mail',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'login' => 
    array (
      'label' => 'Iniciar sessão',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'name' => 
    array (
      'label' => 'Nome',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'password' => 
    array (
      'label' => 'Palavra-passe',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'password_confirm' => 
    array (
      'label' => 'Confirmar palavra-passe',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'new_password' => 
    array (
      'label' => 'Nova palavra-passe',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'new_password_confirmation' => 
    array (
      'label' => 'Confirmação de nova palavra-passe',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'token_name' => 
    array (
      'label' => 'Nome da chave única',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'token_expiry' => 
    array (
      'label' => 'Validade da chave única',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'abilities' => 
    array (
      'label' => 'Capacidades',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    '2fa_code' => 
    array (
      'label' => 'Código',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    '2fa_recovery_code' => 
    array (
      'label' => 'Código de Recuperação',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'created' => 
    array (
      'label' => 'Criado',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'expires' => 
    array (
      'label' => 'Expira',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'or' => 'Ou',
  'cancel' => 'Cancelar',
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
