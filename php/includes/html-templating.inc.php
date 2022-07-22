<?php

/**
 * Genera la estructura HTML de un select
 * @param string $initial_value Nombre del valor inicial
 * @param arrray $data Datos para las opciones del select
 * @return string Estructura HTML en string
 */
function createSelectElement($initial_value, $data, $id, $style, $validate = null, $initial_disabled = false, $control_wrap = false, $required = true, $data_validation = 'empty', $error_message = 'Campo obligatorio')
{
    $disabled = $initial_disabled ? 'disabled' : '';
    $required = $required ? 'required="true"' : 'required="false"';

    $initial =  '<option value="" selected ' . $disabled . '>' . $initial_value . '</option>';
    $options = '';

    $keys = array_keys($data[0]);
    foreach ($data as $item) $options .= '<option value="' . $item[$keys[0]] . '">' . $item[$keys[1]] . '</option>';

    $output = <<<EOT
                <select name="$id" id="$id" class="$style" $required data_validation="$data_validation" data_error_message="$error_message">
                    $initial
                    $options
                </select>
              EOT;

    if (isset($validate)) {
        $output .= '<span class="fas fa-check-circle success-icon"></span>
                    <span class="fas fa-exclamation-circle error-icon"></span>
                    <small class="error-message">Default Message</small>';
    }

    return
        $control_wrap ?
        '<div class="custom-form-control">' . $output . '</div>' :
        $output;
}

/**
 * Genera la estructura HTML de los filtros
 * 
 * @param array $values Array con los diferentes filtros y sus propiedades
 * @return string Cadena de texto con la estructura html
 */
function createFiltersCard($values)
{
    $output = '<div class="card filters w-100 mt-5">
                    <div class="fs-5 card-header fw-bold text-start d-flex align-items-center px-5 py-3">Filtros</div>
                    <div class="py-3 px-4">';

    foreach ($values as $rows) {

        $row = '<div class="row">';

        foreach ($rows as $column) {
            $select = createSelectElement($column['select_title'], $column['data'], $column['id'], $column['custom_style']);

            $col = '
            <div class="col m-4 text-start">
                <p class="fw-light"><i class="me-2 ' . $column['icon_class'] . '"></i>' . $column['filter_title'] . ':</p>
                ' . $select . '
            </div>';

            $row .= $col;
        }

        $row .= '</div>';
        $output .= $row;
    }

    $output .= '<div class="text-start d-flex align-items-center px-4 pb-4">
                    <button type="button" class="btn btn-secondary d-inline-block fw-bold px-4 py-2 text-light" id="clearFilters">Quitar filtros</button>
                </div>';

    $output .= '</div></div>';

    return $output;
}

/**
 * Genera y descarga la orden de pago de un PIN
 * 
 * @param string $reference Referencia del recibo de pago
 * @param array $bill_data Datos de quien tiene que realizar el pago
 * @param boolean $paid_bill La factura ha sido pagada
 * @param \Dompdf\Dompdf $dompdf_instance_instance Instancia de dompdf
 */
