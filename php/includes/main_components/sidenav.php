<?php

require_once HTML_TEMPLATING_HELPERS_PATH;

$active_permissions = $_SESSION['PERMISSIONS'];
$submenus = '';
$secret_key = PHPEncryptionWrapper::encrypt('&V68**%7@36!^78%^m94');

//------------------------------ CONFIGURACIÓN DEL MENÚ ------------------------------
if (isset($active_permissions)) {
    if (in_array('STUDENT', $active_permissions)) {
        switch ($inscription_dates) {
            case array():
                $val = createOption('El procedimiento de este aspirante se encuentra vinculado a un periodo inactivo');
                break;
            case null:
                $val = createOption('No se encuentra ningún procedimiento vinculado al aspirante');
                break;
            default:
                //validar fechas:
                $current_date = date('Y-m-d');
                if ($fecha_inicial > $current_date) $val = createOption('El proceso de inscripción aún no ha iniciado.');
                else if ($fecha_final < $current_date) $val = createOption('El proceso de inscripción ha finalizado.');
                else $val = createOption('Completar Inscripción', 'fas fa-pencil-alt', UPDATE_INSCRIPTION_PATH);
        }
        $submenus = createHeaderMenu('Estudiante', $val);
    }
    //--------------------------------------------------

    // Almacena las opciones de reportes
    $reports_options = '';

    //--------------------------------------------------
    if (in_array('ADMIN', $active_permissions)) {
        $submenus .= createHeaderMenu(
            'Administración',
            createSection('admin-selection', 'Selección', 'fas fa-user-check', [[UNDERGRADUATED_SELECTION_PATH, 'Pregrado']]),
            createSection('admin-parametrization', 'Parametrización', 'fas fa-file-invoice', [
                [BANK_PINS_PATH, 'Cargue pagos PIN'],
                [PIR_MANAGEMENT_PATH, 'Manejo PIR'],
                [MESSAGE_MANAGEMENT_PATH, 'Mensajes'],
                [USER_MANAGEMENT_PATH, 'Usuarios'],
                [CAREERS_MANAGEMENT_PATH, 'Programas académicos'],
                [ICFES_PONDERATION_MANAGEMENT_PATH, 'Ponderaciones ICFES'],
                [ACADEMIC_PERIOD_MANAGEMENT_PATH, 'Periodos académicos'],
                [SOCIAL_PROGRAMS_MANAGEMENT_PATH, 'Programas sociales'],
                [EPS_MANAGEMENT_PATH, 'EPS'],
                [QUOTAS_MANAGEMENT_PATH, 'Cupos'],
            ]),
            createOption('Matricular admitidos', 'fas fa-registered', REGISTRATION_SELECTION_PATH),
        );

        $reports_options .= createOption('Generar', 'fas fa-file-archive', GENERAL_REPORT_PATH);
        $reports_options .= createOption('SNIES', 'fas fa-university', SNIES_REPORT_PATH);
        $reports_options .= createOption('Diario', 'fas fa-calendar-day', DAILY_REPORT_PATH . '?key=' . $secret_key);
    }
    //--------------------------------------------------

    if (in_array('TREASURY_REPORT', $active_permissions)) {
        $reports_options .= createOption('Tesorería', 'fas fa-piggy-bank', TREASURY_REPORT_PATH);
    }

    if (!empty($reports_options)) {
        $submenus .= createHeaderMenu(
            'Reportes',
            $reports_options
        );
    }

    //--------------------------------------------------
    if (in_array('DASHBOARD', $active_permissions))
        $submenus .= createHeaderMenu('Dashboard', createOption('Ver gráficas', 'fas fa-chart-line', DASHBOARD_PATH));
    //--------------------------------------------------


    //--------------------------------------------------
    if (in_array('VALIDATOR', $active_permissions))
        $submenus .=
            createHeaderMenu(
                'Validación',
                createSection('validatie-section', 'Aspirantes', 'fas fa-user-alt', [
                    [VISUALIZE_APPLICANTS_PATH, 'Ver'],
                    [EDIT_INSCRIPTION_PATH, 'Editar'],
                    [VALIDATE_INSCRIPTION_PATH, 'Validar'],
                ]),
                createOption('Calcular puntaje por programa', 'fas fa-pencil-alt', CALCULATE_PIR_PATH, true),
                createOption('Calcular puntajes', 'fas fa-pencil-alt', CALCULATE_GENERAL_PIR_PATH, true),
            );
    //--------------------------------------------------


    //--------------------------------------------------
    if (in_array('CALIFICATION_POS', $active_permissions))
        $submenus .= createHeaderMenu('Posgrados', createOption('Calificación', 'fas fa-spell-check', SET_SCORE_APPLICANTS));
    //--------------------------------------------------
}

echo '<div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                ' . $submenus . '
                </div>
            </div>
            <div class="sb-sidenav-footer">
                <a class="text-muted text-center" href="https://www.unitropico.edu.co/" target="_blank" rel="noopener">
                    <strong>Unitrópico</strong>
                </a> 
                &copy; 2021
            </div>
        </nav>
    </div>';
