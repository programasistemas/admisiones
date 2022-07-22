<?php

require_once '../../../php/includes/routes.config.inc.php';
require_once REQUESTS_VALIDATION_HELPERS_PATH;
require_once RESPONSES_PATH;

if (!validateRequest(RECOVER_PASSWORD_PATH))
    httpResponse(LOGIN_PATH, 403);

require_once RESPONSE_ENTITY_PATH;
$response = new ResponseEntity(true, false);

$data = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

if (!$data)
    $response->error('No se enviaron los datos correctamente, intente nuevamente.');

require_once DB_CONFIG_PATH;
$query_builder = DBConfig::getDoctrineQueryBuilder();

$user = $query_builder
    ->select('email')
    ->from('usuario')
    ->where('email = ? AND estado = "ACTIVO"')
    ->setParameter(0, $data)
    ->fetchAssociative();

if ($user) {
    // If the previous validations are passed, then, create the variables with the token and associates
    $selector = bin2hex(random_bytes(10));
    $token = random_bytes(32);
    $expires = date('U') + 1800; // 30 minutes of expiration
    $url = DOMAIN . CHANGE_PASSWORD_PATH . '?selector=' . $selector . '&validator=' . bin2hex($token);
    $hashed_token = password_hash($token, PASSWORD_DEFAULT);

    try {
        $query_builder
            ->delete('pwdReset')
            ->where('pwdResetEmail = ?')
            ->setParameter(0, $user['email'])
            ->executeQuery();

        $query_builder
            ->insert('pwdReset')
            ->values([
                'pwdResetEmail' => '?',
                'pwdResetSelector' => '?',
                'pwdResetToken' => '?',
                'pwdResetExpires' => '?'
            ])
            ->setParameters([
                0 => $user['email'],
                1 => $selector,
                2 => $hashed_token, 3 => $expires
            ])->executeQuery();
    } catch (Exception $e) {
        $response->error('No se ha podido finalizar el proceso debido a un error inesperado.');
    }

    $user_email = $user['email'];
    $subject = 'Solicitud de reestablecimiento de contraseña | UNITROPICO';
    $message = '<p>
                    Hemos recibido una solicitud de reestablecimiento de contraseña para el usuario: 
                    <strong>' . $user_email . '</strong>
                    de la plataforma de admisiones de Unitrópico, el link para reestablecer 
                    la contraseña lo encontraras a continuación, si no realizaste esta petición puedes ignorarla.
                </p>
                <p>Link de reestablecimiento de tu contraseña: 
                    <br>
                    <a href = " ' . $url . '">Reestablecer contraseña</a>
                </p>';

    require_once EMAIL_SENDING_PATH;
    if (!EmailSending::send($user_email, $subject, $message))
        $response->error('No se podido finalizar el proceso debido a un error inesperado.');
}

$response->ok(
    'Si la cuenta existe le serán enviadas las instrucciones para recuperar su contraseña al correo ingresado.',
    ['redirect' => LOGIN_PATH]
);
