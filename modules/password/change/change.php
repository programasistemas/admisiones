<?php

require_once '../../../php/includes/routes.config.inc.php';
require_once REQUESTS_VALIDATION_HELPERS_PATH;
require_once RESPONSES_PATH;

if (!validateRequest(CHANGE_PASSWORD_PATH)) {
    httpResponse(HOME_PATH, 403);
}

$password_restauration_data = filter_input_array(INPUT_POST, [
    'selector' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    'validator' => FILTER_SANITIZE_FULL_SPECIAL_CHARS
]);

require_once RESPONSE_ENTITY_PATH;
$response = $password_restauration_data == false ?
    new ResponseEntity() :
    new ResponseEntity(true, false);

$password_data = filter_input_array(INPUT_POST, [
    'password' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    'passwordConfirmation' => FILTER_SANITIZE_FULL_SPECIAL_CHARS
]);

if ($password_data == false || in_array(null, $password_data))
    $response->error('La información no fue enviada en su totalidad, intente nuevamente.');

$password_regex = '/^(?=.*?[A-Z])(?=(.*[a-z]){1,})(?=(.*[\d]){1,})(?=(.*[\W]){1,})(?!.*\s).{8,}$/';
if (count(preg_grep($password_regex, $password_data)) < 2)
    $response->error('La nueva contraseña no cumple con los requisitos mínimos.');

if ($password_data['password'] !== $password_data['passwordConfirmation'])
    $response->error('Las contraseñas no coinciden.');

require_once DB_CONFIG_PATH;
$query_builder = DBConfig::getDoctrineQueryBuilder();
$is_forget_process = false;

if ($password_restauration_data != false && !in_array(null, $password_restauration_data)) {
    $is_forget_process = true;
    $selector = $password_restauration_data['selector'];
    $validator = $password_restauration_data['validator'];

    if (empty($selector) || empty($validator))
        $response->error('Proceso de restauración de contraseña inválido.');

    $token_data = $query_builder
        ->select('pwdResetEmail, pwdResetToken, pwdResetExpires')
        ->from('pwdReset')
        ->where('pwdResetSelector = ?')
        ->setParameter(0, $selector)
        ->fetchAssociative();

    if ($token_data == false || date('U') > $token_data['pwdResetExpires'])
        $response->error('El token de restauración enviado no es válido.');

    if (!ctype_xdigit($validator) || strlen($validator) % 2 != 0)
        $response->error('La verificación del token ha fallado.');

    $token_check = password_verify(hex2bin($validator), $token_data['pwdResetToken']);
    if ($token_check === false)
        $response->error('La verificación del token ha fallado.');

    $email = $token_data['pwdResetEmail'];

    $user = $query_builder
        ->select('codigo')
        ->from('usuario')
        ->where('email = ? AND estado = "ACTIVO"')
        ->setParameter(0, $email)
        ->fetchAssociative();

    if (!$user)
        $response->error('No se encontró un usuario activo vinculado al token enviado.');

    if (!isset($_SESSION)) session_start();
    $_SESSION['USER_ID'] = $user['codigo'];

    try {
        $query_builder
            ->delete('pwdReset')
            ->where('pwdResetEmail = ?')
            ->setParameter(0, $email)
            ->executeQuery();
    } catch (Exception $e) {
        $response->error('Ha ocurrido un error inesperado, intente nuevamente el proceso.');
    }
}

try {
    $query_builder
        ->update('usuario', 'u')
        ->set('u.clave', '?')
        ->where('u.codigo = ?')
        ->setParameter(0, password_hash($password_data['password'], PASSWORD_DEFAULT))
        ->setParameter(1, $_SESSION['USER_ID'])
        ->executeQuery();
} catch (Exception $e) {
    $response->error('No se ha podido realizar el cambio de la contraseña debido a un error inesperado.');
}

unset($query_builder);

if ($is_forget_process) {
    session_destroy();
    $message = 'La clave ha sido restaurada correctamente.';
    $link = LOGIN_PATH;
} else {
    $message = 'La clave ha sido cambiada correctamente.';
    $link = HOME_PATH;
}

$response->ok(
    $message,
    ['redirect' => $link]
);