function generatePaymentBill($reference, $bill_data, $dompdf_instance, $paid_bill = false, $barcode = null)
{
    $nombre_concepto = mb_strtoupper($bill_data['concepto_pago']['nombre']);

    $concept_value_digits = str_split($bill_data['concepto_pago']['valor']);
    $concept_value_count = count($concept_value_digits);
    $valor_concepto = [];
    $thousand_count = 0;

    for ($i = $concept_value_count - 1; $i >= 0; $i--, $thousand_count++) {
        if ($thousand_count == 3) {
            $valor_concepto[] = '.';
            $thousand_count = 0;
        }

        $valor_concepto[] = $concept_value_digits[$i];
    }

    $valor_concepto = empty($valor_concepto) ? '' : '$ ' . implode(array_reverse($valor_concepto));
    $vencimiento = $bill_data['concepto_pago']['vencimiento'];

    $table_data = '
    <div class="bill_data">
        <table>
            <tbody>
                <tr>
                    <td class="medium">Fecha generación:</td>
                    <td>' . $bill_data['fecha_generacion']  . '</td>
                </tr>
                <tr>
                    <td class="medium">Nombre:</td>
                    <td>' . mb_strtoupper($bill_data['nombre_cliente'], 'utf-8') . '</td>
                </tr>
                <tr>
                    <td class="medium">Identificación:</td>
                    <td>' . $bill_data['identificacion'] . '</td>
                </tr>
                <tr>
                    <td class="medium">Teléfono:</td>
                    <td>' . $bill_data['telefono'] . '</td>
                </tr>
                <tr>
                    <td class="medium">Periodo académico:</td>
                    <td>' . mb_strtoupper($bill_data['periodo'], 'utf-8') . '</td>
                </tr>
            </tbody>
        </table>
    </div>

    <hr>

    <div class="payment_concept_data">
        <table class="custom_table">
            <tbody>
                <tr class="table-head">
                    <td>CONCEPTO</td>
                    <td class="value">VALOR</td>
                </tr>
                <tr>
                    <td>' . $nombre_concepto  . '</td>
                    <td class="value">' . $valor_concepto . '</td>
                </tr>
            </tbody>
        </table>
    </div>
    
    <div class="payment_valid_date">
        <table class="custom_table">
            <tbody>
                <tr class="table-head">
                    <td></td>
                    <td>PAGUE HASTA</td>
                    <td class="value">VALOR</td>
                </tr>
                <tr>
                    <td>PAGO ORDINARIO</td>
                    <td>' . $vencimiento  . '</td>
                    <td class="value">' . $valor_concepto . '</td>
                </tr>
            </tbody>
        </table>
    </div>';

    $footer = '<p class="account">
                   CONVENIO DAVIVIENDA N° <strong>1443480</strong>
               </p>';

    ob_start(); ?>

    <!DOCTYPE html>
    <html lang="es">

    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <!-- Estilos del reporte -->
        <style>
            @page {
                margin: 2.5rem;
                font-size: 0.75rem;
            }

            .account {
                position: absolute;
                bottom: 12rem;
                left: 2rem;
                font-size: 1.2rem;
            }

            .document_for {
                text-align: center;
                position: absolute;
                bottom: 0;
                left: 8rem;
            }

            .column {
                width: 48%;
            }

            hr {
                display: block;
                margin-top: 1.5rem;
                margin-bottom: 1.5rem;
            }

            .medium {
                font-weight: 700;
            }

            .value {
                width: 250px;
            }

            .brand-container {
                position: relative;
                text-align: start;
                font-size: .9rem;
                line-height: .5;
                height: 110px;
            }

            .brand-container img {
                float: left;
            }

            .brand-container .brand-info p>strong {
                line-height: 1.3;
            }

            .brand-container .brand-info {
                text-align: center;
                position: absolute;
                top: 2rem;
                right: 0;
            }

            .reference {
                text-align: center;
                top: 11rem;
                right: 1.5rem;
                position: absolute;
                font-weight: 700;
                font-size: 1.2rem;
            }

            .custom_table {
                border-collapse: collapse;
                width: 100%;
            }

            .custom_table tr {
                margin: 0;
                padding: 0;
            }

            .custom_table td {
                padding: 0.25rem;
                border: 1px solid #000;
            }

            .payment_concept_data .custom_table {
                margin-top: 1.5rem;
            }

            .payment_valid_date {
                margin-top: 3rem;
            }

            .table-head {
                background-color: #eee;
                font-weight: 700;
            }

            .paid_bill {
                position: fixed;
                left: 0;
                right: 0;
                width: 100vw;
                height: 100vh;
                z-index: 10;
                opacity: 0.5;
                text-align: center;
            }

            .paid_bill img {
                max-width: 800px;
            }

            .barcode_container {
                text-align: center;
                visibility: hidden;
            }

            .barcode {
                margin: 200px auto 10px;
                height: 50px;
                width: 75%;
            }

            .barcode_container p {
                font-size: 10px;
            }

            .bank_order {
                position: absolute;
                float: right;
                border-left: 1px dashed #000;
                padding-left: 2rem;
            }

            .student_order {
                position: absolute;
                float: left;
            }
        </style>
    </head>

    <body>
        <main>
            <?php

            $brand_html = '<div class="brand-container">
                                <img src="http://' . $_SERVER['HTTP_HOST'] . MAIN_PATH . 'img/LogoUnitropicoColor.png" style="width:160px">
                                <div class="brand-info">
                                    <p><strong>UNIVERSIDAD INTERNACIONAL <br> DEL TRÓPICO AMERICANO</strong></p>
                                    <p>Nit. 844002071-4</p>
                                    <p>Cra 19 N° 39-40</p>
                                </div>
                           </div>
                           <hr>

                           <div class="reference">ORDEN DE PAGO <br> N°' . htmlspecialchars($reference) . '</div>';

            if ($paid_bill)
                echo '<div class="paid_bill">
                            <img src="http://' . $_SERVER['HTTP_HOST'] . MAIN_PATH . 'img/watermark.png">
                      </div>';

            ?>
            <div class="bank_order column">
                <?php echo $brand_html . $table_data .
                    '<div class="barcode_container">
                        <div class="barcode">
                            ' . $barcode[0] . '
                        </div>
                        <p>' . $barcode[1] . '</p>
                    </div>' .
                    $footer . '
                        <p class="document_for">** DOCUMENTO PARA EL BANCO **</p>'; ?>
            </div>

            <div class="student_order column">
                <?php echo $brand_html . $table_data .
                    $footer .
                    '<p class="document_for">** DOCUMENTO PARA EL ESTUDIANTE **</p>'; ?>
            </div>
        </main>
    </body>

    </html>
<?php

    $output = ob_get_clean();
    $doc_name = 'orden_pago_' . date('Y-m-d');
    $options = $dompdf_instance->getOptions();
    $options->set(array('isRemoteEnabled' => true,));
    $dompdf_instance->setOptions($options);
    $dompdf_instance->loadHtml($output, 'utf-8');
    $dompdf_instance->setPaper('letter', 'landscape');
    $dompdf_instance->render();
    $dompdf_instance->stream($doc_name . '.pdf');
}

