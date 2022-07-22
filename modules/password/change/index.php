<?php

require_once '../../../php/includes/routes.config.inc.php';

$data = filter_input_array(INPUT_GET, [
    'selector' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    'validator' => FILTER_SANITIZE_FULL_SPECIAL_CHARS
]);

if ($data == false || in_array(null, $data)) {
    require_once REQUESTS_VALIDATION_HELPERS_PATH;

    if (!validateMultipleReferers([CONFIRM_PASSWORD_PATH, LOGIN_PATH])) {
        header('Location: ' . HOME_PATH);
        exit;
    };

    require_once RESPONSE_ENTITY_PATH;
    ResponseEntity::verifySessionStatus();
} else {
    session_start();
    session_destroy();
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" href="<?= DOMAIN . MAIN_PATH ?>assets/favicon/favicon1.ico" type="image/x-icon" />
    <link rel="stylesheet" href="<?= DOMAIN . MAIN_PATH ?>libraries/bootstrap-5.1.3/css/bootstrap.css">
    <link rel="stylesheet" href="<?= DOMAIN . MAIN_PATH ?>components/spinner/spinner.css">
    <link rel="stylesheet" href="<?= DOMAIN . MAIN_PATH ?>libraries/sweetalert/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="<?= DOMAIN . MAIN_PATH ?>components/form/form.css" />
    <link rel="stylesheet" href="change.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>

    <title>Unitropico | Cambiar contraseña</title>
</head>

<body class="bg-white m-0">
    <div class="d-flex min-vh-100">
        <div class="col-12 col-lg-6 d-flex flex-column justify-content-center py-4" id="form-data">
            <div class="d-lg-none">
                <img src="<?= DOMAIN . MAIN_PATH ?>assets/img/LogoUnitropicoColor.png" id="logo">
            </div>
            <h1 class="form__heading">Cambiar contraseña</h1>
            <p class="form__password-tip">
                Tu nueva contraseña debe contener como <strong>MÍNIMO</strong>:
            </p>

            <ul class="password-tip__list">
                <li class="list__item">8 caracteres de longitud</li>
                <li class="list__item">1 caracter especial (@$#!%*?&)</li>
                <li class="list__item">1 dígito (0-9)</li>
                <li class="list__item">1 letra mayúscula</li>
                <li class="list__item">1 letra minúscula</li>
            </ul>

            <form id="changePasswordForm">
                <div class="custom-form-control">
                    <input class="form__input" type="password" id="password" name="password" placeholder=" " title="Ingresa tu contraseña" required autocomplete="off" />
                    <label for="password" class="input__placeholder">Nueva contraseña</label>
                    <span class="fas fa-key input-icon"></span>
                    <div class="feedback">
                        <span class="fas fa-exclamation-triangle error-icon"></span>
                        <small class="feedback-message">Default Message</small>
                    </div>
                </div>

                <div class="show-password__wrapper">
                    <label for="showPassword" class="custom-check__container">
                        <input type="checkbox" id="showPassword" class="form__item form__show-pass default-check__input" />
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Mostrar Contraseña
                        <span class="custom-checkmark"></span>
                    </label>
                </div>

                <?php

                if ($data) {
                    echo '<input name="selector" type="hidden" value="' . $data['selector'] . '">
                              <input name="validator" type="hidden" value="' . $data['validator'] . '">';
                }

                ?>
                <div class="d-flex justify-content-between gap-3">
                    <button type="submit" class="form__btn disabled form__item">Cambiar contraseña</button>
                    <?php

                    if (isset($_GET['extra']) && $_GET['extra'] == 'equals') {
                        echo '<a style="text-decoration: none;" href="' . HOME_PATH . '" class="text-center text-white form__btn form__item bg-danger">Omitir cambio <span class="fas fa-arrow-right"></span></a>';
                    }

                    ?>

                </div>
            </form>
        </div>
        <div class="d-none d-lg-flex col justify-content-center" id="bg_right"></div>
    </div>

    <script src="<?= DOMAIN . MAIN_PATH ?>components/generic/urlBeautifier.js"></script>
    <script src="<?= DOMAIN . MAIN_PATH ?>libraries/sweetalert/dist/sweetalert2.all.min.js"></script>
    <?php require_once JS_REGULAR_EXPRESSIONS_PATH  ?>
    <script type="module" defer src="change.js"></script>
</body>

</html>