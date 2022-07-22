<?php

require_once '../../../php/includes/routes.config.inc.php';
require_once MAIN_COMPONENT_NOTIFICATIONS_PATH;

if (
    !isset($_SESSION['PERMISSIONS']) ||
    !in_array('REPORTS_GENERATION', $_SESSION['PERMISSIONS'])
) {
    header('Location:' . HOME_PATH);
    exit;
}

require_once HTML_TEMPLATING_HELPERS_PATH;
require_once DB_CONFIG_PATH;

$query_builder = DBConfig::getDoctrineQueryBuilder();
$periods = $query_builder
    ->select('codigo, periodo')
    ->from('periodo_academico')
    ->fetchAllAssociative();

$query_builder->resetQueryParts();

$programs = $query_builder
    ->select('codigo, nombre_programa_academico')
    ->from('programa_academico')
    ->fetchAllAssociative();

$query_builder->resetQueryParts();

$states = $query_builder
    ->select('codigo, nombre')
    ->from('estado_procedimiento')
    ->fetchAllAssociative();

$query_builder->resetQueryParts();

$study_levels = $query_builder
    ->select('codigo', 'nombre_nivel')
    ->from('nivel_estudio')
    ->fetchAllAssociative();

$query_builder->resetQueryParts();

$faculties = $query_builder
    ->select('codigo, nombre_facultad')
    ->from('facultad')
    ->fetchAllAssociative();

$query_builder->resetQueryParts();
unset($query_builder);

require_once 'config/data.config.php';

$inputs = '';
foreach ($fields as $item) {
    $checkboxes = '';
    foreach ($item['content'] as $data) {
        $input = '<input class="btn-check" type="checkbox" id="' . $data['id'] . '" name="' . $data['id'] . '" autocomplete="off">';
        $label = '<label class="btn btn-outline-success rounded-pill d-inline-block m-2 py-2 px-4 fw-bold flex-fill" for="' . $data['id'] . '">' . $data['placeholder'] . '</label>';
        $checkboxes .= $input . $label;
    }

    $accordion_item =
        '<div class="accordion-item w-100">
            <h2 class="accordion-header" id="panelsStayOpen-headingOne' . $item['itemId'] . '">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse' . $item['itemId'] . '" aria-expanded="false" aria-controls="panelsStayOpen-collapse' . $item['itemId'] . '">
                    ' . $item['itemName'] . '
                </button>
            </h2>
            <div id="panelsStayOpen-collapse' . $item['itemId'] . '" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingOne' . $item['itemId'] . '" data-bs-parent="#accordionOptions">
                <div class="accordion-body">
                    ' . $checkboxes . '
                </div>
            </div>
        </div>';

    $inputs .= $accordion_item;
}

$html_inputs = '<div class="accordion m-5" id="accordionOptions">' . $inputs . '</div>';
$html_filters = createFiltersCard($filters_html_data);

renderView(
    'generate',
    [
        'title' => 'Generar reporte',
        'viewPath' => 'reports/generate',
        'scripts' => [
            ['url' => 'components/generic/filters.js'],
            ['url' => 'modules/reports/generate/generate.js']
        ]
    ]
);
