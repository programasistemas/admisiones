<?php

require_once '../../../php/includes/routes.config.inc.php';
require_once MAIN_COMPONENT_NOTIFICATIONS_PATH;

if (!isset($_GET['change']) || empty($_GET['change'])) {
    header('location: ' . HOME_PATH);
    exit;
}

require_once HTML_TEMPLATING_HELPERS_PATH;

$css = ['components/form/form.css'];
$js = [
    [
        'url' => 'modules/password/confirm/confirm.js',
        'type' => 'module'
    ]
];

renderView('confirm', [
    'title' => 'Confirmar contraseña',
    'viewPath' => 'password/confirm',
    'scripts' => $js,
    'css' => $css
]);

require_once JS_REGULAR_EXPRESSIONS_PATH;
