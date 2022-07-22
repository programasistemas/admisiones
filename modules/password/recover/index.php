<?php

require_once '../../../php/includes/routes.config.inc.php';

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
    <link rel="stylesheet" href="recover.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>

    <title>Unitropico | Recuperar contraseña</title>
</head>

<body class="bg-white m-0">
    <div class="d-flex min-vh-100">
        <div class="col-12 col-lg-6 d-flex flex-column justify-content-center" id="form-data">
            <img src="<?= DOMAIN . MAIN_PATH ?>assets/img/LogoUnitropicoColor.png" id="logo" class="d-lg-none">
            <h1 class="form__heading">¿Olvidaste tu contraseña?</h1>
            <p class="form__message mb-4">No te preocupes, nosotros nos encargaremos de todo.</p>

            <form id="recoverPasswordForm">
                <div class="custom-form-control">
                    <input class="form__input" type="email" id="email" name="email" placeholder=" " required title="
                    Ingresa tu correo electrónico" autocomplete="off" />
                    <label for="email" class="input__placeholder">Correo Electrónico</label>
                    <span class="fas fa-envelope input-icon"></span>
                    <div class="feedback">
                        <span class="fas fa-exclamation-triangle error-icon"></span>
                        <small class="feedback-message">Default Message</small>
                    </div>
                </div>

                <button type="submit" class="form__btn disabled mt-2">
                    Enviarme un link de recuperación
                </button>
            </form>
        </div>

        <div class="d-none d-lg-flex col justify-content-center" id="bg_right"></div>
    </div>

    <script src="<?= DOMAIN . MAIN_PATH ?>components/generic/urlBeautifier.js"></script>
    <script src="<?= DOMAIN . MAIN_PATH ?>libraries/sweetalert/dist/sweetalert2.all.min.js"></script>
    <?php require_once JS_REGULAR_EXPRESSIONS_PATH  ?>
    <script type="module" defer src="recover.js"></script>
</body>

</html>