/**
 * Genera y retorna el html del codigo de barras con la informacion suministrada
 */
function generateBarcode($data, $generator)
{
    $ref_pago = $data['reference'];
    $ref_digits = strlen($ref_pago);
    $prefix = '';

    if ($ref_digits < 5) {
        $prefix = str_repeat('0', 5 - $ref_digits);
    }

    $ref_pago = $prefix . $ref_pago;

    $value = $data['concepto_pago']['valor'];
    $val_digits = strlen($value);
    $val_prefix = '';

    if ($val_digits < 8) {
        $val_prefix = str_repeat('0', 8 - $val_digits);
    }

    $value = $val_prefix . $value;

    $string = '(415)7709998667969(8020)0700' . $data['identificacion'] . $ref_pago . '(3900)' . $value . '(96)' . str_replace(['/', '-'], '', $data['concepto_pago']['vencimiento']);
    return [
        $generator->getBarcode(str_replace(['(', ')'], '', $string), $generator::TYPE_CODE_128),
        $string
    ];
}


/**
 * Crea el titulo que referencia la sección, y todas las opciones.
 * @param string $title nombre de esa sección
 * @param string $opts contenido html inmerso dentro de la sección.
 * @return string $res contenido html a imprimir.
 */
function createHeaderMenu($title, ...$opts)
{
    $res = '<div class="sb-sidenav-menu-heading">' . $title . '</div>';
    foreach ($opts as $opt) $res .= $opt;
    return $res;
}

/**
 * Crea una sección que contiene más opciones.
 * @param string $id referencia de la sección.
 * @param string $title nombre del encabezado para la sección (la parte que contiene el icono y la flecha)
 * @param string $icon clase de fontawesome con el icono que aparecerá
 * @param array $content arreglo|matriz con el contenido, su estructura debe ser: item = [ruta, texto] o tambien [item, item, item]
 * @param boolean $collapsed si desea tener abierta la sección deberá declararse como último parametro en 'false'
 * @return string contenido html a imprimir.
 */
