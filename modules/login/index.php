<?php
require_once '../../php/includes/routes.config.inc.php';

session_start();
session_unset();
session_destroy();

session_start();
$_SESSION['token'] = md5(rand(10000, 99999));

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" href="../../assets/favicon/favicon1.ico" type="image/x-icon" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous" />
    <link rel="stylesheet" href="../../libraries/bootstrap-5.1.3/css/bootstrap.css">
    <link rel="stylesheet" href="./login.css" />
    <link rel="stylesheet" href="../../components/form/form.css" />
    <link rel="stylesheet" href="../../components/spinner/spinner.css">

    <title>Unitropico | Iniciar sesión</title>
</head>

<body class="bg-white m-0">
    <div class="d-flex min-vh-100">
        <div id="bg-flayer" class="d-none d-lg-flex col justify-content-center align-items-center" style="min-height:100vh;"></div>

        <div class="col-12 col-lg-6 d-flex flex-column justify-content-center" id="form-data">
            <img src="../../assets/img/LogoUnitropicoColor.png" id="logo" class="mb-5 mx-auto d-block d-lg-none">
            <h1 class="form__heading">Iniciar sesión</h1>
            <p class="form__description">Bienvenido a la plataforma de admisiones de la universidad de los Casanareños, inicie sesión con sus credenciales para acceder a los servicios.</p>

            <form id="loginForm">
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

                <div class="custom-form-control">
                    <input class="form__input" type="password" id="password" name="password" placeholder=" " title="Ingresa tu contraseña" required autocomplete="off" />
                    <label for="password" class="input__placeholder">Contraseña</label>
                    <span class="fas fa-key input-icon"></span>
                    <div class="feedback">
                        <span class="fas fa-exclamation-triangle error-icon"></span>
                        <small class="feedback-message">Default Message</small>
                    </div>
                </div>

                <div class="show-password__wrapper">
                    <label for="showPassword" class="custom-check__container">
                        <input type="checkbox" id="showPassword" class="form__show-pass default-check__input" />
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Mostrar contraseña
                        <span class="custom-checkmark"></span>
                    </label>
                </div>

                <button type="submit" class="form__btn disabled mt-0">
                    Iniciar Sesión
                </button>

                <div class="forget-password__wrapper">
                    <div class="d-flex justify-content-between">
                        <a href="<?= INSCRIPTION_CREATE_PATH ?>" class="link">Registrate aquí</a>
                        <a href="<?= RECOVER_PASSWORD_PATH ?>" class="link">¿Olvidaste tu contraseña?</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <?php require_once JS_REGULAR_EXPRESSIONS_PATH  ?>
    <script src="../../components/generic/urlBeautifier.js"></script>
    <script type="module" defer src="./login.js"></script>
    <script src="../../libraries/sweetalert/dist/sweetalert2.all.min.js"></script>
</body>

</html>