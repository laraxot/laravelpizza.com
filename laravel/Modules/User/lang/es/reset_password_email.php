<?php

declare(strict_types=1);

// Testi della mail di reimpostazione password (template database `reset-password`, creato da EnsureResetPasswordMailTemplateAction).
return [
    'subject' => 'Restablece tu contraseña',
    'greeting' => 'Estimado usuario,',
    'intro' => 'Hemos recibido una solicitud para restablecer la contraseña de tu cuenta de :app. Usa el botón de abajo para elegir una nueva.',
    'action' => 'Restablecer contraseña',
    'fallback' => 'Si el botón no funciona, copia esta dirección en tu navegador:',
    'ignore' => 'Si no has solicitado el cambio, puedes ignorar este mensaje: tu contraseña no cambiará.',
];
