<header>
    <nav class="sb-topnav navbar navbar-expand secundario d-flex justify-content-between align-items-center shadow-lg">
        <div class="d-flex align-items-center">
            <!-- Sidebar Toggle-->
            <button class="ms-4 text-light btn btn-link btn-sm" id="sidebarToggle" href="#!"><i class="fas fa-bars fa-2x"></i></button>
            <!-- Navbar Brand-->
            <a class="text-light navbar-brand ps-3" href="<?= HOME_PATH ?>">
                <img src="<?= MAIN_PATH ?>assets/img/LogoUnitropico.png" height="50" id="rounded d-black ms-4">
            </a>
        </div>
        <!-- Navbar-->
        <div class="d-flex justify-content-between align-items-center">
            <span class="user_name_container text-light"><?= $_SESSION['USER_FIRST_NAME'] . " " . $_SESSION['USER_FIRST_SURNAME'] ?></span>

            <?php

            if (isset($codigo_aspirante) && !empty($codigo_aspirante)) {
                $notifications_component = '
                <li class="nav-item dropdown list-unstyled">
                    <a class="nav-icon" href="#" id="alertsDropdown" data-bs-toggle="dropdown">
                        <div class="position-relative">
                            <i class="align-middle fa fa-bell"></i>
                            <span class="indicator">' . $numero_notificaciones . '</span>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end py-0 min-width-15" aria-labelledby="alertsDropdown">
                        <div class="dropdown-menu-header">
                            Tienes ' . $numero_notificaciones . ' Nuevas Notificaciones
                        </div>';

                $contador_notificaciones = 0;
                $output = '';

                foreach ($notificaciones as $notificacion) {
                    if ($contador_notificaciones > 3 || $contador_notificaciones >= $numero_notificaciones) break;

                    $notification_template = '
                            <div class="list-group">
                                <a class="list-group-item" href="' . NOTIFICATIONS_PATH . '">
                                    <div class="g-0 align-items-center">
                                        <div class="row d-flex align-items-center">
                                            <div class="col-6">
                                                <i class="text-danger fas fa-exclamation-circle"></i>
                                                ' . $notificacion['asunto'] . '>
                                            </div>
                                            <div class="col-6">
                                                <i class="text-right"></i>' . date_format(new DateTime($notificacion['fecha_envio']), 'd/m/Y')  . '
                                            </div>
                                        </div>

                                    </div>
                                </a>
                            </div>';

                    $output .= $notification_template;
                    $contador_notificaciones++;
                }

                $output .= '
                <div class="dropdown-menu-footer py-3 px-2">
                    <a href="' . NOTIFICATIONS_PATH . '" class="text-muted">Ver todas las notificaciones</a>
                </div>';

                $notifications_component .= $output . '</div></li>';

                echo $notifications_component;
            } ?>

            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4 h-auto">
                <li class="nav-item dropdown h-auto">
                    <a class="nav-link dropdown-toggle text-light" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li> <a class="dropdown-item me-2" href="<?= CONFIRM_PASSWORD_PATH ?>?change=<?= PHPEncryptionWrapper::encrypt('password') ?>"> <i class="fas fa-key"></i> Cambiar contraseña </a> </li>
                        <li> <a class="dropdown-item me-2" href="<?= CONFIRM_PASSWORD_PATH ?>?change=<?= PHPEncryptionWrapper::encrypt('email') ?>"> <i class="fas fa-envelope"></i> Cambiar email</a> </li>
                        <li>
                            <hr class="dropdown-divider" />
                        </li>
                        <li><a class="dropdown-item" href="<?= LOGIN_PATH ?>">Salir</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>