function createSection($id, $title, $icon, $content, $collapsed = true)
{
    if (!is_array($content[0])) $content = array($content);

    $collapsed = $collapsed ? 'collapsed' : '';
    $show = $collapsed ? '' : 'show';

    $res = '<a class="nav-link ' . $collapsed . '" href="#" data-bs-toggle="collapse" data-bs-target="#' . $id . '">
                <span class="sb-nav-link-icon ' . $icon . '"></span>'
        . $title .
        '<span class="sb-sidenav-collapse-arrow fas fa-angle-down"></span>
            </a>
            <div class="collapse ' . $show . '" id="' . $id . '" data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">';
    foreach ($content as $opt) $res .= '<a class="nav-link" href="' . $opt[0] . '">' . $opt[1] . '</a>';

    $res    .=  '</nav>
            </div>';

    return $res;
}

/**
 * Crea una opción sencilla.
 * @param string $title titulo|referencia a la opción
 * @param string $icon clase de fontawesome para el icono a mostrar.
 * @param string $url lugar a donde se redireccionará una vez el usuario haga click.
 */
function createOption($title, $icon = '', $url = '', $open_new_page = false)
{
    return
        '<a class="nav-link" href="' . $url . ($open_new_page ? '" target="_blank"' : '"') . '>' .
        '<span class="sb-nav-link-icon ' . $icon . '"></span>' .
        $title .
        '</a>';
}

/**
 * Crea un input para ser usado en un formulario
 * @param string $id Id del campo
 * @param string $type Tipo de campo
 * @param string $styles Estilos del campo
 * @param string $label Descripcion del campo
 * @param boolean $required Describe si el campo es obligatorio
 * @param string $validation Validacion que se le aplicara al campo
 * @param boolean $validate Especifica si el campo debe ser validado
 * @return string Input generado a partir de las opciones dadas
 */
function createInput($id, $type, $styles, $label, $required, $validation, $validate, $initial_value = '', $error_message = 'Campo obligatorio')
{
    $required = $required == true ? 'required="true"' : '';

    switch ($type) {
        case 'hidden':
            return '<input id="' . $id . '" name="' . $id . '" type="hidden" value="' . $initial_value . '">';

        case 'textarea':
            $input = '<textarea placeholder=" " id="' . $id . '" name="' . $id . '" ' . $required . ' data_validation="' . $validation . '" data_error_message="' . $error_message . '" validate="' . $validate . '" class="' . $styles . '"></textarea>';
            break;

        default:
            $input = '<input placeholder=" " name="' . $id . '" id="' . $id . '" type="' . $type . '" class="' . $styles . '" data_validation="' . $validation . '" ' . $required . ' data_error_message="' . $error_message . '" value="' . $initial_value . '" validate="' . $validate . '">';
            break;
    }

    $input .= '<label for="' . $id . '" class="input__placeholder">' . $label . '</label>';
    $output = '<div class="custom-form-control">' . $input;

    if ($validate == true)
        $output .= '
            <span class="fas fa-check-circle success-icon"></span>
            <span class="fas fa-exclamation-circle error-icon"></span>
            <small class="error-message">Default Message</small>';

    $output .= '</div>';
    return $output;
}

/**
 * Funcion para crear formularios
 * @param string $id Identificador del formulario
 * @param boolean $validate Especifica si el formulario debe aplicar la validacion por defecto del navegador
 * @param array $inputs Array conteniendo los datos necesarios para generar los inputs
 * @param array $buttons Array conteniendo las caracteristicas de los botones que tendra el formulario
 * @return string Formulario generado
 */
function createForm($id, $validate, &$inputs, &$buttons)
{
    $required = $validate == true ? 'no-validate' : '';
    $output = '<form id="' . $id . '" ' . $required . '>';

    foreach ($inputs as $item) {

        if ($item['type'] == 'select') {
            array_shift($item);
            $output .= createSelectElement(...array_values($item));
            continue;
        }

        $values = array_values($item);
        $output .= createInput(...$values);
    }

    if (is_array($buttons) && !empty($buttons)) {
        $output .= '<div class="row mt-5">';

        foreach ($buttons as $button) {
            $output .= '<button type="' . $button['type'] . '" id="' . $button['id'] . '" class="' . $button['styles'] . '">
                            <i class="' . $button['icon'] . ' me-2"></i>
                            ' . $button['name'] . '
                        </button>';
        }

        $output .= '</div>';
    }

    $output .= '</form>';

    return $output;
}

