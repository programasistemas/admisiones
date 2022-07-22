<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/' . explode('/', $_SERVER['SCRIPT_NAME'])[1] . '/php/includes/routes.config.inc.php';
require_once DB_CONFIG_PATH;
require_once RESPONSE_ENTITY_PATH;

ResponseEntity::verifySessionStatus();

if (isset($_SESSION['APPLICANT_CODE']) && !empty($_SESSION['APPLICANT_CODE'])) {
    $query_builder = DBConfig::getDoctrineQueryBuilder();
    $codigo_aspirante = $_SESSION['APPLICANT_CODE'];

    $notifications = $query_builder
        ->select('asunto', 'mensaje', 'fecha_envio')
        ->from('v_mensajeria_enviada')
        ->where('codigo_aspirante_servicio = ? AND leido = "NO"')
        ->orderBy('fecha_envio DESC')
        ->setParameter(0, $codigo_aspirante)
        ->fetchAllAssociative();

    $numero_notificaciones = count($notificaciones);
    

    //Buscar el código del periodo con el procedimiento a ese aspirante.
    //Si el periodo es inactivo -> variable booleana
    //Si es activo, crear variables fecha inicio y fecha final de proceso de inscripcion

    $inscription_dates = null;

    $period_code = $query_builder
        ->select('codigo_periodo_procedimiento')
        ->from('procedimiento')
        ->where('codigo_aspirante_procedimiento = ?')
        ->setParameter(0, $codigo_aspirante)
        ->fetchOne();

    

    //Si no existe un procedimiento vinculado al aspirante (no hay còdigo de procedimiento)
    if ($period_code) {
        $academic_period = $query_builder
            ->select('codigo')
            ->from('periodo_academico')
            ->where('estado = "ACTIVO" AND codigo = ?')
            ->setParameter(0, $period_code)
            ->fetchOne();

        

        if ($academic_period) {
            $inscription_dates = $query_builder
                ->select('fecha_inicio', 'fecha_final')
                ->from('actividades_calendario')
                ->where('codigo_periodo_activdades = ? AND codigo_calendario_academico = 2')
                ->setParameter(0, $period_code)
                ->fetchAssociative();

            $fecha_inicial = $inscription_dates['fecha_inicio'];
            $fecha_final = $inscription_dates['fecha_final'];
        }
    }
}

unset($query_builder);
require_once PHPENCYPTIONWRAPPER_PATH;