<?php

// ===================================
// Server constants
//===================================

define("DOMAIN", "http://152.200.131.82:18080");
define('HOST', '152.200.131.82:18080');
define('NAME', '152.200.131.82');

// ===================================
// GENERAL CONSTANTS
// ===================================

define('ROOT_DIRECTORY', explode('/', $_SERVER['SCRIPT_NAME'])[1]);
define('MAIN_PATH', '/' . ROOT_DIRECTORY . '/');
define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT'] . MAIN_PATH);
define('QUERY_MANAGER_PATH', ROOT_PATH . 'php/classes/QueryManager.php');

//=================================================================================
// FILES INCLUSSION CONSTANTS
//=================================================================================

// Responses
define('RESPONSES_PATH', ROOT_PATH . 'php/includes/responses.inc.php');

define('VALIDATE_LOGIN_PATH', ROOT_PATH . 'php/session_management/validate_login.php');

// Ruta a funciones para bitacora
define('BITACORA_FUNCTIONS', ROOT_PATH . 'php/classes/bitacora.php'); // Bitacora
define('SEND_EMAIL_PATH',   ROOT_PATH . 'php/classes/sendEmails.php'); // Enviar correos.

//Rutas ayudas proceso de aspirantes:
define('CONTROLLER_POST_INPUTS_PATH', ROOT_PATH . 'php/helpers/helpers_for_asp/controller_post.php');
define('CONTROLLER_FILES_PATH', ROOT_PATH . 'php/helpers/helpers_for_asp/controller_files.php');
define('HELPER_QUERY_SQL_PATH', ROOT_PATH . 'php/helpers/helpers_for_asp/crud_sql.php');
define('HELPER_ERROR_MESSAGES_PATH', ROOT_PATH . 'php/helpers/helpers_for_asp/error_messages.php');
define('EXTRA_FUNCS_PATH', ROOT_PATH . 'php/helpers/helpers_for_asp/extra_funcs.php');
define('FILES_SAVE_PATH', ROOT_PATH . 'php/helpers/helpers_for_asp/save_files.php');
define('ASP_HEADER_HTML_PATH', ROOT_PATH . 'php/helpers/helpers_for_asp/pages_head_aspirants.php');
define('ASP_SCRIPT_HTML_PATH', ROOT_PATH . 'php/helpers/helpers_for_asp/scripts_footer_aspirants.php');

//Otras funciones para aspirantes:
define('ASP_READ_PATH', ROOT_PATH . 'php/inscripcion/funciones_php/crud/read.php');
define('ASP_INPUTS_TEMPLATE_PATH', ROOT_PATH . 'php/inscripcion/funciones_php/template.php');

// Rutas a helpers generales
define('GENERIC_HEAD_PATH', ROOT_PATH . 'php/helpers/generic_head.php');
define('EXPRESSION_REGULAR_PATH', ROOT_PATH . 'php/helpers/regex_validations.php');
define('JS_REGULAR_EXPRESSIONS_PATH', ROOT_PATH . 'php/includes/regex-js.inc.php');
define('SQL_HELPERS_PATH', ROOT_PATH . 'php/helpers/sql_helpers.php');
define('REQUESTS_VALIDATION_HELPERS_PATH', ROOT_PATH . 'php/helpers/requests_validation_helpers.php');
define('JSON_HELPERS_PATH', ROOT_PATH . 'php/helpers/json_helpers.php');
define('HTML_TEMPLATING_HELPERS_PATH', ROOT_PATH . 'php/helpers/html_templating_helpers.php');
define('EXPORTATION_HELPERS_PATH', ROOT_PATH . 'php/helpers/exportation_helpers.php');
define('GENERIC_HELPERS_PATH', ROOT_PATH . 'php/helpers/generic_helpers.php');
define('ENCRYPTION_PATH', ROOT_PATH . 'php/helpers/SED.php');

//Rutas page_main_components:
define('MAIN_COMPONENTS_NOTIFICATIONS_PATH', ROOT_PATH . 'php/page_main_components/notifications.php');
define('MAIN_COMPONENTS_HEADER_PATH', ROOT_PATH . 'php/page_main_components/header.php');
define('MAIN_COMPONENTS_SIDENAV_MENU_PATH', ROOT_PATH . 'php/page_main_components/sidenav_menu.php');
define('MAIN_COMPONENTS_PERMISSIONS_PATH', ROOT_PATH . 'php/page_main_components/permissions.php');

// Vendors de librerias
define('PHPBARCODE_VENDOR_PATH', ROOT_PATH . 'libraries/phpbarcode/vendor/autoload.php');
define('DOMPDF_VENDOR_PATH', ROOT_PATH . 'libraries/dompdf/autoload.inc.php');
define('PHPSPREADSHEET_VENDOR_PATH', ROOT_PATH . 'libraries/PHPSpreadsheet/vendor/autoload.php');

//=================================================================================
// LINK ARCHIVES CONSTANTS
//=================================================================================

// Components
define('MAIN_COMPONENT_HEADER_PATH', MAIN_PATH . 'php/page_main_components/header.php');
define('MAIN_COMPONENT_NOTIFICATIONS_PATH', MAIN_PATH . 'php/page_main_components/notifications.php');
define('MAIN_COMPONENT_NAV_PATH', MAIN_PATH . 'php/page_main_components/sidenav_menu.php');

define('HOME_PATH', MAIN_PATH . 'php/home.php'); // Home