/**
 * Genera la estructura para un datatable
 * @param string $id Identificador de la tabla
 * @param string $styles Estilos a aplicar a la tabla
 * @param array $headers Nombre de los headers de la tabla
 * @return string Estructura de la tabla lista para ser usada en datatables
 */
function createDatatable($id, $styles, $headers)
{
    $output = '<table id="' . $id . '" class="' . $styles . '">
                <thead class="text-center align-middle">';

    foreach ($headers as $item) $output .= '<th class="table-dark">' . $item . '</th>';

    $output .= '</thead>
               </table>';

    return $output;
}

/**
 * Genera un componente que incluye un formulario para un proceso de parametrizacion
 * @param string $component_icon Ícono del componente
 * @param string $component_title Titulo del componente
 * @param string $datatable Tabla para datatables
 * @param string $form_title Título del formulario
 * @param string $form Formulario del componente
 * @return string Estructura HTML del componente
 */
function createParametrizationComponent($component_icon, $component_title, $datatable, $form_title, $form)
{
    return <<<EOT
    <div class="grid-container w-100">
        <div>
            <div class="card">
                <div class="card-header p-4 secundario fw-bold text-light">
                    <i class="$component_icon fa-2x"></i>
                    <span class="ms-3 fs-4">$component_title</span>
                </div>
                <div class="card-body p-4">
                    $datatable
                </div>
            </div>
        </div>
        <div>
            <div class="card ms-3 p-4">
                <p class="display-5 fw-bold mb-3">$form_title</p>
                $form
            </div>
        </div>
    </div>
    EOT;
}

function renderView($view, $extras = [])
{
    $base_path = realpath(dirname(__FILE__, 3)) . '/modules/';
    $base_path .= isset($extras['viewPath']) ? $extras['viewPath'] : $view;
    $base_path .= '/' . $view . '.view.php';

    $css_files = '';
    if (isset($extras['css'])) {
        foreach ($extras['css'] as $item) {
            $css_files .= '<link rel="stylesheet" href="' . DOMAIN . MAIN_PATH . $item . '">';
        }
    }

    echo '<!DOCTYPE html>
            <html lang="es">
            <head>
                <meta charset="utf-8" />
                <meta http-equiv="X-UA-Compatible" content="IE=edge" />
                <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
                <meta http-equiv="cache-control" content="no-cache">
                <meta http-equiv="expires" content="0">
                <meta http-equiv="pragma" content="no-cache">
                <link rel="shortcut icon" href="' . DOMAIN . MAIN_PATH . 'assets/favicon/favicon1.ico" type="image/x-icon" />
                <link rel="stylesheet" href="' . DOMAIN . MAIN_PATH . 'libraries/bootstrap-5.1.3/css/bootstrap.css">
                <link rel="stylesheet" href="' . DOMAIN . MAIN_PATH . 'components/spinner/spinner.css">
                <link rel="stylesheet" href="' . DOMAIN . MAIN_PATH . 'libraries/sweetalert/dist/sweetalert2.min.css">
                <script defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
                ' . $css_files . '
                <title>Unitrópico | ' . $extras['title'] . '</title>
            </head>
            
            <body class="sb-nav-fixed">
                <div id="layoutSidenav">';

    require_once 'main_components/header.php';

    echo '<div id="layoutSidenav_content">';
    require_once 'main_components/sidenav.php';
    require_once $base_path;
    echo '</div>
          </div>';

    $js_scripts = [
        ['url' => 'components/generic/urlBeautifier.js'],
        ['url' => 'components/generic/sideNav.js'],
        ['url' => 'libraries/bootstrap-5.1.3/js/bootstrap.min.js'],
        ['url' => 'libraries/sweetalert/dist/sweetalert2.min.js']
    ];

    if (isset($extras['scripts'])) {
        $js_scripts = array_merge($js_scripts, $extras['scripts']);
    }

    foreach ($js_scripts as $script) {
        $extras = isset($script['type']) && $script['type'] == 'module' ? 'type="module"' : '';
        echo '<script defer ' . $extras . ' src="' . DOMAIN . MAIN_PATH . $script['url'] . '"></script>';
    }

    echo '</body>
    </html>';
}
