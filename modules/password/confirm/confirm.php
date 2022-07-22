<?php

require_once '../../../php/includes/routes.config.inc.php';
require_once RESPONSES_PATH;
require_once REQUESTS_VALIDATION_HELPERS_PATH;

if (!validateRequest(CONFIRM_PASSWORD_PATH))
    httpResponse(LOGIN_PATH, 403);

require_once RESPONSE_ENTITY_PATH;
$response = new ResponseEntity();

$data = filter_input_array(INPUT_POST, [
    'change' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    'password' => FILTER_SANITIZE_FULL_SPECIAL_CHARS
]);

if (!$data || in_array(null, $data) || strlen($data['password']) == 0)
    $response->error('Los datos enviados son inválidos, intente nuevamente.');

require_once DB_CONFIG_PATH;
$query_builder = DBConfig::getDoctrineQueryBuilder();

$user = $query_builder
    ->select('clave')
    ->from('usuario')
    ->where('codigo = ?')
    ->setParameter(0, $_SESSION['USER_ID'])
    ->fetchAssociative();

if (!$user)
    $response->error('No se encontró el usuario, por favor vuelva a iniciar sesión.');

if (!password_verify($data['password'], $user['clave']))
    $response->error('La contraseña no coincide.');


require_once PHPENCYPTIONWRAPPER_PATH;
$data['change'] = PHPEncryptionWrapper::decrypt($data['change']);

$link = '';

switch ($data['change']) {
    case 'password':
        $link = CHANGE_PASSWORD_PATH;
        break;
    case 'email';
        $link = CHANGE_EMAIL_PATH;
        break;
    default:
        $response->error('No se pudo procesar el cambio, recargue e intente nuevamente');
}

$response->ok(
    'Se ha validado correctamente la contraseña, en breves será redirigido.',
    ['redirect' => $link]
);
