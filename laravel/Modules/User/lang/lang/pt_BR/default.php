<?php

declare(strict_types=1);

return array (
  'login' => 
  array (
    'username_or_email' => 'Usuário ou Email',
    'forgot_password_link' => 'Esqueceu a senha?',
    'create_an_account' => 'Criar a sua conta',
  ),
  'password_confirm' => 
  array (
    'heading' => 'Confirme a senha',
    'description' => 'Confirme sua senha para concluir esta ação.',
    'current_password' => 'Senha atual',
  ),
  'two_factor' => 
  array (
    'heading' => 'Autenticação de dois fatores',
    'description' => 'Confirme o acesso à sua conta digitando o código de autenticação fornecido pelo seu aplicativo autenticador.',
    'code_placeholder' => 'XXX-XXX',
    'recovery' => 
    array (
      'heading' => 'Autenticação de dois fatores',
      'description' => 'Confirme o acesso à sua conta digitando um dos seus códigos de recuperação de emergência.',
    ),
    'recovery_code_placeholder' => 'abcdef-98765',
    'recovery_code_text' => 'Sem o aplicativo?',
    'recovery_code_link' => 'Use um código de recuperação',
    'back_to_login_link' => 'Voltar para o login',
  ),
  'registration' => 
  array (
    'title' => 'Registrar',
    'heading' => 'Criar uma conta',
    'submit' => 
    array (
      'label' => 'Inscrever-se',
    ),
    'notification_unique' => 'Já existe uma conta com este e-mail. Por favor, verifique.',
  ),
  'reset_password' => 
  array (
    'title' => 'Esqueceu a senha',
    'heading' => 'Redefinir sua senha',
    'submit' => 
    array (
      'label' => 'Enviar',
    ),
    'notification_error' => 'Erro: Por favor, tente novamente mais tarde.',
    'notification_error_link_text' => 'Try Again',
    'notification_success' => 'Verifique sua caixa de entrada para instruções!',
  ),
  'verification' => 
  array (
    'title' => 'Verificar e-mail',
    'heading' => 'Verificação de e-mail requerida',
    'submit' => 
    array (
      'label' => 'Sair',
    ),
    'notification_success' => 'Verifique sua caixa de entrada para instruções!',
    'notification_resend' => 'O e-mail de verificação foi reenviado.',
    'before_proceeding' => 'Antes de prosseguir, por favor, procure no seu e-mail o link de verificação.',
    'not_receive' => 'Se você não recebeu o e-mail,',
    'request_another' => 'clique aqui para solicitar reenvio.',
  ),
  'profile' => 
  array (
    'account' => 'Conta',
    'profile' => 'Perfil',
    'subheading' => 'Administre seu perfil de usuário aqui.',
    'my_profile' => 'Meu Perfil',
    'personal_info' => 
    array (
      'heading' => 'Informações pessoais',
      'subheading' => 'Gerencie suas informações pessoais.',
      'submit' => 
      array (
        'label' => 'Atualizar',
      ),
      'notify' => 'Perfil atualizado com sucesso!',
    ),
    'password' => 
    array (
      'heading' => 'Senha',
      'subheading' => 'Deve conter 8 caracteres.',
      'submit' => 
      array (
        'label' => 'Atualizar',
      ),
      'notify' => 'Senha alterada com sucesso!',
    ),
    '2fa' => 
    array (
      'title' => 'Autenticação de 2 fatores',
      'description' => 'Gerencie a autenticação de 2 fatores para sua conta (recomendado).',
      'actions' => 
      array (
        'enable' => 'Habilitar',
        'regenerate_codes' => 'Regerar códigos',
        'disable' => 'Desabilitar',
        'confirm_finish' => 'Confirmar & finalizar',
        'cancel_setup' => 'Cancelar',
      ),
      'setup_key' => 'Chave de configuração',
      'must_enable' => 'Você deve ativar a autenticação de dois fatores para usar este aplicativo.',
      'not_enabled' => 
      array (
        'title' => 'Você não ativou a autenticação de dois fatores.',
        'description' => 'Quando a autenticação de dois fatores estiver habilitada, você será solicitado a fornecer um token seguro e aleatório durante a autenticação. Você pode recuperar esse token do aplicativo Google Authenticator do seu telefone.',
      ),
      'finish_enabling' => 
      array (
        'title' => 'Conclua a ativação da autenticação de dois fatores.',
        'description' => 'Para concluir a ativação da autenticação de dois fatores, digitalize o código QR a seguir usando o aplicativo autenticador do seu telefone ou insira a chave de configuração e forneça o código OTP gerado.',
      ),
      'enabled' => 
      array (
        'notify' => 'Autenticação de dois fatores habilitada.',
        'title' => 'Você habilitou a autenticação de dois fatores!',
        'description' => 'A autenticação de dois fatores agora está habilitada. Isso ajuda a tornar sua conta mais segura.',
        'store_codes' => 'Armazene esses códigos de recuperação em um gerenciador de senhas seguro. Eles podem ser usados para recuperar o acesso à sua conta se seu dispositivo de autenticação de dois fatores for perdido.',
        'show_codes' => 'Mostrar códigos de recuperação',
        'hide_codes' => 'Ocultar códigos de recuperação',
      ),
      'disabling' => 
      array (
        'notify' => 'A autenticação de dois fatores foi desativada.',
      ),
      'confirmation' => 
      array (
        'success_notification' => 'Código verificado. Autenticação de dois fatores habilitada.',
        'invalid_code' => 'O código que você digitou é inválido.',
      ),
    ),
    'sanctum' => 
    array (
      'title' => 'Tokens API',
      'description' => 'Gerencie tokens de API para permitir serviços de terceiros acessar este aplicativo em seu nome. NOTA: seu token é mostrado uma vez após a criação. Se você perder seu token, será necessário excluí-lo e criar um novo.',
      'create' => 
      array (
        'notify' => 'Token criado com sucesso!',
        'message' => 'Seu token só é mostrado uma vez após a criação. Se você perder seu token, precisará excluí-lo e criar um novo.',
        'submit' => 
        array (
          'label' => 'Criar',
        ),
      ),
      'update' => 
      array (
        'notify' => 'Token atualizado com sucesso!',
      ),
      'copied' => 
      array (
        'label' => 'Copiei meu token',
      ),
    ),
  ),
  'clipboard' => 
  array (
    'link' => 'Copiar para área de transferência',
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
      'label' => 'Usuário',
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
      'label' => 'Senha',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'password_confirm' => 
    array (
      'label' => 'Confirme a senha',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'new_password' => 
    array (
      'label' => 'Nova senha',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'new_password_confirmation' => 
    array (
      'label' => 'Confirme a senha',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'token_name' => 
    array (
      'label' => 'Nome do Token',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'token_expiry' => 
    array (
      'label' => 'Expiração do token',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'abilities' => 
    array (
      'label' => 'Permissões',
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
      'label' => 'Código de recuperação',
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
