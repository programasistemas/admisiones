<?php

require_once '../../../php/includes/routes.config.inc.php';
require_once REQUESTS_VALIDATION_HELPERS_PATH;
require_once RESPONSES_PATH;

if (
    !validateRefererServerParameter(DOMAIN . GENERAL_REPORT_PATH) ||
    !validateRequestMethodServerPerameter('POST')
) {
    httpResponse(LOGIN_PATH, 400);
}

require_once RESPONSE_ENTITY_PATH;
ResponseEntity::verifySessionStatus();

if (
    !isset($_SESSION['PERMISSIONS']) ||
    !in_array('REPORTS_GENERATION', $_SESSION['PERMISSIONS'])
) {
    httpResponse(HOME_PATH, 403);
}

require_once 'config/report_data.config.php';

$procedures_filter_fields = [];
$procedures_filter_values = [];
$final_fields = [];
$filter_counter = 0;

$headers_names = [
    'PERIODO ACADÉMICO',
    'CODIGO ASPIRANTE',
    'PROCEDIMIENTO',
    'ESTADO DEL PROCEDIMIENTO',
    'NOMBRE COMPLETO',
    'TIPO DE DOCUMENTO',
    'NÚMERO DE DOCUMENTO',
    'PROGRAMA ACADÉMICO',
    'EMAIL',
    'TELÉFONO DE CONTACTO',
    'FECHA DE INSCRIPCIÓN',
    'FECHA DE ACTUALIZACIÓN',
    'CRITERIO DE ADMISIÓN',
    'CRITERIO ESPECIAL GENERAL',
    'CRITERIO ESPECIAL ESPECÍFICO'
];

foreach ($_POST as $i => $value) {
    if (
        isset($filters[$i]) &&
        !empty($value)
    ) {
        $procedures_filter_fields[] = $filters[$i] . ' = ? ';
        $procedures_filter_values[$filter_counter] = filter_var($value, FILTER_SANITIZE_NUMBER_INT);

        $filter_counter++;
        continue;
    }

    if (isset($fields[$i])) {
        $table_name = $fields[$i]['table'];

        if (!isset($final_fields[$table_name])) {
            $final_fields[$table_name] = [];
        }

        $final_fields[$table_name]['columns'][] = $fields[$i]['column_name'];
        $headers_names[] = $fields[$i]['report_column_name'];
    }
}

require_once DB_CONFIG_PATH;
$query_builder = DBConfig::getDoctrineQueryBuilder();

$procedures_query = $query_builder
    ->select(
        'nombre_periodo_academico',
        'codigo_aspirante',
        'nombre_procedimiento',
        'estado_procedimiento',
        'nombre_completo_aspirante',
        'nombre_tipo_documento',
        'numero_documento',
        'nombre_programa_academico',
        'email_aspirante',
        'telefono_contacto_aspirante',
        'fecha_procedimiento',
        'fecha_actualizacion'
    )
    ->from('v_general_datatables');

if (!empty($procedures_filter_fields)) {
    $procedures_query
        ->where(implode(' AND ', $procedures_filter_fields))
        ->setParameters($procedures_filter_values);
}

$procedures = $procedures_query->fetchAllAssociative();
$query_builder->resetQueryParts();

if ($procedures === false) {
    echo '<h1>¡UN ERROR FATAL HA OCURRIDO!</h1>';
    exit;
}

if (!empty($procedures)) {
    foreach ($procedures as &$procedure) {
        $socioeconomic_data = $query_builder
            ->select('nombre_criterio_admision', 'nombre_criterio_especial_general', 'nombre_criterio_especial_especifico')
            ->from('v_general_datos_socioeconomicos')
            ->where('codigo_aspirante = ' . $procedure['codigo_aspirante'])
            ->fetchAssociative();

        $query_builder->resetQueryParts();
        $procedure = array_merge($procedure, $socioeconomic_data);

        foreach ($final_fields as $field => $value) {
            $data_subset = $query_builder
                ->select(implode(',', $value['columns']))
                ->from($field)
                ->where('codigo_aspirante = ' . $procedure['codigo_aspirante'])
                ->fetchAssociative();

            $procedure = array_merge($procedure, $data_subset);
            $query_builder->resetQueryParts();
        }
    }
}

unset($query_builder);
require_once EXPORTATION_HELPERS_PATH;
require_once VENDOR_AUTOLOAD_PATH;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$file = new Spreadsheet();
$writer_instance = new Xlsx($file);

createAndExportExcelDocument(
    $file,
    $writer_instance,
    $procedures,
    $headers_names,
    'reporte_general'
);

exit;
