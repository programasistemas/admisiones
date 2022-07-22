<?php

require_once '../../php/includes/routes.config.inc.php';
require_once RESPONSES_PATH;
require_once REQUESTS_VALIDATION_HELPERS_PATH;

if (!validateRequest(LOGIN_PATH)) httpResponse(LOGIN_PATH, 403);
if (!isset($_SESSION)) session_start();

require_once RESPONSE_ENTITY_PATH;
$response = new ResponseEntity(true, false);

if (
    !isset($_SESSION['token']) ||
    empty($_SESSION['token'])
) {
    $response->error('Acceso inválido, recarga la página e intenta de nuevo.');
}

$data = filter_input_array(INPUT_POST, [
    'email' => FILTER_VALIDATE_EMAIL,
    'password' => FILTER_SANITIZE_FULL_SPECIAL_CHARS
]);

if ($data == false || in_array(null, $data))
    $response->error('Los datos enviados son inválidos, vuelva a intentarlo.');

require_once DB_CONFIG_PATH;
$query_builder = DBConfig::getDoctrineQueryBuilder();

$user = $query_builder
    ->select('codigo', 'tipo_usuario', 'primer_nombre', 'primer_apellido', 'clave', 'numero_documento')
    ->from('usuario')
    ->where('email = ? AND estado = "ACTIVO"')
    ->setParameter(0, $data['email'])
    ->fetchAssociative();

if ($user == false || !password_verify($data['password'], $user['clave']))
    $response->error('Email y/o contraseña incorrectos');

$doc_number = array_pop($user);
$password = array_pop($user);

unset($_SESSION['token']);
$session_keys = ['USER_ID', 'USER_TYPE', 'USER_FIRST_NAME', 'USER_FIRST_SURNAME'];

require_once UTILS_PATH;
$_SESSION = array_combine($session_keys, array_values($user));
$_SESSION['USER_LOGIN_STATUS'] = 1; // Estado de login del usuario
$_SESSION['CREATED']           = time();
$_SESSION['PERMISSIONS']       = getUserPermissions($user['tipo_usuario']);

$applicant = $query_builder
    ->select('aspirante.codigo')
    ->from('aspirante')
    ->where('codigo_usuario = ?')
    ->setParameter(0, $user['codigo'])
    ->fetchAssociative();

if ($applicant != false)
    $_SESSION['APPLICANT_CODE'] = $applicant['codigo'];

if (password_verify($doc_number, $password)) {
    $message = 'En breve serás redirigido a una nueva página para que actualices tu contraseña.';
    $link = CHANGE_PASSWORD_PATH . '?extra=equals';
} else {
    $message = 'En breve serás redirigido a la página principal.';
    $link = HOME_PATH;
}

$response->ok(
    $message,
    ['redirect' => $link]
);
