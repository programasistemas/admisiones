<?php
$domain =  explode('/', $_SERVER['SCRIPT_NAME'])[1];
require_once $_SERVER['DOCUMENT_ROOT'] . '/' . $domain . '/php/includes/routes.config.inc.php';

require_once DB_CONNECTION_PATH;    //conexion.
require_once HELPER_QUERY_SQL_PATH; //CRUD para todo tipo de consulta sql.
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <?php $title = 'Unitrópico | Inscripción'; require_once(ASP_HEADER_HTML_PATH); ?>
    <style>
        #form-data { padding: 0 12rem; }
        #logo { width: 200px; }
        #bg-right{
            background: url(<?php echo MAIN_PATH . 'img/flayers/BgGreenTextNormal.jpeg' ?>) no-repeat center;
            background-size: cover;
            text-align: center;
        }
        @media (max-width: 1600px) { #form-data { padding: 0 4rem; } }
        @media (max-width: 1100px) { #form-data { padding: 0 3rem; } }
        @media (max-width: 600px) { #form-data { padding: 0 2rem; } }
    </style>
</head>

<?php
    function addDefaultOption($array){ 
        array_unshift($array, ['', 'SELECCIONE UNA OPCIÓN']); 
        return $array;
    }
    
    $con = DB::getInstance()->getConnection(); //con-> conexion con db.
    try {
        //Periodo academico activo:
        $data = selectSql($con, 'periodo_academico', ['codigo', 'periodo'], 'estado', 'ACTIVO', true);
        if( empty($data) ) dieWithMsj('No se encuentran ningún periodo academico activo');
        else $academic_period_code = $data['codigo'];

        //Validación de fechas de calendario:
        $dates = selectSql($con, 'actividades_calendario', ['fecha_inicio', 'fecha_final'], ['codigo_calendario_academico', 'codigo_periodo_actividades'], [1, $academic_period_code], true);
        if( empty($dates) ) dieWithMsj('No se encuentran fechas de registro para el periodo académico activo ('.$data['periodo'].').');

        $current_date_str = date('Y-m-d', time());
        $current_date = strtotime($current_date_str);

        if( $current_date < strtotime($dates['fecha_inicio']) ) dieWithMsj('Las fechas de registro <b>inician</b> el día '. $dates['fecha_inicio']);
        if( $current_date > strtotime($dates['fecha_final']) ) dieWithMsj('Las fechas de registro <b>finalizaron</b> el día '. $dates['fecha_final']); //86400

        
        //tipos de select:
        $types_documents = addDefaultOption( selectSql($con, 'tipo_documento', 'codigo as "0", nombre as "1"') );
        $genders = addDefaultOption( selectSql($con, 'sexo', ['codigo as "0"', 'nombre as "1"']) );
        $types_inscription = selectSql( 
            $con, 
            'concepto_pago', 
            ['codigo as "0"', 'nombre_concepto as "1"'],
            'codigo_periodo_academico = ? AND estado = ? AND DATE_SUB(fecha_inicio, INTERVAL 1 DAY) < "' . $current_date_str . '" AND DATE_ADD(fecha_final, INTERVAL 1 DAY) > "'.$current_date_str.'"',
            [$academic_period_code, 'ACTIVO']
        );

        if ( empty($types_inscription) ) $types_inscription = array(['', 'NO HAY NINGUNA VENTA DE PINES VIGENTE']);
        else $types_inscription = addDefaultOption($types_inscription);

        $departments = selectSql($con, 'departamento', ['codigo', 'nombre_departamento'], 'codigo_pais', 170);
    } 
    catch (PDOException $e) { dieWithMsj($e->getMessage()); }
    unset($con);
?>


<body>
    <?php
        function dieWithMsj($msj){
            global $con;
            unset($con);
            $res = "<div class='row h-100 w-100 align-items-center justify-content-center'>
                        <div class='col-12 col-sm-10 col-md-8 col-lg-6 col-lg-4 p-3'> 
                            <img class='d-block w-100 m-auto' style='max-width: 500px' src='" . MAIN_PATH . "img/error.svg'>
                            <h1 class='text-danger text-center'>" . $msj . "</h1>
                        </div>
                    </div>";
            echo $res;
            die();
        }
    ?>

    <datalist id="dl_departments">
        <?php
            foreach($departments as $department){
                echo '<option value="' . $department['nombre_departamento'] . '" data-value="' . $department['codigo'] . '"></option>';
            }
        ?>
    </datalist>

    <datalist id="dl_ub_current_municipalities"></datalist>
    <datalist id="nbhood"></datalist>

    <span class="d-none" id="modalTreatment">
        <!-- Contenido del tratamiento de datos -->
        <?php require_once 'text_template/dataTreatment.php'; ?>
    </span>

    <!---------------------------- FORMULARIO ---------------------------->
    


    <div class="d-flex mx-0 bg-primary px-2 py-5" style="min-height:100vh;">
        <div class="col-12 col-lg-8 col-xl-7 col-xxl-6 m-auto p-5 card" id="form-data">
            <div class="d-flex justify-content-center">
                <img src="<?php echo MAIN_PATH . 'img/LogoUnitropicoColor.png' ?>" id="logo">
            </div>
            <h1 class="mt-4 bs-gray-900 fw-bold"> Registro de usuario </h1>
            <p class="mb-4">
                Primero debes crear un usuario para poder inscribirte! <br>
                Tú correo será el usuario y tú número de documento la contraseña
            </p>
            <form method="POST" id="form_inscripcion">
                <div class="row">
                    <input type="hidden" id="code_email" name="code_email">
                    <?php
                        require_once ASP_INPUTS_TEMPLATE_PATH;
                        $values = [
                            ['id' => 't_id',                'type' => 'select',      'options' => $types_documents,    'label' => 'Tipo de documento',                      'msjError' => 'Seleccione una opción', 'classGrid' => 'col-12 col-lg-6 mb-4'],
                            ['id' => 'n_id',                                         'rgx' => 'id',                    'label' => 'Número de documento',                    'msjError' => 'Sólo se aceptan de 4 a 10 caracteres númericos.', 'classGrid' => 'col-12 col-lg-6 mb-4'],
                            ['id' => 'name1',                                        'rgx' => 'name',                  'label' => 'Primer nombre',                          'msjError' => 'Ingrese SOLAMENTE su primer nombre. No se aceptan espacios, caracteres especiales ni números. [3-15 caracteres]',    'classGrid' => 'col-12 col-sm-6 mb-4'],
                            ['id' => 'name2',                                        'rgx' => 'name2',                 'label'=>'Segundo nombre',                           'msjError'=>'No se aceptan caracteres especiales ni números.  Máximo tres nombres [3-15 caracteres]',                               'classGrid'=>'col-12 col-sm-6 mb-4', ],
                            ['id' => 'lastName1',                                    'rgx' => 'name',                  'label' => 'Primer apellido',                        'msjError' => 'Ingrese SOLAMENTE su primer apellido. No se aceptan espacios, caracteres especiales ni números. [3-15 caracteres]',  'classGrid' => 'col-12 col-sm-6 mb-4'],
                            ['id' => 'lastName2',                                    'rgx' => 'name2',                 'label'=>'Segundo apellido',                         'msjError'=>'No se aceptan caracteres especiales ni números.  Máximo tres nombres [3-15 caracteres]',                               'classGrid'=>'col-12 col-sm-6 mb-4', ],
                            ['id' => 'email',               'typeValue' => 'email',  'rgx' => 'email',                 'label' => 'Correo electrónico',                     'msjError' => 'Email incorrecto! usuario@ejem.plo',                                             'classGrid' => 'col-8 mb-4'],
                            ['id' => 'btn-validate_email',  'type' => 'button',                                        'content'=>'Validar',                                'attr'=>'validate="#email"', 'classContent' => 'btn-success', 'classGrid' => 'col-4 mb-4', 'isDisabled'=>true],
                            ['id' => 'phone',               'type' => 'tel',                                           'label' => 'Número telefónico',                      'msjError' => 'Error desconocido',                                                              'classGrid' => 'col-12 col-md-6 mb-4'],
                            ['id' => 'gender',              'type' => 'select',      'options' => $genders,            'label' => 'Genero biológico',                       'msjError' => 'Seleccione una opción',                                                          'classGrid' => 'col-12 col-md-6 mb-4'],

                            ['name'=>'ub_current_municipalitie',    'type'=>'no-display'],
                            ['id'=>'ub_current_department',         'list'=>'dl_departments',               'name'=>'',         'label'=>'Departamento de residencia',  'attr'=>'typelocation="departments" changeinput="#ub_current_municipalitie"',                   'classGrid'=>'col-12 col-md-6 mb-4'],
                            ['id'=>'ub_current_municipalitie',      'list'=>'dl_ub_current_municipalities', 'name'=>'',         'label'=>'Municipio de residencia',     'msjError'=>'Ingrese sólo texto, verifique que el municipio tenga relación al departamento.',   'classGrid'=>'col-12 col-md-6 mb-4', 'attr'=>'typelocation="municipalities" changeinput="#home_nbhood"', 'isDisabled'=>true],
                            ['id'=>'home_address',                                                          'rgx'=>'addres',    'label'=>'Direccion de residencia',     'msjError'=>'Sólo se aceptan números, letras, y #-.',                                           'classGrid'=>'col-12 col-md-6 mb-4'],
                            ['id'=>'home_nbhood',                   'list'=>'nbhood',                       'rgx'=>'nbhood',    'label'=>'Nombre del barrio',           'msjError'=>'Ingrese sólamente texto y números, no signos raros.',                              'classGrid'=>'col-12 col-md-6 mb-4', 'attr'=>'typelocation="nbhoods" no-code', 'isDisabled'=>true],

                            ['id' => 'type_inscription',    'type' => 'select',      'options' => $types_inscription,  'label' => 'Tipo de inscripción',                    'msjError' => 'Seleccione una opción',                                                          'classGrid' => 'col-12 col-lg-6 mb-4'],
                            ['id' => 'course',              'type' => 'select',      'isDisplayNone'=>true,            'label' => 'Programa académico de interés',          'msjError' => 'Seleccione una opción',                                                          'classGrid' => 'col-12 col-lg-6  mb-4'],
                            ['id' => 'dataTreatment',       'type' => 'checkbox',                                      'label' => 'Autorizo el tratamiento de mis datos.',  'msjExtra' => '<strong id="click-to-dataTreatment"> Click acá </strong> para más información.', 'classGrid' => 'col-12']
                        ];

                        //Create content of the array.
                        foreach ($values as $input) { echo createTemplateFields($input); }
                    ?>
                    <input id="btn" name="btn" type="submit" class="btn btn-success w-100 mt-2" value="Inscribirse" disabled>
                </div>
            </form>
        </div>
    </div>

    <?php require_once ASP_SCRIPT_HTML_PATH; ?>
    <script src="<?php echo MAIN_PATH . 'js/inscripcion/create.js' ?>" type="module"></script>
</body>

</html>