// Views and important files
define('LOGIN_PATH', MAIN_PATH . 'php/login/login.php'); // Login
define('CHANGE_PASSWORD_PATH', MAIN_PATH . 'php/password/change/change.php'); // Cambio de password
define('CHANGE_EMAIL_PATH', MAIN_PATH . 'php/email_aspirante/change.php');    // Cambio de correo electrónico.
define('CONFIRM_PASSWORD_PATH', MAIN_PATH . 'php/password/confirm/confirm.php'); // Confirmacion de password
define('RECOVER_PASSWORD_PATH', MAIN_PATH . 'php/password/recover/recover.php'); // Olvido de password

define('QUOTAS_MANAGEMENT_PATH', MAIN_PATH . 'php/parametrizacion/cupos/cupos.php'); // Manejo de eps
define('EPS_MANAGEMENT_PATH', MAIN_PATH . 'php/parametrizacion/eps/eps.php'); // Manejo de eps
define('ACADEMIC_CALENDAR_PATH', MAIN_PATH . 'php/parametrizacion/calendar/calendar.php'); // Calendario academico
define('USER_MANAGEMENT_PATH', MAIN_PATH . 'php/parametrizacion/users/users.php'); // Usuarios
define('MESSAGE_MANAGEMENT_PATH', MAIN_PATH . 'php/parametrizacion/messages/messages.php'); // Mensajes
define('SOCIAL_PROGRAMS_MANAGEMENT_PATH', MAIN_PATH . 'php/parametrizacion/social_programs/social_programs.php'); // Programas sociales
define('CAREERS_MANAGEMENT_PATH', MAIN_PATH . 'php/parametrizacion/programas_academicos/programas_academicos.php'); // Programas
define('BANK_PINS_PATH', MAIN_PATH . 'php/parametrizacion/pagos/pagos.php'); // Importar pago PINES
define('POSTGRADUATED_VALORATION_MANAGEMENT_PATH', MAIN_PATH . 'php/parametrizacion/valoracion_posgrado/valoracion_posgrado.php'); // Valoracion posgrado
define('ACADEMIC_PROGRAMS_MANAGEMENT_PATH', MAIN_PATH . 'php/parametrizacion/programas_academicos/programas_academicos.php'); // Programas academicos
define('ICFES_PONDERATION_MANAGEMENT_PATH', MAIN_PATH . 'php/parametrizacion/ponderaciones_icfes/ponderaciones_icfes.php'); // Ponderacion ICFES
define('PAYMENT_CONCEPT_MANAGEMENT_PATH', MAIN_PATH . 'php/parametrizacion/concepto_pago/concepto_pago.php'); // Concepto pago
define('CALENDAR_ACTIVITIES_MANAGEMENT_PATH', MAIN_PATH . 'php/parametrizacion/actividades_calendario/actividad_calendario.php'); // Actividades calendario
define('ACADEMIC_PERIOD_MANAGEMENT_PATH', MAIN_PATH . 'php/parametrizacion/periodos_academicos/periodos_academicos.php'); // Periodos academicos
define('MULTIPLIER_INDEX_MANAGEMENT_PATH', MAIN_PATH . 'php/parametrizacion/indices_multiplicadores/indice_multiplicador.php'); // Indice multiplicador

define('INSCRIPTION_CREATE_PATH', MAIN_PATH . 'php/inscripcion/register.php');
define('UPDATE_INSCRIPTION_PATH', MAIN_PATH . 'php/inscripcion/update.php'); // Actualizar datos de inscripcion
define('VALIDATE_INSCRIPTION_PATH', MAIN_PATH . 'php/inscripcion/validate.php'); // Validar inscripcion
define('EDIT_INSCRIPTION_PATH', MAIN_PATH . 'php/inscripcion/edit.php'); // Editar inscription
define('VISUALIZE_APPLICANTS_PATH', MAIN_PATH . 'php/inscripcion/visualizar.php'); // Ver inscription
define('PIN_VALIDATION_PATH', MAIN_PATH . 'php/pin_validation/validacion.php'); // Validacion de pin
define('NOTIFICATIONS_PATH', MAIN_PATH . 'php/notificaciones/notificaciones.php'); // Notificaciones

define('DAILY_REPORT_PATH', MAIN_PATH . 'php/reportes/exportaciones/reporteDiario.php'); // Reporte diario general
define('TREASURY_REPORT_PATH', MAIN_PATH . 'php/reportes/tesoreria/tesoreria.php'); // Reporte inscritos tesoreria
define('GENERAL_REPORT_PATH', MAIN_PATH . 'php/reportes/general/general.php'); // Reporte inscritos tesoreria
define('SNIES_REPORT_PATH', MAIN_PATH . 'php/reportes/snies/snies.php'); // Reportes de SNIES
define('DASHBOARD_PATH', MAIN_PATH . 'php/dashboard/main.php');         //Dashboard

define('UNDERGRADUATED_SELECTION_PATH', MAIN_PATH . 'php/seleccion/pregrado/pregrado.php'); // Reporte seleccionados pregrado
define('POSTGRADUATED_SELECTION_PATH', MAIN_PATH . 'php/seleccion/postgrado/posgrado.php'); // Reporte seleccionados posgrado
define('SET_SCORE_APPLICANTS', MAIN_PATH . 'php/seleccion/posgrado/calificacion.php'); //Ponderar posgrado
define('REGISTRATION_SELECTION_PATH', MAIN_PATH . 'php/matricula/matricula.php'); // Admitidos aprobados listos para ser matriculados
define('PIR_MANAGEMENT_PATH', MAIN_PATH . 'php/parametrizacion/PIR/admin.php'); // Proceso de seleccion
define('CALCULATE_PIR_PATH',  MAIN_PATH . 'php/parametrizacion/PIR/calcular.php');
define('CALCULATE_GENERAL_PIR_PATH',  MAIN_PATH . 'php/parametrizacion/PIR/calcular_general.php');
